<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Produk;
use App\ProdukCabang;
use App\TransaksiPenjualan;
use App\DetailPenjualan;
use App\User;
use App\Merk;
use App\Customer;
use App\Profile;
use Session;
use PDF;
use Auth;
use Redirect;

class CabangController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function indexproduk($idcabang){
        $mencari = 0;
        $produk_list = ProdukCabang::select('produk.*','produkcabang.hargajual','produkcabang.stok','produkcabang.id_profile')->join('produk','produk.id','=','produkcabang.id_produk')
                    ->orderBy('id_merk', 'asc')->addSelect('id_produk')->where('id_profile',$idcabang)->get();           
        $jumlah_produk = $produk_list->count();
        return view('cabang.indexproduk', compact('produk_list','jumlah_produk','mencari'));
    }
    public function editproduk($idcabang,$idproduk){  
        $produk = ProdukCabang::where('id_produk',$idproduk)->where('id_profile',$idcabang)->get(); 
        foreach($produk as $prod){
            $produkcabang = ProdukCabang::findOrFail($prod->id);
        }      
        return view('cabang.edit', compact('produkcabang'));
    }
    public function update(Request $request){
        $input = $request->all();
        $produk = ProdukCabang::findOrFail($request->id);
        $produk->stok = $request->stok;
        $produk->hargajual = $request->hargajual;
        $produk->update();
        Session::flash('flash_message', 'Stok Produk berhasil diupdate');
        return redirect('cabang/produk/'.$produk->id_profile);
    }
    public function indextransaksi($idcabang){
        //Tanggal
        $hariini = date("Y-m-d");
        $awalbulanini = date("Y-m-1", strtotime($hariini));
        $akhirbulanini = date("Y-m-t", strtotime($hariini));

        $transaksi_list = TransaksiPenjualan::whereBetween('tanggal', [$awalbulanini, $akhirbulanini])
                    ->orderBy('tanggal', 'asc')->where('id_profile',$idcabang)->paginate(20);           
        $jumlah_transaksi = $transaksi_list->count();
        return view('cabang.indextransaksi', compact('transaksi_list','jumlah_produk','jumlah_transaksi'));
    }
}
