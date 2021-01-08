<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //
    protected $guarded = ['id'];
    protected $casts = [
      'OrderDate' => 'datetime:Y-m-d',
    ];
    protected $with = [
      'orderItems',
    ];
    //
    // -------------------------------------------------------------------------
    // eloquent relationships
    //
    function customer()
    {
       return $this->belongsTo(\App\Models\Customer::class, 'CustomerId');
    }
    //
    function orderItems()
    {
       return $this->hasMany(\App\Models\OrderItem::class, 'OrderId');
    }
    //
    // </end eloquent relationships
    // -------------------------------------------------------------------------


    /**
      * Recalculates this order's total amount
      *
      * @return void
    */
    function refreshTotalAmount()
    {
       $subAmounts = $this->orderItems->map(function($orderItem) {
         return $orderItem->subAmount = $orderItem->UnitPrice * $orderItem->Quantity;
       })->toArray();
       //
       $this->TotalAmount = array_sum($subAmounts);
       $this->save();
    }
}
