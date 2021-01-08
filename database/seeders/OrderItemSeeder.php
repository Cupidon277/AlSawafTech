<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderMohammed = Order::whereHas('customer', function($q) {
          $q->whereIn('FirstName', ['Mohamad']);
        })->get()->first();
        //
        $orderSamer = Order::whereHas('customer', function($q) {
          $q->whereIn('FirstName', ['Samer']);
        })->get()->first();
        //
        $products = Product::whereIn('ProductName', ['Rice', 'Sugar', 'Biscuit'])->get();
        //
        OrderItem::insert([
          [
            'OrderId' => $orderMohammed->id,
            'ProductId' => $products->where('ProductName', 'Biscuit')->first()->id,
            'UnitPrice' => 500,
            'Quantity' => 2
          ],
          [
            'OrderId' => $orderSamer->id,
            'ProductId' => $products->where('ProductName', 'Sugar')->first()->id,
            'UnitPrice' => 300,
            'Quantity' => 1
          ],
          [
            'OrderId' => $orderSamer->id,
            'ProductId' => $products->where('ProductName', 'Rice')->first()->id,
            'UnitPrice' => 300,
            'Quantity' => 1
          ],
        ]);
    }
}
