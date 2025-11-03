<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verify Email - {{ config('app.name', 'HOM') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('hom-favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('hom-favicon.png') }}">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Site shared styles -->
    @include('layouts.styles')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
        }

        .auth-logo {
            height: 120px;
            width: auto;
        }

        .auth-card {
            border-radius: 10px;
            border: 1px solid #e0e6ed;
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="auth-card panel shadow-soft w-100" style="max-width: 500px;">
            <div class="panel-body p-4">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
                        <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM" class="auth-logo">
                    </a>
                </div>

                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-envelope-open-text" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h1 class="h3 mb-2 fw-bold" style="color: var(--primary-color);">Verify Your Email</h1>
                    <p class="text-muted mb-0">Before proceeding, please check your email for a verification link.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    If you did not receive the email, enter your email address below and click the button to request
                    another.
                </div>

                <form method="POST" action="{{ route('admin.verification.resend') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" class="form-control"
                            value="{{ session('admin_email', old('email')) }}" required autofocus
                            autocomplete="username" placeholder="admin@example.com">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3 py-2"
                        style="border-radius: 10px; background: var(--primary-color); border: none;">
                        <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
                    </button>

                    <div class="text-center">
                        <a class="text-decoration-none" href="{{ route('admin.login') }}"
                            style="color: var(--primary-color);">
                            <i class="fas fa-arrow-left me-1"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
