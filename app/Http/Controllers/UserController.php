<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Session;

class UserController extends Controller
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
        $user_list = User::all();
        return view('user.index', compact('user_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validasi = Validator::make($data, [
            'id_profile' => 'required',
            'name' => 'required|max:255',
            'username' => 'required|max:100|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
            'level' => 'required|in:admin,grosir,kasir,kasircabang,gudang',
        ]);

        if($validasi->fails()){
            return redirect('user/create')
            ->withInput()
            ->withErrors($validasi);
        }

        //Hash Password
        $data['password'] = bcrypt($data['password']);

        User::create($data);
        Session::flash('flash_message', 'Data user berhasil disimpan');

        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        //Jika ada password
        if($request->has('password')){
            $validasi = Validator::make($data, [
            'id_profile' => 'required',
            'name' => 'required|max:255',
            'username' => 'required|max:100|unique:users,username,' . $data['id'],
            'password' => 'required|confirmed|min:6',
            'level' => 'required|in:admin,grosir,kasir,kasircabang,gudang',
            ]);
            //Hash Password
            $data['password'] = bcrypt($data['password']);
        }
        //Jika tidak diganti
        else{
            $validasi = Validator::make($data, [
            'id_profile' => 'required',
            'name' => 'required|max:255',
            'username' => 'required|max:100|unique:users,username,' . $data['id'],
            'level' => 'required|in:admin,grosir,kasir,kasircabang,gudang',
            ]);
            //Hapus password / password tdk diupdate
            $data = array_except($data, ['password']);
        }

        if($validasi->fails()){
            return redirect("user/$id/edit")
            ->withErrors($validasi)
            ->withInput();
        }

        $user->update($data);
        Session::flash('flash_message', 'Data user berhasil diupdate');
        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Session::flash('flash_message', 'Data user berhasil dihapus');
        return redirect('user');
    }
}
