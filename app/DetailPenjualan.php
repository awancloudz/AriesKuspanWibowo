<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detailpenjualan';

    protected $fillable = [
        'id_transaksipenjualan',
        'id_produk',
        'jumlah',
        'diskonrp',
        'diskon',
        'harga',
        'status',
        'created_at',
        'updated_at'
    ];
    //Relasi One to Many ke
    public function transaksipenjualan(){
        return $this->belongsTo('App\TransaksiPenjualan', 'id_transaksipenjualan');
    }
    public function produk(){
        return $this->belongsTo('App\Produk', 'id_produk');
    }
}
