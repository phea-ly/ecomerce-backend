@extends('admin.layout')
@section('content')
<div class="actions"><h1 style="margin-right:auto">Products</h1><a class="btn" href="{{ route('admin.products.create') }}">Create</a></div>
<table><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
@foreach($products as $product)
<tr><td>@if($product->image_url)<img class="thumb" src="{{ $product->image_url }}">@endif</td><td>{{ $product->name }}</td><td>{{ $product->category?->name }}</td><td>${{ $product->price }}</td><td>{{ $product->stock }}</td><td class="actions"><a href="{{ route('admin.products.edit',$product) }}">Edit</a><form method="post" action="{{ route('admin.products.destroy',$product) }}">@csrf @method('delete')<button class="danger">Delete</button></form></td></tr>
@endforeach
</table>
{{ $products->links() }}
@endsection
