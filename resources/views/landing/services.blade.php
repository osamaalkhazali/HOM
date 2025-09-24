<!-- Services Section -->
<section id="services" class="py-5 position-relative section-with-bg">
    <div class="section-bg-overlay"></div>
    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5" data-aos="fade-up">
                <h2 class="section-title fw-bold mb-4">Our Core Services</h2>
                <p class="lead text-muted">
                    Comprehensive expertise delivered through our <strong>flexible staff base</strong> and
                    <strong>qualified business partners</strong>
                </p>
            </div>
        </div>

        <!-- Services Navigation -->
        <div class="mb-5" id="service-nav">
            <div class="row g-4 justify-content-center">
                <!-- Project Development Service -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="service-card position-relative overflow-hidden selected"
                        onclick="showService('project-development')" data-service="project-development">
                        <div class="service-card-progress"></div>
                        <div class="p-4 text-center">
                            <div class="service-icon-wrapper mb-3">
                                <div
                                    class="service-icon bg-blue text-white d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Project Development</h5>
                        </div>
                    </div>
                </div>

                <!-- Project Management Service -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="service-card position-relative overflow-hidden"
                        onclick="showService('project-management')" data-service="project-management">
                        <div class="service-card-progress"></div>
                        <div class="p-4 text-center">
                            <div class="service-icon-wrapper mb-3">
                                <div
                                    class="service-icon bg-green text-white d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-tasks"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Project Management</h5>
                        </div>
                    </div>
                </div>

                <!-- Engineering Services -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="service-card position-relative overflow-hidden"
                        onclick="showService('engineering-services')" data-service="engineering-services">
                        <div class="service-card-progress"></div>
                        <div class="p-4 text-center">
                            <div class="service-icon-wrapper mb-3">
                                <div
                                    class="service-icon bg-purple text-white d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Engineering Services</h5>
                        </div>
                    </div>
                </div>

                <!-- Administrative Studies -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="service-card position-relative overflow-hidden"
                        onclick="showService('administrative-studies')" data-service="administrative-studies">
                        <div class="service-card-progress"></div>
                        <div class="p-4 text-center">
                            <div class="service-icon-wrapper mb-3">
                                <div
                                    class="service-icon bg-orange text-white d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Administrative Studies</h5>
                        </div>
                    </div>
                </div>

                <!-- Feasibility Studies -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="service-card position-relative overflow-hidden"
                        onclick="showService('feasibility-studies')" data-service="feasibility-studies">
                        <div class="service-card-progress"></div>
                        <div class="p-4 text-center">
                            <div class="service-icon-wrapper mb-3">
                                <div
                                    class="service-icon bg-red text-white d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-search-dollar"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Feasibility Studies</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Details Card -->
        <div id="service-details" class="flip-transition">
            <div id="service-content">
                <!-- Content will be dynamically loaded here -->
            </div>
        </div>
    </div>
</section>

