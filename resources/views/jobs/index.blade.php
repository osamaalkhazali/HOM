<x-app-layout>
    @include('layouts.styles')

    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-briefcase me-2"></i>{{ __('site.jobs_index.header.title') }}</h1>
                <p class="subtitle mb-0">{{ __('site.jobs_index.header.subtitle') }}</p>
            </div>
            <div class="actions d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>{{ __('site.jobs_index.header.back_to_dashboard') }}
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <section class="py-3 dashboard">
        <div class="container">
            <!-- Filters Section -->
            <div class="panel mb-4 shadow-soft" data-aos="fade-up">
                <div class="panel-header">
                    <h5 class="panel-title mb-0">
                        <i class="fas fa-filter me-2"></i>{{ __('site.jobs_index.filters.title') }}
                    </h5>
                </div>
                <div class="panel-body">
                    <form method="GET" action="{{ route('jobs.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-search me-1"></i>{{ __('site.jobs_index.filters.search_label') }}
                                </label>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                    placeholder="{{ __('site.jobs_index.filters.search_placeholder') }}" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-tags me-1"></i>{{ __('site.jobs_index.filters.category_label') }}
                                </label>
                                <select class="form-select" name="category" id="categorySelect" style="border-radius: 10px;">
                                    <option value="">{{ __('site.jobs_index.filters.category_all') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-layer-group me-1"></i>{{ __('site.jobs_index.filters.subcategory_label') }}
                                </label>
                                <select class="form-select" name="subcategory" id="subcategorySelect" style="border-radius: 10px;">
                                    <option value="">{{ __('site.jobs_index.filters.subcategory_all') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ __('site.jobs_index.filters.location_label') }}
                                </label>
                                <input type="text" class="form-control" name="location" value="{{ request('location') }}"
                                    placeholder="{{ __('site.jobs_index.filters.location_placeholder') }}" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold text-primary">
                                    <i class="fas fa-level-up-alt me-1"></i>{{ __('site.jobs_index.filters.level_label') }}
                                </label>
                                <select class="form-select" name="level" style="border-radius: 10px;">
                                    <option value="">{{ __('site.jobs_index.filters.level_all') }}</option>
                                    @if (isset($levels))
                                        @foreach ($levels as $level)
                                            <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                                {{ $level }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100" style="background: var(--primary-color); border: none; border-radius: 10px; padding: 0.75rem;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Header -->
            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
                <div>
                    <h4 class="fw-bold mb-1 text-primary">
                        {{ trans_choice('site.jobs_index.results.count', $jobs->total(), ['count' => $jobs->total()]) }}
                    </h4>
                    <p class="text-muted mb-0">
                        @if (request()->hasAny(['search', 'category', 'subcategory', 'location', 'level']))
                            {{ __('site.jobs_index.results.filtered') }}
                        @else
                            {{ __('site.jobs_index.results.all') }}
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0 fw-medium">{{ __('site.jobs_index.results.sort_label') }}</label>
                    <select class="form-select" style="width: auto; border-radius: 10px;" onchange="this.form.submit()" form="sortForm">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('site.jobs_index.results.sort_options.newest') }}</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('site.jobs_index.results.sort_options.oldest') }}</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>{{ __('site.jobs_index.results.sort_options.title') }}</option>
                        <option value="company" {{ request('sort') == 'company' ? 'selected' : '' }}>{{ __('site.jobs_index.results.sort_options.company') }}</option>
                    </select>
                    <form id="sortForm" method="GET" action="{{ route('jobs.index') }}" class="d-none">
                        @foreach (request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="hidden" name="sort" value="">
                    </form>
                </div>
            </div>

            <!-- Jobs Grid -->
            @if ($jobs->count() > 0)
                <div class="row g-4">
                    @foreach ($jobs as $job)
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="panel h-100 shadow-soft {{ $job->isExpired() ? 'expired' : '' }}">
                                <div class="panel-header" style="background: var(--primary-color); color: white;">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-bold mb-0">{{ $job->title_localized }}</h5>
                                    </div>
                                    <p class="mb-2 opacity-90">
                                        <i class="fas fa-building me-1"></i>{{ $job->company_localized }}
                                    </p>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if ($job->subCategory && $job->subCategory->category)
                                            <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                                <i class="fas fa-folder me-1"></i>{{ optional(optional($job->subCategory)->category)->display_name }}
                                            </span>
                                        @endif
                                        @if ($job->subCategory)
                                            <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                                <i class="fas fa-tag me-1"></i>{{ optional($job->subCategory)->display_name }}
                                            </span>
                                        @endif
                                        @if ($job->location)
                                            <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location_localized }}
                                            </span>
                                        @endif
                                        @if ($job->level)
                                            <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                                <i class="fas fa-level-up-alt me-1"></i>{{ __('site.jobs.levels.' . $job->level) }}
                                            </span>
                                        @endif
                                        @if ($job->isExpired())
                                            <span class="badge bg-danger" style="border-radius: 10px;">
                                                <i class="fas fa-calendar-times me-1"></i>{{ __('site.jobs_index.badges.expired') }}
                                            </span>
                                        @else
                                            @php
                                                $daysLeft = \Carbon\Carbon::parse($job->deadline)->diffInDays(now(), false);
                                                $isUrgent = $daysLeft <= 3 && $daysLeft >= 0;
                                            @endphp
                                            @if ($isUrgent)
                                                <span class="badge bg-warning" style="border-radius: 10px;">
                                                    <i class="fas fa-clock me-1"></i>{{ trans_choice('site.jobs_index.badges.days_left', $daysLeft, ['count' => $daysLeft]) }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <p class="text-muted mb-3">
                                        {{ Str::limit(strip_tags($job->description_localized), 120) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ __('site.jobs_index.results.posted', ['time' => $job->created_at->diffForHumans()]) }}
                                        </small>
                                        @if ($job->isExpired())
                                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-secondary btn-sm" style="border-radius: 10px;">
                                            <i class="fas fa-eye me-1"></i>{{ __('site.jobs.buttons.view_expired') }}
                                            </a>
                                        @else
                                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;">
                                            <i class="fas fa-eye me-1"></i>{{ __('site.jobs.buttons.view_details') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

        <!-- Pagination -->
        @if ($jobs->hasPages())
            <div class="panel mt-4">
                <div class="panel-body text-center">
                    {{ $jobs->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    @else
        <!-- No Jobs Found -->
        <div class="panel mx-auto" style="max-width: 500px;">
            <div class="panel-body text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                <h4 class="fw-bold mb-3" style="color: var(--primary-color);">{{ __('site.jobs_index.empty.title') }}</h4>
                <p class="text-muted mb-4">
                    {{ __('site.jobs_index.empty.description') }}
                </p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary" style="border-radius: 10px;">
                    <i class="fas fa-refresh me-2"></i>{{ __('site.jobs.buttons.view_all') }}
                </a>
            </div>
        </div>
    @endif

    <script>
        // Category/Subcategory filter
        document.getElementById('categorySelect').addEventListener('change', function() {
            const categoryId = this.value;
            const subcategorySelect = document.getElementById('subcategorySelect');

            // Clear subcategories
            const subcategoryPlaceholder = @json(__('site.jobs_index.filters.subcategory_all'));
            subcategorySelect.innerHTML = `<option value="">${subcategoryPlaceholder}</option>`;

            if (categoryId) {
                // Here you would typically fetch subcategories via AJAX
                // For now, we'll include them in the page data
                const categories = @json($categories);
                const selectedCategory = categories.find(cat => cat.id == categoryId);

                if (selectedCategory && selectedCategory.sub_categories) {
                    selectedCategory.sub_categories.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.display_name ?? sub.name;
                        option.selected = "{{ request('subcategory') }}" == sub.id;
                        subcategorySelect.appendChild(option);
                    });
                }
            }
        });

        // Trigger on page load if category is already selected
        if (document.getElementById('categorySelect').value) {
            document.getElementById('categorySelect').dispatchEvent(new Event('change'));
        }

        // Sort form submission
        document.querySelector('select[form="sortForm"]').addEventListener('change', function() {
            const form = document.getElementById('sortForm');
            form.querySelector('input[name="sort"]').value = this.value;
            form.submit();
        });
    </script>
</x-app-layout>
