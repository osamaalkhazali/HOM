<!-- Our Valued Clients Section -->
<section id="clients" class="py-5 position-relative section-with-bg">
    <div class="section-bg-overlay"></div>
    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-lg-10 mx-auto text-center mb-5" data-aos="fade-up">
                <h2 class="section-title fw-bold mb-4">Our Valued Clients</h2>
                <p class="lead text-muted">
                    We're proud to partner with innovative companies and organizations that share our vision for
                    <strong>excellence and growth</strong> across diverse industries.
                </p>
            </div>
        </div>

        <!-- Clients Slider Container -->
        <div class="clients-slider-wrapper" data-aos="fade-up" data-aos-delay="200">
            <div class="clients-slider-container">
                <div class="clients-slider">
                    <!-- First set of clients -->
                    <div class="clients-track">
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/energy-edge.png') }}" alt="Energy Edge"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/marsa-zayed.png') }}" alt="Marsa Zayed"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper brominejo-first">
                            <img src="{{ asset('assets/images/clients/brominejo.png') }}" alt="Brominejo"
                                class="client-logo brominejo-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/nci.png') }}" alt="NCI" class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/jiburi.png') }}" alt="Jiburi"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/cargill.png') }}" alt="Cargill"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/almaabar.png') }}" alt="Al Maabar"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/redv.png') }}" alt="REDV" class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/biariq.png') }}" alt="Biariq"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/agoon.png') }}" alt="Agoon"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/almarai.png') }}" alt="Al Marai"
                                class="client-logo">
                        </div>
                    </div>

                    <!-- Duplicate set for seamless loop -->
                    <div class="clients-track">
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/energy-edge.png') }}" alt="Energy Edge"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/marsa-zayed.png') }}" alt="Marsa Zayed"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/brominejo.png') }}" alt="Brominejo"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/nci.png') }}" alt="NCI" class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/jiburi.png') }}" alt="Jiburi"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/cargill.png') }}" alt="Cargill"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/almaabar.png') }}" alt="Al Maabar"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/redv.png') }}" alt="REDV"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/biariq.png') }}" alt="Biariq"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/agoon.png') }}" alt="Agoon"
                                class="client-logo">
                        </div>
                        <div class="client-logo-wrapper">
                            <img src="{{ asset('assets/images/clients/almarai.png') }}" alt="Al Marai"
                                class="client-logo">
                        </div>
                    </div>
                </div>

                <!-- Gradient overlays for smooth fade effect -->
                <div class="clients-fade-left"></div>
                <div class="clients-fade-right"></div>
            </div>
        </div>

    </div>
</section>

