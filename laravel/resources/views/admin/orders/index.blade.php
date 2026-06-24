@extends('admin.layout')
@section('content')
<h1>Orders</h1>
<table><tr><th>ID</th><th>Customer</th><th>Phone</th><th>Total</th><th>Status</th><th></th></tr>
@foreach($orders as $order)
<tr><td>#{{ $order->id }}</td><td>{{ $order->customer_name }}</td><td>{{ $order->phone }}</td><td>${{ $order->total }}</td><td>{{ $order->status }}</td><td><a href="{{ route('admin.orders.show',$order) }}">View</a></td></tr>
@endforeach
</table>
{{ $orders->links() }}
@endsection
