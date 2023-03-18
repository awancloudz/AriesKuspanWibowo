<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategoriproduk extends Model
{
    protected $table = 'kategoriproduk';

    protected $fillable = [
    	'nama',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    public function produk(){
    	return $this->hasMany('App\Kategoriproduk', 'id_kategoriproduk');
    }
}
