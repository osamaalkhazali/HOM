<section>
    <header class="mb-4">
        <h5 class="fw-bold mb-2" style="color: var(--primary-color);">
            <i class="fas fa-lock me-2"></i>{{ __('site.profile_form.password.title') }}
        </h5>
        <p class="text-muted small">
            {{ __('site.profile_form.password.description') }}
        </p>
    </header>

    @if ($errors->updatePassword->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>{{ __('Please correct the following errors:') }}</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password"
                class="form-label fw-medium">{{ __('site.profile_form.password.current') }}</label>
            <input type="password" class="form-control form-control-lg @error('current_password', 'updatePassword') is-invalid @enderror" id="update_password_current_password"
                name="current_password" autocomplete="current-password"
                style="border-radius: 15px; border: 2px solid #e9ecef;">
            @if ($errors->updatePassword->get('current_password'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->updatePassword->get('current_password') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-medium">{{ __('site.profile_form.password.new') }}</label>
            <input type="password" class="form-control form-control-lg @error('password', 'updatePassword') is-invalid @enderror" id="update_password_password" name="password"
                autocomplete="new-password" style="border-radius: 15px; border: 2px solid #e9ecef;">
            @if ($errors->updatePassword->get('password'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->updatePassword->get('password') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation"
                class="form-label fw-medium">{{ __('site.profile_form.password.confirm') }}</label>
            <input type="password" class="form-control form-control-lg @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="update_password_password_confirmation"
                name="password_confirmation" autocomplete="new-password"
                style="border-radius: 15px; border: 2px solid #e9ecef;">
            @if ($errors->updatePassword->get('password_confirmation'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn morph-btn fw-semibold px-4 py-2 text-white"
                style="background: var(--gradient-3); border: none; border-radius: 25px;">
                <i class="fas fa-shield-alt me-2"></i>{{ __('site.profile_form.password.button') }}
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus first password input with error
            var firstErrorInput = document.querySelector('#update_password_current_password.is-invalid, #update_password_password.is-invalid, #update_password_password_confirmation.is-invalid');
            if (firstErrorInput) {
                firstErrorInput.focus();
                firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
</section>
