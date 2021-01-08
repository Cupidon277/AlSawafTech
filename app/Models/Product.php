<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //
    protected $guarded = ['id'];
    //
    // -------------------------------------------------------------------------
    // eloquent relationships
    //
    function supplier()
    {
       return $this->belongsTo(\App\Models\Supplier::class, 'SupplierId');
    }
    //
    function orderItems()
    {
       return $this->hasMany(\App\Models\OrderItem::class, 'ProductId');
    }
    //
    // </end eloquent relationships
    // -------------------------------------------------------------------------
}
