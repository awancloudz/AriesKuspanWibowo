<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Keranjang;
use App\Produk;
use App\TransaksiPenjualan;

class KeranjangController extends Controller
{
    public function indexapp($item)
    {
        //USER
        settype($item, "integer");
        //Seleksi transaksi terakhir
        $transaksi = TransaksiPenjualan::where('id_users', $item);
        $kodeakhir = $transaksi->orderBy('id', 'desc')->first();
        if($transaksi->count() > 0){
            $kode = "GJO-TRX-" . $item . "-" . sprintf("%05s", $kodeakhir->id + 1);
        }
        else
        {
            $kode = "GJO-TRX-" . $item . "-00001";
        }

        //Tampilkan Keranjang
        $daftar = Keranjang::with('produk')->get();
        $daftarkeranjang = $daftar->where('id_users',$item);
        $jumlahkeranjang = $daftarkeranjang->count();
        $total = 0;
        $subtotal = 0;
        if($jumlahkeranjang == 0){
            $koleksi2 = [
                ['user' => null,'subtotal' => 0,'status' => null,'kodepenjualan' => $kode,'bukti' => '','jumlahkeranjang' => null],
            ];
        }
        else{
            //Subtotal
            foreach($daftarkeranjang as $keranjang){
                $user = $keranjang->id_users;
                $status = "order";
                $total = $keranjang->jumlah * $keranjang->produk->harga;
                $subtotal = $subtotal + $total;
            }
            
            $koleksi2 = [
                ['user' => $user,'subtotal' => $subtotal,'status' => $status,'kodepenjualan' => $kode,'bukti' => '','jumlahkeranjang' => $jumlahkeranjang],
            ];    
        }
        
        $koleksi = collect($daftarkeranjang);
        $koleksi->toJson();
        return compact('koleksi','koleksi2');
    }

    public function storeapp(Request $request)
    {
        $daftar = Keranjang::all();
        $keranjang = $daftar->where('id_users',$request->id_users)
        ->where('id_produk',$request->id_produk);
        $jumlah = $keranjang->count();
        if($jumlah == 1){
        return $keranjang;
        }
        else{
        //1. Mengambil value dari input text
        $input = $request->all();
        //2. Simpan Data keranjang 
        $keranjang = Keranjang::create($input);
        return $keranjang;
        }
    }

    public function updateapp(Request $request)
    {
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

    public function destroyapp($item)
    {
        //1. Pencarian berdasarkan Id keranjang
        $keranjang = Keranjang::findOrFail($item);
        //2. Hapus data
        $keranjang->delete();
        return $keranjang;
    }

}