<style>
    /* Clients Section Styling - Professional Design */
    #clients {
        background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(24, 69, 143, 0.3) 100%),
            url('{{ asset('assets/images/hero.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        position: relative;
        overflow: hidden;
    }

    .clients-slider-wrapper {
        position: relative;
        padding: 2rem 0;
    }

    .clients-slider-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(24, 69, 143, 0.2);
        border-radius: 10px;
        padding: 3rem 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
    }

    .clients-slider {
        display: flex;
        animation: slideClients 30s linear infinite;
    }

    .clients-slider:hover {
        animation-play-state: paused;
    }

    @keyframes slideClients {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .clients-track {
        display: flex;
        align-items: center;
        min-width: 100%;
        gap: 4rem;
        flex-shrink: 0;
    }

    .client-logo-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 180px;
        height: 120px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(24, 69, 143, 0.1);
        flex-shrink: 0;
    }

    .client-logo-wrapper:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 50px rgba(24, 69, 143, 0.15);
        background: rgba(255, 255, 255, 1);
        border-color: rgba(24, 69, 143, 0.3);
    }

    .client-logo {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(0.3) opacity(0.8);
        transition: all 0.4s ease;
    }

    .client-logo-wrapper:hover .client-logo {
        filter: grayscale(0) opacity(1);
        transform: scale(1.1);
    }

    /* Special styling for first Brominejo logo - thinner in middle */
    .brominejo-first {
        width: 140px;
        /* Narrower than default 180px */
        position: relative;
        animation: expandBrominejo 3s ease-out 1s forwards;
    }

    .brominejo-first .brominejo-logo {
        width: 80%;
        /* Make logo itself thinner initially */
        animation: expandBrominejoLogo 3s ease-out 1s forwards;
    }

    @keyframes expandBrominejo {
        from {
            width: 140px;
        }

        to {
            width: 180px;
        }
    }

    @keyframes expandBrominejoLogo {
        from {
            width: 80%;
        }

        to {
            width: 100%;
        }
    }

    /* Gradient fade effects */
    .clients-fade-left,
    .clients-fade-right {
        position: absolute;
        top: 0;
        width: 80px;
        height: 100%;
        pointer-events: none;
        z-index: 10;
    }

    .clients-fade-left {
        left: 0;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.95) 0%, transparent 100%);
    }

    .clients-fade-right {
        right: 0;
        background: linear-gradient(-90deg, rgba(255, 255, 255, 0.95) 0%, transparent 100%);
    }

    /* Statistics Cards */
    .client-stat-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, rgba(24, 69, 143, 0.8) 100%);
        border-radius: 10px;
        padding: 2.5rem 2rem;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 15px 40px rgba(24, 69, 143, 0.2);
    }

    .client-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .client-stat-card:hover::before {
        transform: translateX(100%);
    }

    .client-stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 60px rgba(24, 69, 143, 0.3);
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .client-stat-card .counter {
        font-size: 3rem;
        color: white;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .client-stat-card p {
        font-size: 1.1rem;
        font-weight: 500;
        opacity: 0.9;
    }

    /* Call to Action Button Enhancement */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 15px 35px rgba(24, 69, 143, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, var(--primary-color) 100%);
        transform: translateY(-3px);
        box-shadow: 0 20px 45px rgba(24, 69, 143, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .clients-track {
            gap: 3rem;
        }

        .client-logo-wrapper {
            width: 160px;
            height: 100px;
            padding: 1rem;
        }

        /* Brominejo responsive adjustments */
        .brominejo-first {
            width: 120px;
            /* Thinner on tablet */
            animation: expandBrominejoTablet 3s ease-out 1s forwards;
        }

        @keyframes expandBrominejoTablet {
            from {
                width: 120px;
            }

            to {
                width: 160px;
            }
        }

        .clients-slider-container {
            padding: 2rem 1.5rem;
        }

        .client-stat-card {
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }

        .client-stat-card .counter {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .clients-track {
            gap: 2rem;
        }

        .client-logo-wrapper {
            width: 140px;
            height: 90px;
            padding: 0.75rem;
        }

        /* Brominejo mobile adjustments */
        .brominejo-first {
            width: 110px;
            /* Even thinner on mobile */
            animation: expandBrominejoMobile 3s ease-out 1s forwards;
        }

        @keyframes expandBrominejoMobile {
            from {
                width: 110px;
            }

            to {
                width: 140px;
            }
        }

        .clients-slider-container {
            padding: 1.5rem 1rem;
            border-radius: 10px;
        }

        .clients-fade-left,
        .clients-fade-right {
            width: 40px;
        }

        .client-stat-card {
            padding: 1.5rem 1rem;
        }

        .client-stat-card .counter {
            font-size: 2rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
        }

        .stat-icon i {
            font-size: 1.5rem !important;
        }
    }

    @media (max-width: 575.98px) {
        .clients-track {
            gap: 1.5rem;
        }

        .client-logo-wrapper {
            width: 120px;
            height: 80px;
            padding: 0.5rem;
        }

        /* Brominejo extra small mobile adjustments */
        .brominejo-first {
            width: 95px;
            /* Very thin on extra small screens */
            animation: expandBrominejoExtraSmall 3s ease-out 1s forwards;
        }

        @keyframes expandBrominejoExtraSmall {
            from {
                width: 95px;
            }

            to {
                width: 120px;
            }
        }

        .clients-slider-container {
            margin: 0 -1rem;
            border-radius: 10px;
        }

        .clients-slider-wrapper {
            padding: 1rem 0;
        }
    }

    /* Animation Performance Optimization */
    .clients-slider {
        will-change: transform;
        backface-visibility: hidden;
        perspective: 1000px;
    }

    .client-logo-wrapper {
        will-change: transform;
        backface-visibility: hidden;
    }

    /* Unified section title styling to match hero headline size and color */
    #clients .section-title {
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        line-height: 1.2;
        color: var(--primary-color) !important;
        margin-bottom: 1.5rem;
    }

    /* Drag / touch enhancements */
    .clients-slider-container {
        cursor: grab;
        user-select: none;
        -webkit-user-drag: none;
        -webkit-tap-highlight-color: transparent;
        touch-action: pan-x;
    }

    .clients-slider-container.dragging {
        cursor: grabbing;
    }
</style>

<script>
    // Enhanced counter animation with intersection observer
    function initializeClientsCounters() {
        const counters = document.querySelectorAll('#clients .counter');

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    entry.target.classList.add('animated');
                    animateCounter(entry.target);
                }
            });
        }, {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    function animateCounter(counter) {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;

        const updateCounter = () => {
            if (current < target) {
                current += step;
                if (current > target) current = target;

                // Add smooth easing
                const progress = current / target;
                const easeOut = 1 - Math.pow(1 - progress, 3);
                counter.textContent = Math.floor(target * easeOut);

                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
                // Add completion effect
                counter.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    counter.style.transform = 'scale(1)';
                }, 200);
            }
        };

        requestAnimationFrame(updateCounter);
    }

    // Pause animation on hover
    function initializeSliderControls() {
        const slider = document.querySelector('.clients-slider');
        const container = document.querySelector('.clients-slider-container');

        if (slider && container) {
            container.addEventListener('mouseenter', () => {
                slider.style.animationPlayState = 'paused';
            });

            container.addEventListener('mouseleave', () => {
                slider.style.animationPlayState = 'running';
            });
        }
    }

    // Touch/Mouse drag to move the slider manually
    function initializeClientsDrag() {
        const container = document.querySelector('.clients-slider-container');
        const slider = document.querySelector('.clients-slider');
        if (!container || !slider) return;

        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let startOffset = 0;
        let minOffset = 0;
        let maxNegativeOffset = 0;
        let savedAnimation = '';

        const getCurrentTranslateX = () => {
            const style = window.getComputedStyle(slider);
            const transform = style.transform || 'none';
            if (transform === 'none') return 0;
            // matrix(a, b, c, d, tx, ty)
            const match = transform.match(/matrix\([^,]+,[^,]+,[^,]+,[^,]+,\s*([-\d.]+),\s*([-\d.]+)\)/);
            if (match && match[1]) {
                return parseFloat(match[1]);
            }
            return 0;
        };

        const clamp = (val, min, max) => Math.max(min, Math.min(max, val));

        const recalcBounds = () => {
            const sliderWidth = slider.scrollWidth;
            // With two identical tracks, we allow dragging over half the width
            maxNegativeOffset = -(sliderWidth / 2 - container.clientWidth);
            if (!isFinite(maxNegativeOffset)) maxNegativeOffset = -1000; // fallback
            minOffset = 0;
        };

        const stopAnimation = () => {
            savedAnimation = slider.style.animation || '';
            slider.style.animationPlayState = 'paused';
            // Also remove inline animation to fully stop CSS keyframes influence
            const computedAnim = window.getComputedStyle(slider).animationName;
            if (computedAnim && computedAnim !== 'none') {
                slider.style.animation = 'none';
            }
        };

        const setTranslate = (x) => {
            slider.style.transform = `translateX(${x}px)`;
        };

        const onPointerDown = (clientX) => {
            recalcBounds();
            isDragging = true;
            container.classList.add('dragging');
            stopAnimation();
            startX = clientX;
            // Use current translate if any (e.g., when animation was running)
            startOffset = getCurrentTranslateX();
        };

        const onPointerMove = (clientX) => {
            if (!isDragging) return;
            currentX = clientX;
            const delta = currentX - startX;
            const next = clamp(startOffset + delta, maxNegativeOffset, minOffset);
            setTranslate(next);
        };

        const onPointerUp = () => {
            if (!isDragging) return;
            isDragging = false;
            container.classList.remove('dragging');
            // Keep paused after user interaction to avoid snapping; do not restore animation
        };

        // Mouse events
        container.addEventListener('mousedown', (e) => {
            onPointerDown(e.clientX);
        });
        window.addEventListener('mousemove', (e) => {
            onPointerMove(e.clientX);
        });
        window.addEventListener('mouseup', onPointerUp);

        // Touch events
        container.addEventListener('touchstart', (e) => {
            if (e.touches && e.touches.length > 0) {
                onPointerDown(e.touches[0].clientX);
            }
        }, { passive: true });
        window.addEventListener('touchmove', (e) => {
            if (e.touches && e.touches.length > 0) {
                onPointerMove(e.touches[0].clientX);
            }
        }, { passive: true });
        window.addEventListener('touchend', onPointerUp, { passive: true });
        window.addEventListener('touchcancel', onPointerUp, { passive: true });
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeClientsCounters();
        initializeSliderControls();
        initializeClientsDrag();
    });

    // Reinitialize on page show (for back/forward navigation)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            initializeClientsCounters();
            initializeSliderControls();
            initializeClientsDrag();
        }
    });
</script>
