<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} - AVOCADO</title>
    <style>
        body{margin:0;font-family:Arial,sans-serif;background:#f5f7fb;color:#172033}a{color:#1456d9;text-decoration:none}.app{min-height:100vh}.wrap{max-width:none;margin:0;padding:40px 48px}.nav{position:fixed;inset:0 auto 0 0;width:280px;background:#111c30;color:white;padding:26px 22px;box-sizing:border-box;display:flex;flex-direction:column;gap:8px;box-shadow:8px 0 24px rgba(15,23,42,.08)}.nav a{color:#dbe7ff;padding:13px 14px;border-radius:8px;font-weight:700}.nav a:hover,.nav a.active{background:#223456;color:white}.brand{display:flex;gap:12px;align-items:center;font-size:22px;line-height:1.15;font-weight:800;margin:4px 0 34px;color:white}.brand-mark{width:42px;height:42px;border-radius:10px;background:#1f6feb;display:grid;place-items:center;font-size:20px;box-shadow:0 10px 24px rgba(31,111,235,.28)}.brand small{display:block;margin-top:4px;font-size:12px;font-weight:700;color:#8fb3e8;letter-spacing:.08em;text-transform:uppercase}.nav form{margin-top:auto}.nav button{width:100%;text-align:center;border-radius:8px;font-weight:700}.content{margin-left:280px}.card{background:white;border:1px solid #e3e8f2;border-radius:8px;padding:18px;margin:16px 0}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px}.stat{font-size:28px;font-weight:700}h1{margin:0 0 26px;font-size:38px;letter-spacing:0}table{width:100%;border-collapse:collapse;background:white;border:1px solid #e3e8f2;border-radius:8px;overflow:hidden}th,td{padding:14px 16px;border-bottom:1px solid #e3e8f2;text-align:left}tr:last-child td{border-bottom:0}input,textarea,select{width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:6px;box-sizing:border-box}label{display:block;font-weight:700;margin-top:12px}.btn,button{display:inline-block;border:0;border-radius:6px;background:#1456d9;color:white;padding:9px 13px;cursor:pointer}.danger{background:#c62828}.muted{color:#64748b}.actions{display:flex;gap:8px;align-items:center}.alert{background:#ddf8e8;border:1px solid #91d8ad;padding:10px;border-radius:6px}.error{color:#c62828}.thumb{width:56px;height:56px;object-fit:cover;border-radius:6px;background:#e2e8f0}@media(max-width:900px){.nav{position:static;width:auto;flex-direction:row;flex-wrap:wrap;align-items:center}.brand{width:100%;margin-bottom:8px}.nav form{margin-top:0;margin-left:auto}.nav button{width:auto}.content{margin-left:0}.wrap{padding:24px 16px}}
    </style>
</head>
<body>
<div class="app">
@auth
    <aside class="nav">
        <div class="brand"><span class="brand-mark">A</span><span>AVOCADO<br><small>Admin Panel</small></span></div>
        <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a>
        <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Products</a>
        <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Orders</a>
        <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
        <form method="post" action="{{ route('admin.logout') }}">@csrf<button>Logout</button></form>
    </aside>
@endauth
<main class="{{ auth()->check() ? 'content' : '' }}">
    <div class="wrap">
    @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
    @yield('content')
    </div>
</main>
</div>
</body>
</html>
