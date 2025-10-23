<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-paper-plane me-2"></i>My Applications</h1>
                <p class="subtitle mb-0">Track and manage all your job applications in one place.</p>
            </div>
            <div class="actions d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                <a href="{{ route('jobs.index') }}" class="btn btn-light btn-sm text-primary">
                    <i class="fas fa-search me-1"></i>Browse Jobs
                </a>
            </div>
        </div>
    </x-slot>

    <section class="py-3 dashboard">
        <div class="container">
            <!-- Statistics Overview -->
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-1 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->total() }}</div>
                        <div class="kpi-label">Total Applications</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-2 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->where('status', 'pending')->count() }}</div>
                        <div class="kpi-label">Pending Review</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-3 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->where('status', 'accepted')->count() }}</div>
                        <div class="kpi-label">Accepted</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-4 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                        <div class="kpi-label">This Month</div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="panel mb-4 shadow-soft">
                <div class="panel-header">
                    <h5 class="panel-title mb-0"><i class="fas fa-filter me-2"></i>Filter Applications</h5>
                </div>
                <div class="panel-body">
                    <form method="GET" action="{{ route('applications.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Search Applications</label>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                    placeholder="Job title, company...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small">Sort By</label>
                                <select class="form-select" name="sort">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                    <option value="job_title" {{ request('sort') == 'job_title' ? 'selected' : '' }}>Job Title</option>
                                    <option value="company" {{ request('sort') == 'company' ? 'selected' : '' }}>Company</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications List -->
            @if ($applications->count() > 0)
                <div class="row g-3">
                    @foreach ($applications as $application)
                        <div class="col-12">
                            <div class="panel shadow-soft">
                                <div class="panel-body">
                                    <div class="row align-items-center g-3">
                                        <div class="col-12 col-md-8">
                                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                                @if($application->job && !$application->job->deleted_at)
                                                    @if($application->job->status === 'draft')
                                                        <h6 class="fw-bold mb-0 text-muted">{{ $application->job->title }}
                                                            <span class="badge bg-secondary ms-2 small">
                                                                <i class="fas fa-ban me-1"></i>Job Unavailable
                                                            </span>
                                                        </h6>
                                                    @else
                                                        <h6 class="fw-bold mb-0">{{ $application->job->title }}</h6>
                                                    @endif
                                                @else
                                                    <h6 class="fw-bold mb-0 text-muted">
                                                        @if($application->job)
                                                            {{ $application->job->title }}
                                                        @else
                                                            Deleted Job
                                                        @endif
                                                        <span class="badge bg-danger ms-2 small">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>Job Removed
                                                        </span>
                                                    </h6>
                                                @endif
                                                <span class="status status-{{ $application->status }}">
                                                    @if ($application->status === 'pending')
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    @elseif($application->status === 'reviewed')
                                                        <i class="fas fa-eye me-1"></i>Reviewed
                                                    @elseif($application->status === 'accepted')
                                                        <i class="fas fa-check me-1"></i>Accepted
                                                    @elseif($application->status === 'rejected')
                                                        <i class="fas fa-times me-1"></i>Rejected
                                                    @elseif($application->status === 'shortlisted')
                                                        <i class="fas fa-star me-1"></i>Shortlisted
                                                    @elseif($application->status === 'hired')
                                                        <i class="fas fa-trophy me-1"></i>Hired
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="row g-3 text-muted small">
                                                @if($application->job && !$application->job->deleted_at)
                                                    @if($application->job->status === 'draft')
                                                        <div class="col-12">
                                                            <div class="alert alert-info mb-2 py-2">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                <strong>Job Unavailable:</strong> This listing is currently in draft by the employer and isn’t publicly available. Your application remains on file and will be reviewed once it’s published.
                                                            </div>
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-info-circle me-2"></i>Status:
                                                                <span class="badge bg-secondary ms-2 small">
                                                                    <i class="fas fa-ban me-1"></i>Job Unavailable
                                                                </span>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-building me-2"></i>{{ $application->job->company }}
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-calendar me-2"></i>Applied: {{ $application->created_at->format('M d, Y') }}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-6">
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-info-circle me-2"></i>Status:
                                                                @if($application->job->status === 'inactive' || $application->job->isExpired())
                                                                    <span class="badge bg-warning text-dark ms-2 small"><i class="fas fa-lock me-1"></i>Closed</span>
                                                                @elseif($application->job->status === 'active')
                                                                    <span class="badge bg-success ms-2 small"><i class="fas fa-check me-1"></i>Open</span>
                                                                @elseif($application->job->status === 'draft')
                                                                    <span class="badge bg-secondary ms-2 small"><i class="fas fa-ban me-1"></i>Job Unavailable</span>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-building me-2"></i>{{ $application->job->company }}
                                                            </div>
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-map-marker-alt me-2"></i>{{ $application->job->location }}
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-calendar me-2"></i>Applied: {{ $application->created_at->format('M d, Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-layer-group me-2"></i>{{ ucfirst($application->job->level) }}
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-clock me-2"></i>Deadline: {{ \Carbon\Carbon::parse($application->job->deadline)->format('M d, Y') }}
                                                                @if ($application->job->isExpired())
                                                                    <span class="badge bg-danger ms-1 small">Expired</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="col-12">
                                                        <div class="alert alert-warning mb-2 py-2">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Job No Longer Available:</strong> This position has been removed by the employer.
                                                            Your application status will remain visible for your records.
                                                        </div>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <i class="fas fa-info-circle me-2"></i>Status:
                                                            <span class="badge bg-danger ms-2 small">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>Job Removed
                                                            </span>
                                                        </div>
                                                        @if($application->job)
                                                            <div class="d-flex align-items-center mb-1">
                                                                <i class="fas fa-building me-2"></i>{{ $application->job->company ?? 'Company information unavailable' }}
                                                            </div>
                                                        @endif
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-calendar me-2"></i>Applied: {{ $application->created_at->format('M d, Y') }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 text-end">
                                            <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                                @if($application->job && !$application->job->deleted_at)
                                                    @if($application->job->status === 'draft')
                                                        <span class="btn btn-sm btn-outline-secondary disabled">
                                                            <i class="fas fa-ban me-1"></i>Job Unavailable
                                                        </span>
                                                    @else
                                                        <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i>View Job
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="btn btn-sm btn-outline-secondary disabled">
                                                        <i class="fas fa-ban me-1"></i>Job Unavailable
                                                    </span>
                                                @endif
                                                @if ($application->cv_path)
                                                    <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-download me-1"></i>CV
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="text-muted small mt-2">
                                                #{{ $application->id }} • {{ $application->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($applications->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $applications->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- No Applications Found -->
                <div class="text-center py-5">
                    <div class="panel mx-auto" style="max-width: 500px;">
                        <div class="panel-body p-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-4"></i>
                            <h5 class="fw-bold mb-3">No Applications Found</h5>
                            <p class="text-muted mb-4">
                                @if (request()->hasAny(['search', 'status', 'sort']))
                                    No applications match your current filters. Try adjusting your search criteria.
                                @else
                                    You haven't submitted any job applications yet. Start exploring opportunities!
                                @endif
                            </p>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                @if (request()->hasAny(['search', 'status', 'sort']))
                                    <a href="{{ route('applications.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-refresh me-2"></i>Clear Filters
                                    </a>
                                @endif
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Browse Jobs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
