<x-guest-layout>
    <div class="mb-3">
        <h1 class="h4 mb-1 fw-bold" style="color: var(--primary-color);">Set a new password</h1>
        <p class="text-muted mb-0">Enter your email and choose a strong password.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-2">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px; background: var(--primary-color); border: none;">Reset Password</button>
        </div>
    </form>
</x-guest-layout>
