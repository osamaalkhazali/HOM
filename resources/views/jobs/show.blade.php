<x-app-layout>
    <x-slot name="header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-white text-decoration-none">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('jobs.index') }}" class="text-white text-decoration-none">Jobs</a>
                        </li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $job->title }}</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold mb-3">{{ $job->title }}</h1>
                <p class="lead mb-4 opacity-90">{{ Str::limit($job->description, 150) }}</p>
                <div class="d-flex flex-wrap gap-2">
                    @if ($job->subCategory && $job->subCategory->category)
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-folder me-1"></i>{{ $job->subCategory->category->name }}
                        </span>
                    @endif
                    @if ($job->subCategory)
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-tag me-1"></i>{{ $job->subCategory->name }}
                        </span>
                    @endif
                    @if ($job->location)
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                        </span>
                    @endif
                    @if ($job->level)
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-level-up-alt me-1"></i>{{ $job->level }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                @auth
                    @if ($job->isExpired())
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-calendar-times me-2"></i>This job application deadline has passed
                        </div>
                        <p class="text-white opacity-75">Application deadline:
                            {{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}</p>
                    @elseif ($hasApplied)
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>You have already applied for this job
                        </div>
                    @elseif (!$hasCv)
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-upload me-2"></i>
                            <strong>CV Required:</strong> Upload your CV to your profile to apply for jobs
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="btn btn-warning btn-lg morph-btn fw-semibold px-5 py-3 mb-2">
                            <i class="fas fa-upload me-2"></i>Upload CV First
                        </a>
                        <p class="text-white opacity-75 small">Complete your profile to apply for this job</p>
                    @else
                        <a href="{{ route('jobs.apply', $job) }}"
                            class="btn btn-success btn-lg morph-btn pulse-btn fw-semibold px-5 py-3">
                            <i class="fas fa-paper-plane me-2"></i>Apply Now
                        </a>
                    @endif
                @else
                    @if ($job->isExpired())
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-calendar-times me-2"></i>This job application deadline has passed
                        </div>
                        <p class="text-white opacity-75">Application deadline:
                            {{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}</p>
                    @else
                        <div class="text-white">
                            <p class="mb-3">Want to apply for this job?</p>
                            <a href="{{ route('login') }}"
                                class="btn btn-light btn-lg morph-btn fw-semibold px-4 py-3 me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="btn btn-success btn-lg morph-btn fw-semibold px-4 py-3">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <style>
        .job-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .info-item {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--gradient-1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .related-job-card {
            background: rgba(248, 249, 250, 0.8);
            border-radius: 10px;
            padding: 1rem;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .related-job-card:hover {
            background: rgba(248, 249, 250, 1);
            transform: translateX(5px);
        }

        .morph-btn {
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .morph-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .pulse-btn {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }
    </style>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-up">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-up">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Job Content -->
        <div class="col-lg-8">
            <!-- Job Description -->
            <div class="job-card p-4 mb-4" data-aos="fade-up">
                <h4 class="fw-bold mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-file-alt me-2"></i>Job Description
                </h4>
                <div class="job-description">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>

            <!-- Requirements -->
            @if ($job->requirements)
                <div class="job-card p-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="fas fa-list-check me-2"></i>Requirements
                    </h4>
                    <div class="requirements">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>
            @endif

            <!-- Benefits -->
            @if ($job->benefits)
                <div class="job-card p-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <h4 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="fas fa-gift me-2"></i>Benefits
                    </h4>
                    <div class="benefits">
                        {!! nl2br(e($job->benefits)) !!}
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Job Information -->
            <div class="job-card p-4 mb-4" data-aos="fade-up">
                <h5 class="fw-bold mb-4" style="color: var(--primary-color);">
                    <i class="fas fa-info-circle me-2"></i>Job Information
                </h5>

                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Company</h6>
                            <small class="text-muted">{{ $job->company }}</small>
                        </div>
                    </div>
                </div>

                @if ($job->location)
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Location</h6>
                                <small class="text-muted">{{ $job->location }}</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->type)
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-briefcase text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Job Type</h6>
                                <small class="text-muted">{{ $job->type }}</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->schedule)
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Schedule</h6>
                                <small class="text-muted">{{ $job->schedule }}</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->level)
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-level-up-alt text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Experience Level</h6>
                                <small class="text-muted">{{ $job->level }}</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->salary_min && $job->salary_min > 0 && ($job->salary_max && $job->salary_max > 0))
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Salary Range</h6>
                                <small class="text-muted">${{ number_format($job->salary_min) }} -
                                    ${{ number_format($job->salary_max) }}</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Salary</h6>
                                <small class="text-muted">Negotiable</small>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->deadline)
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <div class="info-icon">
                                <i class="fas fa-calendar-times text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Application Deadline</h6>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}</small>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Posted</h6>
                            <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apply Button (Sidebar) -->
            <div class="job-card p-4 mb-4 text-center" data-aos="fade-up" data-aos-delay="100">
                @auth
                    @if ($job->isExpired())
                        <div class="alert alert-danger mb-3" role="alert">
                            <i class="fas fa-calendar-times me-2"></i>Application Deadline Passed
                        </div>
                        <p class="text-muted mb-0">This job is no longer accepting applications.</p>
                        <small class="text-muted">Deadline was:
                            {{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}</small>
                    @elseif ($hasApplied)
                        <div class="alert alert-success mb-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>Application Submitted
                        </div>
                        <p class="text-muted mb-0">You have already applied for this position.</p>
                    @elseif (!$hasCv)
                        <div class="alert alert-warning mb-3" role="alert">
                            <i class="fas fa-upload me-2"></i>CV Required
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning morph-btn fw-semibold w-100 mb-3">
                            <i class="fas fa-upload me-2"></i>Upload CV to Profile
                        </a>
                        <p class="text-muted small mb-0">Complete your profile to apply for jobs</p>
                    @else
                        <a href="{{ route('jobs.apply', $job) }}"
                            class="btn btn-success btn-lg morph-btn pulse-btn fw-semibold w-100 mb-3">
                            <i class="fas fa-paper-plane me-2"></i>Apply for this Job
                        </a>
                        <p class="text-muted small mb-0">Click to submit your application</p>
                    @endif
                @else
                    @if ($job->isExpired())
                        <div class="alert alert-danger mb-3" role="alert">
                            <i class="fas fa-calendar-times me-2"></i>Application Deadline Passed
                        </div>
                        <p class="text-muted mb-0">This job is no longer accepting applications.</p>
                        <small class="text-muted">Deadline was:
                            {{ \Carbon\Carbon::parse($job->deadline)->format('F d, Y') }}</small>
                    @else
                        <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Ready to Apply?</h6>
                        <a href="{{ route('login') }}" class="btn btn-primary morph-btn fw-semibold w-100 mb-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary morph-btn fw-semibold w-100">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Share Job -->
            <div class="job-card p-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <h6 class="fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="fas fa-share-alt me-2"></i>Share this Job
                </h6>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm flex-fill" onclick="shareJob('facebook')">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="btn btn-outline-info btn-sm flex-fill" onclick="shareJob('twitter')">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="btn btn-outline-success btn-sm flex-fill" onclick="shareJob('whatsapp')">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm flex-fill" onclick="copyJobLink()">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>

            <!-- Related Jobs -->
            @if (isset($relatedJobs) && $relatedJobs->count() > 0)
                <div class="job-card p-4" data-aos="fade-up" data-aos-delay="300">
                    <h6 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="fas fa-lightbulb me-2"></i>Related Jobs
                    </h6>

                    @foreach ($relatedJobs as $relatedJob)
                        <div class="related-job-card mb-3">
                            <h6 class="fw-bold mb-2">
                                <a href="{{ route('jobs.show', $relatedJob) }}" class="text-decoration-none"
                                    style="color: var(--primary-color);">
                                    {{ $relatedJob->title }}
                                </a>
                            </h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-building me-1"></i>{{ $relatedJob->company }}
                            </p>
                            @if ($relatedJob->location)
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $relatedJob->location }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

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
                // Simple notification
                const btn = event.target.closest('button');
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-secondary');

                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-secondary');
                }, 2000);
            });
        }
    </script>
</x-app-layout>
