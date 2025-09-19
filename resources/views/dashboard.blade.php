<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: white;">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </h1>
                <p class="text-muted mb-0">Welcome back, <span class="fw-semibold">{{ Auth::user()->name }}</span>!</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-search me-1"></i>Browse Jobs
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-edit me-1"></i>Profile
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stat-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .dashboard-section {
            background: white;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .section-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            background: #fafbfc;
        }

        .application-item {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.2s ease;
        }

        .application-item:hover {
            background: #f8fafc;
        }

        .application-item:last-child {
            border-bottom: none;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-reviewed {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-accepted {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-shortlisted {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-hired {
            background: #dcfce7;
            color: #166534;
        }

        .quick-action {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .quick-action:hover {
            border-color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: inherit;
            text-decoration: none;
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            color: var(--primary-color);
        }

        .profile-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.25rem;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: var(--gradient-1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            background: #f8fafc;
            margin-bottom: 0.5rem;
        }

        .info-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--gradient-2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 0.75rem;
        }

        .compact-stat {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .compact-label {
            font-size: 0.75rem;
            opacity: 0.9;
            font-weight: 500;
        }
    </style>

    <section class="py-4">
        <div class="container">
            <!-- User Welcome & Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card stat-card-1">
                        <div class="stat-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="compact-stat">{{ $stats['total'] }}</div>
                        <div class="compact-label">Total Applications</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-card-2">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="compact-stat">{{ $stats['pending'] }}</div>
                        <div class="compact-label">Pending Reviews</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-card-3">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="compact-stat">{{ $stats['accepted'] }}</div>
                        <div class="compact-label">Accepted</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-card-4">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="compact-stat">{{ $stats['reviewed'] }}</div>
                        <div class="compact-label">Under Review</div>
                    </div>
                </div>
            </div>

            <!-- Email Verification Alert -->
            @if (!Auth::user()->email_verified_at)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Email Verification Required:</strong> Please verify your email to access all features.
                    <a href="{{ route('verification.notice') }}" class="alert-link">Verify Now</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- CV Upload Warning -->
            @if (!$hasCv)
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-file-upload me-2"></i>
                    <strong>Complete Your Profile:</strong> Upload your CV/Resume to increase your chances of getting
                    hired!
                    <a href="{{ route('profile.edit') }}" class="alert-link">Upload CV Now</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Recent Applications -->
                <div class="col-lg-8">
                    <div class="dashboard-section">
                        <div class="section-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-semibold mb-0" style="color: var(--primary-color);">
                                    <i class="fas fa-clock me-2"></i>Recent Applications
                                </h5>
                                <a href="{{ route('applications.index') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i>View All
                                </a>
                            </div>
                        </div>
                        <div>
                            @if ($recentApplications->count() > 0)
                                @foreach ($recentApplications as $application)
                                    <div class="application-item">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h6 class="fw-semibold mb-1">{{ $application->job->title }}</h6>
                                                <div class="d-flex align-items-center text-muted small mb-1">
                                                    <i
                                                        class="fas fa-building me-1"></i>{{ $application->job->company }}
                                                </div>
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="fas fa-calendar me-1"></i>Applied:
                                                    {{ $application->created_at->format('M d, Y') }}
                                                    <span
                                                        class="ms-2 text-primary">{{ $application->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <span class="status-badge status-{{ $application->status }}">
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
                                            <div class="col-md-3 text-end">
                                                <div class="dropdown">
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
                    <!-- Quick Actions -->
                    <div class="dashboard-section mb-4">
                        <div class="section-header">
                            <h5 class="fw-semibold mb-0" style="color: var(--primary-color);">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="p-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('jobs.index') }}" class="quick-action">
                                        <div class="action-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <small class="fw-semibold">Browse Jobs</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('profile.edit') }}" class="quick-action">
                                        <div class="action-icon">
                                            <i class="fas fa-user-edit"></i>
                                        </div>
                                        <small class="fw-semibold">Edit Profile</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('applications.index') }}" class="quick-action">
                                        <div class="action-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <small class="fw-semibold">My Applications</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('jobs.index', ['sort' => 'newest']) }}" class="quick-action">
                                        <div class="action-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <small class="fw-semibold">Latest Jobs</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Summary -->
                    <div class="profile-card">
                        <div class="text-center mb-3">
                            <div class="user-avatar">
                                <i class="fas fa-user fa-lg text-white"></i>
                            </div>
                            <h6 class="fw-semibold mb-1">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                    <div>
                                        <div class="small fw-semibold">Joined</div>
                                        <div class="small text-muted">{{ Auth::user()->created_at->format('M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-sign-in-alt text-white"></i>
                                    </div>
                                    <div>
                                        <div class="small fw-semibold">Last Login</div>
                                        <div class="small text-muted">{{ now()->format('M d') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (Auth::user()->email_verified_at)
                            <div class="text-center mt-3">
                                <span class="badge bg-success">
                                    <i class="fas fa-shield-check me-1"></i>Email Verified
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
