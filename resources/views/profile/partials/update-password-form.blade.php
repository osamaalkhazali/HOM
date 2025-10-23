<section>
    <header class="mb-4">
        <h5 class="fw-bold mb-2" style="color: var(--primary-color);">
            <i class="fas fa-lock me-2"></i>{{ __('site.profile_form.password.title') }}
        </h5>
        <p class="text-muted small">
            {{ __('site.profile_form.password.description') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password"
                class="form-label fw-medium">{{ __('site.profile_form.password.current') }}</label>
            <input type="password" class="form-control form-control-lg" id="update_password_current_password"
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
            <input type="password" class="form-control form-control-lg" id="update_password_password" name="password"
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
            <input type="password" class="form-control form-control-lg" id="update_password_password_confirmation"
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

            @if (session('status') === 'password-updated')
                <div class="alert alert-success d-inline-block mb-0 py-2 px-3"
                    style="border-radius: 15px; font-size: 0.875rem;" x-data="{ show: true }" x-show="show"
                    x-init="setTimeout(() => show = false, 3000)">
                    <i class="fas fa-check-circle me-1"></i>{{ __('site.profile_form.password.updated') }}
                </div>
            @endif
        </div>
    </form>
</section>
