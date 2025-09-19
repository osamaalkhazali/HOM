<x-app-layout>
    <x-slot name="header">
        <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-briefcase me-3"></i>Jobs
        </h1>
    </x-slot>

    <style>
        .job-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .job-card.expired {
            opacity: 0.7;
            background: rgba(248, 249, 250, 0.9);
        }

        .job-card.expired .job-header {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }

        .job-card.expired:hover {
            transform: translateY(-2px);
            opacity: 0.85;
        }

        .job-header {
            background: var(--gradient-1);
            color: white;
            padding: 1.5rem;
            margin: -1px -1px 0 -1px;
        }

        .job-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            margin: 0.25rem 0.25rem 0.25rem 0;
        }

        .filter-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-control,
        .form-select {
            border-radius: 15px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(24, 69, 143, 0.25);
        }

        .salary-badge {
            background: var(--gradient-4);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            border-radius: 10px;
            margin: 0 0.25rem;
            border: none;
            background: rgba(255, 255, 255, 0.8);
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--gradient-1);
            border: none;
        }
    </style>

    <!-- Filters Section -->
    <div class="filter-card" data-aos="fade-up">
        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-search me-1"></i>Search Jobs
                    </label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Job title, company, keywords...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-tags me-1"></i>Category
                    </label>
                    <select class="form-select" name="category" id="categorySelect">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-layer-group me-1"></i>Subcategory
                    </label>
                    <select class="form-select" name="subcategory" id="subcategorySelect">
                        <option value="">All Subcategories</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-map-marker-alt me-1"></i>Location
                    </label>
                    <input type="text" class="form-control" name="location" value="{{ request('location') }}"
                        placeholder="City, State, Country">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-level-up-alt me-1"></i>Level
                    </label>
                    <select class="form-select" name="level">
                        <option value="">All Levels</option>
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
                    <button type="submit" class="btn morph-btn fw-semibold text-white w-100"
                        style="background: var(--gradient-1); border: none; border-radius: 15px; padding: 0.75rem;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--primary-color);">
                {{ $jobs->total() }} Jobs Found
            </h4>
            <p class="text-muted mb-0">
                @if (request()->hasAny(['search', 'category', 'subcategory', 'location', 'level']))
                    Filtered results
                @else
                    Showing all available positions
                @endif
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <label class="form-label mb-0 fw-medium">Sort by:</label>
            <select class="form-select" style="width: auto;" onchange="this.form.submit()" form="sortForm">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Job Title</option>
                <option value="company" {{ request('sort') == 'company' ? 'selected' : '' }}>Company</option>
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
                    <div class="job-card h-100 {{ $job->isExpired() ? 'expired' : '' }}">
                        <div class="job-header">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">{{ $job->title }}</h5>
                                @if ($job->salary && $job->salary > 0)
                                    <span class="salary-badge">${{ number_format($job->salary, 0) }}</span>
                                @else
                                    <span class="salary-badge">Negotiable</span>
                                @endif
                            </div>
                            <p class="mb-2 opacity-90">
                                <i class="fas fa-building me-1"></i>{{ $job->company }}
                            </p>
                            <div class="d-flex flex-wrap gap-1">
                                @if ($job->subCategory && $job->subCategory->category)
                                    <span class="job-badge">
                                        <i class="fas fa-folder me-1"></i>{{ $job->subCategory->category->name }}
                                    </span>
                                @endif
                                @if ($job->subCategory)
                                    <span class="job-badge">
                                        <i class="fas fa-tag me-1"></i>{{ $job->subCategory->name }}
                                    </span>
                                @endif
                                @if ($job->location)
                                    <span class="job-badge">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                    </span>
                                @endif
                                @if ($job->level)
                                    <span class="job-badge">
                                        <i class="fas fa-level-up-alt me-1"></i>{{ $job->level }}
                                    </span>
                                @endif
                                @if ($job->isExpired())
                                    <span class="job-badge" style="background: rgba(220, 53, 69, 0.8);">
                                        <i class="fas fa-calendar-times me-1"></i>Expired
                                    </span>
                                @else
                                    @php
                                        $daysLeft = \Carbon\Carbon::parse($job->deadline)->diffInDays(now(), false);
                                        $isUrgent = $daysLeft <= 3 && $daysLeft >= 0;
                                    @endphp
                                    @if ($isUrgent)
                                        <span class="job-badge" style="background: rgba(255, 193, 7, 0.8);">
                                            <i class="fas fa-clock me-1"></i>{{ $daysLeft }} days left
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="p-3">
                            <p class="text-muted mb-3">
                                {{ Str::limit($job->description, 120) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Posted {{ $job->created_at->diffForHumans() }}
                                </small>
                                @if ($job->isExpired())
                                    <a href="{{ route('jobs.show', $job) }}"
                                        class="btn btn-secondary btn-sm morph-btn">
                                        <i class="fas fa-eye me-1"></i>View (Expired)
                                    </a>
                                @else
                                    <a href="{{ route('jobs.show', $job) }}"
                                        class="btn btn-primary btn-sm morph-btn">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    @else
        <!-- No Jobs Found -->
        <div class="text-center py-5" data-aos="fade-up">
            <div class="glass-card p-5 mx-auto" style="max-width: 500px;">
                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                <h4 class="fw-bold mb-3" style="color: var(--primary-color);">No Jobs Found</h4>
                <p class="text-muted mb-4">
                    We couldn't find any jobs matching your criteria. Try adjusting your filters or search terms.
                </p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary morph-btn">
                    <i class="fas fa-refresh me-2"></i>View All Jobs
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
            subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';

            if (categoryId) {
                // Here you would typically fetch subcategories via AJAX
                // For now, we'll include them in the page data
                const categories = @json($categories);
                const selectedCategory = categories.find(cat => cat.id == categoryId);

                if (selectedCategory && selectedCategory.sub_categories) {
                    selectedCategory.sub_categories.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name;
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
