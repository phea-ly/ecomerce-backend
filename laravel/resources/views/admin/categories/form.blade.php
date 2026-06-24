@extends('admin.layout')
@section('content')
<h1>{{ $category->exists ? 'Edit' : 'Create' }} Category</h1>
<div class="card">
<form method="post" action="{{ $category->exists ? route('admin.categories.update',$category) : route('admin.categories.store') }}">
@csrf @if($category->exists) @method('put') @endif
<label>Name</label><input name="name" value="{{ old('name',$category->name) }}" required>@error('name')<p class="error">{{ $message }}</p>@enderror
<label>Description</label><textarea name="description">{{ old('description',$category->description) }}</textarea>
<p><button>Save</button></p>
</form>
</div>
@endsection
