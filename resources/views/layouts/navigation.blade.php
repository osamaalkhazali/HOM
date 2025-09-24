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
</style>

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
            <ul class="navbar-nav ms-auto me-4">
                <li class="nav-item" data-aos="fade-down" data-aos-delay="100">
                    <a class="nav-link fw-medium position-relative" href="{{ url('/#services') }}">Services</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                    <a class="nav-link fw-medium" href="{{ url('/#clients') }}">Clients</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="300">
                    <a class="nav-link fw-medium" href="{{ url('/#about') }}">About</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="400">
                    <a class="nav-link fw-medium" href="{{ url('/#contact') }}">Contact</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="500">
                    <a class="nav-link fw-medium" href="{{ route('jobs.index') }}">Jobs</a>
                </li>
            </ul>

            <!-- Authentication Section -->
            @auth
                <!-- User Dropdown Button -->
                <div class="dropdown" data-aos="fade-left">
                    <button class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white dropdown-toggle"
                        style="background: var(--primary-color); border: none; border-radius: 10px;" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Guest Login/Register Buttons -->
                <div class="d-flex gap-2" data-aos="fade-left">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary fw-semibold px-3 py-2"
                        style="border-radius: 10px; border: 2px solid var(--primary-color); color: var(--primary-color);">
                        Login
                    </a>
                    <button class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white"
                        style="background: var(--primary-color); border: none; border-radius: 10px;"
                        onclick="window.location.href='{{ route('register') }}'">
                        Get Started
                    </button>
                </div>
            @endauth
        </div>
    </div>
</nav>
