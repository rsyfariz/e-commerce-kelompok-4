<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = product::findOrFail($id);
        return view('product.show', ['productId' => $product]);
    }
}