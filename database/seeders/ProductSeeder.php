<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//
use App\Models\Product;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $suppliers = Supplier::all();
       //
       $swafTech = $suppliers->where('CompanyName', 'SwafTech')->first();
       $durra = $suppliers->where('CompanyName', 'Durra')->first();
       $alMasri = $suppliers->where('CompanyName', 'كهربائيات المصري')->first();
       //
       Product::insert([
         [
           'ProductName' => 'Chai',
           'SupplierId' => $swafTech->id,
           'UnitPrice' => 150
         ],
         [
           'ProductName' => 'Rice',
           'SupplierId' => $swafTech->id,
           'UnitPrice' => 300
         ],
         [
           'ProductName' => 'Sugar',
           'SupplierId' => $durra->id,
           'UnitPrice' => 250
         ],
         [
           'ProductName' => 'Biscuit',
           'SupplierId' => $alMasri->id,
           'UnitPrice' => 500
         ],
       ]);
    }
}
