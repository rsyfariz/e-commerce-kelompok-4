<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        // Ambil produk dengan relasi yang dibutuhkan
        $product = Product::with([
            'productImages',           // Gambar produk
            'productCategory',         // Kategori produk
            'store.user',             // Toko dan pemiliknya
            // 'reviews.user'          // Uncomment jika sudah ada fitur review
        ])->findOrFail($id);

        // Ambil produk terkait dari kategori yang sama
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)       // Exclude produk yang sedang dilihat
            ->where('stock', '>', 0)                // Hanya yang masih ada stok
            ->with(['productImages', 'store'])      // Eager load relasi
            ->limit(4)                              // Maksimal 4 produk
            ->get();

        return view('detailProduct', compact('product', 'relatedProducts'));
    }
}