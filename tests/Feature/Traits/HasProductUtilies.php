<?php

namespace Tests\Feature\Traits;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;


trait HasProductUtilies
{
    private function createUser(?int $amount = null, bool $isAdmin = false): User|Collection
    {
        return User::factory($amount)->create(['is_admin' => $isAdmin]);
    }

    private function createProduct(?int $amount = null): Product|Collection
    {
        return Product::factory($amount)->create();
    }
}
