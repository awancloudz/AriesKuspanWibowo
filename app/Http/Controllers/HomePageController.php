<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Produk;

class HomePageController extends Controller
{
    //
    public function index(){
        $produk_list = Produk::orderBy('id_merk', 'asc')->get();
        $jumlah_produk = Produk::count();
        return view('pages.landingpage', compact('produk_list','jumlah_produk'));
    }
}
