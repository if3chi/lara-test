<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }
    public function store(ProductRequest $request)
    {
        return Product::create($request->validated());
    }

    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
