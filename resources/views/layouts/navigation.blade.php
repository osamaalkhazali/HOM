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
                    <a class="nav-link fw-medium position-relative" href="#services">Services</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                    <a class="nav-link fw-medium" href="#clients">Clients</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="300">
                    <a class="nav-link fw-medium" href="#about">About</a>
                </li>
                <li class="nav-item" data-aos="fade-down" data-aos-delay="400">
                    <a class="nav-link fw-medium" href="#contact">Contact</a>
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
                        style="background: var(--gradient-1); border: none; border-radius: 25px;" type="button"
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
                        style="border-radius: 25px; border: 2px solid var(--primary-color); color: var(--primary-color);">
                        Login
                    </a>
                    <button class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white"
                        style="background: var(--gradient-1); border: none; border-radius: 25px;"
                        onclick="window.location.href='{{ route('register') }}'">
                        Get Started
                    </button>
                </div>
            @endauth
        </div>
    </div>
</nav>
