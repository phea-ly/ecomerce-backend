<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return Wishlist::with('product.category')->where('user_id', $request->user()->id)->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['product_id' => ['required', 'exists:products,id']]);

        return Wishlist::firstOrCreate(['user_id' => $request->user()->id, 'product_id' => $data['product_id']]);
    }

    public function destroy(Request $request, int $product)
    {
        Wishlist::where('user_id', $request->user()->id)->where('product_id', $product)->delete();

        return response()->noContent();
    }
}
