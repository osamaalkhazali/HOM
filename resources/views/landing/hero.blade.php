<!-- Hero Section -->
<section class="hero-section position-relative  d-flex align-items-center">
    <!-- Background Image -->
    <div class="hero-bg-overlay"></div>

    <!-- Hero Content -->
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-8 col-xl-8 h-100">
                <div class="hero-content py-5" data-aos="fade-up">

                    <!-- Main Headline -->
                    @php($hero = trans('site.hero'))
                    <h1 class="hero-headline mb-3" data-aos="fade-up" data-aos-delay="400">
                        {!! $hero['heading_html'] !!}
                    </h1>

                    <!-- Subtitle -->
                    <p class="hero-description mb-4" data-aos="fade-up" data-aos-delay="600">
                        {!! $hero['description_html'] !!}
                    </p>



                    <!-- CTA Buttons -->
                    <div class="hero-cta mb-4" data-aos="fade-up" data-aos-delay="1000">
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <button class="btn btn-primary cta-primary"
                                onclick="document.querySelector('#services').scrollIntoView({behavior: 'smooth'});">
                                <i class="fas fa-rocket me-2"></i>
                                {{ $hero['cta_primary'] }}
                            </button>
                            <button class="btn btn-outline-dark cta-secondary"
                                onclick="window.location.href='{{ route('jobs.index') }}'">
                                <i class="fas fa-briefcase me-2"></i>
                                {{ $hero['cta_secondary'] }}
                            </button>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Hero Section - Full Background Image */
    .hero-section {
        position: relative;
        overflow: hidden;
        background-color: #ffffff;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('assets/images/hero.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        transform: scaleX(1);
        transform-origin: center;
        z-index: 0;
        transition: transform 0.6s ease;
        pointer-events: none;
    }

    .hero-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 60%, rgba(255, 255, 255, 0.4) 70%, rgba(255, 255, 255, 0.1) 80%, rgba(255, 255, 255, 0.05) 90%, transparent 100%);
        z-index: 1;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 5;
        padding: 3rem 0; /* add more breathing room */
        min-height: 100vh; /* fill viewport height */
        height: 100%; /* fill parent when available */
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        justify-content: center; /* vertically center content */
    }

    .hero-badge {
        display: inline-block;
    }

    .badge-text {
        background: linear-gradient(135deg, var(--primary-color), #667eea);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(24, 69, 143, 0.3);
    }

    .hero-headline {
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.2;
        color: #2c3e50;
        margin-bottom: 2.25rem; /* increase spacing below headline */
    }

    .text-gradient {
        background: linear-gradient(135deg, var(--primary-color), #667eea);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description {
        font-size: 1rem;
        line-height: 1.6;
        color: #6c757d;
        max-width: 600px;
        margin-bottom: 2rem; /* add extra space before CTA */
    }

    .hero-features .feature-item {
        font-size: 0.9rem;
        color: #495057;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .cta-primary {
        background: linear-gradient(135deg, var(--primary-color), #667eea);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        box-shadow: 0 6px 20px rgba(24, 69, 143, 0.3);
        transition: all 0.3s ease;
    }

    .cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(24, 69, 143, 0.4);
    }

    .cta-secondary {
        border: 2px solid #6c757d;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        color: #495057;
        transition: all 0.3s ease;
    }

    .cta-secondary:hover {
        background: #495057;
        border-color: #495057;
        color: white;
        transform: translateY(-2px);
    }

    .hero-trust .trust-item {
        text-align: center;
    }

    .trust-number {
        display: block;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    .trust-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {

        /* Remove background image and use solid color on mobile */
        .hero-section::before {
            background-image: none !important;
        }

        .hero-bg-overlay {
            display: none;
            background: none !important;
        }

        .hero-content {
            padding-top: 56px;
            padding-bottom: 1.25rem;
            min-height: auto; /* don't force full height on smaller screens */
            height: auto;
            justify-content: flex-start;
            gap: 1rem;
        }

        .hero-headline {
            font-size: clamp(3rem, 7vw, 4rem);
            margin-bottom: 1.1rem;
        }
        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        .hero-cta {
            margin-bottom: 1rem !important;
        }

        .hero-trust .d-flex {
            justify-content: center;
        }

        .trust-item {
            margin-bottom: 1rem;
        }
    }

    body.rtl .hero-section::before {
        transform: scaleX(-1);
    }

    body.rtl .hero-bg-overlay {
        background: linear-gradient(270deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 40%, rgba(255, 255, 255, 0.4) 55%, rgba(255, 255, 255, 0.1) 70%, rgba(255, 255, 255, 0.05) 80%, transparent 100%);
    }
</style>
