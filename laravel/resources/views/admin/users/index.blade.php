@extends('admin.layout')
@section('content')
<h1>Users</h1>
<table><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr>
@foreach($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->is_admin ? 'Admin' : 'Customer' }}</td><td>{{ $user->created_at->format('Y-m-d') }}</td></tr>@endforeach
</table>
{{ $users->links() }}
@endsection
