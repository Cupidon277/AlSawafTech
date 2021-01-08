<?php

namespace App\Http\Controllers;

// meta
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// models
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'ProductId' => 'required',
          'OrderId' => 'required',
          'Quantity' => ['required', 'numeric', 'gt:0']
        ]);
        //
        DB::beginTransaction();
        try
        {
            $order = Order::findOrFail($request->OrderId);
            $product = Product::findOrFail($request->ProductId);
            OrderItem::create([
              'ProductId' => $request->ProductId,
              'OrderId' => $request->OrderId,
              'UnitPrice' => $product->UnitPrice,
              'Quantity' => $request->Quantity,
            ]);
            //
            DB::commit();
            session()->flash('success', 'Order item has been created successfully.');
            return redirect()->route('orders.edit', ['order' => $order]);
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('orders.edit', ['order' => $order])->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $this->validate($request, [
          'ProductId' => 'required',
          'OrderId' => 'required',
          'Quantity' => ['required', 'numeric', 'gt:0']
        ]);
        //
        DB::beginTransaction();
        try
        {
            $order = Order::findOrFail($orderItem->OrderId);
            $orderItem->update([
              'ProductId' => $request->ProductId,
              'Quantity' => $request->Quantity
            ]);
            //
            DB::commit();
            session()->flash('success', 'Order item has been updated successfully.');
            return redirect()->route('orders.edit', ['order' => $order]);
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('orders.edit', ['order' => $order])->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        DB::beginTransaction();
        try
        {
            $order = Order::findOrFail($orderItem->OrderId);
            $orderItem->delete();
            //
            DB::commit();
            session()->flash('success', 'Order item has been deleted successfully.');
            return redirect()->route('orders.edit', ['order' => $order]);
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('orders.edit', ['order' => $order])->withErrors($e->getMessage());
        }
    }
}
