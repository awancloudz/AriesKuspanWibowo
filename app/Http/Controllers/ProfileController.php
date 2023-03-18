<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Validator;
use App\Http\Requests\ProfileRequest;
use App\Profile;
use App\Produk;
use App\ProdukCabang;
use Session;

class ProfileController extends Controller
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
        $daftar_cabang = Profile::orderBy('id', 'asc')->where('status','cabang')->paginate(20);
        $jumlah_cabang = $daftar_cabang->count();
        return view('profile.index', compact('daftar_cabang','jumlah_cabang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $profile = Profile::create($input);
        $profilecabang = Profile::orderBy('id', 'desc')->first();

        $daftarproduk = Produk::all();
        foreach($daftarproduk as $produk){
            $produkcabang = New ProdukCabang;
            $produkcabang->id_profile = $profilecabang->id;
            $produkcabang->id_produk = $produk->id;
            $produkcabang->hargajual = $produk->hargajual;
            $produkcabang->save();
        }
        Session::flash('flash_message', 'Data Cabang berhasil disimpan.');
        return redirect('profile');
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
    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Profile $profile,ProfileRequest $request)
    {
        $input = $request->all();
        $profile->update($input);
        Session::flash('flash_message', 'Data profile berhasil diupdate');
        return redirect('profile/'. $request->id .'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        Session::flash('flash_message', 'Data Cabang berhasil dihapus');
        return redirect('profile');
    }
}
