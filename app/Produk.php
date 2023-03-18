<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    //Hanya jika semua data disimpan tanpa seleksi
    protected $fillable = [
    	'kodeproduk',
        'id_kategoriproduk',
        'id_merk',
        'namaproduk',
        'hargajual',
        'hargagrosir',
        'hargadistributor',
        'diskon',
        'stok',
        'foto',
        'created_at',
        'updated_at'
    ];

    //Relasi One to Many ke kategoriproduk
    public function kategoriproduk(){
        return $this->belongsTo('App\Kategoriproduk', 'id_kategoriproduk');
    }
    public function merk(){
        return $this->belongsTo('App\Merk', 'id_merk');
    }
    public function keranjang(){
        return $this->hasMany('App\Keranjang', 'id_produk');
    }
    public function detailpenjualan(){
        return $this->hasMany('App\DetailPenjualan', 'id_produk');
    }
    public function produkcabang(){
        return $this->hasMany('App\ProdukCabang', 'id_produk');
    }
}
