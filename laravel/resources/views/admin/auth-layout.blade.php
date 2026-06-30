<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - AVOCADOO SHOP</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Arial,sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .login-container{background:white;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,0.3);padding:40px;width:100%;max-width:420px;animation:fadeIn 0.5s ease-in}
        @keyframes fadeIn{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}
        .login-header{text-align:center;margin-bottom:30px}
        .login-header h1{color:#1a202c;font-size:32px;margin-bottom:8px;font-weight:700}
        .login-header p{color:#718096;font-size:14px}
        .form-group{margin-bottom:20px}
        label{display:block;font-weight:600;color:#2d3748;margin-bottom:8px;font-size:14px}
        input[type="email"],input[type="password"]{width:100%;padding:12px 16px;border:2px solid#e2e8f0;border-radius:8px;font-size:15px;transition:all 0.3s;background:#f7fafc}
        input[type="email"]:focus,input[type="password"]:focus{outline:none;border-color:#667eea;background:white;box-shadow:0 0 0 3px rgba(102,126,234,0.1)}
        .btn{width:100%;padding:14px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white;border:none;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;transition:transform 0.2s;box-shadow:0 4px 12px rgba(102,126,234,0.4)}
        .btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(102,126,234,0.5)}
        .btn:active{transform:translateY(0)}
        .error{color:#e53e3e;font-size:13px;margin-top:6px;display:block}
        .example-credentials{background:#f7fafc;border-left:4px solid#667eea;padding:12px 16px;margin-top:24px;border-radius:6px;font-size:13px;color:#4a5568}
        .example-credentials strong{color:#2d3748;display:block;margin-bottom:6px}
        .example-credentials code{background:#edf2f7;padding:2px 6px;border-radius:4px;font-family:monospace;color:#667eea}
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand" style="text-align:center;margin-bottom:30px">
            <span class="brand-mark" style="margin:0 auto 10px;width:36px;height:36px;font-size:16px">A</span>
            <span style="font-size:20px;font-weight:800;color:#1a202c;display:block">AVOCADO<br><small style="font-size:10px;font-weight:600;color:#718096;letter-spacing:0.08em;text-transform:uppercase">Admin Panel</small></span>
        </div>
        <div class="login-header">
            <h1 style="font-size:28px">Welcome Back</h1>
            <p style="font-size:13px">Please sign in to continue</p>
        </div>

        <form method="post" action="{{ route('admin.login.store') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input name="email" type="email" id="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                @error('email')<span class="error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" type="password" id="password" placeholder="Enter your password" required>
                @error('password')<span class="error">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="example-credentials">
            <strong>Demo Credentials:</strong>
            <p>Email: <code>admin@example.com</code></p>
            <p>Password: <code>password123</code></p>
        </div>
    </div>
</body>
</html>