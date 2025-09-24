<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="h3 mb-2 fw-bold" style="color: var(--primary-color);">Welcome back</h1>
        <p class="text-muted mb-0">Sign in to your account to continue</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="Enter your password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label text-muted" for="remember_me">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-decoration-none small" href="{{ route('password.request') }}" style="color: var(--primary-color);">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3 py-2" style="border-radius: 10px; background: var(--primary-color); border: none;">
            <i class="fas fa-sign-in-alt me-2"></i>Sign in
        </button>

        <div class="text-center">
            <span class="text-muted">Don't have an account?</span>
            <a class="text-decoration-none ms-1" href="{{ route('register') }}" style="color: var(--primary-color);">Create one</a>
        </div>
    </form>
</x-guest-layout>
