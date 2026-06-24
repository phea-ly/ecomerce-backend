<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'categories' => Category::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'users' => User::where('is_admin', false)->count(),
            'sales' => Order::sum('total'),
            'latestOrders' => Order::latest()->take(5)->get(),
        ]);
    }
}
