<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributor';

    protected $fillable = [
    	'nama',
    	'alamat',
        'notelp',
        'created_at',
        'updated_at'
    ];
}
