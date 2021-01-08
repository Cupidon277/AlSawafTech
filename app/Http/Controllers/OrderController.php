<?php

namespace App\Http\Controllers;

// meta
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
// models
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('customer')->orderBy('OrderNumber')->get();
        $customers = Customer::all();
        //
        return Inertia::render('Orders/Index', [
            'orders' => $orders,
            'customrs' => $customers
        ]);
    }


    /**
     * Show the form to store new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        //
        return Inertia::render('Orders/Create', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'CustomerId' => ['required'],
          'OrderDate' => ['required']
        ]);
        //
        DB::beginTransaction();
        try
        {
            $lastOrder = Order::orderByDesc('OrderNumber')->get()->first();
            $order = Order::create([
              'OrderNumber' => $lastOrder->OrderNumber + 1,
              'CustomerId' => $request->CustomerId,
              'OrderDate' => date('Y-m-d H:i:s', strtotime($request->OrderDate)),
              'TotalAmount' => 0
            ]);
            DB::commit();
            session()->flash('success', 'Order has been created successfully. Add products to it.');
            return redirect()->route('orders.edit', ['order' => $order]);
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('orders.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form to edit the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order)
    {
        $customers = Customer::all(); // to update the order's customer
        $products = Product::all(); // to add products to this order
        $order->refreshTotalAmount();
        //
        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'customers' => $customers,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
          'CustomerId' => 'required',
          'OrderDate' => 'required'
        ]);
        //
        DB::beginTransaction();
        try
        {
            $order->update([
              'CustomerId' => $request->CustomerId,
              'OrderDate' => $request->OrderDate
            ]);
            DB::commit();
            session()->flash('success', 'Order has been updated successfully.');
            return back();
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('orders.edit', ['order' => $order])->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try
        {
            $order->delete();
            DB::commit();
            session()->flash('success', 'Order has been deleted successfully.');
            return back();
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('orders.index')->withErrors($e->getMessage());
        }
    }
}
