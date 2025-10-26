<x-guest-layout>
    <div class="mb-3">
        <h1 class="h4 mb-1 fw-bold" style="color: var(--primary-color);">{{ __('auth.reset.title') }}</h1>
        <p class="text-muted mb-0">{{ __('auth.reset.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-2">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.reset.email_label') }}</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('auth.reset.password_label') }}</label>
            <div class="position-relative">
                <input id="password" type="password" name="password" class="form-control pe-5" required autocomplete="new-password">
                <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted" onclick="togglePasswordVisibility('password', this)" style="text-decoration: none;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('auth.reset.password_confirmation_label') }}</label>
            <div class="position-relative">
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control pe-5" required autocomplete="new-password">
                <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted" onclick="togglePasswordVisibility('password_confirmation', this)" style="text-decoration: none;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px; background: var(--primary-color); border: none;">{{ __('auth.reset.submit') }}</button>
        </div>
    </form>

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
</x-guest-layout>
