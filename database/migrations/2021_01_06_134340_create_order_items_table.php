<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Order::class, 'OrderId')->index();
            $table->foreignIdFor(App\Models\Product::class, 'ProductId')->index();
            $table->decimal('UnitPrice', 12, 2);
            $table->integer('Quantity');
            $table->timestamps();
            //
            $table->foreign('OrderId')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ProductId')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
