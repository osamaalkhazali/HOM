<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
                <p class="subtitle mb-0">Welcome back, <span class="fw-semibold">{{ Auth::user()->name }}</span>!</p>
            </div>
            <div class="actions d-flex gap-2">
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-search me-1"></i>Browse Jobs
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm text-primary">
                    <i class="fas fa-user-edit me-1"></i>Profile
                </a>
            </div>
        </div>
    </x-slot>
    <section class="py-3 dashboard">
        <div class="container">

            <!-- Email Verification Alert (original) -->
            @if (!Auth::user()->email_verified_at)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Email Verification Required:</strong> Please verify your email to access all features.
                    <a href="{{ route('verification.notice') }}" class="alert-link">Verify Now</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- CV Upload Warning (original) -->
            @if (!$hasCv)
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-file-upload me-2"></i>
                    <strong>Complete Your Profile:</strong> Upload your CV/Resume to increase your chances of getting hired!
                    <a href="{{ route('profile.edit') }}" class="alert-link">Upload CV Now</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Recent Applications -->
                <div class="col-lg-8">
                    <div class="panel shadow-soft">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="panel-title mb-0"><i class="fas fa-clock me-2"></i>Recent Applications</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-filter me-1"></i>Filter
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('applications.index') }}">All</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'pending']) }}">Pending</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'reviewed']) }}">Reviewed</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'accepted']) }}">Accepted</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'rejected']) }}">Rejected</a></li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('applications.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-arrow-right me-1"></i>View All
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body p-0">
                            @if ($recentApplications->count() > 0)
                                @foreach ($recentApplications as $application)
                                    <div class="list-item">
                                        <div class="row align-items-center g-2 g-md-0">
                                            <div class="col-12 col-md-9">
                                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                                    <h6 class="fw-semibold mb-0">{{ $application->job->title }}</h6>
                                                    <span class="status status-{{ $application->status }}">
                                                        @if ($application->status === 'pending')
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        @elseif($application->status === 'accepted')
                                                            <i class="fas fa-check me-1"></i>Accepted
                                                        @elseif($application->status === 'rejected')
                                                            <i class="fas fa-times me-1"></i>Rejected
                                                        @elseif($application->status === 'reviewed')
                                                            <i class="fas fa-eye me-1"></i>Reviewed
                                                        @elseif($application->status === 'shortlisted')
                                                            <i class="fas fa-star me-1"></i>Shortlisted
                                                        @elseif($application->status === 'hired')
                                                            <i class="fas fa-trophy me-1"></i>Hired
                                                        @else
                                                            {{ ucfirst($application->status) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center text-muted small mb-1">
                                                    <i class="fas fa-building me-1"></i>{{ $application->job->company }}
                                                </div>
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="fas fa-calendar me-1"></i>Applied:
                                                    {{ $application->created_at->format('M d, Y') }}
                                                    <span class="ms-2 text-primary">{{ $application->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3 text-end">
                                                <div class="dropdown item-actions">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('jobs.show', $application->job) }}">
                                                                <i class="fas fa-eye me-2"></i>View Job
                                                            </a></li>
                                                        @if ($application->cv_path)
                                                            <li><a class="dropdown-item"
                                                                    href="{{ Storage::url($application->cv_path) }}"
                                                                    target="_blank">
                                                                    <i class="fas fa-download me-2"></i>Download CV
                                                                </a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted mb-3">No Applications Yet</h6>
                                    <p class="text-muted mb-4">Start exploring job opportunities!</p>
                                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Browse Jobs
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Profile Summary (moved to top) -->
                    <div class="panel mb-4 profile-card shadow-soft">
                        <div class="panel-body">
                            @if (Auth::user()->email_verified_at)
                                <span class="badge bg-success verified-badge"><i class="fas fa-shield-check me-1"></i>Verified</span>
                            @endif
                            <div class="text-center mb-3">
                                <div class="avatar-lg profile-avatar mb-2">
                                    <i class="fas fa-user fa-lg text-white"></i>
                                </div>
                                <h5 class="fw-bold mb-0">{{ Auth::user()->name }}</h5>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="row g-0 text-center meta">
                                <div class="col-6 py-2">
                                    <div class="label">Joined</div>
                                    <div class="value">{{ Auth::user()->created_at->format('M Y') }}</div>
                                </div>
                                <div class="col-6 py-2 border-start">
                                    <div class="label">Last Login</div>
                                    <div class="value">{{ now()->format('M d') }}</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ route('applications.index') }}" class="btn btn-sm btn-outline-primary">My Applications</a>
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>

                    <!-- Status Summary (from stats) -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-chart-pie me-2"></i>Status Summary</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-layer-group"></i></div>
                                        <small class="d-block text-muted">Total</small>
                                        <div class="fw-bold">{{ $stats['total'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-clock"></i></div>
                                        <small class="d-block text-muted">Pending</small>
                                        <div class="fw-bold">{{ $stats['pending'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-check"></i></div>
                                        <small class="d-block text-muted">Accepted</small>
                                        <div class="fw-bold">{{ $stats['accepted'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-eye"></i></div>
                                        <small class="d-block text-muted">Reviewed</small>
                                        <div class="fw-bold">{{ $stats['reviewed'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('jobs.index') }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <small class="fw-semibold">Browse Jobs</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('profile.edit') }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-user-edit"></i>
                                        </div>
                                        <small class="fw-semibold">Edit Profile</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('applications.index') }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <small class="fw-semibold">My Applications</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('jobs.index', ['sort' => 'newest']) }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <small class="fw-semibold">Latest Jobs</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checklist -->
                    <div class="panel">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-list-check me-2"></i>Checklist</h5>
                        </div>
                        <div class="panel-body">
                            <div class="d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center">
                                    @if (Auth::user()->email_verified_at)
                                        <span class="me-2 text-success"><i class="fas fa-check-circle"></i></span>
                                        <span>Email verified</span>
                                    @else
                                        <span class="me-2 text-warning"><i class="fas fa-exclamation-circle"></i></span>
                                        <span>Verify your email</span>
                                    @endif
                                </div>
                                @unless (Auth::user()->email_verified_at)
                                    <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-outline-primary">Verify</a>
                                @endunless
                            </div>
                            <div class="d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center">
                                    @if ($hasCv)
                                        <span class="me-2 text-success"><i class="fas fa-check-circle"></i></span>
                                        <span>CV uploaded</span>
                                    @else
                                        <span class="me-2 text-info"><i class="fas fa-info-circle"></i></span>
                                        <span>Upload your CV/Resume</span>
                                    @endif
                                </div>
                                @unless ($hasCv)
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">Upload</a>
                                @endunless
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
