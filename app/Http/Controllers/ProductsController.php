<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
