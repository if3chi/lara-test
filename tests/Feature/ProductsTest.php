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
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    public function test_products_home_returns_successful_response()
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
    }

    public function test_products_homepage_contains_empty_table()
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertSeeText('Nothing to show');
    }

    public function test_products_homepage_contains_non_empty_table()
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSeeText('Nothing to show');
        $response->assertViewHas('products', fn ($collection) => $collection->contains($product));
    }

    public function test_paginated_data_doesnt_contain_11th_record()
    {
        $product = $this->createProduct(amount: 11)->last();

        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', fn ($collection) => !$collection->contains($product));
    }

    public function test_admin_can_see_product_create_button()
    {
        $response = $this->actingAs($this->admin)->get('/products');

        $response->assertStatus(200);
        $response->assertSee('New Product');
    }

    public function test_non_admin_cannot_see_product_create_button()
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee('Add New Product');
    }

    public function test_admin_can_access_product_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/products/create');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_product_create_page()
    {
        $response = $this->actingAs($this->user)->get('/products/create');

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_create_product()
    {
        $response = $this->actingAs($this->user)->post('/products');

        $response->assertStatus(403);
    }

    public function test_admin_can_create_product_successfully()
    {
        $product = ['name' => 'AD product', 'price' => 9.99];

        $response = $this->actingAs($this->admin)->post('/products', $product);

        $response->assertStatus(302);
        $response->assertRedirect('products');
        $this->assertDatabaseHas('products', $product);

        $latestProduct = Product::latest()->first();
        $this->assertEquals($product['name'], $latestProduct->name);
        $this->assertEquals($product['price'], $latestProduct->price);
    }

    public function test_admin_can_access_product_edit_page()
    {
        $product = $this->createProduct();

        $response = $this->get(route('products.edit', $product->id));

        $response->assertStatus(302);
        $response->assertRedirect('login');

        $response = $this->actingAs($this->admin)->get(route('products.edit', $product->id));

        $response->assertStatus(200);
        $response->assertSee("value=\"$product->name\"", escape: false);
        $response->assertSee("value=\"$product->price\"", escape: false);
        $response->assertViewHas('product', $product);
    }

    public function test_product_update_throws_validation_errors_and_redirects_back_to_form()
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->admin)
            ->put(route('products.update', $product->id), ['name' => '', 'price' => 'qww']);

        $response->assertStatus(302);
        $response->assertInvalid(['name', 'price']);
        $response->assertSessionHasErrors(['name', 'price']);
    }

    private function createUser(?int $amount = null, bool $isAdmin = false): User|Collection
    {
        return User::factory($amount)->create(['is_admin' => $isAdmin]);
    }

    private function createProduct(?int $amount = null): Product|Collection
    {
        return Product::factory($amount)->create();
    }
}
