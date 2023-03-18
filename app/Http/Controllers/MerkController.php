<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Http\Requests\MerkRequest;
use App\Merk;
use App\Profile;
use App\Produk;
use PDF;
use Session;

class MerkController extends Controller
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
        $merk_list = Merk::orderBy('nama', 'asc')->paginate(20);
        $jumlah_merk = Merk::count();
        return view('merk.index', compact('merk_list','jumlah_merk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MerkRequest $request)
    {
        $input = $request->all();
        //Simpan Data kategoriproduk
        $merk = Merk::create($input);
        Session::flash('flash_message', 'Merk/Brand produk Berhasil Disimpan');
        return redirect('merk');
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
    public function edit(Merk $merk)
    {
        return view('merk.edit', compact('merk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Merk $merk, MerkRequest $request)
    {
        $input = $request->all();
        $merk->update($input);

        Session::flash('flash_message', 'Merk/Brand produk berhasil diupdate');
        return redirect('merk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merk $merk)
    {
        $merk->delete();
        Session::flash('flash_message', 'Merk/Brand produk berhasil dihapus');
        return redirect('merk');
    }
    //pencarian
    public function cari(Request $request){
        $kata_kunci = $request->input('kata_kunci');
        if(!empty($kata_kunci)){
            //Query
            $query = Merk::where('nama', 'LIKE', '%' . $kata_kunci . '%');
            $merk_list = $query->paginate(20);

            //Url Pagination
            $pagination = $merk_list->appends($request->except('page'));
            $jumlah_merk = $merk_list->total();
            return view('merk.index', compact('merk_list','kata_kunci','pagination','jumlah_merk'));
        }
        return redirect('merk');
    }
    //Cetak harga per merk
    public function getPdf($idmerk)
    {
        settype($idmerk, "integer");
        $profiletoko = Profile::all();
        $daftarmerk = Produk::where('id_merk',$idmerk)->join('merk','merk.id','=','produk.id_merk')->distinct()->addSelect('id_merk')->get();
        $daftarproduk = Produk::all();
        $pdf = PDF::loadView('merk.print',compact('daftarmerk','daftarproduk','profiletoko'))->setPaper('a4','portrait');
        return $pdf->stream();
    }
}
