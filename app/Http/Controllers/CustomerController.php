<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Http\Requests\CustomerRequest;
use App\Customer;
use App\Profile;
use Session;

class CustomerController extends Controller
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
        $customer_list = Customer::orderBy('nama', 'asc')->where('id','!=',1)->where('jenis','customer')->paginate(20);
        $jumlah_customer = $customer_list->count();
        return view('customer.index', compact('customer_list','jumlah_customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
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
        //Simpan Data Siswa
        $customer = Customer::create($input);

        Session::flash('flash_message', 'Data Pelanggan Berhasil Disimpan');
        return redirect('customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {  
        return view('customer.edit', compact('customer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer, CustomerRequest $request)
    {
        $input = $request->all();
        $customer->update($input);

        Session::flash('flash_message', 'Data Pelanggan berhasil diupdate');
        return redirect('customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        Session::flash('flash_message', 'Data Pelanggan berhasil dihapus');
        Session::flash('Penting', true);
        return redirect('customer');
    }

    //pencarian
    public function cari(Request $request){
        $kata_kunci = $request->input('kata_kunci');
        if(!empty($kata_kunci)){
            //Query
            $query = Customer::where('nama', 'LIKE', '%' . $kata_kunci . '%');
            $customer_list = $query->paginate(20);

            //Url Pagination
            $pagination = $customer_list->appends($request->except('page'));
            $jumlah_customer = $customer_list->total();
            return view('customer.index', compact('customer_list','kata_kunci','pagination','jumlah_customer'));
        }
        return redirect('customer');
    }
}
