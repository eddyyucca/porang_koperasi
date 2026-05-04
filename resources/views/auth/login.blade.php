<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        body { background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #4caf50 100%); min-height: 100vh; }
        .login-box { width: 400px; }
        .login-logo { color: #fff; text-shadow: 1px 1px 3px rgba(0,0,0,0.4); }
        .login-logo small { font-size: 0.85rem; font-weight: 300; display: block; margin-top: 4px; color: rgba(255,255,255,0.8); }
        .login-card-body { border-radius: 12px; }
        .login-card-body .btn-primary { background: #2e7d32; border-color: #1b5e20; }
        .login-card-body .btn-primary:hover { background: #1b5e20; }
        .porang-icon { font-size: 3rem; color: #a5d6a7; margin-bottom: 10px; }
        @media (max-width: 420px) { .login-box { width: 95%; margin: 0 auto; } }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <div class="porang-icon"><i class="fas fa-seedling"></i></div>
        <b>Koperasi Tani</b> Porang
        <small>Sistem Informasi Manajemen Pertanian</small>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg text-muted">Masuk ke akun Anda</p>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Ingat Saya</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-3 text-center">
                <small class="text-muted">Hubungi administrator jika lupa password</small>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <small class="text-white-50">&copy; {{ date('Y') }} Koperasi Tani Porang</small>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
