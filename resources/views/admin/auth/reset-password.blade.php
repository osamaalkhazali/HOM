<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Password - {{ config('app.name', 'HOM') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('hom-favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('hom-favicon.png') }}">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Site shared styles -->
    @include('layouts.styles')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
        }
        .auth-logo { height: 120px; width: auto; }
        .auth-card {
            border-radius: 10px;
            border: 1px solid #e0e6ed;
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="auth-card panel shadow-soft w-100" style="max-width: 420px;">
            <div class="panel-body p-4">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
                        <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM" class="auth-logo">
                    </a>
                </div>

                <div class="text-center mb-4">
                    <h1 class="h3 mb-2 fw-bold" style="color: var(--primary-color);">Reset Password</h1>
                    <p class="text-muted mb-0">Enter your new password below</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" class="form-control bg-light" value="{{ old('email', $email) }}" readonly style="cursor: not-allowed;" placeholder="admin@example.com">
                        <small class="text-muted"><i class="fas fa-lock me-1"></i>Email is locked for security</small>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <div class="position-relative">
                            <input id="password" type="password" name="password" class="form-control pe-5" required autofocus autocomplete="new-password" placeholder="Enter new password">
                            <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted" onclick="togglePasswordVisibility('password', this)" style="text-decoration: none;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <x-password-checklist for="password" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="position-relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control pe-5" required autocomplete="new-password" placeholder="Confirm new password">
                            <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted" onclick="togglePasswordVisibility('password_confirmation', this)" style="text-decoration: none;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3 py-2" style="border-radius: 10px; background: var(--primary-color); border: none;">
                        <i class="fas fa-key me-2"></i>Reset Password
                    </button>

                    <div class="text-center">
                        <a class="text-decoration-none" href="{{ route('admin.login') }}" style="color: var(--primary-color);">
                            <i class="fas fa-arrow-left me-1"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
