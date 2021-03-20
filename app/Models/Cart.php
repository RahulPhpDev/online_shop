<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope('myCart', function ($query) {
                $query->where('user_id' , Auth::id());
        });
    }


    public function scopeUserCart($query)
    {
    	return $query->where('user_id', Auth::id());
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
        // ->without('product');
    }


    
    public function products()
    {
    	return $this->belongsToMany(Product::class,'cart_products', 'cart_id', 'product_id','id', 'id')
    		->as('cart_products')
			->withPivot('quantity', 'deleted_at', 'id')
			->wherePivotNull('deleted_at')
			->withTimestamps();
    }
}
