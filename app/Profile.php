<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';

    protected $fillable = [
    	'nama',
    	'alamat',
    	'kota',
        'notelp',
        'promosi',
        'status',
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->hasMany('App\User', 'id_profile');
    }
    public function produkcabang(){
        return $this->hasMany('App\ProdukCabang', 'id_profile');
    }
    public function transaksipenjualan(){
        return $this->hasMany('App\TransaksiPenjualan', 'id_profile');
    }
    public function pengiriman(){
        return $this->hasMany('App\Pengiriman', 'id_profile');
    }
}
