<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'id_transaksipenjualan',
        'id_profile',
        'status',
        'created_at',
        'updated_at'
    ];
    //Relasi One to Many ke
    public function transaksipenjualan(){
        return $this->belongsTo('App\TransaksiPenjualan', 'id_transaksipenjualan');
    }
    public function profile(){
        return $this->belongsTo('App\Profile', 'id_profile');
    }
}
