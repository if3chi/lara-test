<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\HasProductUtilies;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase, HasProductUtilies;

    public function test_api_returns_products_list()
    {
        $product = $this->createProduct();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJson([$product->toArray()]);
    }

    public function test_api_product_store_validates_request()
    {
        $response = $this->postJson('/api/products');

        $response->assertStatus(422);
    }

    public function test_api_product_store_successful()
    {
        $product = [
            'name' => 'Green',
            'price' => 98.89
        ];

        $response = $this->postJson('/api/products', $product);

        $response->assertStatus(201);
        $response->assertJson($product);
    }
}
