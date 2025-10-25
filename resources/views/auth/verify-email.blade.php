<x-guest-layout>
    <div class="mb-3">
        <h1 class="h4 mb-1 fw-bold" style="color: var(--primary-color);">{{ __('auth.verify.title') }}</h1>
        <p class="text-muted mb-0">{{ __('auth.verify.subtitle') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            {{ __('auth.verify.status') }}
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between mt-3">
        <form method="POST" action="{{ route('verification.send') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-primary" style="border-radius: 10px; background: var(--primary-color); border: none;">{{ __('auth.verify.resend') }}</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">{{ __('auth.verify.logout') }}</button>
        </form>
    </div>
</x-guest-layout>
