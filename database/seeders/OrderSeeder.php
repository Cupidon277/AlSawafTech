<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//
use App\Models\Order;
use App\Models\Customer;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $customers = Customer::all();
      //
      $customerMohamad = $customers->where('FirstName', 'Mohamad')->first();
      $customerSamer = $customers->where('FirstName', 'Samer')->first();
      //
      Order::insert([
        [
          'OrderDate' => '2020-7-5',
          'OrderNumber' => 5,
          'CustomerId' => $customerMohamad->id,
          'TotalAmount' => 1000
        ],
        [
          'OrderDate' => '2020-8-14',
          'OrderNumber' => 8,
          'CustomerId' => $customerSamer->id,
          'TotalAmount' => 600
        ],
      ]);
    }
}
