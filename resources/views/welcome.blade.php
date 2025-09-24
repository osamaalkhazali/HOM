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
    @include('layouts.styles')
    <style>

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

        /* Page-specific components */

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

        /* Hover lift utility is provided globally */

        /* Animated Counter */
        .counter {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .metric-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .metric-value {
            font-size: 1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.2rem;
        }

        .metric-label {
            font-size: 0.75rem;
            color: #6c757d;
            margin: 0;
        }

        .progress {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
        }

        .progress-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #495057;
        }

        .floating-card-1, .floating-card-2 {
            position: absolute;
            width: 220px;
            padding: 1rem;
            z-index: 8;
        }

        .floating-card-1 {
            top: 5%;
            right: -15%;
            transform: rotate(3deg);
        }

        .floating-card-2 {
            bottom: 10%;
            left: -10%;
            transform: rotate(-2deg);
        }

        .floating-card-1 h6, .floating-card-2 h6 {
            font-size: 0.9rem;
        }

        .floating-card-1 small, .floating-card-2 small {
            font-size: 0.75rem;
        }

        .icon-wrapper {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .decoration-1 {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }

        .decoration-2 {
            width: 150px;
            height: 150px;
            bottom: 10%;
            right: 60%;
        }

        .decoration-3 {
            width: 100px;
            height: 100px;
            top: 60%;
            left: -30px;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: #6c757d;
            z-index: 10;
        }

        .scroll-arrow {
            width: 40px;
            height: 40px;
            border: 2px solid #6c757d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        /* Section-with-bg is provided globally */

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .floating-card-1, .floating-card-2 {
                display: none;
            }
        }

        @media (max-width: 576px) {
        }

        /* Typing Animation */
        .typing-text {
            color: #ffd700;
            display: inline-block;
            border-right: 3px solid #ffd700;
            font-size: 1.5rem !important;
            animation: blink 1s step-end infinite;
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

        /* Button animations are provided globally */

        /* Logo styling provided globally */

        .footer-logo {
            height: 55px;
            width: auto;
            object-fit: contain;
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
            .timeline-item .col-lg-6 {
                padding-left: 4rem !important;
            }
        }

        /* Position scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        /* Utilities are provided globally */
    </style>
</head>

<body id="top" class="landing">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Hero Section -->
    @include('landing.hero')



    <!-- Services Section -->
    @include('landing.services')

    <!-- Our Valued Clients Section -->
    @include('landing.clients')

    <!-- Our Business Partners Section -->
    @include('landing.partners')

    @include('landing.focus')

    @include('landing.profile-download')



    @include('layouts.footer')

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
