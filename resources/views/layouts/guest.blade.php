<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ar';
@endphp
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HOM') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('hom-favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('hom-favicon.png') }}">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap{{ $isRtl ? '.rtl' : '' }}.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if ($isRtl)
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    @endif

    <!-- Site shared styles (primary color variables, panel classes, etc.) -->
    @include('layouts.styles')

    <style>
        body {
            font-family: {{ $isRtl ? "'Tajawal', 'Poppins', sans-serif" : "'Poppins', sans-serif" }};
            background: #18458f;
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
        }
        .auth-logo { height: 120px; width: auto; }
        .auth-card {
            border-radius: 10px;
            border: 1px solid #e0e6ed;
            background-color: #ffffff;
        }
        .auth-meta a { color: var(--primary-color); text-decoration: none; }
        .auth-meta a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="auth-card panel shadow-soft w-100" style="max-width: 420px;">
            <div class="panel-body p-4">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
                        <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM" class="auth-logo">
                    </a>
                </div>
                @php
                    $flashLocale = session('locale_status_locale');
                @endphp
                @if ($flashLocale)
                    @php
                        $languageKey = $flashLocale === 'ar' ? 'arabic' : 'english';
                        $languageLabel = __('site.nav.language.' . $languageKey);
                        $statusMessage = __('auth.language.updated', ['language' => $languageLabel]);
                    @endphp
                    <div class="alert alert-success text-center mb-4" role="alert">
                        {{ $statusMessage }}
                    </div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