<style>
    /* Services Section Styling - Professional Design */
    #services {
        background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(24, 69, 143, 0.3) 100%),
            url('{{ asset('assets/images/hero.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        position: relative;
        overflow: hidden;
    }

    .section-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.92) 0%, rgba(255, 255, 255, 0.88) 60%, rgba(255, 255, 255, 0.82) 80%, rgba(255, 255, 255, 0.75) 90%, rgba(255, 255, 255, 0.65) 100%);
        z-index: 1;
    }

    #services .container {
        position: relative;
        z-index: 5;
    }

    /* Service Cards Styling */
    .service-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(24, 69, 143, 0.3);
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        box-shadow: 0 20px 40px rgba(24, 69, 143, 0.15), 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .service-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 30px 60px rgba(24, 69, 143, 0.25), 0 15px 35px rgba(0, 0, 0, 0.2);
        border-color: rgba(24, 69, 143, 0.6);
        background: rgba(255, 255, 255, 0.98);
    }

    .service-card.selected {
        border: 2px solid var(--primary-color);
        box-shadow: 0 25px 50px rgba(24, 69, 143, 0.3);
        transform: translateY(-8px) scale(1.05);
        background: rgba(255, 255, 255, 0.98);
    }

    .service-card-progress {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        transform: translateX(-100%);
        transition: transform 0.8s ease;
    }

    .service-card.active .service-card-progress {
        transform: translateX(100%);
    }

    .service-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .service-icon.bg-blue {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-icon.bg-green {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-icon.bg-purple {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-icon.bg-orange {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-icon.bg-red {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-icon-wrapper {
        position: relative;
    }

    .service-icon-wrapper::before {
        content: '';
        position: absolute;
        top: -6px;
        left: -6px;
        right: -6px;
        bottom: -6px;
        background: linear-gradient(45deg, var(--primary-color), transparent, var(--primary-color));
        border-radius: 10px;
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: -1;
    }

    .service-card.selected .service-icon {
        background: transparent !important;
        border: 1px solid var(--primary-color);
        color: var(--primary-color) !important;
    }

    @keyframes pulse-glow {

        0%,
        100% {
            opacity: 0.3;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.05);
        }
    }

    .service-card h5 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    /* Service Details Styling */
    #service-details {
        min-height: 400px;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        padding: 2rem;
    }

    .flip-transition {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .flip-enter {
        opacity: 0;
        transform: rotateY(-90deg) scale(0.8);
    }

    .flip-exit {
        opacity: 1;
        transform: rotateY(0deg) scale(1);
    }

    /* Rebuilt Service Details Card Styling */

    /* Service Overview Section */
    .service-overview-section {
        margin-bottom: 2rem;
    }

    .service-header-content {
        height: 100%;
    }

    .service-main-icon {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    }

    .service-main-icon.bg-blue {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-main-icon.bg-green {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-main-icon.bg-purple {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-main-icon.bg-orange {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-main-icon.bg-red {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-color)) !important;
    }

    .service-main-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.3;
    }

    .service-main-desc {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .service-status-badge .badge {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
    }

    /* Service Stats Card */
    .service-stats-card {
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.9), rgba(255, 255, 255, 0.95));
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .stats-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* Featured Projects Section */
    .featured-projects-section {
        position: relative;
    }

    /* Slider Counter Styling */
    .slider-counter-section {
        text-align: center;
    }

    .slider-counter-display {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(24, 69, 143, 0.2);
        border-radius: 25px;
        padding: 8px 20px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .current-slide {
        color: var(--primary-color);
        font-weight: 700;
    }

    .counter-separator {
        color: #6b7280;
        margin: 0 8px;
    }

    .total-slides {
        color: #6b7280;
        font-weight: 500;
    }

    .section-header .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1a202c;
        margin: 0;
    }

    .project-navigation-info .nav-counter {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* Projects Slider */
    .projects-slider-container {
        position: relative;
        margin-top: 1.5rem;
    }

    .slider-navigation {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        z-index: 10;
        pointer-events: none;
    }

    .nav-button {
        position: absolute;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(24, 69, 143, 0.2);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        color: #64748b;
        font-size: 16px;
        pointer-events: auto;
    }

    .nav-button:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(24, 69, 143, 0.25);
    }

    .prev-btn {
        left: -24px;
    }

    .next-btn {
        right: -24px;
    }

    .slider-viewport {
        overflow: hidden;
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.8), rgba(255, 255, 255, 0.9));
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        cursor: grab;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        touch-action: pan-y pinch-zoom;
    }

    .slider-viewport:active {
        cursor: grabbing;
    }

    .slider-track {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .project-slide-card {
        flex-shrink: 0;
        padding: 2rem;
        box-sizing: border-box;
    }

    .project-content-wrapper {
        display: flex;
        gap: 2rem;
        height: 100%;
        min-height: 280px;
    }

    /* Full-width layout for Feasibility Studies */
    .project-content-wrapper-full {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        height: 100%;
        min-height: 400px;
    }

    .project-text-content-full {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .project-visual-content-full {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1;
    }

    .project-image-container-full {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        width: 100%;
        height: 100%;
        min-height: 300px;
    }

    .project-image-container-full:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }

    .project-text-content {
        flex: 1.2;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .project-visual-content {
        flex: 0.8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .project-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
        line-height: 1.3;
        flex: 1;
        margin-right: 1rem;
    }

    .project-number .badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }

    .project-description {
        color: #6b7280;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .project-footer {
        margin-top: auto;
    }

    .project-tags {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .tag {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 500;
        border: 1px solid transparent;
    }

    .tag-blue {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border-color: rgba(59, 130, 246, 0.2);
    }

    .tag-green {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border-color: rgba(16, 185, 129, 0.2);
    }

    .tag-purple {
        background: rgba(139, 92, 246, 0.1);
        color: #7c3aed;
        border-color: rgba(139, 92, 246, 0.2);
    }

    .tag-orange {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border-color: rgba(245, 158, 11, 0.2);
    }

    .tag-red {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .tag-default {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border-color: rgba(107, 114, 128, 0.2);
    }

    /* Project Visual */
    .project-image-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        width: 100%;
        height: 300px;
    }

    .project-image-container:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }

    /* Fixed grid gallery: fit all images (1-3) within the area, no scroll */
    .project-image-container .image-grid {
        display: grid;
        height: 100%;
        width: 100%;
        gap: 2px;
        /* maximize image area */
        padding: 3px;
        /* minimal padding for larger tiles */
        box-sizing: border-box;
    }

    .project-image-container .image-grid.grid-1 {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
    }

    .project-image-container .image-grid.grid-2 {
        grid-template-columns: 1fr;
        grid-template-rows: repeat(2, 1fr);
    }

    .project-image-container .image-grid.grid-3 {
        grid-template-columns: repeat(2, 1fr);
        /* Balance to enlarge bottom tiles significantly */
        grid-template-rows: 50% 50%;
    }

    /* Mobile: reduce gaps for better space usage and adjust grid layout */
    @media (max-width: 767.98px) {
        .project-image-container .image-grid {
            gap: 1px;
            padding: 2px;
        }

        /* For 2 images on mobile: stack vertically */
        .project-image-container .image-grid.grid-2 {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr;
        }

        /* For 3 images on mobile: adjust to better layout */
        .project-image-container .image-grid.grid-3 {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr 1fr;
        }

        .project-image-container .image-grid.grid-3 .tile-1 {
            grid-column: 1;
        }

        /* Increase mobile image container heights for better visibility */
        .project-image-container.count-2 {
            height: 200px !important;
            width: 100%;
        }

        .project-image-container.count-3 {
            height: 240px !important;
            width: 100%;
        }
    }

    /* Increase overall height when there are exactly 2 images (within slider limits) */
    .project-image-container.count-2 {
        /* min 360px, prefer ~52vh, cap at 560px */
        height: clamp(360px, 52vh, 560px);
    }

    /* Increase overall height when there are 3 images (within slider limits) */
    .project-image-container.count-3 {
        /* min 360px, prefer ~50vh, cap at 540px */
        height: clamp(360px, 50vh, 540px);
    }

    .project-image-container .image-grid.grid-3 .tile-1 {
        grid-column: 1 / -1;
        /* top image spans two columns */
    }

    .project-image-container .image-grid .grid-item {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        background: #fff;
    }

    .project-image-container .image-grid .grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .project-icon-wrapper {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 48px;
        position: relative;
        overflow: hidden;
    }

    .project-icon-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: translateX(-100%);
        animation: shimmer 3s infinite;
    }

    /* Slider Indicators */
    .slider-indicators {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 1.5rem;
    }

    .indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(107, 114, 128, 0.3);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator.active {
        background: var(--primary-color);
        transform: scale(1.5);
        box-shadow: 0 0 0 4px rgba(24, 69, 143, 0.1);
    }

    .indicator:hover:not(.active) {
        background: rgba(107, 114, 128, 0.6);
        transform: scale(1.2);
    }

    /* Team Information */
    .team-info-section {
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        padding-top: 1.5rem;
    }

    .team-card {
        background: rgba(248, 250, 252, 0.5);
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .team-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .team-details {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }

    /* Project Card Styling */
    .project-showcase-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .project-showcase-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
    }

    .project-image-placeholder {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 64px;
        position: relative;
        overflow: hidden;
    }

    .project-image-placeholder::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: translateX(-100%);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .service-metrics {
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.8), rgba(255, 255, 255, 0.9));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .metric-item {
        text-align: center;
        padding: 20px 15px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .metric-item:hover {
        background: rgba(255, 255, 255, 0.95);
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .service-overview {
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.9), rgba(255, 255, 255, 0.95));
        border-radius: 10px;
        padding: 32px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
    }

    /* Color variations for different services */
    .text-purple {
        color: #8b5cf6 !important;
    }

    .text-success {
        color: #10b981 !important;
    }

    .text-warning {
        color: #f59e0b !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Badge Styling */
    .badge {
        font-weight: 600;
        font-size: 0.8rem;
        padding: 8px 16px;
        border-radius: 10px;
    }

    .bg-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, var(--primary-color), #1d4ed8) !important;
    }

    .bg-purple {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Responsive Design for Rebuilt Service Cards */
    @media (max-width: 991.98px) {
        .service-card {
            margin-bottom: 1.5rem;
        }

        .service-main-icon {
            width: 56px;
            height: 56px;
            font-size: 24px;
        }

        .service-main-title {
            font-size: 1.5rem;
        }

        .service-main-desc {
            font-size: 0.9rem;
        }

        .nav-button {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .prev-btn {
            left: -20px;
        }

        .next-btn {
            right: -20px;
        }

        .project-content-wrapper {
            flex-direction: column;
            gap: 1.5rem;
            min-height: auto;
        }

        .project-content-wrapper-full {
            gap: 1rem;
            min-height: 400px;
        }

        .project-image-container-full {
            height: 100%;
            min-height: 250px;
        }

        .project-text-content {
            order: 2;
            text-align: center;
        }

        .project-visual-content {
            order: 1;
            width: 100%;
        }

        .project-image-container {
            width: 100%;
        }

        .project-slide-card {
            padding: 1.5rem;
        }

        .service-icon {
            width: 56px;
            height: 56px;
            font-size: 24px;
        }

        #service-details {
            padding: 1.5rem;
        }

        .project-icon-wrapper {
            font-size: 40px;
        }

        .project-image-container {
            height: 160px;
        }

        .project-image-container.count-2 {
            height: 160px;
        }

        .project-image-container.count-3 {
            height: 160px;
        }

        .service-metrics {
            padding: 20px;
        }

        .service-overview {
            padding: 24px;
        }

        .slider-counter-display {
            padding: 6px 16px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 767.98px) {
        .service-card h5 {
            font-size: 0.75rem;
            line-height: 1.2;
            margin-bottom: 0;
        }

        .service-card {
            margin-bottom: 0.5rem;
        }

        .service-card .p-2 {
            padding: 0.5rem !important;
        }

        .service-icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }

        .service-icon-wrapper {
            margin-bottom: 0.5rem !important;
        }

        /* Mobile services grid - 3 columns with smaller gaps */
        .mb-5 {
            margin-bottom: 1rem !important;
        }

        .mb-5 .row {
            gap: 0.25rem !important;
        }

        .mb-5 .row .col-lg-2 {
            flex: 0 0 calc(33.333% - 0.5rem);
            max-width: calc(33.333% - 0.5rem);
        }

        /* Override desktop padding and margins for mobile */
        .service-card .p-4 {
            padding: 0.5rem !important;
        }

        .service-icon-wrapper.mb-3 {
            margin-bottom: 0.5rem !important;
        }

        .service-main-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .service-main-title {
            font-size: 1.25rem;
        }

        .project-slide-card {
            padding: 1rem;
        }

        .project-title {
            font-size: 1.25rem;
        }

        .project-description {
            font-size: 0.9rem;
        }

        .project-image-container {
            height: 140px;
            width: 100%;
        }

        .project-image-container.count-2 {
            height: 200px;
            width: 100%;
        }

        .project-image-container.count-3 {
            height: 240px;
            width: 100%;
        }

        .project-visual-content {
            width: 100%;
        }

        .project-icon-wrapper {
            font-size: 32px;
        }

        #service-details {
            padding: 1rem;
        }

        .service-overview-section .row {
            flex-direction: column;
        }

        .service-stats-card {
            margin-top: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .project-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .project-title {
            margin-right: 0;
        }

        .nav-button {
            width: 36px;
            height: 36px;
            font-size: 12px;
        }

        .prev-btn {
            left: -18px;
        }

        .next-btn {
            right: -18px;
        }

        .slider-indicators {
            margin-top: 1rem;
            gap: 6px;
        }

        .indicator {
            width: 10px;
            height: 10px;
        }

        .projects-slider-container {
            margin-top: 1rem;
        }

        .project-content-wrapper {
            min-height: 240px;
            gap: 1rem;
        }

        .project-content-wrapper-full {
            min-height: 320px;
            gap: 0.75rem;
        }

        .project-image-container-full {
            height: 100%;
            min-height: 200px;
        }

        .slider-counter-display {
            padding: 5px 14px;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 575.98px) {
        .service-card h5 {
            font-size: 0.7rem;
            line-height: 1.1;
        }

        .service-card .p-2 {
            padding: 0.4rem !important;
        }

        .service-icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .service-icon-wrapper {
            margin-bottom: 0.25rem !important;
        }

        /* Extra small mobile - even smaller gaps and margins */
        .mb-5 {
            margin-bottom: 0.75rem !important;
        }

        .mb-5 .row {
            gap: 0.15rem !important;
        }

        .mb-5 .row .col-lg-2 {
            flex: 0 0 calc(33.333% - 0.3rem);
            max-width: calc(33.333% - 0.3rem);
        }

        /* Override desktop padding for extra small mobile */
        .service-card .p-4 {
            padding: 0.4rem !important;
        }

        .service-icon-wrapper.mb-3 {
            margin-bottom: 0.25rem !important;
        }

        .nav-button {
            width: 32px;
            height: 32px;
            font-size: 10px;
        }

        .prev-btn {
            left: -16px;
        }

        .next-btn {
            right: -16px;
        }

        .project-slide-card {
            padding: 0.75rem;
        }

        .service-main-title {
            font-size: 1.1rem;
        }

        .project-title {
            font-size: 1.1rem;
        }

        .project-description {
            font-size: 0.85rem;
        }

        .service-main-desc {
            font-size: 0.85rem;
        }

        .section-title {
            font-size: 1.1rem !important;
        }

        .project-content-wrapper {
            min-height: 200px;
        }

        .project-content-wrapper-full {
            min-height: 280px;
            gap: 0.5rem;
        }

        .project-image-container-full {
            height: 100%;
            min-height: 180px;
        }

        .project-image-container {
            height: 120px;
            width: 100%;
        }

        .project-image-container.count-2 {
            height: 180px;
            width: 100%;
        }

        .project-image-container.count-3 {
            height: 220px;
            width: 100%;
        }

        .project-visual-content {
            width: 100%;
        }

        .project-visual-content-full {
            width: 100%;
        }

        .project-icon-wrapper {
            font-size: 28px;
        }

        .slider-counter-display {
            padding: 4px 12px;
            font-size: 0.7rem;
        }
    }

    /* Additional mobile grid fixes for very small screens */
    @media (max-width: 575.98px) {
        .project-image-container .image-grid.grid-2 {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr;
        }

        .project-image-container .image-grid.grid-3 {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr 1fr;
        }

        .project-image-container .image-grid.grid-3 .tile-1 {
            grid-column: 1;
        }
    }

    /* Section title uses shared .landing .section-title */
</style>

<script>
    const serviceData = {
        'project-development': {
            title: 'Project Development Services',
            icon: 'fas fa-project-diagram',
            iconColor: 'bg-blue',
            textColor: 'text-primary',
            status: 'Active',
            projects: [{
                name: 'PET Recycling Plant - Qatar',
                description: '<strong>Project Description:</strong> USD 12 Million grass root recycling plant for plastics packaging in Qatar.<br><br><strong>HOM Services:</strong> Project Development: Feasibility study, company formation, land selection, technology selection, project budgeting, Fund management, and strategy building.<br><br><strong>Progress:</strong> Scope completed on time.',
                image: '/assets/images/projects/project-development-project-1.png'
            }],
            description: 'End-to-end project development solutions from conception to completion, including planning, design, execution, and delivery management.',
            team: 'Project Managers: 3, Engineers: 5, Architects: 2, Consultants: 4'
        },
        'project-management': {
            title: 'Project Management Services',
            icon: 'fas fa-tasks',
            iconColor: 'bg-green',
            textColor: 'text-success',
            status: 'Scaling',
            projects: [{
                    tag: 'Industrial Sector',
                    name: 'Jordan Bromine Co. Ltd. (JBC) - Jordan',
                    description: '<strong>Project Description:</strong> 18 Million UD$ Expansion of the existing chemical manufacturing plant.<br><br><strong>HOM Services:</strong> Project Management, cost control, construction supervision, commissioning and startup.<br><br><strong>Achievements:</strong> completed successfully with 10% saving on budget and two months earlier than plan, HOM received an incentive money award for appreciation.',
                    image: '/assets/images/projects/project-management-project-1.png'
                },
                {
                    tag: 'Industrial Sector',
                    name: 'Jordan India Fertilizers Co. Ltd. (JIFCO) - Jordan',
                    description: '<strong>Project Description:</strong> 700 Million UD$ fertilizers manufacturing plant.<br><br><strong>HOM Services:</strong> The project schedule and budget has out run beyond plans, HOM has been appointed to diagnose the construction deficiencies and propose recovery plans for delays to reach the completion of the project successfully. Review handing over procedures, construction method statements and commissioning planning.<br><br><strong>Achievements:</strong> Completed.',
                    image: '/assets/images/projects/project-management-project-2.png'
                },
                {
                    tag: 'Tourism Sector',
                    name: 'Lagoon Hotel and Resort Project, Dead Sea - Jordan',
                    description: '<strong>Project Description:</strong> 30 Million UD$ artificial lagoon and 5 stars resort and spa.<br><br><strong>HOM Services:</strong> Project management and Construction management<br><br><strong>Achievements:</strong> Completed on time and budget.',
                    image: '/assets/images/projects/project-management-project-3.png'
                },
                {
                    tag: 'Renewable Energy Sector',
                    name: 'Photovoltaic Power Generation Project - Jordan',
                    description: '<strong>Project Description:</strong> 1.3 Million UD$ photovoltaic power generation project for domestic applications, car Parking roof mounted, fully integrated, 500KW capacity.<br><br><strong>HOM Services:</strong> Project management and Construction management<br><br><strong>Achievements:</strong> construction successfully completed.',
                    image: '/assets/images/projects/project-management-project-4.png'
                }
            ],
            description: 'Strategic project oversight and management services ensuring timely delivery, budget compliance, and quality standards.',
            team: 'Senior PMs: 2, Coordinators: 4, Analysts: 3, Quality Managers: 2'
        },
        'engineering-services': {
            title: 'Engineering Services',
            icon: 'fas fa-cogs',
            iconColor: 'bg-purple',
            textColor: 'text-purple',
            status: 'Growing',
            projects: [{
                    tag: 'Industrial Sector',
                    name: 'Al-Biariq Fertilizers Co., Yanbu – Saudi Arabia',
                    description: '<strong>Project Description:</strong> SOP fertilizers plant to produce 22,000 MT/Year SOP and 25,000 MT/Year HCl, with two reactors Manheim technology and related utilities and equipment, in addition to NPK physical blending plant and accessories.<br><br><strong>HOM Services:</strong> Pre-startup evaluation, commissioning plan preparation including cost, raw material, tools/equipment and staff requirements assessment, short term and long term expansions and future opportunities.<br><br><strong>Achievements:</strong> Completed and reported successfully on time',
                    images: ['/assets/images/projects/engineering-services-project-1-1.png',
                        '/assets/images/projects/engineering-services-project-1-2.png',
                        '/assets/images/projects/engineering-services-project-1-3.png'
                    ]
                },
                {
                    tag: 'Industrial Sector',
                    name: 'Almarai Poultry Co., Hail – Saudi Arabia',
                    description: '<strong>Project Description:</strong> 30 Million UD$ Electricity transmission, distribution and connection to national grid for Almarai poultry project, Hail – KSA.<br><br><strong>HOM Services:</strong> Technical specifications, conceptual design and tender documents for MV electrical transmission and distribution for the project (with association with Riyadh Engineering Center).<br><br><strong>Achievements:</strong> Completed successfully on time.',
                    images: ['/assets/images/projects/engineering-services-project-2-1.png',
                        '/assets/images/projects/engineering-services-project-2-2.png'
                    ]
                },
                {
                    tag: 'Industrial Sector',
                    name: 'National Chlorine Industries Co. – Jordan',
                    description: '<strong>Project Description:</strong> Technical assessment and evaluation study for alternative energy sources including Cogeneration, Solar and Hybrid off-grid systems compared with current connection to national power grid.<br><br><strong>HOM Services:</strong> Analysis of technical and commercial proposals for different power supply systems, financial assessment for each system for 25 years project lifetime, evaluation and recommendations.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                    images: ['/assets/images/projects/engineering-services-project-3-1.png',
                        '/assets/images/projects/engineering-services-project-3-2.png'
                    ]
                },
                {
                    tag: 'Industrial Sector',
                    name: 'Jordan Bromine Co. Ltd., Safi - Jordan',
                    description: '<strong>Project Description:</strong> Evaluate JBC energy options for future demand and saving opportunities in terms:<br>• Continue for Utility Supply for All Electricity Needs (current case)<br>• Solar Power Generation: Enter into a long term power purchase agreement for electricity supply from a new solar generation facility ("Solar PPA") and continue to receive utility supply for the balance of electricity needs.<br>• On-Site Cogeneration: Enter into a long term power purchase agreement ("Cogen PPA") for electricity supply and steam from a new on-site cogeneration facility and continue to receive backup electricity service from the utility<br><br><strong>HOM Services:</strong> Data collection, Offer soliciting for each option, technical and financial evaluation of options, recommendations and reporting. (with association with Energy Edge Consulting - USA).<br><br><strong>Achievements:</strong> Completed successfully on time.',
                    images: ['/assets/images/projects/engineering-services-project-4.png']
                },
                {
                    tag: 'Industrial Sector',
                    name: 'New Parking Area for Chlorine ISO Tanks – Jordan Bromine Co. – Jordan',
                    description: '<strong>Project Description:</strong> 600 square meters steel building for Chlorine ISO Tank Parking area at Jordan Bromine Co. Plant.<br><br><strong>HOM Services:</strong> Design, Engineering, Project Specification and Tender Document preparation for the Project.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                    images: ['/assets/images/projects/engineering-services-project-5.png']
                },
                {
                    tag: 'Real Estate Sector',
                    name: 'Al Maabar Jordan Real Estate Development Co. – Jordan',
                    description: '<strong>Project Description:</strong> 1. St. Regis – Amman: Two 16-story tower hotel with 260 luxurious guest rooms project in Amman. 2. Marsa Zayed project – Aqaba: $10 billion project, the biggest real estate and tourism project take place in the history of Jordan.<br><br><strong>HOM Services:</strong> Analysis, estimate review and verification of electrical load and value engineering for both projects.<br><br><strong>Achievements:</strong> Completed successfully on time.',
                    images: ['/assets/images/projects/engineering-services-project-6-1.png',
                        '/assets/images/projects/engineering-services-project-6-2.png'
                    ]
                }
            ],
            description: 'Technical engineering solutions across civil, mechanical, electrical, and environmental disciplines with innovative approaches.',
            team: 'Civil Engineers: 4, Mechanical Engineers: 3, Electrical Engineers: 2, Environmental Engineers: 2'
        },
        'administrative-studies': {
            title: 'Administrative Studies',
            icon: 'fas fa-chart-line',
            iconColor: 'bg-orange',
            textColor: 'text-warning',
            status: 'Consulting',
            projects: [{
                tag: 'Industrial Sector',
                name: 'S’HAIL GROUP – Qatar',
                description: '<strong>Project Description:</strong> Study and analyze the laws and regulations adopted by several countries to protect the local industries and national producers. In particular the protection of recycling industry and measures provided to support waste generated in the country as national resources.<br><br><strong>HOM Services:</strong> Collect data, analysis, report and set group of recommendations to protect recycling industry in Qatar.<br><br><strong>Achievements:</strong> Completed successfully on very short time.',
                images: ['/assets/images/projects/administrative-studies-project-1.png']
            }],
            description: 'In-depth administrative and organizational studies providing strategic insights and operational improvement recommendations.',
            team: 'Business Analysts: 3, Consultants: 4, Researchers: 2, Data Specialists: 2'
        },
        'feasibility-studies': {
            title: 'Feasibility Studies',
            icon: 'fas fa-search-dollar',
            iconColor: 'bg-red',
            textColor: 'text-danger',
            status: 'Research',
            projects: [{
                name: 'Our Experience',
                description: 'HOM has strong experience in preparation of financial assessments and feasibility studies for new projects and evaluation of investment opportunities, the following list shows samples of performed feasibility assessments in various sectors and wide range of scale.',
                image: '/assets/images/projects/feasibility-studies.png',
                fullWidth: true
            }],
            description: 'Comprehensive feasibility studies including market analysis, financial modeling, risk assessment, and investment recommendations.',
            team: 'Market Researchers: 3, Financial Analysts: 2, Risk Assessors: 2, Industry Experts: 3'
        }
    };

    let currentService = null;
    let currentProjectIndex = 0;
    let totalProjects = 0;
    // Prevent auto-scroll on first page load
    window.__servicesFirstLoad = true;

    // Touch/Swipe functionality variables
    let startX = 0;
    let startY = 0;
    let currentX = 0;
    let currentY = 0;
    let isDragging = false;
    let sliderElement = null;

    // Initialize with first service without auto-scrolling
    document.addEventListener('DOMContentLoaded', function() {
        window.__servicesFirstLoad = true;
        showService('project-development');
        window.__servicesFirstLoad = false;
    });

    function showService(serviceId) {
        const serviceDetails = document.getElementById('service-details');
        const serviceContent = document.getElementById('service-content');

        // If same service is clicked, do nothing
        if (currentService === serviceId) return;

        // Show service details with flip animation
        if (currentService !== null) {
            // Flip out current content
            serviceDetails.classList.add('flip-enter');
            setTimeout(() => {
                updateServiceContent(serviceId);
                serviceDetails.classList.remove('flip-enter');
            }, 200);
        } else {
            // First time showing
            updateServiceContent(serviceId);
        }

        currentService = serviceId;

        // Update active state of service cards
        document.querySelectorAll('.service-card').forEach(card => {
            card.classList.remove('selected');
            card.classList.remove('active');
        });

        const selectedCard = document.querySelector(`[data-service="${serviceId}"]`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
            selectedCard.classList.add('active');
        }

        // Smooth scroll to service details card (skip on first page load)
        if (!window.__servicesFirstLoad) {
            scrollToServiceDetails();
        }
    }

    function updateServiceContent(serviceId) {
        const data = serviceData[serviceId];
        const serviceContent = document.getElementById('service-content');

        totalProjects = data.projects.length;
        currentProjectIndex = 0;

        // Helper to render the right visual for a project (multi-image grid, single image, or icon)
        const renderVisual = (project) => {
            // Multi-image case (1-3 images shown without scroll)
            if (Array.isArray(project.images) && project.images.length > 0) {
                const imgs = project.images.slice(0, 3);
                const gridClass = imgs.length === 1 ? 'grid-1' : (imgs.length === 2 ? 'grid-2' : 'grid-3');
                const countClass = imgs.length === 2 ? 'count-2' : (imgs.length === 3 ? 'count-3' : '');
                const tiles = imgs.map((src, i) => (
                    `<div class="grid-item tile-${i + 1}"><img src="${src}" alt="${project.name}" loading="lazy"></div>`
                )).join('');
                return `
                    <div class="project-visual-content">
                        <div class="project-image-container ${countClass}">
                            <div class="image-grid ${gridClass}">${tiles}</div>
                        </div>
                    </div>
                `;
            }

            // Single image path (keep aspect ratio)
            if (project.image && (project.image.startsWith('/') || project.image.startsWith('http'))) {
                return `
                    <div class="project-visual-content">
                        <div class="project-image-container">
                            <img src="${project.image}" alt="${project.name}" style="width: 100%; height: 100%; object-fit: contain;" />
                        </div>
                    </div>
                `;
            }

            // Icon fallback
            const icon = project.image || 'fas fa-project-diagram';
            return `
                <div class="project-visual-content">
                    <div class="project-image-container">
                        <div class="project-icon-wrapper"><i class="${icon}"></i></div>
                    </div>
                </div>
            `;
        };

        serviceContent.innerHTML =
            `
        <!-- Service Overview Section -->
        <div class="service-overview-section">
            <div class="row g-4 mb-3">
                <!-- Service Header -->
                <div class="col-lg-12">
                    <div class="service-header-content">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="service-main-icon ${data.iconColor}">
                                    <i class="${data.icon}"></i>
                                </div>
                                <div class="d-flex align-items-center">
                                    <h2 class="service-main-title mb-0">${data.title}</h2>
                                </div>
                            </div>
                            <!-- Slider Counter on the right -->
                            <div class="slider-counter-display">
                                <span class="current-slide">1</span>
                                <span class="counter-separator"> / </span>
                                <span class="total-slides">${data.projects.length}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="featured-projects-section">
            <!-- Projects Slider -->
            <div class="projects-slider-container">
                <div class="slider-navigation">
                    <button class="nav-button prev-btn" onclick="previousProject()" id="prevBtn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="nav-button next-btn" onclick="nextProject()" id="nextBtn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="slider-viewport">
                    <div class="slider-track" id="mainSliderTrack" style="width: ${data.projects.length * 100}%;">
                        ${data.projects.map((project) => `
                            <div class="project-slide-card" style="width: ${100 / data.projects.length}%;">
                                ${project.fullWidth ? `
                                    <div class="project-content-wrapper-full">
                                        <div class="project-text-content-full">
                                            <div class="project-header">
                                                <div class="w-100">
                                                    <h4 class="project-title">${project.name}</h4>
                                                </div>
                                            </div>
                                            <div class="project-description">${project.description}</div>
                                        </div>
                                        <div class="project-visual-content-full">
                                            <div class="project-image-container-full">
                                                <img src="${project.image}" alt="${project.name}" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                        </div>
                                    </div>
                                ` : `
                                    <div class="project-content-wrapper">
                                        <div class="project-text-content">
                                            <div class="project-header">
                                                <div class="w-100">
                                                    ${(serviceId === 'engineering-services' || serviceId === 'administrative-studies') && project.tag ? `<div class=\"project-tag mb-2\"><span class=\"badge bg-primary\">${project.tag}</span></div>` : ''}
                                                    <h4 class="project-title">${project.name}</h4>
                                                </div>
                                            </div>
                                            ${(serviceId !== 'engineering-services' && serviceId !== 'administrative-studies') && project.tag ? `<div class="project-tag mb-3"><span class="badge bg-primary">${project.tag}</span></div>` : ''}
                                            <div class="project-description">${project.description}</div>
                                            <div class="project-footer">
                                                <div class="project-tags"></div>
                                            </div>
                                        </div>
                                        ${renderVisual(project)}
                                    </div>
                                `}
                            </div>
                        `).join('')}
                    </div>
                </div>

                <!-- Slider Indicators -->
                <div class="slider-indicators">
                    ${data.projects.map((_, index) => `
                        <button class="indicator ${index === 0 ? 'active' : ''}" onclick="goToProject(${index})" data-slide="${index}"></button>
                    `).join('')}
                </div>
            </div>
        </div>
    `;

        // Initialize touch/swipe functionality
        initializeTouchControls();
        // Ensure image area fits within the left text height
        requestAnimationFrame(adjustImageHeightsToText);
    }

    function nextProject() {
        if (currentProjectIndex < totalProjects - 1) {
            currentProjectIndex++;
            updateProjectSlider();
        }
    }

    function previousProject() {
        if (currentProjectIndex > 0) {
            currentProjectIndex--;
            updateProjectSlider();
        }
    }

    function goToProject(index) {
        currentProjectIndex = index;
        updateProjectSlider();
    }

    function updateProjectSlider() {
        const sliderTrack = document.getElementById('mainSliderTrack');
        const indicators = document.querySelectorAll('.indicator');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const currentSlideElement = document.querySelector('.current-slide');

        if (sliderTrack) {
            // Move slider to current project
            sliderTrack.style.transform = `translateX(-${currentProjectIndex * (100 / totalProjects)}%)`;

            // Update indicators
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentProjectIndex);
            });

            // Update slider counter
            if (currentSlideElement) {
                currentSlideElement.textContent = currentProjectIndex + 1;
            }

            // Update navigation buttons
            if (prevBtn) {
                prevBtn.style.opacity = currentProjectIndex === 0 ? '0.5' : '1';
                prevBtn.style.pointerEvents = currentProjectIndex === 0 ? 'none' : 'auto';
            }

            if (nextBtn) {
                nextBtn.style.opacity = currentProjectIndex === totalProjects - 1 ? '0.5' : '1';
                nextBtn.style.pointerEvents = currentProjectIndex === totalProjects - 1 ? 'none' : 'auto';
            }
            // After slide change, adjust image heights
            requestAnimationFrame(adjustImageHeightsToText);
        }
    }

    // Touch/Swipe functionality
    function initializeTouchControls() {
        sliderElement = document.querySelector('.slider-viewport');
        if (!sliderElement) return;

        // Touch events
        sliderElement.addEventListener('touchstart', handleTouchStart, {
            passive: false
        });
        sliderElement.addEventListener('touchmove', handleTouchMove, {
            passive: false
        });
        sliderElement.addEventListener('touchend', handleTouchEnd, {
            passive: false
        });

        // Mouse events for desktop
        sliderElement.addEventListener('mousedown', handleMouseStart);
        sliderElement.addEventListener('mousemove', handleMouseMove);
        sliderElement.addEventListener('mouseup', handleMouseEnd);
        sliderElement.addEventListener('mouseleave', handleMouseEnd);

        // Prevent default drag behavior
        sliderElement.addEventListener('dragstart', e => e.preventDefault());
    }

    function handleTouchStart(e) {
        const touch = e.touches[0];
        startX = touch.clientX;
        startY = touch.clientY;
        isDragging = true;
        sliderElement.style.cursor = 'grabbing';
    }

    function handleTouchMove(e) {
        if (!isDragging) return;

        currentX = e.touches[0].clientX;
        currentY = e.touches[0].clientY;

        const deltaX = Math.abs(currentX - startX);
        const deltaY = Math.abs(currentY - startY);

        // If horizontal movement is greater, prevent vertical scroll
        if (deltaX > deltaY) {
            e.preventDefault();
        }
    }

    function handleTouchEnd(e) {
        if (!isDragging) return;

        const deltaX = currentX - startX;
        const deltaY = Math.abs(currentY - startY);

        // Only process horizontal swipes
        if (Math.abs(deltaX) > 50 && deltaY < 100) {
            if (deltaX > 0) {
                // Swipe right - go to previous
                previousProject();
            } else {
                // Swipe left - go to next
                nextProject();
            }
        }

        isDragging = false;
        sliderElement.style.cursor = 'grab';
    }

    function handleMouseStart(e) {
        startX = e.clientX;
        startY = e.clientY;
        isDragging = true;
        sliderElement.style.cursor = 'grabbing';
        e.preventDefault();
    }

    function handleMouseMove(e) {
        if (!isDragging) return;
        currentX = e.clientX;
        currentY = e.clientY;
    }

    function handleMouseEnd(e) {
        if (!isDragging) return;

        const deltaX = currentX - startX;
        const deltaY = Math.abs(currentY - startY);

        // Only process horizontal drags
        if (Math.abs(deltaX) > 50 && deltaY < 100) {
            if (deltaX > 0) {
                // Drag right - go to previous
                previousProject();
            } else {
                // Drag left - go to next
                nextProject();
            }
        }

        isDragging = false;
        sliderElement.style.cursor = 'grab';
    }

    // Smooth scroll to service navigation
    function scrollToServiceDetails() {
        const serviceNavigation = document.getElementById('service-nav');
        if (serviceNavigation) {
            serviceNavigation.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Adjust 2/3 image containers to not exceed the left text column height
    function adjustImageHeightsToText() {
        const slides = document.querySelectorAll('.project-slide-card');
        slides.forEach(slide => {
            const textCol = slide.querySelector('.project-text-content');
            const imgContainer = slide.querySelector('.project-image-container');
            if (!textCol || !imgContainer) return;

            // Only adjust for 2- or 3-image layouts
            const isCount2 = imgContainer.classList.contains('count-2');
            const isCount3 = imgContainer.classList.contains('count-3');
            if (!isCount2 && !isCount3) return;

            // Compute max allowed height = text content height
            const maxH = textCol.getBoundingClientRect().height;
            // Apply max-height so container will not exceed the text column
            imgContainer.style.maxHeight = `${Math.max(140, Math.floor(maxH))}px`;
        });
    }

    // Re-run on resize to keep within limits
    window.addEventListener('resize', () => {
        requestAnimationFrame(adjustImageHeightsToText);
    });
</script>
