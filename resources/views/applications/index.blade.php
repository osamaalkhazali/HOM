<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-paper-plane me-3"></i>My Applications
                </h1>
                <p class="lead mb-0 opacity-90">
                    Track and manage all your job applications in one place.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="{{ route('jobs.index') }}" class="btn btn-success btn-lg morph-btn fw-semibold px-4 py-3">
                    <i class="fas fa-search me-2"></i>Browse More Jobs
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        .application-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .application-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .application-header {
            background: var(--gradient-1);
            color: white;
            padding: 1.5rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.9);
            color: #856404;
        }

        .status-accepted {
            background: rgba(40, 167, 69, 0.9);
            color: #155724;
        }

        .status-rejected {
            background: rgba(220, 53, 69, 0.9);
            color: #721c24;
        }

        .status-reviewed {
            background: rgba(23, 162, 184, 0.9);
            color: #0c5460;
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

        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
            height: 100%;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
    </style>

    <!-- Statistics Overview -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card">
                <div class="stats-icon" style="background: var(--gradient-1);">
                    <i class="fas fa-paper-plane text-white"></i>
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--primary-color);">
                    {{ $applications->total() }}
                </h3>
                <p class="text-muted mb-0">Total Applications</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card">
                <div class="stats-icon" style="background: var(--gradient-2);">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--primary-color);">
                    {{ $applications->where('status', 'pending')->count() }}
                </h3>
                <p class="text-muted mb-0">Pending Review</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card">
                <div class="stats-icon" style="background: var(--gradient-3);">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--primary-color);">
                    {{ $applications->where('status', 'accepted')->count() }}
                </h3>
                <p class="text-muted mb-0">Accepted</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="stats-card">
                <div class="stats-icon" style="background: var(--gradient-4);">
                    <i class="fas fa-calendar-check text-white"></i>
                </div>
                <h3 class="fw-bold mb-2" style="color: var(--primary-color);">
                    {{ $applications->where('created_at', '>=', now()->startOfMonth())->count() }}
                </h3>
                <p class="text-muted mb-0">This Month</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card" data-aos="fade-up">
        <form method="GET" action="{{ route('applications.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-search me-1"></i>Search Applications
                    </label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Job title, company...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-filter me-1"></i>Status
                    </label>
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed
                        </option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-sort me-1"></i>Sort By
                    </label>
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First
                        </option>
                        <option value="job_title" {{ request('sort') == 'job_title' ? 'selected' : '' }}>Job Title
                        </option>
                        <option value="company" {{ request('sort') == 'company' ? 'selected' : '' }}>Company</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 morph-btn fw-semibold">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Applications List -->
    @if ($applications->count() > 0)
        <div class="row g-4">
            @foreach ($applications as $application)
                <div class="col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="application-card">
                        <div class="application-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="fw-bold mb-2">{{ $application->job->title }}</h5>
                                    <p class="mb-1 opacity-90">
                                        <i class="fas fa-building me-2"></i>{{ $application->job->company }}
                                    </p>
                                    <p class="mb-0 opacity-75">
                                        <i class="fas fa-map-marker-alt me-2"></i>{{ $application->job->location }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-end text-center mt-3 mt-md-0">
                                    <span class="status-badge status-{{ $application->status }}">
                                        @if ($application->status === 'pending')
                                            <i class="fas fa-clock me-1"></i>Pending Review
                                        @elseif($application->status === 'reviewed')
                                            <i class="fas fa-eye me-1"></i>Under Review
                                        @elseif($application->status === 'accepted')
                                            <i class="fas fa-check me-1"></i>Accepted
                                        @elseif($application->status === 'rejected')
                                            <i class="fas fa-times me-1"></i>Rejected
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Application Details
                                    </h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Applied on:</small>
                                        <div class="fw-medium">
                                            {{ $application->created_at->format('F d, Y \a\t g:i A') }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Job Level:</small>
                                        <div class="fw-medium">{{ ucfirst($application->job->level) }}</div>
                                    </div>
                                    @if ($application->job->salary && $application->job->salary > 0)
                                        <div class="mb-2">
                                            <small class="text-muted">Salary:</small>
                                            <div class="fw-medium">${{ number_format($application->job->salary) }}
                                                annually</div>
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <small class="text-muted">Salary:</small>
                                            <div class="fw-medium">Negotiable</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Job Information</h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Category:</small>
                                        <div class="fw-medium">
                                            @if ($application->job->subCategory && $application->job->subCategory->category)
                                                {{ $application->job->subCategory->category->name }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Subcategory:</small>
                                        <div class="fw-medium">
                                            @if ($application->job->subCategory)
                                                {{ $application->job->subCategory->name }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Application Deadline:</small>
                                        <div
                                            class="fw-medium {{ $application->job->isExpired() ? 'text-danger' : '' }}">
                                            {{ \Carbon\Carbon::parse($application->job->deadline)->format('F d, Y') }}
                                            @if ($application->job->isExpired())
                                                <span class="badge bg-danger ms-1">Expired</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top pt-3 mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('jobs.show', $application->job) }}"
                                            class="btn btn-outline-primary btn-sm morph-btn">
                                            <i class="fas fa-eye me-1"></i>View Job
                                        </a>
                                        @if ($application->cv_path)
                                            <a href="{{ Storage::url($application->cv_path) }}" target="_blank"
                                                class="btn btn-outline-secondary btn-sm morph-btn">
                                                <i class="fas fa-download me-1"></i>Download CV
                                            </a>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        Application #{{ $application->id }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
            {{ $applications->appends(request()->query())->links() }}
        </div>
    @else
        <!-- No Applications Found -->
        <div class="text-center py-5" data-aos="fade-up">
            <div class="application-card p-5 mx-auto" style="max-width: 500px;">
                <i class="fas fa-inbox fa-4x text-muted mb-4"></i>
                <h4 class="fw-bold mb-3" style="color: var(--primary-color);">No Applications Found</h4>
                <p class="text-muted mb-4">
                    @if (request()->hasAny(['search', 'status', 'sort']))
                        No applications match your current filters. Try adjusting your search criteria.
                    @else
                        You haven't submitted any job applications yet. Start exploring opportunities!
                    @endif
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    @if (request()->hasAny(['search', 'status', 'sort']))
                        <a href="{{ route('applications.index') }}" class="btn btn-outline-primary morph-btn">
                            <i class="fas fa-refresh me-2"></i>Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary morph-btn">
                        <i class="fas fa-search me-2"></i>Browse Jobs
                    </a>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
