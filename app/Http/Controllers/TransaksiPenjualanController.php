<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TransaksiPenjualan;
use App\DetailPenjualan;
use App\Keranjang;
use App\Produk;
use App\ProdukCabang;
use App\User;
use App\Customer;
use App\Profile;
use App\Pengiriman;
use App\History;
use Session;
use PDF;
use Auth;
use Redirect;

class TransaksiPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //TRANSAKSI
    public function index(){
        $caritrans = 0;
        $transaksi_list =  TransaksiPenjualan::orderBy('tanggal', 'desc')->paginate(20);
        $jumlah_transaksi = TransaksiPenjualan::all()->count();
        return view('transaksi.index', compact('transaksi_list','jumlah_transaksi','caritrans'));
    }
    public function migrasiharga($tgl_awal,$tgl_akhir){
        $transaksi = TransaksiPenjualan::with('detailpenjualan')->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])->get();
        //return $transaksi;
        foreach($transaksi as $trans){
            foreach($trans->detailpenjualan as $detail){
            $idproduk = $detail->id_produk;
            settype($idproduk, "integer");
            $produk = Produk::findOrFail($idproduk);
            if($trans->jenis == 'retail' || $trans->jenis == 'kirimcabang'){
                $detail->harga = $produk->hargajual;
            }
            if($trans->jenis == 'pembelian'){
                $detail->harga = $produk->hargadistributor;
            }
            if($trans->jenis == 'grosir'){
                $detail->harga = $produk->hargagrosir;
            }
            $detail->update();
            echo "Sukses,ID Detail :" . $detail->id;
            echo "<br>";
            }
        }
        echo "Migrasi Data Sukses!";
    }
    public function updatedetailpenjualan(){
        ini_set('memory_limit', '-1');
        $no = 1;
        $from = '2023-01-01 04:19:57.000000';
        $to = '2023-03-22 04:19:57.000000';
        $detailpenjualan = DetailPenjualan::whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->get();
        foreach($detailpenjualan as $detail){
            $jenis = $detail->transaksipenjualan->jenis;
            $detail->hargadistributor = $detail->produk->hargadistributor;
            $detail->hargagrosir = $detail->produk->hargagrosir;
            $detail->hargajual = $detail->produk->hargajual;
            echo $no . "." . $jenis . " : " . $detail->id_produk . "<br>";
            $detail->update();
            $no++;
        }
        echo "Sukses Update Harga!";
    }
    public function store(Request $request){
        //1. Mengambil value dari input text
        $input = $request->all();
        $iduser = $request->input('id_users');
        settype($iduser, "integer");
            //Seleksi transaksi terakhir
            $transaksiakhir = TransaksiPenjualan::where('id_users', $iduser);
            $kodeakhir = $transaksiakhir->orderBy('id', 'desc')->first();
            //$hariini = date("YmdHis");
            if($request->jenis == 'retail'){
                $trx = "RTL-";
            }
            else if($request->jenis == 'pembelian'){
                $trx = "PBL-";
            }
            else if($request->jenis == 'grosir'){
                $trx = "GRS-";
            }
            else if($request->jenis == 'kirimcabang'){
                $trx = "KRM-";
            }
            if($transaksiakhir->count() > 0){
                $kodepenjualan = $trx . $iduser . "-" . sprintf("%010s", $kodeakhir->id + 1);
            }
            else
            {
                $kodepenjualan = $trx . $iduser . "-0000000001";
            }
        $input['kodepenjualan'] = $kodepenjualan;

        //2. Simpan Data Transaksi 
        $transaksi = TransaksiPenjualan::create($input);
        //Ambil ID Transaksi
        $jenistrans = $request->input('jenis');

        if($jenistrans == 'pembelian'){
            //History
            $history = New History;
            $history->idtransaksi = $transaksi->id;
            $history->kodepenjualan = $transaksi->kodepenjualan;
            $history->noinvoice = $transaksi->noinvoice;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Input Transaksi Pembelian/Order";
            $history->jenis = "transaksi";
            $history->save();
        }

        $id_awal = TransaksiPenjualan::where('id_users', $iduser)->orderBy('id', 'desc')->first();
        $idtransaksi = $id_awal->id;
        settype($idtransaksi, "integer");
        //Tampilkan Keranjang
        $daftar = Keranjang::all();
        $daftarkeranjang = $daftar->where('id_users',$iduser)->where('jenis',$jenistrans);
        //Pengiriman
        if($jenistrans == 'kirimcabang'){
            $pengiriman = New Pengiriman;
            $pengiriman->id_transaksipenjualan = $idtransaksi;
            $pengiriman->id_profile = $request->id_cabang;
            $pengiriman->status = "kirim";
            $pengiriman->save();
        }
        //Simpan DetailPenjualan
        foreach($daftarkeranjang as $keranjang){
            $detailpenjualan = New DetailPenjualan;
            $detailpenjualan->id_transaksipenjualan = $idtransaksi;
            $detailpenjualan->id_produk = $keranjang->id_produk;
            $detailpenjualan->jumlah = $keranjang->jumlah;
            $detailpenjualan->diskon = $keranjang->diskon;
            $detailpenjualan->diskonrp = $keranjang->diskonrp;
            $detailpenjualan->hargadistributor = $keranjang->produk->hargadistributor;
            $detailpenjualan->hargajual = $keranjang->produk->hargajual;
            $detailpenjualan->hargagrosir = $keranjang->produk->hargagrosir;
            $detailpenjualan->save();
            //Update Stok
            if(Auth::check()){
                $level = Auth::user()->level;
                $id_profile = Auth::user()->id_profile;
            }
            if($level != 'kasircabang'){
                $produk = Produk::findOrFail($keranjang->id_produk);
                $stokawal = $produk->stok;
                if($jenistrans == 'pembelian'){
                    //$stokakhir = $stokawal + $keranjang->jumlah;
                    $stokakhir = $stokawal;
                }
                //Update stok Cabang
                else if($jenistrans == 'kirimcabang'){
                    $stokakhir = $stokawal - $keranjang->jumlah;
                    $produkcabang = ProdukCabang::where('id_produk',$keranjang->id_produk)->where('id_profile',$request->id_cabang)->get();
                    foreach($produkcabang as $produk2){
                        $stokawal2 = $produk2->stok;
                        $stokakhir2 = $stokawal2 + $keranjang->jumlah;
                        $produk2->stok = $stokakhir2;
                        $produk2->update();
                    }
                }
                else{
                    $stokakhir = $stokawal - $keranjang->jumlah;
                }
                $produk->stok = $stokakhir;
                $produk->update();
            }
            else{
                $produkcabang = ProdukCabang::where('id_produk',$keranjang->id_produk)->where('id_profile',$id_profile)->get();
                foreach($produkcabang as $produk){
                    $stokawal = $produk->stok;
                    $stokakhir = $stokawal - $keranjang->jumlah;
                    $produk->stok = $stokakhir;
                    $produk->update();
                }
            }
            //Hapus Keranjang
            $keranjang->delete();
        }
        $transaksi = $id_awal;
        
        Session::flash('flash_message', 'Data Transaksi berhasil disimpan.');
        if(($jenistrans == 'retail') || ($jenistrans == 'grosir') || ($jenistrans == 'kirimcabang')){
            return redirect('transaksi/' . $idtransaksi);
        }
        else{
            return redirect('jenistransaksi/' . $jenistrans);
        }
    }
    public function updateapp(Request $request){
        $item = $request->id;
        settype($item, "integer"); 
        //1.Pencarian berdasarkan Id 
        $penjualan = TransaksiPenjualan::findOrFail($item);
        $penjualan->status = 4;
        $penjualan->save();
        
        return $penjualan;
    }
    public function show(TransaksiPenjualan $transaksi){
        return view('transaksi.show',compact('transaksi'));
    }
    public function viewtransaksi(TransaksiPenjualan $transaksi){
        return view('transaksi.show2',compact('transaksi'));
    }
    public function createkeranjang($jenis){
        $mencari = 0;
        if(Auth::check()){
        $iduser = Auth::user()->id;
        $idtoko = Auth::user()->id_profile;
        $level = Auth::user()->level;
        settype($iduser, "integer");
        $daftar = Keranjang::all();
        $keranjang = $daftar->where('id_users',$iduser)->where('jenis',$jenis);
        $jumlahkeranjang = $keranjang->count();
        }

        if($level != 'kasircabang'){
            $cabang = 0;
            $produk_list = Produk::orderBy('id_merk', 'asc')->get();
            $jumlah_produk = Produk::count();
        }
        else{
            $cabang = 1;
            $produk_list = ProdukCabang::select('produk.*','produkcabang.hargajual','produkcabang.stok')->join('produk','produk.id','=','produkcabang.id_produk')
                    ->orderBy('id_merk', 'asc')->addSelect('id_produk')->where('id_profile',$idtoko)->get();  
            $jumlah_produk = $produk_list->count();
        }
        return view('transaksi.keranjang', compact('cabang','produk_list','jumlah_produk','mencari','keranjang','jumlahkeranjang','jenis'));
    }
    public function keranjangjson($jenis, $iduser){
        settype($iduser, "integer");
        //$daftar = Keranjang::all();
        $keranjang = Keranjang::where('id_users',$iduser)->where('jenis',$jenis)->get();
        $koleksi = collect($keranjang);
        $koleksi->toJson();
        return $koleksi;
    }
    public function lunas($idtransaksi){
        settype($idtransaksi, "integer");
        $transaksi = TransaksiPenjualan::findOrFail($idtransaksi);
        $transaksi->status = 'lunas';
        $transaksi->update();
        Session::flash('flash_message', 'Transaksi Pembelian sudah dilunasi.');
        return redirect('jenistransaksi/pembelian');
    }
    public function history($idtransaksi){
        settype($idtransaksi, "integer");
        $history_list = History::where('idtransaksi', $idtransaksi)->get(); 
        return view('transaksi.history', compact('history_list'));
    }
    public function checkgudang($idtransaksi){
        settype($idtransaksi, "integer");
        $transaksi = TransaksiPenjualan::findOrFail($idtransaksi);
        $transaksi->statusorder = 'check';
        $transaksi->update();

        //History
        $history = New History;
        $history->idtransaksi = $transaksi->id;
        $history->kodepenjualan = $transaksi->kodepenjualan;
        $history->noinvoice = $transaksi->noinvoice;
        if(Auth::check()){
        $history->namauser = Auth::user()->name;
        }
        $history->tanggal = date("Y-m-d");
        $history->deskripsi = "Klik Tombol Konfirmasi Order";
        $history->jenis = "transaksi";
        $history->save();

        Session::flash('flash_message', 'Transaksi Pembelian sudah dikonfirmasi.');
        return redirect('jenistransaksi/pembelian');
    }
    public function ready($iddetail,$status){
        $detail = DetailPenjualan::findOrFail($iddetail);
        $detail->status = $status;
        $detail->update();

        //History
        $history = New History;
        $history->idtransaksi = $detail->id_transaksipenjualan;
        $history->kodepenjualan = $detail->transaksipenjualan->kodepenjualan;
        $history->noinvoice = $detail->transaksipenjualan->noinvoice;
        if(Auth::check()){
        $history->namauser = Auth::user()->name;
        }
        $history->tanggal = date("Y-m-d");
        $history->deskripsi = "Klik tombol " . $status . " untuk produk ". $detail->produk->namaproduk;
        $history->jenis = "transaksi";
        $history->save();

        return redirect('transaksi/view/'. $detail->id_transaksipenjualan);
    }
    public function verifikasistok($idtransaksi){
        settype($idtransaksi, "integer");
        $detailtransaksi = DetailPenjualan::where('id_transaksipenjualan',$idtransaksi)->get();
        foreach($detailtransaksi as $detail){
            $produk = Produk::findOrFail($detail->id_produk);
            if($detail->status == 'ready'){
                $stokawal = $produk->stok;
                $stokakhir = $stokawal + $detail->jumlah;
                $produk->stok = $stokakhir;
                $produk->update();
            }
        }

        $transaksi = TransaksiPenjualan::findOrFail($idtransaksi);
        $transaksi->statusorder = 'verifikasi';
        $transaksi->update();

        //History
        $history = New History;
        $history->idtransaksi = $transaksi->id;
        $history->kodepenjualan = $transaksi->kodepenjualan;
        $history->noinvoice = $transaksi->noinvoice;
        if(Auth::check()){
        $history->namauser = Auth::user()->name;
        }
        $history->tanggal = date("Y-m-d");
        $history->deskripsi = "Klik Tombol Verifikasi Order";
        $history->jenis = "transaksi";
        $history->save();

        Session::flash('flash_message', 'Stok dari Transaksi Pembelian sudah diverifikasi.');
        return redirect('jenistransaksi/pembelian');
    }
    public function verifikasijson($idtransaksi){
        //settype($iduser, "integer");
        $detailtransaksi = DetailPenjualan::where('id_transaksipenjualan',$idtransaksi)->get();
        $koleksi = collect($detailtransaksi);
        $koleksi->toJson();
        return $koleksi;
    }
    public function verifikasitransaksijson($idtransaksi){
        //settype($iduser, "integer");
        $transaksi = TransaksiPenjualan::where('id',$idtransaksi)->with('DetailPenjualan')->get();
        $koleksi = collect($transaksi);
        $koleksi->toJson();
        return $koleksi;
    }
    public function editinvoice(Request $request){
        $transaksi = TransaksiPenjualan::findOrFail($request->id);
        $transaksi->noinvoice = $request->noinvoice;
        $transaksi->update();
        return redirect('transaksi/view/'.$request->id);
    }
    //PENCARIAN
    public function cari(Request $request){
        $caritrans = 1;
        $kata_kunci = $request->input('kata_kunci');
        $jenis = $request->input('jenis');
        if(!empty($kata_kunci)){
            //Query
            $query = TransaksiPenjualan::where('kodepenjualan', 'LIKE', '%' . $kata_kunci . '%')->orWhere('noinvoice', 'LIKE', '%' . $kata_kunci . '%');
            $transaksi_list = $query->paginate(20);
            $jumlah_transaksi = $transaksi_list->total();
            return view('transaksi.index', compact('jenis','transaksi_list','kata_kunci','jumlah_transaksi','caritrans'));
        }
        else{
            return redirect('jenistransaksi/' . $jenis);
        }
    }
    //PENCARIAN BARCODE
    public function caribarcode(Request $request){
        $caritrans = 1;
        $kata_kunci_barcode = $request->input('kata_kunci_barcode');
        $jenis = $request->input('jenis');
        if(!empty($kata_kunci_barcode)){
            //Query
            $transaksi_list = TransaksiPenjualan::where('kodepenjualan',$kata_kunci_barcode)->orWhere('noinvoice', 'LIKE', '%' . $kata_kunci_barcode . '%')->orderBy('kodepenjualan', 'desc')->paginate(20);
            $seleksi = $transaksi_list->all();
            foreach ($seleksi as $key => $value) {
            return redirect('transaksi/' . $value->id);
            }
        }
        else{
            return redirect('jenistransaksi/' . $jenis);
        }
    }
    //KERANJANG BELANJA
    public function cari2(Request $request){
        $mencari = 0;
        $jenis = $request->input('jenis');
        $kata_kunci = $request->input('kata_kunci');
        if(!empty($kata_kunci)){
            //Query
            if(Auth::check()){
            $iduser = Auth::user()->id;
            settype($iduser, "integer");
            $daftar = Keranjang::all();
            $keranjang = $daftar->where('id_users',$iduser);
            $jumlahkeranjang = $keranjang->count();
            }
            $query = Produk::with('Merk')->whereHas('Merk', function($q) use ($kata_kunci){
                $q->where('nama', 'LIKE', '%' . $kata_kunci . '%');
            });
            //$query = Produk::where('namaproduk', 'LIKE', '%' . $kata_kunci . '%');
            $produk_list = $query->paginate(20);
            //Url Pagination
            $pagination = $produk_list->appends($request->except('page'));
            $jumlah_produk = $produk_list->total();
            return view('transaksi.keranjang', compact('produk_list','kata_kunci','pagination','jumlah_produk','mencari','keranjang','jumlahkeranjang','jenis'));
        }
        return redirect('transaksi/create/' . $jenis);
    }
    public function caribarcode2(Request $request){
        if(Auth::check()){
            $iduser = Auth::user()->id;
            $idtoko = Auth::user()->id_profile;
            $level = Auth::user()->level;
        }
        $mencari = 0;
        $jenis = $request->input('jenis');
        $kata_kunci_barcode = $request->input('kata_kunci_barcode');
        if(!empty($kata_kunci_barcode)){
            //Query
            if($level != 'kasircabang'){
                $produk_list = Produk::where('kodeproduk',$kata_kunci_barcode)->get();
            }
            else{
                $produk = Produk::where('kodeproduk',$kata_kunci_barcode)->get();
                foreach($produk as $prod){
                    $id_produk = $prod->id;
                }
                $produk_list = ProdukCabang::where('id_produk',$id_produk)->get();
            }
            foreach ($produk_list as $key => $value) {
                if($value->stok > 0){
                    if($level != 'kasircabang'){
                    return redirect('transaksi/item/' . $value->id . '/jenis/' . $jenis);
                    }
                    else{
                    return redirect('transaksi/item/' . $value->id_produk . '/jenis/' . $jenis);   
                    }
                }
                if(($value->stok <= 0) && ($jenis == 'pembelian')){
                    return redirect('transaksi/item/' . $value->id . '/jenis/' . $jenis);
                }
                if(($value->stok <= 0) && ($jenis != 'pembelian')){
                    Session::flash('flash_message', 'Stok produk kosong.');
                    return redirect('transaksi/create/' . $jenis);
                }
            }  
        }
        Session::flash('flash_message', 'Produk tidak ditemukan di sistem.');
        return redirect('transaksi/create/' . $jenis);
    }
    public function inputkeranjang($idproduk,$jenis){
        settype($idproduk, "integer");
        if(Auth::check()){
            $iduser = Auth::user()->id;
            $idtoko = Auth::user()->id_profile;
            $level = Auth::user()->level;
            settype($iduser, "integer");
            // $daftar = Keranjang::all();
            $keranjang = Keranjang::where('id_users',$iduser)
            ->where('id_produk',$idproduk)->get();
            $jumlah = $keranjang->count();
            if($level != 'kasircabang'){
                $produk_list = Produk::where('id',$idproduk)->get();
            }
            else{
                $produk_list = ProdukCabang::where('id_produk',$idproduk)->where('id_profile',$idtoko)->get();
            }
            foreach($produk_list as $produk){
               $stok = $produk->stok; 
            }
            foreach($keranjang as $cart){
                $jmlcart = $cart->jumlah;
            }

            if($stok > 0){   
                if($jumlah > 0){
                    if($jmlcart < $stok){
                        foreach($keranjang as $cart)
                        {
                            $cart->jumlah = $cart->jumlah + 1;
                            $cart->update();
                            Session::flash('flash_message', 'Jumlah item ditambah di daftar belanja');
                            return redirect('transaksi/create/' . $jenis);
                        }
                    }
                    else{
                        Session::flash('flash_message', 'Stok produk tidak mencukupi.');
                        return redirect('transaksi/create/' . $jenis); 
                    }
                }
                else{
                    $cart = New Keranjang;
                    $cart->id_users = $iduser;
                    $cart->id_produk = $idproduk;
                    $cart->jumlah = 1;
                    $cart->jenis = $jenis;
                    $cart->save();
                    Session::flash('flash_message', 'Produk dimasukkan ke daftar belanja');
                    return redirect('transaksi/create/' . $jenis);
                }
            }
            else{
                Session::flash('flash_message', 'Stok produk tidak mencukupi.');
                return redirect('transaksi/create/' . $jenis);
            } 
        }
        else{
            Session::flash('flash_message', 'Akses gagal. Login Ulang');
            return redirect('transaksi/create' . $jenis);
        }
    }
    public function inputkeranjang2($idproduk,$jenis){
        settype($idproduk, "integer");
        if(Auth::check()){
            $iduser = Auth::user()->id;
            settype($iduser, "integer");
            // $daftar = Keranjang::all();
            $keranjang = Keranjang::where('id_users',$iduser)
            ->where('id_produk',$idproduk)->get();
            $jumlah = $keranjang->count();
            $produk_list = Produk::where('id',$idproduk)->get();
            foreach($produk_list as $produk){
               $stok = $produk->stok; 
            }
            foreach($keranjang as $cart){
                $jmlcart = $cart->jumlah;
            }

            if($jumlah > 0){
                foreach($keranjang as $cart)
                {
                    $cart->jumlah = $cart->jumlah + 1;
                    $cart->update();
                    Session::flash('flash_message', 'Jumlah item ditambah di daftar belanja');
                    return redirect('transaksi/create/' . $jenis);
                }
            }
            else{
                $cart = New Keranjang;
                $cart->id_users = $iduser;
                $cart->id_produk = $idproduk;
                $cart->jumlah = 1;
                $cart->jenis = $jenis;
                $cart->save();
                Session::flash('flash_message', 'Produk dimasukkan ke daftar belanja');
                return redirect('transaksi/create/' . $jenis);
            }
        }
        else{
            Session::flash('flash_message', 'Akses gagal. Login Ulang');
            return redirect('transaksi/create' . $jenis);
        }
    }
    public function updatekeranjang(Request $request){
        $item = $request->id;
        settype($item, "integer");
        //1.Pencarian berdasarkan Id pengaduan
        $keranjang = Keranjang::findOrFail($item);
        //2.Mengambil data dari field edit
        $input = $request->all();
        //3.Menyimpan data pengaduan
        $keranjang->update($input);
        return $keranjang;
    }
    public function updatepembelian(Request $request){
        //Update jumlah
        $item = $request->id;
        settype($item, "integer");
        $detail = DetailPenjualan::findOrFail($item);
        $input = $request->all();

        //History
        $history = New History;
        $history->idtransaksi = $detail->id_transaksipenjualan;
        $history->kodepenjualan = $detail->transaksipenjualan->kodepenjualan;
        $history->noinvoice = $detail->transaksipenjualan->noinvoice;
        if(Auth::check()){
        $history->namauser = Auth::user()->name;
        }
        $history->tanggal = date("Y-m-d");
        $history->deskripsi = "Ubah jumlah produk " . $detail->produk->namaproduk . " dari " . $detail->jumlah . " menjadi " . $request->jumlah;
        $history->jenis = "transaksi";
        $history->save();

        $detail->update($input);
        $idtransaksi = $detail->id_transaksipenjualan;
        settype($idtransaksi, "integer");
        //loop data detailpenjualan
        $diskon1 = 0;
        $diskon2 = 0;
        $totalbelanja = 0;
        $totaldiskon = 0;
        $subtotal = 0;
        $loopdetail = DetailPenjualan::where('id_transaksipenjualan',$idtransaksi)->get();
        foreach($loopdetail as $dt){
            $totalbelanja = $totalbelanja + ($dt->jumlah * $dt->produk->hargadistributor);
            $diskon1 = $dt->diskonrp;
            $diskon2 = ($dt->diskon / 100) * $dt->produk->hargadistributor;
            $totaldiskon = $totaldiskon + ($dt->jumlah * ($diskon1 + $diskon2));
        }
        $subtotal = $totalbelanja - $totaldiskon;
        //update transaksi
        $transaksi = TransaksiPenjualan::findOrFail($idtransaksi);
        $transaksi->totaldiskon = $totaldiskon;
        $transaksi->totalbelanja = $totalbelanja;
        $transaksi->subtotal = $subtotal;
        $transaksi->bayar = $subtotal;
        $transaksi->kembali = 0;
        $transaksi->update();
        return $transaksi;
    }
    public function hapusitemkeranjang($item){
        //1. Pencarian berdasarkan Id keranjang
        $keranjang = Keranjang::findOrFail($item);
        //2. Hapus data
        $keranjang->delete();
        return $keranjang;
    }
    //Cetak PDF
    //1.FAKTUR
    public function getPdf(TransaksiPenjualan $transaksi){
        if(Auth::check()){
            $iduser = Auth::user()->id;
            $idtoko = Auth::user()->id_profile;
            $level = Auth::user()->level;
        }
        $profiletoko = Profile::where('id',$idtoko)->get();
        $pdf = PDF::loadView('transaksi.print',compact('transaksi','profiletoko'))->setPaper('letter','portrait');
        // $pdf = PDF::loadView('transaksi.print',compact('transaksi','profiletoko'))->setPaper(array(0,0,332.59,650),'portrait');
        $trx = $transaksi->kodepenjualan;
        //if($transaksi->jenis =='grosir'){
            //return $pdf->save('/Users/awancloud/project/kasir/public/struk/'. $trx . '.pdf')->stream();
            //return $pdf->save('C:/xampp/htdocs/kasir/public/struk/'. $trx . '.pdf')->stream();
        //}
        //else{
            return $pdf->stream();
        //}
    }
    //2. STRUK
    public function getPdf2(TransaksiPenjualan $transaksi){
        if(Auth::check()){
            $iduser = Auth::user()->id;
            $idtoko = Auth::user()->id_profile;
            $level = Auth::user()->level;
        }
        $profiletoko = Profile::where('id',$idtoko)->get();
        //$pdf = PDF::loadView('transaksi.print',compact('transaksi','profiletoko'))->setPaper('a4','portrait');
        //return $pdf->stream();
        $pdf = PDF::loadView('transaksi.printstruk',compact('transaksi','profiletoko'))->setPaper(array(0,0,120,650),'portrait');
        $trx = $transaksi->kodepenjualan;
        //return $pdf->save('/Users/awancloud/project/kasir/public/struk/'. $trx . '.pdf')->stream();
        return $pdf->save('C:/xampp/htdocs/kasir/public/struk/'. $trx . '.pdf')->stream();
    }
    //3. STRUK HARIAN
    public function getPdf3(){
        if(Auth::check()){
            $iduser = Auth::user()->id;
            $idtoko = Auth::user()->id_profile;
            $level = Auth::user()->level;
        }
        $profiletoko = Profile::where('id',$idtoko)->get();
        $hariini = date("Y-m-d");
        $daftartransaksi = TransaksiPenjualan::where('tanggal', $hariini)->where('jenis', 'retail')->where('id_users',$iduser)->get();
        $pdf = PDF::loadView('transaksi.printstrukharian',compact('daftartransaksi','profiletoko'))->setPaper(array(0,0,120,10000),'portrait');
        //return $pdf->save('/Users/awancloud/project/kasir/public/struk/transaksi_'. $hariini . '.pdf')->stream();
        return $pdf->save('C:/xampp/htdocs/kasir/public/struk/transaksi_'. $hariini . '.pdf')->stream();
    }
    //Kategori Transaksi
    public function jenistrans($jenis){   
        if(Auth::check()){
            $iduser = Auth::user()->id;
            $idtoko = Auth::user()->id_profile;
            $level = Auth::user()->level;
        }
        //Tanggal
        $hariini = date("Y-m-d");
        $awalbulanini = date("Y-m-1", strtotime($hariini));
        $akhirbulanini = date("Y-m-t", strtotime($hariini));

        $caritrans = 1;
        if($level == 'admin'){
            $transaksi_list = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->where('jenis',$jenis)->orderBy('tanggal', 'desc')->paginate(20);
            $jumlah_transaksi = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->where('jenis',$jenis)->count();    
        }
        else if($level == 'gudang'){
            $transaksi_list = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->where('jenis','=','pembelian')->orderBy('tanggal', 'desc')->paginate(20);
            $jumlah_transaksi = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->where('jenis','=','pembelian')->count();    
        }
        else{
            $transaksi_list = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->where('jenis',$jenis)->where('id_users',$iduser)->orderBy('tanggal', 'desc')->paginate(20);
            $jumlah_transaksi = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->where('jenis',$jenis)->where('id_users',$iduser)->count();
        }
        return view('transaksi.index', compact('transaksi_list','jumlah_transaksi','jenis','caritrans'));
    }
    //Hapus Transaksi
    public function destroy(TransaksiPenjualan $transaksi){
        //Tampilkan Detail Penjualan
        $dpenjualan = DetailPenjualan::where('id_transaksipenjualan',$transaksi->id)->get();
        $jenistrans = $transaksi->jenis;
        $pengiriman = Pengiriman::where('id_transaksipenjualan',$transaksi->id)->get();
        foreach($pengiriman as $kirim){
            $idcabang = $kirim->id_profile;
        }
        foreach($dpenjualan as $detail){
            //Update Stok
            $produk = Produk::findOrFail($detail->id_produk);
            $stokawal = $produk->stok;
            if($jenistrans == 'pembelian'){
                $stokakhir = $stokawal - $detail->jumlah;
            }
            //Update stok Cabang
            else if($jenistrans == 'kirimcabang'){
                $stokakhir = $stokawal + $detail->jumlah;
                $produkcabang = ProdukCabang::where('id_produk',$detail->id_produk)->where('id_profile',$idcabang)->get();
                foreach($produkcabang as $produk2){
                    $stokawal2 = $produk2->stok;
                    $stokakhir2 = $stokawal2 - $detail->jumlah;
                    $produk2->stok = $stokakhir2;
                    $produk2->update();
                }
            }
            else{
                $stokakhir = $stokawal + $detail->jumlah;
            }
            $produk->stok = $stokakhir;
            $produk->update();
        }
        //Hapus data
        $transaksi->delete();
        Session::flash('flash_message', 'Data Transaksi berhasil dihapus');
        return redirect('jenistransaksi/' . $jenistrans);
    }
    public function destroy2($item){
        settype($item, "integer");
        $transaksi = TransaksiPenjualan::findOrFail($item);
        //Tampilkan Detail Penjualan
        $dpenjualan = DetailPenjualan::where('id_transaksipenjualan',$transaksi->id)->get();
        $jenistrans = $transaksi->jenis;
        foreach($dpenjualan as $detail){
            //Update Stok
            $produkcabang = ProdukCabang::where('id_produk',$detail->id_produk)->where('id_profile',$transaksi->users->id_profile)->get();
            foreach($produkcabang as $produk){
                $stokawal = $produk->stok;
                if($jenistrans == 'pembelian'){
                    $stokakhir = $stokawal - $detail->jumlah;
                }
                else{
                    $stokakhir = $stokawal + $detail->jumlah;
                }
                $produk->stok = $stokakhir;
                $produk->update();
            }
        }
        //Hapus data
        $transaksi->delete();
        Session::flash('flash_message', 'Data Transaksi berhasil dihapus');
        return redirect('jenistransaksi/' . $jenistrans);
    }
    public function bataltransaksi($item){
        settype($item, "integer");
        $transaksi = TransaksiPenjualan::findOrFail($item);
        $jenistrans = $transaksi->jenis;
        //Hapus data
        $transaksi->delete();
        Session::flash('flash_message', 'Data Transaksi berhasil dibatalkan');
        return redirect('jenistransaksi/' . $jenistrans);
    }
}
