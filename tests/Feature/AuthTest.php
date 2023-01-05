<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthencated_user_cannot_access_product_page()
    {
        $response = $this->get('/product');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_authencated_user_can_access_product_page()
    {
        User::factory()->create([
            'email' => 'test@lara.com',
            'password' => bcrypt('passwd')
        ]);

        $this->post('/login', [
            'email' => 'test@lara.com',
            'password' => 'passwd'
        ]);
        $response = $this->get('/product');

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }
}
