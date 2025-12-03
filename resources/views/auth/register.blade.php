<x-guest-layout>
    <div class="text-center mb-4">
        <h1 class="h3 mb-2 fw-bold" style="color: var(--primary-color);">{{ __('auth.register.title') }}</h1>
        <p class="text-muted mb-0">{{ __('auth.register.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('auth.register.name_label') }}</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('auth.register.name_placeholder') }}">
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.register.email_label') }}</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username" placeholder="{{ __('auth.register.email_placeholder') }}">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('auth.register.password_label') }}</label>
            <div class="position-relative">
                <input id="password" type="password" name="password" class="form-control pe-5" required autocomplete="new-password" placeholder="{{ __('auth.register.password_placeholder') }}">
                <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted" onclick="togglePasswordVisibility('password', this)" style="text-decoration: none;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <x-password-checklist for="password" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">{{ __('auth.register.password_confirmation_label') }}</label>
            <div class="position-relative">
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control pe-5" required autocomplete="new-password" placeholder="{{ __('auth.register.password_confirmation_placeholder') }}">
                <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted" onclick="togglePasswordVisibility('password_confirmation', this)" style="text-decoration: none;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3 py-2" style="border-radius: 10px; background: var(--primary-color); border: none;">
            <i class="fas fa-user-plus me-2"></i>{{ __('auth.register.submit') }}
        </button>

        <div class="text-center">
            <span class="text-muted">{{ __('auth.register.have_account') }}</span>
            <a class="text-decoration-none ms-1" href="{{ route('login') }}" style="color: var(--primary-color);">{{ __('auth.register.login_cta') }}</a>
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
