<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\HasProductUtilies;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase, HasProductUtilies;

    public function test_api_products_endpoint_returns_success_with_data()
    {
        $product = $this->createProduct();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJson([$product->toArray()]);
    }
}
