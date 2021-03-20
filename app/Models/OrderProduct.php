<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
   use SoftDeletes;

   protected $fillable = [
       'order_id',
       'product_id',
       'quantity',
       'price',
       'status'
   ];

   protected $casts = [
       'quantity' => 'integer',
       'price' => 'double',
       'status' => 'integer'
   ];


}
