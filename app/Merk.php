<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $table = 'merk';

    protected $fillable = [
    	'nama',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    public function produk(){
    	return $this->hasMany('App\Merk', 'id_merk');
    }
}
