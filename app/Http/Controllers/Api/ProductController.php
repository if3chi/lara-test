<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

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
        // $product->delete();

        return $product->delete();
    }
}
