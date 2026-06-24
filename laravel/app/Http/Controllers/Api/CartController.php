<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return CartItem::with('product.category')->where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $item = CartItem::firstOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $data['product_id']],
            ['quantity' => 0],
        );
        $item->increment('quantity', $data['quantity'] ?? 1);

        return $item->load('product.category');
    }

    public function update(Request $request, CartItem $cart)
    {
        abort_unless($cart->user_id === $request->user()->id, 403);
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $cart->update($data);

        return $cart->load('product.category');
    }

    public function destroy(Request $request, CartItem $cart)
    {
        abort_unless($cart->user_id === $request->user()->id, 403);
        $cart->delete();

        return response()->noContent();
    }
}
