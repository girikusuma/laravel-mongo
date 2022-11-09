<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kendaraan extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'kendaraan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'tahun_keluaran', 'harga', 'warna'
    ];

}