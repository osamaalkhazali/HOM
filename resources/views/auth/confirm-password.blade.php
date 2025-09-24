<x-guest-layout>
    <div class="mb-3">
        <h1 class="h4 mb-1 fw-bold" style="color: var(--primary-color);">Confirm your password</h1>
        <p class="text-muted mb-0">This is a secure area. Please confirm your password to continue.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px; background: var(--primary-color); border: none;">Confirm</button>
        </div>
    </form>
</x-guest-layout>
