<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    public function test_products_home_returns_successful_response()
    {
        $response = $this->actingAs($this->user)->get('/product');

        $response->assertStatus(200);
    }

    public function test_products_homepage_contains_empty_table()
    {
        $response = $this->actingAs($this->user)->get('/product');

        $response->assertStatus(200);
        $response->assertSeeText('Nothing to show');
    }

    public function test_products_homepage_contains_non_empty_table()
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->user)->get('/product');

        $response->assertStatus(200);
        $response->assertDontSeeText('Nothing to show');
        $response->assertViewHas('products', fn ($collection) => $collection->contains($product));
    }

    public function test_paginated_data_doesnt_contain_11th_record()
    {
        $product = $this->createProduct(11)->last();

        $response = $this->actingAs($this->user)->get('/product');

        $response->assertStatus(200);
        $response->assertViewHas('products', fn ($collection) => !$collection->contains($product));
    }

    private function createUser(?int $amount = null): User
    {
        return User::factory($amount)->create();
    }

    private function createProduct(?int $amount = null): Product|Collection
    {
        return Product::factory($amount)->create();
    }
}
