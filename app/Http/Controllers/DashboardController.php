<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('productImages')->get();

        return view('dashboard', compact('products'));
    }
}
