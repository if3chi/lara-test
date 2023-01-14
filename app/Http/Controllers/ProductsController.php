<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return view('product', compact('products'));
    }

    public function create()
    {
        # code...
    }

    public function store(Request $request)
    {
        Product::create($request->only(['name', 'price']));

        return redirect('products');
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return Redirect::route('products.edit', $product->id)->with('status', 'product-updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return Redirect::route('products');
    }
}
