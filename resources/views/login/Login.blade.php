<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .auth-card {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="auth-card">
    <h3 class="text-center mb-4">تسجيل الدخول</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>

        <p class="text-center mt-3">
            ليس لديك حساب؟ <a href="{{ route('register.form') }}">سجل الآن</a>
        </p>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>