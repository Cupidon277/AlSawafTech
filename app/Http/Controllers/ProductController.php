<?php

namespace App\Http\Controllers;

// meta
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
// models
use App\Models\Product;
use App\Models\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('supplier')->orderBy('ProductName')->get();
        $suppliers = Supplier::all();
        //
        return Inertia::render('Products/Index', [
            'products' => $products,
            'suppliers' => $suppliers
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
          'ProductName' => 'required',
          'SupplierId' => 'required',
          'UnitPrice' => ['required', 'numeric', 'gt:1']
        ]);
        //
        DB::beginTransaction();
        try
        {
            Product::create([
              'ProductName' => $request->ProductName,
              'SupplierId' => $request->SupplierId,
              'UnitPrice' => $request->UnitPrice
            ]);
            DB::commit();
            session()->flash('success', 'Product has been created successfully.');
            return redirect()->route('products.index');
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('products.index')->withErrors($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
          'ProductName' => 'required',
          'SupplierId' => 'required',
          'UnitPrice' => ['required', 'numeric', 'gt:1']
        ]);
        //
        DB::beginTransaction();
        try
        {
            $product->update([
              'ProductName' => $request->ProductName,
              'SupplierId' => $request->SupplierId,
              'UnitPrice' => $request->UnitPrice
            ]);
            DB::commit();
            session()->flash('success', 'Product has been updated successfully.');
            return redirect()->route('products.index');
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('products.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try
        {
            $product->delete();
            DB::commit();
            session()->flash('success', 'Product has been deleted successfully.');
            return back();
        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->route('products.index')->withErrors($e->getMessage());
        }
    }
}
