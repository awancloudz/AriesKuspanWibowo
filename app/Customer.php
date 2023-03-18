<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
    	'nama',
    	'alamat',
        'notelp',
        'jenis',
        'created_at',
        'updated_at'
    ];

    public function transaksipenjualan(){
        return $this->hasMany('App\TransaksiPenjualan', 'id_customer');
    }
}
