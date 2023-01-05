<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_home_returns_successful_response()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/product');

        $response->assertStatus(200);
    }

    public function test_products_homepage_contains_empty_table()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/product');

        $response->assertStatus(200);
        $response->assertSeeText('Nothing to show');
    }

    public function test_products_homepage_contains_non_empty_table()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get('/product');

        $response->assertStatus(200);
        $response->assertDontSeeText('Nothing to show');
        $response->assertViewHas('products', fn ($collection) => $collection->contains($product));
    }

    public function test_paginated_data_doesnt_contain_11th_record()
    {
        $user = User::factory()->create();
        $product = Product::factory(11)->create()->last();

        $response = $this->actingAs($user)->get('/product');

        $response->assertStatus(200);
        $response->assertViewHas('products', fn ($collection) => !$collection->contains($product));
    }
}
