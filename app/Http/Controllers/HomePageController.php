<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Produk;
use App\History;

class HomePageController extends Controller
{
    //
    public function index(){
        $produk_list = Produk::orderBy('id_merk', 'asc')->get();
        $jumlah_produk = Produk::count();
        return view('pages.landingpage', compact('produk_list','jumlah_produk'));
    }
    public function notifikasi(){
        $notifikasi_list = History::orderBy('created_at', 'desc')->paginate(20);
        $jumlah_notifikasi = History::count();
        return view('pages.notifikasi', compact('notifikasi_list','jumlah_notifikasi'));
    }
}
