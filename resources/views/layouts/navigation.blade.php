<style>
    /* Uses shared CSS variables from layouts.styles */

    /* Navigation Styles */
    .navbar-custom {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        height: 80px;
        min-height: 80px;
    }

    .navbar-custom .container {
        height: 100%;
        display: flex;
        align-items: center;
    }

    .navbar-scrolled {
        background: rgba(255, 255, 255, 0.98) !important;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand .logo-img {
        height: 60px;
        width: auto;
    }

    .navbar-nav .nav-link {
        color: #333 !important;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: color 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        color: var(--primary-color) !important;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-left: 1.5rem;
    }

    .mx-lg-auto {
        @if($isRtl)
            margin-left: 0 !important;
            margin-right: auto !important;
        @else
            margin-right: 0 !important;
            margin-left: auto !important;
        @endif
    }

    .nav-actions > * {
        display: flex;
        align-items: center;
    }

    .nav-actions .btn {
        white-space: nowrap;
    }

    .nav-action-guest {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Navbar Toggler */
    .navbar-toggler {
        border: none !important;
        padding: 4px 8px;
        outline: none !important;
        box-shadow: none !important;
    }

    .navbar-toggler:focus {
        box-shadow: none !important;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        width: 24px;
        height: 24px;
    }

    /* Button animations are provided by shared styles */

    /* Dropdown Styling */
    .dropdown-menu {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .dropdown-item {
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        border-radius: 10px;
        margin: 0.2rem;
    }

    /* Mobile Dropdown Fix */
    @media (max-width: 991.98px) {
        .dropdown-menu {
            background: rgb(255, 255, 255) !important;
            backdrop-filter: none;
        }

        .navbar-collapse {
            background: rgb(255, 255, 255) !important;
            backdrop-filter: none;
            padding: 1rem;
            margin-top: 0.5rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    }

    .dropdown-item:hover {
        background: var(--primary-color);
        color: white !important;
    }

    .language-toggle {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        border: 1px solid rgba(24, 69, 143, 0.35);
        color: var(--primary-color);
        background: rgba(24, 69, 143, 0.08);
        padding: 0.35rem 0.85rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        transition: all 0.25s ease;
    }

    .language-toggle:hover {
        color: #fff;
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(24, 69, 143, 0.2);
    }

    .language-toggle__abbr {
        font-size: 0.75rem;
    }

    .language-toggle__icon {
        font-size: 0.75rem;
    }

    @media (max-width: 991.98px) {
        .nav-links {
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }

        .nav-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }

        .nav-actions > *,
        .nav-action-guest,
        .nav-action-profile,
        .nav-action-notif,
        .nav-action-locale {
            justify-content: center;
            width: 100%;
        }

        .nav-action-guest {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
</style>

@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ar';
    $toggleLocale = $isRtl ? 'en' : 'ar';
    $toggleLabel = $isRtl ? __('site.nav.language.short_en') : __('site.nav.language.short_ar');
@endphp
<nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNav">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" data-aos="fade-right">
            <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM Logo" class="logo-img">
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav nav-links mx-lg-auto mb-3 mb-lg-0">
                <li class="nav-item" data-aos="fade-down" data-aos-delay="100">
                    <a class="nav-link fw-medium position-relative" href="{{ url('/#services') }}">{{ __('site.nav.services') }}</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                    <a class="nav-link fw-medium" href="{{ url('/#clients') }}">{{ __('site.nav.clients') }}</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="300">
                    <a class="nav-link fw-medium" href="{{ url('/#about') }}">{{ __('site.nav.about') }}</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="400">
                    <a class="nav-link fw-medium" href="{{ url('/#contact') }}">{{ __('site.nav.contact') }}</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="500">
                    <a class="nav-link fw-medium" href="{{ route('jobs.index') }}">{{ __('site.nav.jobs') }}</a>
                </li>
            </ul>

            <div class="nav-actions">
                @auth
                    @php($user = auth()->user())
                    @php($unread = \Illuminate\Notifications\DatabaseNotification::where('notifiable_id', $user->id)->where('notifiable_type', get_class($user))->whereNull('read_at')->latest()->limit(10)->get())

                    <div class="dropdown nav-action-notif" data-aos="fade-left">
                        <button class="btn position-relative" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px;">
                            <i class="fas fa-bell" style="font-size: 1.2rem; color: var(--primary-color);"></i>
                            @if($unread->count() > 0)
                                <span class="position-absolute badge rounded-pill bg-danger" style="top: 0%; left: 60%; font-size: 0.5rem !important; padding: 0.2rem 0.4rem !important;">{{ $unread->count() }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdown" style="min-width: 320px;">
                            <li class="px-2 py-1 text-muted small">{{ __('site.nav.notifications') }}</li>
                            @forelse($unread as $notification)
                                <li>
                                    <a class="dropdown-item d-flex align-items-start gap-2" href="{{ route('notifications.open', $notification->id) }}">
                                        <i class="fas fa-circle mt-1" style="font-size: 0.6rem; color: var(--primary-color);"></i>
                                        <div>
                                            <div class="fw-semibold">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                            <div class="small text-muted">{{ $notification->data['message'] ?? '' }}</div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item text-muted">{{ __('site.nav.no_notifications') }}</span></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li class="d-flex gap-2 px-2">
                                <form method="POST" action="{{ route('notifications.readAll') }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-secondary">{{ __('site.nav.mark_all_read') }}</button>
                                </form>
                                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-primary ms-auto">{{ __('site.nav.view_all') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown nav-action-profile" data-aos="fade-left">
                        <button class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white dropdown-toggle"
                            style="background: var(--primary-color); border: none; border-radius: 10px;" type="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    {{ __('site.nav.dashboard') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    {{ __('site.nav.profile') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        {{ __('site.nav.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="nav-action-guest" data-aos="fade-left">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary fw-semibold px-3 py-2"
                            style="border-radius: 10px; border: 2px solid var(--primary-color); color: var(--primary-color);">
                            {{ __('site.nav.login') }}
                        </a>
                        <button class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white"
                            style="background: var(--primary-color); border: none; border-radius: 10px;"
                            onclick="window.location.href='{{ route('register') }}'">
                            {{ __('site.nav.register') }}
                        </button>
                    </div>
                @endauth

                <form method="POST" action="{{ route('locale.switch') }}" class="nav-action-locale">
                    @csrf
                    <input type="hidden" name="locale" value="{{ $toggleLocale }}">
                    <button type="submit" class="language-toggle btn btn-sm" aria-label="{{ __('site.nav.language.label') }}"
                        title="{{ __('site.nav.language.label') }}">
                        <span class="language-toggle__abbr">{{ strtoupper($toggleLocale) }}</span>
                        <span class="language-toggle__icon"><i class="fas fa-globe"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
