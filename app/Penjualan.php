<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Penjualan extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'penjualan';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];

}