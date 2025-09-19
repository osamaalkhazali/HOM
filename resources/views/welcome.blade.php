<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'House of Management for Studies and Consultations') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #18458f;
            --primary-dark: #123660;
            --primary-light: #2a5ba8;
            --gradient-1: linear-gradient(135deg, #18458f 0%, #667eea 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Hero Background with Image */
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(24, 69, 143, 0.7), rgba(24, 69, 143, 0.7)), url('{{ asset('assets/images/hero.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: -2;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .shape:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 60%;
            left: 80%;
            width: 120px;
            height: 120px;
            background: white;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation-delay: 5s;
        }

        .shape:nth-child(3) {
            top: 40%;
            left: 70%;
            width: 60px;
            height: 60px;
            background: white;
            transform: rotate(45deg);
            animation-delay: 10s;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-100px) rotate(180deg);
            }

            100% {
                transform: translateY(0px) rotate(360deg);
            }
        }

        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Service Cards with Fixed Dimensions */
        .service-card {
            height: 280px;
            width: 100%;
            border-radius: 20px;
            color: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            opacity: 0.9;
            z-index: 1;
        }

        .service-card-content {
            position: relative;
            z-index: 2;
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .gradient-card-1 {
            background: var(--gradient-1);
        }

        .gradient-card-2 {
            background: var(--gradient-2);
        }

        .gradient-card-3 {
            background: var(--gradient-3);
        }

        .gradient-card-4 {
            background: var(--gradient-4);
        }

        /* Timeline Fixes */
        .timeline-section {
            position: relative;
            padding: 4rem 0;
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--gradient-1);
            transform: translateX(-50%);
            z-index: 1
        }

        .timeline-item {
            position: relative;
            margin: 3rem 0;
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border: 4px solid white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 3;
            box-shadow: 0 0 0 4px rgba(24, 69, 143, 0.3);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% {
                box-shadow: 0 0 0 4px rgba(24, 69, 143, 0.3), 0 0 0 0 rgba(24, 69, 143, 0.7);
            }

            70% {
                box-shadow: 0 0 0 4px rgba(24, 69, 143, 0.3), 0 0 0 10px rgba(24, 69, 143, 0);
            }

            100% {
                box-shadow: 0 0 0 4px rgba(24, 69, 143, 0.3), 0 0 0 0 rgba(24, 69, 143, 0);
            }
        }

        .timeline-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            transition: all 0.3s ease;
        }

        .timeline-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Hover Effects */
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hover-lift:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        /* Animated Counter */
        .counter {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        /* Hero Section Improvements */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 6rem 0 4rem;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 2rem;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 4vw, 1.5rem);
            line-height: 1.6;
            margin-bottom: 3rem;
            opacity: 0.95;
        }

        /* Typing Animation */
        .typing-text {
            color: #ffd700;
            display: inline-block;
            border-right: 3px solid # font-size: 1.5rem !important;
        }

        @keyframes blink {

            0%,
            50% {
                border-color: transparent;
            }

            51%,
            100% {
                border-color: #ffd700;
            }
        }

        /* Button Animations */
        .pulse-btn {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(24, 69, 143, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(24, 69, 143, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(24, 69, 143, 0);
            }
        }

        .morph-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .morph-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .morph-btn:hover::before {
            left: 100%;
        }

        /* Logo Styling */
        .logo-img {
            height: 65px;
            width: auto;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        .footer-logo {
            height: 55px;
            width: auto;
            object-fit: contain;
        }

        /* Custom Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .timeline-line {
                left: 30px;
            }

            .timeline-dot {
                left: 30px;
            }

            .timeline-item .col-lg-6 {
                padding-left: 5rem !important;
                padding-right: 1rem !important;
            }

            .counter {
                font-size: 2rem;
            }

            .service-card {
                height: auto;
                min-height: 280px;
                margin-bottom: 2rem;
            }

            .hero-section {
                padding: 8rem 0 4rem;
                text-align: center;
            }

            .hero-bg {
                background-attachment: scroll;
            }

            .floating-shapes .shape {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .service-card {
                height: auto;
                min-height: 250px;
                padding: 1.5rem;
            }

            .timeline-item .col-lg-6 {
                padding-left: 4rem !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#" data-aos="fade-right">
                <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM Logo" class="logo-img">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

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
                </ul>
                <button class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white"
                    style="background: var(--gradient-1); border: none; border-radius: 25px;" data-aos="fade-left">
                    Get Started
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white position-relative">
        <div class="hero-bg"></div>
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="hero-content text-center">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <h1 class="hero-title">
                                Strategic Excellence in<br>
                                <span class="typing-text" id="typingText">Management Consulting</span>
                            </h1>
                        </div>

                        <div data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                            <p class="hero-subtitle">
                                Proactive financial advisory, commercial strategy, and project management solutions
                                with <strong>flexible staff</strong> and <strong>qualified business partners</strong>
                                across diverse industries.
                            </p>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center" data-aos="fade-up"
                            data-aos-delay="600">
                            <button class="btn btn-light btn-lg fw-semibold px-5 py-3 morph-btn hover-lift"
                                style="border-radius: 50px; color: var(--primary-color);">
                                <i class="fas fa-rocket me-2"></i>Explore Our Services
                            </button>
                            <button class="btn btn-outline-light btn-lg fw-semibold px-5 py-3 morph-btn hover-lift"
                                style="border-radius: 50px; border-width: 2px;">
                                <i class="fas fa-calendar me-2"></i>Schedule Consultation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4" data-aos="fade-up"
            data-aos-delay="1000">
            <div class="text-center">
                <div class="animate__animated animate__bounce animate__infinite">
                    <i class="fas fa-chevron-down fs-4"></i>
                </div>
                <small class="d-block mt-2">Scroll to explore</small>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light position-relative">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="glass-card p-4 h-100 hover-lift">
                        <div class="counter" data-target="150">0</div>
                        <h5 class="fw-bold text-dark">Projects Completed</h5>
                        <p class="text-muted mb-0">Successful deliveries across industries</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="glass-card p-4 h-100 hover-lift">
                        <div class="counter" data-target="50">0</div>
                        <h5 class="fw-bold text-dark">Expert Partners</h5>
                        <p class="text-muted mb-0">Qualified business professionals</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="glass-card p-4 h-100 hover-lift">
                        <div class="counter" data-target="15">0</div>
                        <h5 class="fw-bold text-dark">Years Experience</h5>
                        <p class="text-muted mb-0">Proven track record of excellence</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="glass-card p-4 h-100 hover-lift">
                        <div class="counter" data-target="98">0</div>
                        <h5 class="fw-bold text-dark">Client Satisfaction</h5>
                        <p class="text-muted mb-0">Percentage of satisfied clients</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-dark mb-4">Our Core Services</h2>
                    <p class="lead text-muted">
                        Comprehensive expertise delivered through our <strong>flexible staff base</strong> and
                        <strong>qualified business partners</strong>
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card gradient-card-1 hover-lift">
                        <div class="service-card-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="service-icon">
                                    <i class="fas fa-chart-line fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fw-bold mb-1">Financial Advisory</h4>
                                    <small class="opacity-75">Strategic solutions</small>
                                </div>
                            </div>
                            <p class="opacity-90 mb-0">Strategic financial planning, risk assessment, and investment
                                guidance tailored to your business needs with proactive market insights.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card gradient-card-2 hover-lift">
                        <div class="service-card-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="service-icon">
                                    <i class="fas fa-briefcase fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fw-bold mb-1">Commercial Strategy</h4>
                                    <small class="opacity-75">Growth focused</small>
                                </div>
                            </div>
                            <p class="opacity-90 mb-0">Market analysis, business development, and commercial
                                optimization strategies for sustainable growth and competitive advantage.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card gradient-card-3 hover-lift">
                        <div class="service-card-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="service-icon">
                                    <i class="fas fa-tasks fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fw-bold mb-1">Project Management</h4>
                                    <small class="opacity-75">End-to-end delivery</small>
                                </div>
                            </div>
                            <p class="opacity-90 mb-0">Comprehensive project oversight, timeline management, and
                                resource optimization for successful delivery across all sectors.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card gradient-card-4 hover-lift">
                        <div class="service-card-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="service-icon">
                                    <i class="fas fa-building fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fw-bold mb-1">Construction Strategy</h4>
                                    <small class="opacity-75">Quality assured</small>
                                </div>
                            </div>
                            <p class="opacity-90 mb-0">Strategic construction planning, cost optimization, and quality
                                assurance for building projects of all scales.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Types Section with Timeline -->
    <section id="clients" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-dark mb-4">Organizations We Serve</h2>
                    <p class="lead text-muted">
                        Our <strong>flexible staff base</strong> and <strong>qualified business partners</strong>
                        provide effective services across diverse sectors
                    </p>
                </div>
            </div>

            <div class="timeline-section position-relative">
                <div class="timeline-line"></div>

                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-lg-6 pe-lg-5">
                            <div class="timeline-card p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3"
                                        style="width: 60px; height: 60px; background: var(--gradient-1); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-industry fs-3 text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">Manufacturers/Industry</h4>
                                </div>
                                <p class="text-muted mb-0">Comprehensive support for facility owners and operators in
                                    manufacturing and industrial sectors with cutting-edge solutions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-left">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6 ps-lg-5">
                            <div class="timeline-card p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3"
                                        style="width: 60px; height: 60px; background: var(--gradient-2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-landmark fs-3 text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">Government & Local Authorities</h4>
                                </div>
                                <p class="text-muted mb-0">Strategic consulting and project management for government
                                    agencies and local authority organizations with proven methodologies.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-lg-6 pe-lg-5">
                            <div class="timeline-card p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3"
                                        style="width: 60px; height: 60px; background: var(--gradient-3); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-city fs-3 text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">Real Estate & Infrastructure</h4>
                                </div>
                                <p class="text-muted mb-0">Development strategies, project management, and financial
                                    advisory for real estate and infrastructure projects of all scales.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-left">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6 ps-lg-5">
                            <div class="timeline-card p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3"
                                        style="width: 60px; height: 60px; background: var(--gradient-4); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-concierge-bell fs-3 text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">Service Sector</h4>
                                </div>
                                <p class="text-muted mb-0">Specialized support for tourism, educational, and healthcare
                                    service organizations with innovative approaches.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-dot"></div>
                    <div class="row">
                        <div class="col-lg-6 pe-lg-5">
                            <div class="timeline-card p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3"
                                        style="width: 60px; height: 60px; background: var(--gradient-2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-hands-helping fs-3 text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">Non-Governmental Organizations</h4>
                                </div>
                                <p class="text-muted mb-0">Strategic planning, project management, and organizational
                                    development for NGOs and non-profits with sustainable impact.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-4 fw-bold text-dark mb-4">Why Choose HOM?</h2>
                    <p class="lead text-muted mb-5">
                        House of Management for Studies and Consultations brings together a <strong>flexible staff
                            base</strong>
                        and <strong>qualified business partners</strong> to deliver strategic solutions across diverse
                        industries.
                    </p>

                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 rounded-4 hover-lift"
                                style="background: rgba(24, 69, 143, 0.1);">
                                <div class="me-3"
                                    style="width: 50px; height: 50px; background: var(--gradient-1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Flexible Staff Base</h6>
                                    <small class="text-muted">Qualified professionals</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 rounded-4 hover-lift"
                                style="background: rgba(24, 69, 143, 0.1);">
                                <div class="me-3"
                                    style="width: 50px; height: 50px; background: var(--gradient-2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-handshake text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Business Partners</h6>
                                    <small class="text-muted">Strategic alliances</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 rounded-4 hover-lift"
                                style="background: rgba(24, 69, 143, 0.1);">
                                <div class="me-3"
                                    style="width: 50px; height: 50px; background: var(--gradient-3); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Proactive Approach</h6>
                                    <small class="text-muted">Anticipate challenges</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 rounded-4 hover-lift"
                                style="background: rgba(24, 69, 143, 0.1);">
                                <div class="me-3"
                                    style="width: 50px; height: 50px; background: var(--gradient-4); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-cogs text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Wide Range Services</h6>
                                    <small class="text-muted">Comprehensive solutions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="position-relative">
                        <div class="card border-0 shadow-lg hover-lift" style="background: var(--gradient-1);">
                            <div class="card-body p-5 text-white text-center">
                                <div class="mb-4">
                                    <i class="fas fa-rocket fs-1"></i>
                                </div>
                                <h3 class="fw-bold mb-4">Ready to Transform Your Organization?</h3>
                                <p class="opacity-90 mb-4 fs-5">
                                    Let's discuss how our flexible team and qualified partners can drive your success.
                                    Schedule a consultation today.
                                </p>
                                <button class="btn btn-light btn-lg fw-semibold w-100 morph-btn pulse-btn"
                                    style="border-radius: 50px; color: var(--primary-color);">
                                    <i class="fas fa-calendar-check me-2"></i>Schedule Free Consultation
                                </button>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div class="position-absolute top-0 end-0 translate-middle">
                            <div
                                style="width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; animation: float 6s ease-in-out infinite;">
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 translate-middle">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%; animation: float 4s ease-in-out infinite reverse;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 position-relative"
        style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5" data-aos="fade-up">
                    <h2 class="display-4 fw-bold text-white mb-4">Get In Touch</h2>
                    <p class="lead text-light">Ready to elevate your organization? Let's start the conversation.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="glass-card text-center p-5 h-100 hover-lift">
                        <div class="mb-4">
                            <div
                                style="width: 80px; height: 80px; background: var(--gradient-1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-envelope fs-3 text-white"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3 text-white">Email Us</h5>
                        <p class="text-light mb-0">info@hom-consultations.com</p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="glass-card text-center p-5 h-100 hover-lift">
                        <div class="mb-4">
                            <div
                                style="width: 80px; height: 80px; background: var(--gradient-2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-phone fs-3 text-white"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3 text-white">Call Us</h5>
                        <p class="text-light mb-0">+1 (555) 123-4567</p>
                    </div>
                </div>

                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="glass-card text-center p-5 h-100 hover-lift">
                        <div class="mb-4">
                            <div
                                style="width: 80px; height: 80px; background: var(--gradient-3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-map-marker-alt fs-3 text-white"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3 text-white">Visit Us</h5>
                        <p class="text-light mb-0">123 Business District<br>City, State 12345</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM Logo" class="footer-logo">
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0" data-aos="fade-left">
                    <small class="text-muted">© {{ date('Y') }} HOM. All rights reserved. | Designed with
                        ❤️</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 100) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 100;
                let current = 0;

                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current);
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });
        }

        // Trigger counter animation when in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.counter');
        if (statsSection) {
            observer.observe(statsSection.closest('section'));
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Button click handlers
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                if (this.textContent.includes('Get Started') || this.textContent.includes('Explore')) {
                    document.querySelector('#services').scrollIntoView({
                        behavior: 'smooth'
                    });
                } else if (this.textContent.includes('Consultation')) {
                    document.querySelector('#contact').scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Typing animation
        const typingTexts = ['Management Consulting', 'Strategic Solutions', 'Business Excellence'];
        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        function typeWriter() {
            const typingElement = document.getElementById('typingText');
            if (!typingElement) return;

            const currentText = typingTexts[textIndex];

            if (isDeleting) {
                typingElement.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;
            } else {
                typingElement.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;
            }

            let typeSpeed = isDeleting ? 50 : 100;

            if (!isDeleting && charIndex === currentText.length) {
                typeSpeed = 2000; // Pause at end
                isDeleting = true;
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                textIndex = (textIndex + 1) % typingTexts.length;
                typeSpeed = 500; // Pause before starting new text
            }

            setTimeout(typeWriter, typeSpeed);
        }

        // Start typing animation after page load
        window.addEventListener('load', () => {
            setTimeout(typeWriter, 1000);
        });

        // Add loading animation to page
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>

</html>
