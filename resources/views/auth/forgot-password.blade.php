<x-guest-layout>
    <div class="mb-3">
        <h1 class="h4 mb-1 fw-bold" style="color: var(--primary-color);">Forgot your password?</h1>
        <p class="text-muted mb-0">No worries. Enter your email and we’ll send you a reset link.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a class="text-decoration-none" href="{{ route('login') }}">Back to login</a>
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px; background: var(--primary-color); border: none;">Send reset link</button>
        </div>
    </form>
</x-guest-layout>
