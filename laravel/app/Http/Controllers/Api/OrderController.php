<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return Order::with('items')->where('user_id', $request->user()->id)->latest()->get();
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        return $order->load('items');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string'],
        ]);

        $items = CartItem::with('product')->where('user_id', $request->user()->id)->get();
        if ($items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        return DB::transaction(function () use ($request, $data, $items) {
            $order = Order::create($data + [
                'user_id' => $request->user()->id,
                'total' => $items->sum(fn ($item) => $item->quantity * $item->product->price),
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
            }

            CartItem::where('user_id', $request->user()->id)->delete();

            return response()->json($order->load('items'), 201);
        });
    }
}
