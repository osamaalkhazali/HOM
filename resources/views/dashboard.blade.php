<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-tachometer-alt me-2"></i>{{ __('site.dashboard_user.header.title') }}</h1>
                <p class="subtitle mb-0">{{ __('site.dashboard_user.header.welcome', ['name' => Auth::user()->name]) }}</p>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-search me-1"></i>{{ __('site.dashboard_user.header.buttons.browse_jobs') }}
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm text-primary">
                        <i class="fas fa-user-edit me-1"></i>{{ __('site.dashboard_user.header.buttons.profile') }}
                    </a>
                </div>
            </div>
        </div>
    </x-slot>
    <section class="py-3 dashboard">
        <div class="container">

            <!-- Document Upload Warning -->
            @if ($hasPendingDocuments)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fas fa-exclamation-triangle mt-1"></i>
                        <div class="flex-grow-1">
                            <strong>{{ __('site.dashboard_user.alerts.pending_documents.title') }}</strong>
                            {{ __('site.dashboard_user.alerts.pending_documents.message') }}
                            <a href="{{ route('applications.index') }}" class="alert-link">{{ __('site.dashboard_user.alerts.pending_documents.action') }}</a>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Email Verification Alert (original) -->
            @if (!Auth::user()->email_verified_at)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>{{ __('site.dashboard_user.alerts.verify_email.title') }}</strong> {{ __('site.dashboard_user.alerts.verify_email.message') }}
                    <a href="{{ route('verification.notice') }}" class="alert-link">{{ __('site.dashboard_user.alerts.verify_email.action') }}</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- CV Upload Warning (original) -->
            @if (!$hasCv)
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-file-upload me-2"></i>
                    <strong>{{ __('site.dashboard_user.alerts.upload_cv.title') }}</strong> {{ __('site.dashboard_user.alerts.upload_cv.message') }}
                    <a href="{{ route('profile.edit') }}" class="alert-link">{{ __('site.dashboard_user.alerts.upload_cv.action') }}</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Profile Overview -->
            <div class="panel mb-4 shadow-soft">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="fas fa-user-circle me-2"></i>{{ __('site.dashboard_user.profile.title') }}</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i>{{ __('site.dashboard_user.profile.edit_button') }}
                    </a>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <!-- Left Column: Basic Info -->
                        <div class="col-lg-4">
                            <div class="text-center border rounded p-3">
                                <!-- Profile Completion -->
                                @if(isset($profileCompletion))
                                    @php
                                        $percentage = $profileCompletion['percentage'];
                                        $isComplete = $percentage === 100;

                                        // Dynamic color based on percentage
                                        if ($percentage >= 80) {
                                            $progressColor = '#10b981'; // Green
                                            $textColor = 'text-success';
                                        } elseif ($percentage >= 60) {
                                            $progressColor = '#22c55e'; // Light green
                                            $textColor = 'text-success';
                                        } elseif ($percentage >= 40) {
                                            $progressColor = '#eab308'; // Yellow
                                            $textColor = 'text-warning';
                                        } elseif ($percentage >= 20) {
                                            $progressColor = '#f97316'; // Orange
                                            $textColor = 'text-warning';
                                        } else {
                                            $progressColor = '#ef4444'; // Red
                                            $textColor = 'text-danger';
                                        }
                                    @endphp
                                    @if($isComplete)
                                        <!-- 100% Complete Badge -->
                                        <div class="badge bg-success text-white mb-3" style="font-size: 0.875rem; padding: 8px 16px;">
                                            <i class="fas fa-check-circle me-1"></i>{{ __('site.profile_completion.profile') }} 100%
                                        </div>
                                    @else
                                        <!-- Progress Bar -->
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <small class="text-muted"><i class="fas fa-chart-line me-1"></i>{{ __('site.profile_completion.title') }}</small>
                                                <small class="fw-bold {{ $textColor }}">{{ $percentage }}%</small>
                                            </div>
                                            <div class="progress" style="height: 6px; background: #e5e7eb;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $percentage }}%; background-color: {{ $progressColor }}; transition: all 0.3s ease;"
                                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <div class="avatar-lg profile-avatar mb-2 mx-auto">
                                    <i class="fas fa-user fa-lg text-white"></i>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                <div class="text-muted small mb-2">{{ $user->email }}</div>
                                @if (!empty($user->phone))
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-phone me-1"></i>{{ $user->phone }}
                                    </div>
                                @endif
                                @if ($profile && !empty($profile->headline))
                                    <div class="badge bg-primary text-white mt-2">{{ $profile->headline }}</div>
                                @endif
                                @if($profile && !empty($profile->linkedin_url))
                                    <div class="mt-2">
                                        <a href="{{ $profile->linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-linkedin me-1"></i>LinkedIn
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right Column: Professional Details -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <!-- Location -->
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary me-2">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small text-muted">{{ __('site.dashboard_user.profile.location') }}</div>
                                                <div class="fw-semibold">{{ $profile->location ?? __('site.dashboard_user.profile.not_specified') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Position -->
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary me-2">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small text-muted">{{ __('site.dashboard_user.profile.current_position') }}</div>
                                                <div class="fw-semibold">{{ $profile->current_position ?? __('site.dashboard_user.profile.not_specified') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Experience -->
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary me-2">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small text-muted">{{ __('site.dashboard_user.profile.experience') }}</div>
                                                <div class="fw-semibold">{{ $profile->experience_years ?? __('site.dashboard_user.profile.not_specified') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Resume -->
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary me-2">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small text-muted">{{ __('site.dashboard_user.profile.resume') }}</div>
                                                <div class="fw-semibold">
                                                    @if($profile && !empty($profile->cv_path))
                                                        <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" class="text-success text-decoration-none">
                                                            <i class="fas fa-download me-1"></i>{{ __('site.dashboard_user.profile.resume_view') }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">{{ __('site.dashboard_user.profile.resume_missing') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skills -->
                                @if($profile && !empty($profile->skills))
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="text-primary me-2">
                                                    <i class="fas fa-tools"></i>
                                                </div>
                                                <div class="small text-muted">{{ __('site.dashboard_user.profile.skills') }}</div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $skills = array_filter(array_map('trim', explode(',', $profile->skills)));
                                                @endphp
                                                @foreach($skills as $skill)
                                                    <span class="badge bg-light text-primary border border-primary">{{ $skill }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Website -->
                                @if($profile && !empty($profile->website))
                                    <div class="col-12">
                                        <a href="{{ $profile->website }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-globe me-1"></i>{{ __('site.dashboard_user.profile.website') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Recent Applications -->
                <div class="col-lg-8">
                    <div class="panel shadow-soft">
                        <div class="panel-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="panel-title mb-0"><i class="fas fa-clock me-2"></i>{{ __('site.dashboard_user.applications.title') }}</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                             <i class="fas fa-filter me-1"></i>{{ __('site.dashboard_user.applications.filter') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('applications.index') }}">{{ __('site.dashboard_user.applications.filters.all') }}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'pending']) }}">{{ __('site.dashboard_user.applications.filters.pending') }}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'reviewed']) }}">{{ __('site.dashboard_user.applications.filters.reviewed') }}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'accepted']) }}">{{ __('site.dashboard_user.applications.filters.accepted') }}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('applications.index', ['status' => 'rejected']) }}">{{ __('site.dashboard_user.applications.filters.rejected') }}</a></li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('applications.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-arrow-right me-1"></i>{{ __('site.dashboard_user.applications.view_all') }}
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
                                                    @if($application->job && !$application->job->deleted_at)
                                                        @if($application->job->status === 'draft')
                                                            <h6 class="fw-semibold mb-0 text-muted">{{ $application->job->title }}
                                                                <span class="badge bg-secondary ms-2 small">
                                                                    <i class="fas fa-ban me-1"></i>{{ __('site.dashboard_user.applications.job_unavailable') }}
                                                                </span>
                                                            </h6>
                                                        @else
                                                            <h6 class="fw-semibold mb-0">{{ $application->job->title }}</h6>
                                                        @endif
                                                    @else
                                                        <h6 class="fw-semibold mb-0 text-muted">
                                                            @if($application->job)
                                                                {{ $application->job->title }}
                                                            @else
                                                                {{ __('site.dashboard_user.applications.deleted_job') }}
                                                            @endif
                                                            <span class="badge bg-danger ms-2 small">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>{{ __('site.dashboard_user.applications.job_removed_badge') }}
                                                            </span>
                                                        </h6>
                                                    @endif
                                                    @php
                                                        $statusKey = 'site.dashboard_user.statuses.' . $application->status;
                                                        $statusLabel = __($statusKey);
                                                        if ($statusLabel === $statusKey) {
                                                            $statusLabel = ucfirst($application->status);
                                                        }
                                                    @endphp
                                                    <span class="status status-{{ $application->status }}">
                                                        @if ($application->status === 'pending')
                                                            <i class="fas fa-clock me-1"></i>{{ __('site.dashboard_user.statuses.pending') }}
                                                        @elseif($application->status === 'under_reviewing')
                                                            <i class="fas fa-search me-1"></i>{{ __('site.dashboard_user.statuses.under_reviewing') }}
                                                        @elseif($application->status === 'reviewed')
                                                            <i class="fas fa-eye me-1"></i>{{ __('site.dashboard_user.statuses.reviewed') }}
                                                        @elseif($application->status === 'shortlisted')
                                                            <i class="fas fa-star me-1"></i>{{ __('site.dashboard_user.statuses.shortlisted') }}
                                                        @elseif($application->status === 'documents_requested')
                                                            <i class="fas fa-file-upload me-1"></i>{{ __('site.dashboard_user.statuses.documents_requested') }}
                                                        @elseif($application->status === 'documents_submitted')
                                                            <i class="fas fa-file-check me-1"></i>{{ __('site.dashboard_user.statuses.documents_submitted') }}
                                                        @elseif($application->status === 'rejected')
                                                            <i class="fas fa-times me-1"></i>{{ __('site.dashboard_user.statuses.rejected') }}
                                                        @elseif($application->status === 'hired')
                                                            <i class="fas fa-trophy me-1"></i>{{ __('site.dashboard_user.statuses.hired') }}
                                                        @else
                                                            {{ $statusLabel }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center text-muted small mb-1">
                                                    @if($application->job && !$application->job->deleted_at)
                                                        <i class="fas fa-building me-1"></i>{{ $application->job->company }}
                                                    @else
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ __('site.dashboard_user.applications.job_unavailable') }}
                                                        @if($application->job)
                                                            - {{ $application->job->company }}
                                                        @endif
                                                    @endif
                                                </div>
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="fas fa-calendar me-1"></i>{{ __('site.dashboard_user.applications.applied') }}
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
                                                        @if($application->job && !$application->job->deleted_at)
                                                            @if($application->job->status === 'draft')
                                                                <li><span class="dropdown-item text-muted">
                                                                        <i class="fas fa-ban me-2"></i>{{ __('site.dashboard_user.applications.job_unavailable') }}
                                                                    </span></li>
                                                            @else
                                                                 <li><a class="dropdown-item"
                                                                         href="{{ route('jobs.show', $application->job) }}">
                                                                         <i class="fas fa-eye me-2"></i>{{ __('site.dashboard_user.applications.view_job') }}
                                                                    </a></li>
                                                            @endif
                                                        @else
                                                             <li><span class="dropdown-item text-muted">
                                                                     <i class="fas fa-ban me-2"></i>{{ __('site.dashboard_user.applications.job_unavailable') }}
                                                                 </span></li>
                                                        @endif
                                                        @if ($application->cv_path)
                                                             <li><a class="dropdown-item"
                                                                     href="{{ Storage::url($application->cv_path) }}"
                                                                     target="_blank">
                                                                     <i class="fas fa-download me-2"></i>{{ __('site.dashboard_user.applications.download_cv') }}
                                                                 </a></li>
                                                        @endif
                                                        @if ($application->status === 'documents_requested' && $application->documentRequests->count() > 0)
                                                             <li><hr class="dropdown-divider"></li>
                                                             <li><a class="dropdown-item text-warning"
                                                                     href="{{ route('applications.index') }}">
                                                                     <i class="fas fa-file-upload me-2"></i>{{ __('site.dashboard_user.applications.show_requested_documents') }}
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
                                <h6 class="text-muted mb-3">{{ __('site.dashboard_user.applications.no_applications_title') }}</h6>
                                <p class="text-muted mb-4">{{ __('site.dashboard_user.applications.no_applications_message') }}</p>
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>{{ __('site.dashboard_user.header.buttons.browse_jobs') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Status Summary (from stats) -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-chart-pie me-2"></i>{{ __('site.dashboard_user.metrics.title') }}</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-layer-group"></i></div>
                                        <small class="d-block text-muted">{{ __('site.dashboard_user.metrics.total') }}</small>
                                        <div class="fw-bold">{{ $stats['total'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-clock"></i></div>
                                        <small class="d-block text-muted">{{ __('site.dashboard_user.metrics.pending') }}</small>
                                        <div class="fw-bold">{{ $stats['pending'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-check"></i></div>
                                        <small class="d-block text-muted">{{ __('site.dashboard_user.metrics.accepted') }}</small>
                                        <div class="fw-bold">{{ $stats['accepted'] }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="quick-action">
                                        <div class="quick-icon"><i class="fas fa-eye"></i></div>
                                        <small class="d-block text-muted">{{ __('site.dashboard_user.metrics.reviewed') }}</small>
                                        <div class="fw-bold">{{ $stats['reviewed'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-bolt me-2"></i>{{ __('site.dashboard_user.quick_actions.title') }}</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('jobs.index') }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <small class="fw-semibold">{{ __('site.dashboard_user.quick_actions.browse_jobs') }}</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('profile.edit') }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-user-edit"></i>
                                        </div>
                                        <small class="fw-semibold">{{ __('site.dashboard_user.quick_actions.edit_profile') }}</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('applications.index') }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <small class="fw-semibold">{{ __('site.dashboard_user.quick_actions.applications') }}</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('jobs.index', ['sort' => 'newest']) }}" class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <small class="fw-semibold">{{ __('site.dashboard_user.quick_actions.latest_jobs') }}</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checklist -->
                    <div class="panel">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-list-check me-2"></i>{{ __('site.dashboard_user.checklist.title') }}</h5>
                        </div>
                        <div class="panel-body">
                            <div class="d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center">
                                    @if (Auth::user()->email_verified_at)
                                        <span class="me-2 text-success"><i class="fas fa-check-circle"></i></span>
                                        <span>{{ __('site.dashboard_user.checklist.email_verified') }}</span>
                                    @else
                                        <span class="me-2 text-warning"><i class="fas fa-exclamation-circle"></i></span>
                                        <span>{{ __('site.dashboard_user.checklist.verify_email') }}</span>
                                    @endif
                                </div>
                                @unless (Auth::user()->email_verified_at)
                                    <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-outline-primary">{{ __('site.dashboard_user.checklist.verify_action') }}</a>
                                @endunless
                            </div>
                            <div class="d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center">
                                    @if ($hasCv)
                                        <span class="me-2 text-success"><i class="fas fa-check-circle"></i></span>
                                        <span>{{ __('site.dashboard_user.checklist.cv_uploaded') }}</span>
                                    @else
                                        <span class="me-2 text-info"><i class="fas fa-info-circle"></i></span>
                                        <span>{{ __('site.dashboard_user.checklist.upload_cv') }}</span>
                                    @endif
                                </div>
                                @unless ($hasCv)
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">{{ __('site.dashboard_user.checklist.upload_action') }}</a>
                                @endunless
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
