<!-- Hero Section -->
<section class="hero-section position-relative min-vh-100 d-flex align-items-center">
    <!-- Background Image -->
    <div class="hero-bg-overlay"></div>

    <!-- Hero Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-8">
                <div class="hero-content py-5" data-aos="fade-up">
                    <!-- Badge -->
                    <div class="hero-badge mb-3" data-aos="fade-up" data-aos-delay="200">
                        <span class="badge-text">Leading Management Consultancy</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="hero-headline mb-3" data-aos="fade-up" data-aos-delay="400">
                        Empowering Businesses with
                        <span class="text-gradient">Strategic Excellence</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="hero-description mb-4" data-aos="fade-up" data-aos-delay="600">
                        House of Management for Studies and Consultations (HOM) delivers comprehensive financial
                        advisory,
                        commercial strategy, project management, and construction consulting services to organizations
                        across <strong>industry, government, real estate, healthcare, tourism, and NGO sectors</strong>.
                    </p>

                    <!-- Key Features -->
                    <div class="hero-features mb-4" data-aos="fade-up" data-aos-delay="800">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>
                                    <span>Proactive Financial Advisory</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>
                                    <span>Strategic Project Management</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>
                                    <span>Qualified Business Partners</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>
                                    <span>Flexible Staff Solutions</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="hero-cta mb-4" data-aos="fade-up" data-aos-delay="1000">
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button class="btn btn-primary cta-primary"
                                onclick="document.querySelector('#services').scrollIntoView({behavior: 'smooth'});">
                                <i class="fas fa-rocket me-2"></i>
                                Explore Our Services
                            </button>
                            <button class="btn btn-outline-dark cta-secondary"
                                onclick="window.location.href='{{ route('jobs.index') }}'">
                                <i class="fas fa-briefcase me-2"></i>
                                View Career Opportunities
                            </button>
                        </div>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="hero-trust" data-aos="fade-up" data-aos-delay="1200">
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <div class="trust-item">
                                <span class="trust-number">150+</span>
                                <span class="trust-label">Projects Delivered</span>
                            </div>
                            <div class="trust-item">
                                <span class="trust-number">15+</span>
                                <span class="trust-label">Years Experience</span>
                            </div>
                            <div class="trust-item">
                                <span class="trust-number">98%</span>
                                <span class="trust-label">Client Satisfaction</span>
                            </div>
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
        background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(24, 69, 143, 0.3) 100%),
            url('{{ asset('assets/images/hero.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        position: relative;
        overflow: hidden;
    }

    .hero-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 60%, rgba(255, 255, 255, 0.4) 70%, rgba(255, 255, 255, 0.1) 80%, rgba(255, 255, 255, 0.05) 90%, transparent 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 5;
        padding: 2rem 0;
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
        margin-bottom: 1.5rem;
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
        .hero-section {
            background-image: none !important;
            background-color: #ffffff;
            /* solid color */
            background-attachment: scroll;
        }

        .hero-bg-overlay {
            display: none;
            background: none !important;
        }

        .hero-content {
            padding-top: 100px;
            padding-bottom: 2rem;
        }

        .hero-headline {
            font-size: clamp(1.5rem, 4vw, 2.2rem);
        }

        .hero-trust .d-flex {
            justify-content: center;
        }

        .trust-item {
            margin-bottom: 1rem;
        }
    }
</style>
