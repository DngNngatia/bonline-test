<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('sku')
            ->orderByDesc('id')
            ->paginate($request->input('per_page', 10));

        return response()->json([
            "message" => "Products retrieved successfully!",
            "data" => $products
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:products'],
            'product_sku_id' => ['required'],
            'price' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Error creating product",
                "errors" => collect($validator->errors()->all())->join(',')
            ], 422);
        }
        Product::query()->updateOrCreate([
            'name' => $request->input('name'),
            'product_sku_id' => $request->input('product_sku_id')
        ], [
            'price' => $request->input('price')
        ]);
        return response()->json([
            "message" => "Products created successfully!",
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::query()->with('sku:id,name')->findOrFail($id);
        return response()->json([
            "message" => "Product retrieved successfully!",
            "data" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'product_sku_id' => ['required'],
            'price' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Error updating product",
                "errors" => collect($validator->errors()->all())->join(',')
            ], 422);
        }
        $product = Product::query()->lockForUpdate()->findOrFail($id);
        $product->update($request->only('name', 'product_sku_id', 'price'));

        return response()->json([
            "message" => "Product updated successfully!",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
