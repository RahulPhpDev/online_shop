<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupen extends Model
{
	use SoftDeletes;

    public $fillable = [
    	'name',
    	'code',
    	'description',
    	'type',
    	'expire_at',
    	'discount'
    ];
    public $casts = ['type' => 'integer', 'expire_at' => 'date'];

    public function product()
    {
    	return $this->belongsToMany(Product::class);
    }
}
