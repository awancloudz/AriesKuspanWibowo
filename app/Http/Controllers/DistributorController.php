<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Http\Requests\DistributorRequest;
use App\Http\Requests\CustomerRequest;
use App\Distributor;
use App\Customer;
use Session;

class DistributorController extends Controller
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
        $distributor_list = Customer::orderBy('nama', 'asc')->where('jenis','distributor')->paginate(20);
        $jumlah_distributor = $distributor_list->count();
        return view('distributor.index', compact('distributor_list','jumlah_distributor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('distributor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $input = $request->all();
        //Simpan Data distributor
        $distributor = Customer::create($input);
        Session::flash('flash_message', 'Data Distributor Berhasil Disimpan');
        return redirect('distributor');
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
    public function edit(Customer $distributor)
    {  
        return view('distributor.edit', compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $distributor, CustomerRequest $request)
    {
        $input = $request->all();
        $distributor->update($input);

        Session::flash('flash_message', 'Data Distributor berhasil diupdate');
        return redirect('distributor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $distributor)
    {
        $distributor->delete();
        Session::flash('flash_message', 'Data distributor berhasil dihapus');
        Session::flash('Penting', true);
        return redirect('distributor');
    }

    //pencarian
    public function cari(Request $request){
        $kata_kunci = $request->input('kata_kunci');
        if(!empty($kata_kunci)){
            //Query
            $query = Customer::where('nama', 'LIKE', '%' . $kata_kunci . '%');
            $distributor_list = $query->paginate(20);

            //Url Pagination
            $pagination = $distributor_list->appends($request->except('page'));
            $jumlah_distributor = $distributor_list->total();
            return view('distributor.index', compact('distributor_list','kata_kunci','pagination','jumlah_distributor'));
        }
        return redirect('distributor');
    }
}
