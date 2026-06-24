@extends('admin.layout')
@section('content')
<div class="card" style="max-width:420px;margin:70px auto">
    <h1>Admin Login</h1>
    <form method="post" action="{{ route('admin.login.store') }}">
        @csrf
        <label>Email</label>
        <input name="email" type="email" value="{{ old('email') }}" required>
        @error('email')<p class="error">{{ $message }}</p>@enderror
        <label>Password</label>
        <input name="password" type="password" required>
        <p><button class="btn">Login</button></p>
    </form>
</div>
@endsection
