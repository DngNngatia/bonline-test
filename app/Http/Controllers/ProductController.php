<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // list all products
        $products = Product::query()
            ->with('sku')
            ->orderByDesc('id')
            ->paginate($request->input('per_page', 10));

        return view('products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product_skus = ProductSku::query()->get();
        // show form to create a product
        return view('products.create', compact('product_skus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // product form submit action
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:products'],
            'product_sku_id' => ['required'],
            'price' => ['required']
        ]);
        if ($validator->fails()) {
            return back()->with('error',collect($validator->errors()->all())->join(','));
        }
        Product::query()->updateOrCreate([
            'name' => $request->input('name'),
            'product_sku_id' => $request->input('product_sku_id')
        ], [
            'price' => $request->input('price')
        ]);

        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // show a single product
        $product = Product::query()->with('sku:id,name')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // show product edit form
        $product_skus = ProductSku::query()->get();
        $product = Product::query()->findOrFail($id);
        return view('products.edit', compact('product', 'product_skus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // product edit update action
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'product_sku_id' => ['required'],
            'price' => ['required']
        ]);
        if ($validator->fails()) {
            return back()->with('error',collect($validator->errors()->all())->join(','));
        }
        $product = Product::query()->lockForUpdate()->findOrFail($id);
        $product->update($request->only('name', 'product_sku_id', 'price'));

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete a product
    }
}
