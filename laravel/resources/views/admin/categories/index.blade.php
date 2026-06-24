@extends('admin.layout')
@section('content')
<div class="actions"><h1 style="margin-right:auto">Categories</h1><a class="btn" href="{{ route('admin.categories.create') }}">Create</a></div>
<table><tr><th>Name</th><th>Description</th><th>Actions</th></tr>
@foreach($categories as $category)
<tr><td>{{ $category->name }}</td><td>{{ $category->description }}</td><td class="actions"><a href="{{ route('admin.categories.edit',$category) }}">Edit</a><form method="post" action="{{ route('admin.categories.destroy',$category) }}">@csrf @method('delete')<button class="danger">Delete</button></form></td></tr>
@endforeach
</table>
{{ $categories->links() }}
@endsection
