<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Produk;
use App\Distributor;
use App\KategoriProduk;
use App\Profile;
use App\Merk;
use App\History;
use App\ProdukCabang;
use Storage;
use Validator;
use App\Http\Requests\ProdukRequest;
use Session;
use PDF;
use DB;
use Excel;
use Auth;
use OneSignal;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $mencari = 0;
        $produk_list = Produk::orderBy('id_merk', 'asc')->get();
        $jumlah_produk = Produk::count();
        return view('produk.index', compact('produk_list','jumlah_produk','mencari'));
    }
    public function create()
    {
        return view('produk.create');
    }
    public function input($cat)
    {
        return view('produk.create2', compact('cat'));
    }
    public function store(ProdukRequest $request)
    {
        $input = $request->all();
        
        if($request->hasFile('foto')){
            $input['foto'] = $this->uploadFoto($request);
        }
        else{
            $input['foto'] = "noimage.png";
        }
        
        //Simpan Data produk
        $produk = Produk::create($input);
        $produkbaru = Produk::orderBy('id', 'desc')->first();
        $daftar_cabang = Profile::orderBy('id', 'asc')->where('status','cabang')->get();
        foreach($daftar_cabang as $cabang){
            $produkcabang = New ProdukCabang;
            $produkcabang->id_profile = $cabang->id;
            $produkcabang->id_produk = $produkbaru->id;
            $produkcabang->hargajual = $produkbaru->hargajual;
            $produkcabang->save();
        }

        Session::flash('flash_message', 'Data Produk Berhasil Disimpan');
        return redirect('produk');
    }
    public function show(Produk $produk)
    {
        return view('produk.show',compact('produk'));
    }
    public function edit(Produk $produk)
    {  
        return view('produk.edit', compact('produk'));
    }
    public function update(Produk $produk, ProdukRequest $request)
    {
        $input = $request->all();

        if($request->hasFile('foto')){
            //Hapus foto lama
            $this->hapusFoto($produk);
            //Upload foto baru
            $input['foto'] = $this->uploadFoto($request);
        }
        
        //History
        if($produk->hargajual != $request->hargajual){
            $history = New History;
            $history->idtransaksi = $produk->id;
            $history->kodepenjualan = $produk->kodeproduk;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Ubah harga jual dari " . $produk->hargajual . " menjadi " . $request->hargajual . " (Catatan: " . $request->catatan . ")";
            $history->jenis = "produk";
            $notifikasi = $history->namauser ." => ". $history->deskripsi;
            $this->kirimnotifikasi($notifikasi,$produk->id);
            $history->save();
        }
        if($produk->hargagrosir != $request->hargagrosir){
            $history = New History;
            $history->idtransaksi = $produk->id;
            $history->kodepenjualan = $produk->kodeproduk;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Ubah harga grosir dari " . $produk->hargagrosir . " menjadi " . $request->hargagrosir . " (Catatan: " . $request->catatan . ")";
            $history->jenis = "produk";
            $notifikasi = $history->namauser ." => ". $history->deskripsi;
            $this->kirimnotifikasi($notifikasi,$produk->id);
            $history->save();
        }
        if($produk->hargadistributor != $request->hargadistributor){
            $history = New History;
            $history->idtransaksi = $produk->id;
            $history->kodepenjualan = $produk->kodeproduk;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Ubah harga distributor dari " . $produk->hargadistributor . " menjadi " . $request->hargadistributor . " (Catatan: " . $request->catatan . ")";
            $history->jenis = "produk";
            $notifikasi = $history->namauser ." => ". $history->deskripsi;
            $this->kirimnotifikasi($notifikasi,$produk->id);
            $history->save();
        }
        if($produk->stok != $request->stok){
            $history = New History;
            $history->idtransaksi = $produk->id;
            $history->kodepenjualan = $produk->kodeproduk;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Ubah jumlah stok dari " . $produk->stok . " menjadi " . $request->stok . " (Catatan: " . $request->catatan . ")";
            $history->jenis = "produk";
            $notifikasi = $history->namauser ." => ". $history->deskripsi;
            $this->kirimnotifikasi($notifikasi,$produk->id);
            $history->save();
        }
        if($produk->kodeproduk != $request->kodeproduk){
            $history = New History;
            $history->idtransaksi = $produk->id;
            $history->kodepenjualan = $produk->kodeproduk;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Ubah Kode Produk dari " . $produk->kodeproduk . " menjadi " . $request->kodeproduk . " (Catatan: " . $request->catatan . ")";
            $history->jenis = "produk";
            $notifikasi = $history->namauser ." => ". $history->deskripsi;
            $this->kirimnotifikasi($notifikasi,$produk->id);
            $history->save();
        }
        if($produk->namaproduk != $request->namaproduk){
            $history = New History;
            $history->idtransaksi = $produk->id;
            $history->kodepenjualan = $produk->kodeproduk;
            if(Auth::check()){
            $history->namauser = Auth::user()->name;
            }
            $history->tanggal = date("Y-m-d");
            $history->deskripsi = "Ubah Nama Produk dari " . $produk->namaproduk . " menjadi " . $request->namaproduk . " (Catatan: " . $request->catatan . ")";
            $history->jenis = "produk";
            $notifikasi = $history->namauser ." => ". $history->deskripsi;
            $this->kirimnotifikasi($notifikasi,$produk->id);
            $history->save();
        }
        $produk->update($input);

        Session::flash('flash_message', 'Data Produk berhasil diupdate');
        return redirect('produk');
    }
    public function kirimnotifikasi($notifikasi,$produk){
        //Notifikasi semua user
        OneSignal::sendNotificationToAll(
            $notifikasi, 
            $url = "http://192.168.1.100:8000/produk/history/".$produk, 
            $data = null, 
            $buttons = null, 
            $schedule = null
        );
        //Notifikasi spesifik user
        /*$userId = "faf8f81c-4bb4-4663-bf1e-576442853108";
        OneSignal::sendNotificationToUser(
            $notifikasi,
            $userId,
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null
        );*/
    }
    public function history($idproduk){
        settype($idproduk, "integer");
        $history_list = History::where('idtransaksi', $idproduk)->orderBy('created_at','desc')->get(); 
        return view('produk.history', compact('history_list'));
    }
    //Upload foto ke direktori lokal
    public function uploadFoto(ProdukRequest $request){
        $foto = $request->file('foto');
        $ext = $foto->getClientOriginalExtension();

        if($request->file('foto')->isValid()){
            $foto_name = date('YmdHis'). ".$ext";
            $upload_path = 'fotoupload';
            $request->file('foto')->move($upload_path, $foto_name);
            return $foto_name;
        }
        return false;
    }
    //Hapus foto di direktori lokal
    public function hapusFoto(Produk $produk){
        $exist = Storage::disk('foto')->exists($produk->foto);
        if(isset($produk->foto) && $exist){
           $delete = Storage::disk('foto')->delete($produk->foto);
           if($delete){
            return true;
           }
           return false;
        }
    }
    public function destroy(Produk $produk)
    {
        $recat = $produk->id_kategoriproduk;
        $this->hapusFoto($produk);
        $produk->delete();
        Session::flash('flash_message', 'Data Produk berhasil dihapus');
        Session::flash('Penting', true);
        return redirect('kategori/' . $recat);
    }
    //pencarian
    public function cari(Request $request){
        $mencari = 0;
        $kata_kunci = $request->input('kata_kunci');
        if(!empty($kata_kunci)){
            //Query
            $query = Produk::where('namaproduk', 'LIKE', '%' . $kata_kunci . '%');
            $produk_list = $query->paginate(20);
            //Url Pagination
            $pagination = $produk_list->appends($request->except('page'));
            $jumlah_produk = $produk_list->total();
            return view('produk.index', compact('produk_list','kata_kunci','pagination','jumlah_produk','mencari'));
        }
        return redirect('produk');
    }
    //pencarian barcode
    public function caribarcode(Request $request){
        $mencari = 0;
        $kata_kunci_barcode = $request->input('kata_kunci_barcode');
        if(!empty($kata_kunci_barcode)){
            //Query
            $produk_list = Produk::where('kodeproduk',$kata_kunci_barcode)->orderBy('kodeproduk', 'desc')->paginate(20);
            $seleksi = $produk_list->all();
            foreach ($seleksi as $key => $value) {
            return redirect('produk/' . $value->id);
            }
        }
        return redirect('produk');
    }
    //Kategori Produk
    public function kategori($cat)
    {   
        $mencari = 1;
        $produk_list = Produk::where('id_kategoriproduk',$cat)->orderBy('id_merk', 'asc')->get();
        $jumlah_produk = $produk_list->count();
        $kategorinya = KategoriProduk::all();
        return view('produk.index2', compact('produk_list','jumlah_produk','kategorinya','cat','mencari'));
    }
    //Cetak Produk
    public function getPdf()
    {
        $profiletoko = Profile::all();
        $daftarmerk = Produk::join('merk','merk.id','=','produk.id_merk')->distinct()->addSelect('id_merk')->get();
        $daftarproduk = Produk::all();
        $pdf = PDF::loadView('produk.print',compact('daftarmerk','daftarproduk','profiletoko'))->setPaper('a4','portrait');
        return $pdf->stream();
    }
    public function getPdf2($id)
    {
        $daftarproduk = Produk::where('id',$id)->get();
        $pdf = PDF::loadView('produk.printbarcode',compact('daftarproduk'))->setPaper(array(0,0,120,650),'portrait');
        return $pdf->stream();
    }
    //Import Excel
    public function importExcel(Request $request)
    {
        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $insert[] = ['id'=>'' ,'kodeproduk' => $value->kodeproduk ,'jenisproduk'=>'' ,'id_distributor'=>'1' ,'id_kategoriproduk'=>$request->cat1 ,'namaproduk' => $value->namaproduk ,'seriproduk' => $value->seriproduk ,'hargajual' => $value->hargajual ,'hargagrosir' => $value->hargagrosir ,'hargadistributor' => $value->hargadistributor ,'diskon'=> $value->diskon ,'stok'=> $value->stok ,'foto'=>''];
                }
                if(!empty($insert)){
                    DB::table('produk')->insert($insert);
                    Session::flash('flash_message', 'Import Data Produk Berhasil');
                }
            }
            else{
                Session::flash('flash_message', 'Data Kosong');
            }
        }
        else{
            Session::flash('flash_message', 'Silahkan Pilih File Excel (.xlsx / .xls / .csv) terlebih dahulu');
        }
        return back();
    }
    //Export Excel
    public function exportExcel($type)
    {
        $data = Produk::get()->toArray();
        return Excel::create('Data Produk', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
}
