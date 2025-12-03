<section id="about" class="py-5 position-relative overflow-hidden section-with-bg">
    <div class="section-bg-overlay"></div>
    <div class="container">
        @php($focus = trans('site.focus'))

        <!-- Header -->
        <div class="row text-center mb-5">
            <div class="col-12" data-aos="fade-up">
                <h2 class="section-title fw-bold mb-3">{{ $focus['title'] }}</h2>
                <p class="lead text-muted mb-4 mx-auto" style="max-width: 700px;">
                    {{ $focus['subtitle'] }}
                </p>
            </div>
        </div>

        <!-- Focus Areas Grid -->
        <div class="row g-4 mb-5 justify-content-center between">
            @foreach ($focus['cards'] as $index => $card)
                <div class="col-lg-4 col-md-6" style="max-width: 360px;" data-aos="zoom-in" data-aos-delay="{{ 100 + ($index * 100) }}">
                    <div class="card border-0 shadow h-100 hover-lift" style="border-radius: 10px; background: #ffffff;">
                        <div class="card-body p-3 text-center">
                            <div class="mb-3">
                                <div class="icon-wrapper mx-auto mb-2"
                                    style="background: var(--primary-color); width: 50px; height: 50px; border-radius: 10px;">
                                    <i class="{{ $card['icon'] }} text-white fs-5"></i>
                                </div>
                                <h5 class="fw-bold mb-2" style="color: var(--primary-color);">{{ $card['title'] }}</h5>
                            </div>
                            <div class="text-start">
                                @foreach ($card['items'] as $item)
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check-circle text-success me-2 mt-1 small"></i>
                                        <span class="text-muted small">{{ $item }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Why We Are Unique Section -->
        <div class="text-center mb-4" data-aos="fade-up">
            <h3 class="section-title fw-bold mb-2">{{ $focus['unique']['title'] }}</h3>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="pe-lg-4">
                    <ul class="list-unstyled m-0">
                        @foreach ($focus['unique']['items'] as $item)
                            <li class="mb-3">
                                <div class="d-flex align-items-start p-3 bg-white border rounded-3 shadow-sm"
                                    style="border-left: 4px solid var(--primary-color); border-radius: 10px !important;">
                                    <i class="fas fa-check-circle text-hom-primary me-3 mt-1"></i>
                                    <p class="mb-0 text-muted small">{{ $item }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-xl" style="border-radius: 10px; background: var(--primary-color);">
                    <div class="card-body p-5 text-white">
                        <div class="text-center mb-4">
                            <div class="mb-3"
                                style="width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-handshake fs-1"></i>
                            </div>
                            <h3 class="fw-bold mb-3">{{ $focus['unique']['cta']['heading'] }}</h3>
                            <p class="mb-4 opacity-90 fs-5">
                                {{ $focus['unique']['cta']['description'] }}
                            </p>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <a href="{{ $focus['unique']['cta']['buttons']['primary']['href'] }}"
                                    class="btn btn-hom btn-light text-primary fw-semibold w-100 morph-btn">
                                    <i class="{{ $focus['unique']['cta']['buttons']['primary']['icon'] }} me-2"></i>{{ $focus['unique']['cta']['buttons']['primary']['label'] }}
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ $focus['unique']['cta']['buttons']['secondary']['href'] }}"
                                    class="btn btn-hom btn-outline-light fw-semibold w-100 morph-btn">
                                    <i class="{{ $focus['unique']['cta']['buttons']['secondary']['icon'] }} me-2"></i>{{ $focus['unique']['cta']['buttons']['secondary']['label'] }}
                                </a>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <small class="opacity-75">
                                <i class="fas fa-shield-halved me-2"></i>
                                {{ $focus['unique']['cta']['note'] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .between {
        justify-content: center !important;
    }

    @media (min-width: 992px) {
        .between {
            justify-content: space-between !important;
        }
    }
</style>
