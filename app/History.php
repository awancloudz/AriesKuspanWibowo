<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'idtransaksi',
        'kodepenjualan',
        'noinvoice',
        'namauser',
    	'tanggal',
        'deskripsi',
        'jenis',
        'created_at',
        'updated_at'
    ];
}
