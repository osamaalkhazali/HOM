<x-app-layout>
    @include('layouts.styles')

    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-briefcase me-2"></i>Job Details</h1>
                <p class="subtitle mb-0">{{ $job->title }} at {{ $job->company }}</p>
            </div>
            <div class="actions d-flex gap-2">
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back to Jobs
                </a>
            </div>
        </div>
    </x-slot>

    <section class="py-3 dashboard">
        <div class="container">

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Job Header Panel -->
            <div class="panel mb-4 shadow-soft">
                <div class="panel-header" style="background: var(--primary-color); color: white; padding: 1.5rem;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-3">{{ $job->title }}</h2>
                            <p class="mb-3 opacity-90 fs-5">
                                <i class="fas fa-building me-2"></i>{{ $job->company }}
                                @if ($job->location)
                                    <span class="ms-4">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                    </span>
                                @endif
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($job->subCategory && $job->subCategory->category)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-folder me-1"></i>{{ $job->subCategory->category->name }}
                                    </span>
                                @endif
                                @if ($job->subCategory)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-tag me-1"></i>{{ $job->subCategory->name }}
                                    </span>
                                @endif
                                @if ($job->level)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-level-up-alt me-1"></i>{{ $job->level }}
                                    </span>
                                @endif
                                @if ($job->type)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-briefcase me-1"></i>{{ $job->type }}
                                    </span>
                                @endif
                                @if ($job->isExpired())
                                    <span class="badge bg-danger" style="border-radius: 10px;">
                                        <i class="fas fa-calendar-times me-1"></i>Expired
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-4 mt-md-0">
                            @if ($job->salary_min && $job->salary_min > 0 && ($job->salary_max && $job->salary_max > 0))
                                <div class="fs-3 fw-bold mb-1">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</div>
                                <div class="opacity-75 mb-3">Per year</div>
                            @elseif ($job->salary && $job->salary > 0)
                                <div class="fs-3 fw-bold mb-1">${{ number_format($job->salary) }}</div>
                                <div class="opacity-75 mb-3">Per year</div>
                            @else
                                <div class="fs-3 fw-bold mb-1">Negotiable</div>
                                <div class="opacity-75 mb-3">Salary</div>
                            @endif

                            @if ($job->deadline)
                                <div>
                                    <div class="opacity-75">Apply by:</div>
                                    <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Job Description -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0">
                                <i class="fas fa-file-alt me-2"></i>Job Description
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="job-description" style="line-height: 1.7; font-size: 15px;">
                                {!! nl2br(e($job->description)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Requirements & Benefits -->
                    <div class="row g-4 mb-4">
                        @if ($job->requirements)
                            <div class="col-md-6">
                                <div class="panel h-100 shadow-soft">
                                    <div class="panel-header">
                                        <h5 class="panel-title mb-0">
                                            <i class="fas fa-list-check me-2"></i>Requirements
                                        </h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="requirements" style="line-height: 1.6;">
                                            {!! nl2br(e($job->requirements)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($job->benefits)
                            <div class="col-md-6">
                                <div class="panel h-100 shadow-soft">
                                    <div class="panel-header">
                                        <h5 class="panel-title mb-0">
                                            <i class="fas fa-gift me-2"></i>Benefits
                                        </h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="benefits" style="line-height: 1.6;">
                                            {!! nl2br(e($job->benefits)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Job Details -->
                    <div class="panel shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Job Information
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <small class="d-block text-muted mb-1">Company</small>
                                        <div class="fw-bold">{{ $job->company }}</div>
                                    </div>
                                </div>

                                @if ($job->location)
                                    <div class="col-sm-6">
                                        <div class="quick-action">
                                            <div class="quick-icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <small class="d-block text-muted mb-1">Location</small>
                                            <div class="fw-bold">{{ $job->location }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if ($job->type)
                                    <div class="col-sm-6">
                                        <div class="quick-action">
                                            <div class="quick-icon">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <small class="d-block text-muted mb-1">Job Type</small>
                                            <div class="fw-bold">{{ $job->type }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if ($job->schedule)
                                    <div class="col-sm-6">
                                        <div class="quick-action">
                                            <div class="quick-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <small class="d-block text-muted mb-1">Schedule</small>
                                            <div class="fw-bold">{{ $job->schedule }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if ($job->level)
                                    <div class="col-sm-6">
                                        <div class="quick-action">
                                            <div class="quick-icon">
                                                <i class="fas fa-level-up-alt"></i>
                                            </div>
                                            <small class="d-block text-muted mb-1">Experience</small>
                                            <div class="fw-bold">{{ $job->level }}</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-6">
                                    <div class="quick-action">
                                        <div class="quick-icon">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                        <small class="d-block text-muted mb-1">Posted</small>
                                        <div class="fw-bold">{{ $job->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 90px;">
                    <!-- Apply Section -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0">
                                <i class="fas fa-paper-plane me-2"></i>Application
                            </h5>
                        </div>
                        <div class="panel-body text-center py-4">
                            @auth
                                @if ($job->isExpired())
                                    <div class="alert alert-danger mb-3" role="alert">
                                        <i class="fas fa-calendar-times me-2"></i>Application deadline has passed
                                    </div>
                                    <button class="btn btn-secondary btn-lg w-100" disabled>
                                        <i class="fas fa-times me-2"></i>Applications Closed
                                    </button>
                                @elseif ($job->isInactive())
                                    <div class="alert alert-warning mb-3" role="alert">
                                        <i class="fas fa-pause-circle me-2"></i>This job is no longer accepting applications.
                                    </div>
                                    <button class="btn btn-warning btn-lg w-100" disabled>
                                        <i class="fas fa-pause me-2"></i>Not Accepting Applications
                                    </button>
                                @elseif ($hasApplied)
                                    <div class="alert alert-success mb-3" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>You have already applied for this position
                                    </div>
                                    <button class="btn btn-success btn-lg w-100" disabled>
                                        <i class="fas fa-check me-2"></i>Application Submitted
                                    </button>
                                @elseif (!$hasCv)
                                    <div class="alert alert-warning mb-3" role="alert">
                                        <i class="fas fa-upload me-2"></i>Please upload your CV to your profile to apply
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-lg w-100">
                                        <i class="fas fa-upload me-2"></i>Upload CV First
                                    </a>
                                @else
                                    <a href="{{ route('jobs.apply', $job) }}" class="btn btn-success btn-lg w-100 pulse-btn">
                                        <i class="fas fa-paper-plane me-2"></i>Apply for this Job
                                    </a>
                                @endif
                            @else
                                <h5 class="mb-3 text-primary">Ready to Apply?</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="panel-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="quick-action w-100" onclick="shareJob('linkedin')">
                                        <div class="quick-icon">
                                            <i class="fab fa-linkedin"></i>
                                        </div>
                                        <small class="fw-semibold">Share on LinkedIn</small>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="quick-action w-100" onclick="copyJobLink()">
                                        <div class="quick-icon">
                                            <i class="fas fa-link"></i>
                                        </div>
                                        <small class="fw-semibold">Copy Link</small>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="quick-action w-100" onclick="shareJob('facebook')">
                                        <div class="quick-icon">
                                            <i class="fab fa-facebook"></i>
                                        </div>
                                        <small class="fw-semibold">Facebook</small>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="quick-action w-100" onclick="shareJob('twitter')">
                                        <div class="quick-icon">
                                            <i class="fab fa-twitter"></i>
                                        </div>
                                        <small class="fw-semibold">Twitter</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div class="panel mb-4 shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0">
                                <i class="fas fa-building me-2"></i>About Company
                            </h5>
                        </div>
                        <div class="panel-body text-center py-4">
                            <div class="avatar-lg mb-3" style="background: var(--primary-color);">
                                <i class="fas fa-building fa-2x text-white"></i>
                            </div>
                            <h4 class="fw-bold mb-2">{{ $job->company }}</h4>
                            @if ($job->location)
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Related Jobs -->
                    @if (isset($relatedJobs) && $relatedJobs->count() > 0)
                        <div class="panel shadow-soft">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0">
                                    <i class="fas fa-lightbulb me-2"></i>Similar Jobs
                                </h5>
                            </div>
                            <div class="panel-body p-0">
                                @foreach ($relatedJobs->take(3) as $relatedJob)
                                    <div class="list-item">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px; background: var(--primary-color); color: white; border-radius: 10px;">
                                                    <i class="fas fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="{{ route('jobs.show', $relatedJob) }}" class="text-decoration-none">
                                                    <div class="fw-bold text-primary">{{ Str::limit($relatedJob->title, 35) }}</div>
                                                    <div class="text-muted small">
                                                        <i class="fas fa-building me-1"></i>{{ Str::limit($relatedJob->company, 25) }}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function shareJob(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $job->title }} - {{ $job->company }}');

            let shareUrl = '';
            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }

        function copyJobLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                const btn = event.target.closest('button');
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<div class="quick-icon"><i class="fas fa-check"></i></div><small class="fw-semibold">Copied!</small>';
                btn.classList.add('text-success');

                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.remove('text-success');
                }, 2000);
            });
        }
    </script>
</x-app-layout>
