<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Malangkab.com</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css">
    <style>
        body { background: linear-gradient(160deg,#2F4A34,#23392A); min-height:100vh; }
        .login-box { margin-top: 8vh; }
        .btn-malang { background:#C98A2C; border-color:#C98A2C; color:#23392A; font-weight:600; }
        .btn-malang:hover { background:#b87c22; color:#23392A; }
    </style>
</head>
<body class="login-page d-flex align-items-center">
<div class="login-box mx-auto">
    <div class="login-logo text-white mb-3 text-center">
        <strong>Malangkab<span style="color:#C98A2C">.com</span></strong><br>
        <small>Panel Admin</small>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Masuk untuk mengelola kategori & artikel</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required autofocus>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <div class="col-5">
                        <button type="submit" class="btn btn-malang w-100">Masuk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
