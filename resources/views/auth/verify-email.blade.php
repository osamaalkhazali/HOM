<x-guest-layout>
    <div class="mb-3">
        <h1 class="h4 mb-1 fw-bold" style="color: var(--primary-color);">Verify your email</h1>
        <p class="text-muted mb-0">We sent a verification link to your email. If you didn’t receive it, request another below.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between mt-3">
        <form method="POST" action="{{ route('verification.send') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-primary" style="border-radius: 10px; background: var(--primary-color); border: none;">Resend verification email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">Log out</button>
        </form>
    </div>
</x-guest-layout>
