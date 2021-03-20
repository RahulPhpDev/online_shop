<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'reference',
        'user_id',
        'user_address_id',
        'status',
        'expect_delivery',
        'received',
        'reject'
    ];

    protected $casts = [
        'status' => 'integer',
        'user_address_id' => 'integer',
        'expect_delivery' => 'date',
        'received' => 'date'
    ];

    public $appends = ['current_status'];

    public function scopeUser($query)
    {
        return $query->whereUserId(\Auth::id());
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->as('order_product')
                    ->withPivot('quantity','price', 'status');
    }

    public function getCurrentStatusAttribute()
    {
      return Str::lower(OrderStatus::getKey($this->status));
    }


}
