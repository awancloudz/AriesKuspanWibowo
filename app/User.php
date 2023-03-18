<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_profile',
        'name', 
        'username', 
        'password',
        'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function keranjang(){
        return $this->hasMany('App\Keranjang', 'id_users');
    }
    public function transaksipenjualan(){
        return $this->hasMany('App\TransaksiPenjualan', 'id_users');
    }
    
    public function profile(){
        return $this->belongsTo('App\Profile', 'id_profile');
    }
}
