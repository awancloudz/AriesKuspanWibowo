<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DetailPenjualan;
use App\Produk;
use App\TransaksiPenjualan;
use App\Profile;
use Auth;
use PDF;
use Excel;
set_time_limit(0);
ini_set('memory_limit', '-1');

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //Kategori Laporan
    public function jenislap($jenis){   
        if(Auth::check()){
        $iduser = Auth::user()->id;
        }
        //Tanggal
        $hariini = date("Y-m-d");
        $awalbulanini = date("Y-m-1", strtotime($hariini));
        $akhirbulanini = date("Y-m-t", strtotime($hariini));

        if($jenis == 'semua'){
            $laporan = TransaksiPenjualan::where('id_profile',1)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            return view('laporan.index', compact('laporan','jenis'));
        }
        else if($jenis == 'pembelian'){
            $daftar = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            $laporan = $daftar->where('jenis', 'pembelian');
            return view('laporan.index', compact('laporan','jenis'));
        }
        else if($jenis == 'retail'){
            $daftar = TransaksiPenjualan::where('id_profile',1)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            $laporan = $daftar->where('jenis', 'retail');
            return view('laporan.index', compact('laporan','jenis'));
        }
        else if($jenis == 'grosir'){
            $daftar = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            $laporan = $daftar->where('jenis', 'grosir');
            return view('laporan.index', compact('laporan','jenis'));
        }
        else if($jenis == 'produk'){
            $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()->addSelect('id_produk')
                ->where('id_profile',1)->where('jenis','!=','pembelian')->get();
            $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()
                ->where('id_profile',1)->where('jenis','!=','pembelian')->get();
            
            //DATA PRODUK
            $data = [];
            foreach($daftarproduk as $produk){
                $data[] = [
                    'id_produk' => $produk->id_produk,
                    'merk' => $produk->produk->merk->nama,
                    'namaproduk' => $produk->produk->namaproduk,
                    'hargadistributor' => $produk->produk->hargadistributor,
                    'hargagrosir' => $produk->produk->hargagrosir,
                    'hargajual' => $produk->produk->hargajual,
                    'diskon' => $produk->produk->diskon,
                    'stok' => $produk->produk->stok,
                ];
            }
            $koleksiproduk = collect($data);
            $koleksiproduk->toJson();

            //DATA JUAL
            $data2 = [];
            foreach($daftarjual as $jual){
                $data2[] = [
                    'id_produk' => $jual->id_produk,
                    'jumlah' => $jual->jumlah,
                    'jenis' => $jual->transaksipenjualan->jenis,
                ];
            }
            $koleksijual = collect($data2);
            $koleksijual->toJson();

            return view('laporan.produk', compact('jenis','koleksiproduk','koleksijual'));
            //return $koleksijual;
        }
        else if($jenis == 'labarugi'){
            $laporan = TransaksiPenjualan::where('id_profile',1)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            return view('laporan.labarugi', compact('laporan','jenis'));
        }
    }
    public function carilaporan(Request $request){
        if(Auth::check()){
        $iduser = Auth::user()->id;
        }
        
        //Ambil value dari inputan pencarian
        $id_customer = $request->id_customer;
        $id_pengguna = $request->id_pengguna;
        $tgl_awal = $request->tgl_awal;    
        $tgl_akhir = $request->tgl_akhir;
        $jenis = $request->jenis;
        $id_profile = $request->id_profile;
        if(!empty($tgl_awal)){                        //Jika kata kunci tidak kosong, maka... 
            //Query
            if($jenis == 'semua'){
            $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])->get();
            return view('laporan.index', compact('laporan','jenis'));
            }
            else if($jenis == 'pembelian'){
                if($id_pengguna !=''){
                    $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'pembelian')->where('id_customer', $id_pengguna)->get();
                }
                else{
                    $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'pembelian')->get();
                }
            return view('laporan.index', compact('laporan','jenis'));
            }
            else if($jenis == 'retail'){
                if($id_pengguna !=''){
                    $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'retail')->where('id_users', $id_pengguna)->get();
                }
                else{
                    $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'retail')->get();
                }
            return view('laporan.index', compact('laporan','jenis'));
            }
            else if($jenis == 'grosir'){
                if($id_pengguna !='' && $id_customer ==''){
                    $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'grosir')->where('id_users', $id_pengguna)->get();
                }
                else if($id_pengguna =='' && $id_customer !=''){
                    $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'grosir')->where('id_customer', $id_customer)->get();
                }
                else if($id_pengguna !='' && $id_customer !=''){
                    $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'grosir')->where('id_users', $id_pengguna)->where('id_customer', $id_customer)->get();
                }
                else{
                    $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('jenis', 'grosir')->get();
                }
            return view('laporan.index', compact('laporan','jenis'));
            }
            else if($jenis == 'produk'){
                if($id_pengguna !=''){
                    $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                        ->whereBetween('transaksipenjualan.tanggal', [$tgl_awal, $tgl_akhir])->distinct()->addSelect('id_produk')
                        ->where('id_profile',$id_profile)->where('transaksipenjualan.id_users', $id_pengguna)->where('jenis','!=','pembelian')->get();
                    $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                        ->whereBetween('transaksipenjualan.tanggal', [$tgl_awal, $tgl_akhir])->distinct()
                        ->where('id_profile',$id_profile)->where('transaksipenjualan.id_users', $id_pengguna)->where('jenis','!=','pembelian')->get();
                }
                else{
                    $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                        ->whereBetween('transaksipenjualan.tanggal', [$tgl_awal, $tgl_akhir])->distinct()->addSelect('id_produk')
                        ->where('id_profile',$id_profile)->where('jenis','!=','pembelian')->get();
                    $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                        ->whereBetween('transaksipenjualan.tanggal', [$tgl_awal, $tgl_akhir])->distinct()
                        ->where('id_profile',$id_profile)->where('jenis','!=','pembelian')->get();
                }

            //DATA PRODUK
            $data = [];
            foreach($daftarproduk as $produk){
                $data[] = [
                    'id_produk' => $produk->id_produk,
                    'merk' => $produk->produk->merk->nama,
                    'namaproduk' => $produk->produk->namaproduk,
                    'hargadistributor' => $produk->produk->hargadistributor,
                    'hargagrosir' => $produk->produk->hargagrosir,
                    'hargajual' => $produk->produk->hargajual,
                    'diskon' => $produk->produk->diskon,
                    'stok' => $produk->produk->stok,
                ];
            }
            $koleksiproduk = collect($data);
            $koleksiproduk->toJson();

            //DATA JUAL
            $data2 = [];
            foreach($daftarjual as $jual){
                $data2[] = [
                    'id_produk' => $jual->id_produk,
                    'jumlah' => $jual->jumlah,
                    'jenis' => $jual->transaksipenjualan->jenis,
                ];
            }
            $koleksijual = collect($data2);
            $koleksijual->toJson();

            return view('laporan.produk', compact('jenis','koleksiproduk','koleksijual'));
            }
            else if($jenis == 'labarugi'){
            $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])->get();
            return view('laporan.labarugi', compact('laporan','jenis'));
            }
        }
        return redirect('laporan');
    }
    //Cetak PDF
    public function getPdf($jenis,$tgl_awal,$tgl_akhir,$id_pengguna,$id_profile){
        $profiletoko = Profile::where('id', $id_profile)->get();
        //Tanggal
        $hariini = date("Y-m-d");
        $awalbulanini = $tgl_awal;
        $akhirbulanini = $tgl_akhir;

        if($jenis == 'semua'){
            $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'pembelian'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'pembelian')->get();
            }
            else{
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'pembelian')->where('id_customer', $id_pengguna)->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'retail'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'retail')->get();
            }
            else{
                $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'retail')->where('id_users', $id_pengguna)->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'grosir'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'grosir')->get();
            }
            else{
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'grosir')->where('id_users', $id_pengguna)->where('id_customer', $id_pengguna)->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'produk'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
                $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()->addSelect('id_produk')
                    ->where('id_profile',$id_profile) ->where('jenis','!=','pembelian')->get();
                $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()
                    ->where('id_profile',$id_profile)->where('jenis','!=','pembelian')->get();
            }
            else{
                $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
                $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()->addSelect('id_produk')
                    ->where('id_profile',$id_profile)->where('transaksipenjualan.id_users', $id_pengguna)->where('jenis','!=','pembelian')->get();
                $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()
                    ->where('id_profile',$id_profile)->where('transaksipenjualan.id_users', $id_pengguna)->where('jenis','!=','pembelian')->get();
            }
            //DATA PRODUK
            $data = [];
            foreach($daftarproduk as $produk){
                $data[] = [
                    'id_produk' => $produk->id_produk,
                    'merk' => $produk->produk->merk->nama,
                    'namaproduk' => $produk->produk->namaproduk,
                    'hargadistributor' => $produk->produk->hargadistributor,
                    'hargagrosir' => $produk->produk->hargagrosir,
                    'hargajual' => $produk->produk->hargajual,
                    'diskon' => $produk->produk->diskon,
                    'stok' => $produk->produk->stok,
                ];
            }
            $koleksiproduk = collect($data);
            $koleksiproduk->toJson();

            //DATA JUAL
            $data2 = [];
            foreach($daftarjual as $jual){
                $data2[] = [
                    'id_produk' => $jual->id_produk,
                    'jumlah' => $jual->jumlah,
                    'jenis' => $jual->transaksipenjualan->jenis,
                ];
            }
            $koleksijual = collect($data2);
            $koleksijual->toJson();

            //$pdf = PDF::loadView('laporan.printproduk',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini','daftarproduk','daftarjual'))->setPaper('letter','portrait');
            return view('laporan.printproduk',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini','koleksiproduk','koleksijual'));
        }
        else if($jenis == 'labarugi'){
            $laporan = TransaksiPenjualan::where('id_profile',$id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            //$pdf = PDF::loadView('laporan.printlabarugi',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.printlabarugi',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        //return $pdf->stream();
    }
    public function getPdfGrosir($jenis,$tgl_awal,$tgl_akhir,$id_pengguna,$id_profile,$id_customer){
        $profiletoko = Profile::where('id', $id_profile)->get();
        //Tanggal
        $hariini = date("Y-m-d");
        $awalbulanini = $tgl_awal;
        $akhirbulanini = $tgl_akhir;

        if($jenis == 'grosir'){
            if($id_pengguna !=0 && $id_customer ==0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                ->where('jenis', 'grosir')->where('id_users', $id_pengguna)->get();
            }
            else if($id_pengguna ==0 && $id_customer !=0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                ->where('jenis', 'grosir')->where('id_customer', $id_customer)->get();
            }
            else if($id_pengguna !=0 && $id_customer !=0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                ->where('jenis', 'grosir')->where('id_users', $id_pengguna)->where('id_customer', $id_customer)->get();
            }
            else{
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                ->where('jenis', 'grosir')->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
    }
    //Export Excel
    public function exportExcel($jenis,$tgl_awal,$tgl_akhir,$id_pengguna,$id_profile){
        $profiletoko = Profile::where('id',$id_profile)->get();
        //Tanggal
        $hariini = date("Y-m-d");
        $awalbulanini = $tgl_awal;
        $akhirbulanini = $tgl_akhir;

        if($jenis == 'semua'){
            $laporan = TransaksiPenjualan::where('id_profile', $id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.export',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'pembelian'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'pembelian')->get();
            }
            else{
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'pembelian')->where('id_customer', $id_pengguna)->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.export',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'retail'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::where('id_profile', $id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'retail')->get();
            }
            else{
                $laporan = TransaksiPenjualan::where('id_profile', $id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'retail')->where('id_users', $id_pengguna)->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.export',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'grosir'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'grosir')->get();
            }
            else{
                $laporan = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                ->where('jenis', 'grosir')->where('id_customer', $id_pengguna)->get();
            }
            //$pdf = PDF::loadView('laporan.print',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.export',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        else if($jenis == 'produk'){
            if($id_pengguna == 0){
                $laporan = TransaksiPenjualan::where('id_profile', $id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
                $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()->addSelect('id_produk')
                    ->where('id_profile', $id_profile)->where('jenis','!=','pembelian')->get();
                $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()
                    ->where('id_profile', $id_profile)->where('jenis','!=','pembelian')->get();
            }
            else{
                $laporan = TransaksiPenjualan::where('id_profile', $id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
                $daftarproduk = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()->addSelect('id_produk')
                    ->where('id_profile', $id_profile)->where('transaksipenjualan.id_users', $id_pengguna)->where('jenis','!=','pembelian')->get();
                $daftarjual = DetailPenjualan::join('transaksipenjualan','transaksipenjualan.id','=','detailpenjualan.id_transaksipenjualan')
                    ->whereBetween('transaksipenjualan.tanggal', [$awalbulanini, $akhirbulanini])->distinct()
                    ->where('id_profile', $id_profile)->where('transaksipenjualan.id_users', $id_pengguna)->where('jenis','!=','pembelian')->get();
            }
            //DATA PRODUK
            $data = [];
            foreach($daftarproduk as $produk){
                $data[] = [
                    'id_produk' => $produk->id_produk,
                    'merk' => $produk->produk->merk->nama,
                    'namaproduk' => $produk->produk->namaproduk,
                    'hargadistributor' => $produk->produk->hargadistributor,
                    'hargagrosir' => $produk->produk->hargagrosir,
                    'hargajual' => $produk->produk->hargajual,
                    'diskon' => $produk->produk->diskon,
                    'stok' => $produk->produk->stok,
                ];
            }
            $koleksiproduk = collect($data);
            $koleksiproduk->toJson();

            //DATA JUAL
            $data2 = [];
            foreach($daftarjual as $jual){
                $data2[] = [
                    'id_produk' => $jual->id_produk,
                    'jumlah' => $jual->jumlah,
                    'jenis' => $jual->transaksipenjualan->jenis,
                ];
            }
            $koleksijual = collect($data2);
            $koleksijual->toJson();

            //$pdf = PDF::loadView('laporan.printproduk',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini','daftarproduk','daftarjual'))->setPaper('letter','portrait');
            return view('laporan.exportproduk',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini','koleksiproduk','koleksijual'));
        }
        else if($jenis == 'labarugi'){
            $laporan = TransaksiPenjualan::where('id_profile', $id_profile)->whereBetween('tanggal', [$awalbulanini, $akhirbulanini])->get();
            //$pdf = PDF::loadView('laporan.printlabarugi',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'))->setPaper('letter','portrait');
            return view('laporan.exportlabarugi',compact('laporan','profiletoko','jenis','awalbulanini','akhirbulanini'));
        }
        //return $pdf->stream();
    }
}
