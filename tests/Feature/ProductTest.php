<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testProductsIndexReturnsSuccess(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function testProductRecordStoreRedirectsToIndex(): void
    {
        Product::query()->where('name', 'test product')->delete();
        $response = $this->post('/products', [
            "name" => "test product",
            "price" => random_int(100, 1000),
            "product_sku_id" => ProductSku::query()->inRandomOrder()->first()->id
        ]);
        $response->assertRedirectToRoute('products.index');

    }

    public function testProductRecordEditRedirectsToIndex()
    {
        $product = Product::query()->updateOrCreate([
            "name" => "test product",
            "product_sku_id" => ProductSku::query()->inRandomOrder()->first()->id
        ], [
            "price" => random_int(100, 1000),
        ]);
        $response = $this->put('/products/' . $product->id, [
            "name" => $product->name,
            "product_sku_id" => ProductSku::query()->inRandomOrder()->first()->id,
            "price" => random_int(100, 1000)
        ]);

        $response->assertRedirectToRoute('products.index');
    }
}
