<!-- Our Business Partners Section -->
<section id="partners" class="py-5 bg-light">
    <div class="container">
        @php($partners = trans('site.partners'))
        <!-- Section Header -->
        <div class="row">
            <div class="col-lg-10 mx-auto text-center mb-5" data-aos="fade-up">
                <h2 class="section-title fw-bold mb-4">{{ $partners['title'] }}</h2>
                <p class="lead text-muted">
                    {!! $partners['subtitle_html'] !!}
                </p>
            </div>
        </div>

        <!-- Partners Grid -->
        <div class="partners-grid" data-aos="fade-up" data-aos-delay="200">
            <div class="row justify-content-center g-4">
                <!-- Fluor Corporation -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="partner-card">
                        <div class="partner-logo-container">
                            <img src="{{ asset('assets/images/partners/flour.png') }}" alt="Fluor Corporation"
                                class="partner-logo">
                        </div>
                        <div class="partner-info">
                            <h5 class="partner-name">Fluor Corporation</h5>
                            <a href="https://www.fluor.com" target="_blank" rel="noopener noreferrer"
                                class="partner-website">
                                <i class="fas fa-external-link-alt me-2"></i>www.fluor.com
                            </a>
                        </div>
                    </div>
                </div>

                <!-- KYD Engineering -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="partner-card">
                        <div class="partner-logo-container">
                            <img src="{{ asset('assets/images/partners/kyd.png') }}" alt="KYD Engineering"
                                class="partner-logo">
                        </div>
                        <div class="partner-info">
                            <h5 class="partner-name">KYD Engineering</h5>
                            <a href="https://www.kyd-eng.com" target="_blank" rel="noopener noreferrer"
                                class="partner-website">
                                <i class="fas fa-external-link-alt me-2"></i>www.kyd-eng.com
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Consolidated Contractors Company (CCC) -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="partner-card">
                        <div class="partner-logo-container">
                            <img src="{{ asset('assets/images/partners/ccc.png') }}"
                                alt="Consolidated Contractors Company" class="partner-logo">
                        </div>
                        <div class="partner-info">
                            <h5 class="partner-name">Consolidated Contractors Company (CCC)</h5>
                            <a href="https://www.ccc.gr" target="_blank" rel="noopener noreferrer"
                                class="partner-website">
                                <i class="fas fa-external-link-alt me-2"></i>www.ccc.gr
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bosch Energy and Building Solutions (BEBS) -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="partner-card">
                        <div class="partner-logo-container">
                            <img src="{{ asset('assets/images/partners/bosch.png') }}"
                                alt="Bosch Energy and Building Solutions" class="partner-logo">
                        </div>
                        <div class="partner-info">
                            <h5 class="partner-name">Bosch Energy and Building Solutions (BEBS)</h5>
                            <a href="https://www.bosch-energy.de" target="_blank" rel="noopener noreferrer"
                                class="partner-website">
                                <i class="fas fa-external-link-alt me-2"></i>www.bosch-energy.de
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>

<style>
    /* Partners Section Styling - Professional Design */
    #partners {
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }

    .partners-grid {
        position: relative;
        margin: 2rem 0;
    }

    .partner-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(24, 69, 143, 0.1);
        border-radius: 10px;
        padding: 2.5rem 2rem;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .partner-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 60px rgba(24, 69, 143, 0.2);
        border-color: rgba(24, 69, 143, 0.3);
        background: rgba(255, 255, 255, 1);
    }

    .partner-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), #667eea, var(--primary-color));
        transform: scaleX(0);
        transition: transform 0.6s ease;
        transform-origin: left;
    }

    .partner-card:hover::before {
        transform: scaleX(1);
    }

    .partner-logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 120px;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(248, 250, 252, 0.8);
        border-radius: 10px;
        transition: all 0.4s ease;
        border: 1px solid rgba(24, 69, 143, 0.05);
    }

    .partner-card:hover .partner-logo-container {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 25px rgba(24, 69, 143, 0.1);
        transform: scale(1.05);
    }

    .partner-logo {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(0.2) opacity(0.9);
        transition: all 0.4s ease;
    }

    .partner-card:hover .partner-logo {
        filter: grayscale(0) opacity(1);
        transform: scale(1.1);
    }

    .partner-info {
        text-align: center;
    }

    .partner-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1rem;
        line-height: 1.3;
        min-height: 2.6rem;
        /* Consistent height for alignment */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .partner-website {
        display: inline-flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 10px;
        background: rgba(24, 69, 143, 0.1);
        transition: all 0.3s ease;
        border: 1px solid rgba(24, 69, 143, 0.2);
    }

    .partner-website:hover {
        color: white;
        background: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(24, 69, 143, 0.3);
        text-decoration: none;
    }

    .partner-website i {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .partner-website:hover i {
        transform: translateX(3px);
    }

    /* Partnership Benefits Styling */
    .partnership-benefits {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(24, 69, 143, 0.1);
        border-radius: 10px;
        padding: 2.5rem 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    }

    .benefit-item {
        text-align: center;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .benefit-item:hover {
        transform: translateY(-5px);
    }

    .benefit-icon {
        color: var(--primary-color);
        margin: 0 auto;
        width: 60px;
        height: 60px;
        background: rgba(24, 69, 143, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .benefit-item:hover .benefit-icon {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(24, 69, 143, 0.3);
    }

    .benefit-item h6 {
        color: #1a202c;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    /* Button uses shared .landing .btn-primary */

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .partner-card {
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }

        .partner-logo-container {
            height: 100px;
            margin-bottom: 1rem;
        }

        .partner-name {
            font-size: 1rem;
            min-height: 2.2rem;
        }

        .partnership-benefits {
            padding: 2rem 1.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .partner-card {
            padding: 1.5rem 1rem;
        }

        .partner-logo-container {
            height: 80px;
        }

        .partner-name {
            font-size: 0.9rem;
            min-height: auto;
            line-height: 1.2;
        }

        .partner-website {
            font-size: 0.8rem;
            padding: 6px 12px;
        }

        .partnership-benefits {
            padding: 1.5rem 1rem;
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
        }

        .benefit-icon i {
            font-size: 1.5rem !important;
        }
    }

    @media (max-width: 575.98px) {
        .partner-card {
            margin-bottom: 1.5rem;
        }

        .partners-grid .row {
            margin: 0 -0.5rem;
        }

        .partners-grid .col-lg-3 {
            padding: 0 0.5rem;
        }
    }

    /* Animation Performance Optimization */
    .partner-card {
        will-change: transform;
        backface-visibility: hidden;
    }

    .partner-logo {
        will-change: transform, filter;
        backface-visibility: hidden;
    }

    /* Section title uses shared .landing .section-title */
</style>

<script>
    // Enhanced hover effects for partner cards
    document.addEventListener('DOMContentLoaded', function() {
        const partnerCards = document.querySelectorAll('.partner-card');

        partnerCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                // Add subtle animation to other cards
                partnerCards.forEach(otherCard => {
                    if (otherCard !== card) {
                        otherCard.style.transform = 'scale(0.98)';
                        otherCard.style.opacity = '0.7';
                    }
                });
            });

            card.addEventListener('mouseleave', function() {
                // Reset all cards
                partnerCards.forEach(otherCard => {
                    otherCard.style.transform = '';
                    otherCard.style.opacity = '';
                });
            });
        });

        // Add click tracking for website links
        const websiteLinks = document.querySelectorAll('.partner-website');
        websiteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Add click animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    });

    // Smooth scrolling enhancement for partner section
    function scrollToPartnersSection() {
        document.querySelector('#partners').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
</script>
