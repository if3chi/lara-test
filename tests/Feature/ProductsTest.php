<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_home_returns_successful_response()
    {
        $response = $this->get('/product');

        $response->assertStatus(200);
    }

    public function test_products_homepage_contains_empty_table()
    {
        $response = $this->get('/product');

        $response->assertStatus(200);
        $response->assertSeeText('Nothing to show');
    }

    public function test_products_homepage_contains_non_empty_table()
    {
        $product = Product::factory()->create();

        $response = $this->get('/product');

        $response->assertStatus(200);
        $response->assertDontSeeText('Nothing to show');
        $response->assertViewHas('products', fn ($collection) => $collection->contains($product));
    }

    public function test_paginated_data_doesnt_contain_11th_record()
    {
        $product = Product::factory(11)->create()->last();

        $response = $this->get('/product');

        $response->assertStatus(200);
        $response->assertViewHas('products', fn ($collection) => !$collection->contains($product));
    }
}
