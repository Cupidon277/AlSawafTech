<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    //
    protected $guarded = ['id'];
    protected $with = [
      'product'
    ];
    //
    // -------------------------------------------------------------------------
    // eloquent relationships
    //
    function order()
    {
       return $this->belongsTo(\App\Models\Order::class, 'OrderId');
    }
    //
    function product()
    {
       return $this->belongsTo(\App\Models\Product::class, 'ProductId');
    }
    //
    // </end eloquent relationships
    // -------------------------------------------------------------------------
}
