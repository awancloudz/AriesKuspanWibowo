<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Http\Requests\KategoriprodukRequest;
use App\Kategoriproduk;
use Session;

class KategoriprodukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $kategoriproduk_list = Kategoriproduk::orderBy('nama', 'asc')->paginate(20);
        $jumlah_kategoriproduk = Kategoriproduk::count();
        return view('kategoriproduk.index', compact('kategoriproduk_list','jumlah_kategoriproduk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoriproduk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriprodukRequest $request)
    {
        $input = $request->all();
        //Simpan Data kategoriproduk
        $kategoriproduk = Kategoriproduk::create($input);
        Session::flash('flash_message', 'Data Kategori produk Berhasil Disimpan');
        return redirect('kategoriproduk');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategoriproduk $kategoriproduk)
    {  
        return view('kategoriproduk.edit', compact('kategoriproduk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Kategoriproduk $kategoriproduk, KategoriprodukRequest $request)
    {
        $input = $request->all();
        $kategoriproduk->update($input);

        Session::flash('flash_message', 'Data Kategori produk berhasil diupdate');
        return redirect('kategoriproduk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategoriproduk $kategoriproduk)
    {
        $kategoriproduk->delete();
        Session::flash('flash_message', 'Data kategori produk berhasil dihapus');
        Session::flash('Penting', true);
        return redirect('kategoriproduk');
    }

    //pencarian
    public function cari(Request $request){
        $kata_kunci = $request->input('kata_kunci');
        if(!empty($kata_kunci)){
            //Query
            $query = Kategoriproduk::where('nama', 'LIKE', '%' . $kata_kunci . '%');
            $kategoriproduk_list = $query->paginate(20);

            //Url Pagination
            $pagination = $kategoriproduk_list->appends($request->except('page'));
            $jumlah_kategoriproduk = $kategoriproduk_list->total();
            return view('kategoriproduk.index', compact('kategoriproduk_list','kata_kunci','pagination','jumlah_kategoriproduk'));
        }
        return redirect('kategoriproduk');
    }
}
