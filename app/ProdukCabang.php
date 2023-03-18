<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukCabang extends Model
{
    protected $table = 'produkcabang';

    //Hanya jika semua data disimpan tanpa seleksi
    protected $fillable = [
    	'id_profile',
        'id_produk',
        'hargajual',
        'stok',
        'created_at',
        'updated_at'
    ];

    public function profile(){
        return $this->belongsTo('App\Profile', 'id_profile');
    }
    public function produk(){
        return $this->belongsTo('App\Produk', 'id_produk');
    }
}
