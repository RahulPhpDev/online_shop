<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'abbreviation'
    ];


    public function product()
    {
    	return $this->hasMany(Product::class);
    }
}
