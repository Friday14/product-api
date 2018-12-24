<?php

namespace Tests\Feature;

use App\Domain\Products\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends BaseFeature
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testUpdateProduct()
    {
        $this->createProducts();
        $product = Product::first();
        $payload = [
            'name' => 'Product Name',
            'description' => 'Product Description',
            'price' => 10
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getUserToken())
            ->put(route('products.update', $product), $payload);

        $response->assertStatus(200);
        $updatedProduct = Product::find($product->id);

        $this->assertEquals($payload['name'], $updatedProduct->name);
        $this->assertEquals($payload['description'], $updatedProduct->description);
        $this->assertEquals($payload['price'], $updatedProduct->price);
    }

    public function testCreateProduct()
    {
        $payload = [
            'name' => 'Product Name',
            'description' => 'Product Description',
            'price' => 10
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getUserToken())
            ->post(route('products.store'), $payload);
        $response->assertJsonStructure([
            'message',
            'data' => ['id', 'name', 'description', 'price', 'created_at']
        ]);
    }

    public function testDeleteProduct()
    {
        $this->createProducts();
        $product = Product::first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getUserToken())
            ->delete(route('products.destroy', $product));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

}
