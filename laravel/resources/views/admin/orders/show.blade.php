@extends('admin.layout')
@section('content')
<h1>Order #{{ $order->id }}</h1>
<div class="card">
<p><b>Customer:</b> {{ $order->customer_name }} | {{ $order->phone }}</p>
<p><b>Address:</b> {{ $order->address }}</p>
<form method="post" action="{{ route('admin.orders.update',$order) }}">@csrf @method('patch')<label>Status</label><select name="status"><option @selected($order->status==='pending')>pending</option><option @selected($order->status==='completed')>completed</option><option @selected($order->status==='cancelled')>cancelled</option></select><p><button>Update</button></p></form>
</div>
<table><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
@foreach($order->items as $item)<tr><td>{{ $item->product_name }}</td><td>${{ $item->price }}</td><td>{{ $item->quantity }}</td><td>${{ $item->subtotal }}</td></tr>@endforeach
</table>
@endsection
