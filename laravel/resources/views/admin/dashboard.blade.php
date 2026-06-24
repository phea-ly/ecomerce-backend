@extends('admin.layout')
@section('content')
<h1>Dashboard</h1>
<div class="grid">
    <div class="card"><div class="muted">Categories</div><div class="stat">{{ $categories }}</div></div>
    <div class="card"><div class="muted">Products</div><div class="stat">{{ $products }}</div></div>
    <div class="card"><div class="muted">Orders</div><div class="stat">{{ $orders }}</div></div>
    <div class="card"><div class="muted">Users</div><div class="stat">{{ $users }}</div></div>
    <div class="card"><div class="muted">Sales</div><div class="stat">${{ number_format($sales, 2) }}</div></div>
</div>
<div class="card">
    <h2>Latest Orders</h2>
    <table><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr>
    @foreach($latestOrders as $order)
        <tr><td>#{{ $order->id }}</td><td>{{ $order->customer_name }}</td><td>${{ $order->total }}</td><td>{{ $order->status }}</td><td><a href="{{ route('admin.orders.show',$order) }}">View</a></td></tr>
    @endforeach
    </table>
</div>
@endsection
