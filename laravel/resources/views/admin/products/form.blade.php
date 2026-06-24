@extends('admin.layout')
@section('content')
<h1>{{ $product->exists ? 'Edit' : 'Create' }} Product</h1>
<div class="card">
<form method="post" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update',$product) : route('admin.products.store') }}">
@csrf @if($product->exists) @method('put') @endif
<label>Category</label><select name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select>
<label>Name</label><input name="name" value="{{ old('name',$product->name) }}" required>
<label>Description</label><textarea name="description">{{ old('description',$product->description) }}</textarea>
<label>Price</label><input name="price" type="number" step="0.01" min="0" value="{{ old('price',$product->price) }}" required>
<label>Stock</label><input name="stock" type="number" min="0" value="{{ old('stock',$product->stock ?? 0) }}" required>
<label>Image URL</label><input name="image_url" type="url" placeholder="https://example.com/product.jpg" value="{{ old('image_url', filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : '') }}">
<label>Upload Image</label><input name="image" type="file" accept="image/*">
@if($product->image_url)<p><img class="thumb" src="{{ $product->image_url }}"></p>@endif
<label><input style="width:auto" name="is_active" type="checkbox" value="1" @checked(old('is_active',$product->is_active))> Active</label>
<p><button>Save</button></p>
</form>
</div>
@endsection
