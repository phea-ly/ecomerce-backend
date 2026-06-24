<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    public function index(Request $request)
    {
        return Product::with('category')
            ->where('is_active', true)
            ->when($request->search, fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->when($request->category_id, fn ($q, $id) => $q->where('category_id', $id))
            ->when($request->min_price, fn ($q, $price) => $q->where('price', '>=', $price))
            ->when($request->max_price, fn ($q, $price) => $q->where('price', '<=', $price))
            ->latest()
            ->paginate(12);
    }

    public function show(Product $product)
    {
        return $product->load(['category', 'reviews.user:id,name']);
    }
}
