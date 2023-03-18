<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    protected $table = 'transaksipenjualan';

    protected $fillable = [
        'kodepenjualan',
        'noinvoice',
        'id_users',
        'id_customer',
        'id_profile',
    	'tanggal',
        'totaldiskon',
        'totalbelanja',
        'subtotal',
        'jenis',
        'status',
        'statusdiskon',
        'bayar',
        'kembali',
        'statustoko',
        'statusorder',
        'created_at',
        'updated_at'
    ];

    //Relasi Many to Many ke
    /*public function produktoko(){
        return $this->belongsToMany('App\ProdukToko', 'detailpenjualan', 'id_transaksipenjualan', 'id_produktoko');
    }*/
    public function detailpenjualan(){
        return $this->hasMany('App\DetailPenjualan', 'id_transaksipenjualan');
    }
    public function pengiriman(){
        return $this->hasMany('App\Pengiriman', 'id_transaksipenjualan');
    }
    //Relasi One to Many ke
    public function users(){
        return $this->belongsTo('App\User', 'id_users');
    }
    public function customer(){
        return $this->belongsTo('App\Customer', 'id_customer');
    }
    public function profile(){
        return $this->belongsTo('App\Profile', 'id_profile');
    }
}
