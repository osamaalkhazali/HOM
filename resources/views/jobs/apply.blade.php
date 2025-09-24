<x-app-layout>
    @include('layouts.styles')

    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-paper-plane me-2"></i>Apply for Job</h1>
                <p class="subtitle mb-0">Submit your application for this position</p>
            </div>
            <div class="actions d-flex gap-2">
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back to Job
                </a>
            </div>
        </div>
    </x-slot>

    <section class="py-3 dashboard">
        <div class="container">

            <!-- Job Summary Header -->
            <div class="panel mb-4 shadow-soft">
                <div class="panel-header" style="background: var(--primary-color); color: white; padding: 1.25rem;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">{{ $job->title }}</h2>
                            <p class="mb-2 opacity-90">
                                <i class="fas fa-building me-2"></i>{{ $job->company }}
                                @if ($job->location)
                                    <span class="ms-4"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</span>
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
                                @if ($job->type)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-briefcase me-1"></i>{{ $job->type }}
                                    </span>
                                @endif
                                @if ($job->schedule)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-clock me-1"></i>{{ $job->schedule }}
                                    </span>
                                @endif
                                @if ($job->salary_min && $job->salary_max)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-dollar-sign me-1"></i>${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            @if ($job->deadline)
                                <div class="opacity-90">Apply by</div>
                                <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Main: Application Form -->
                <div class="col-lg-8">
                    <div class="panel shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-file-signature me-2"></i>Application Form</h5>
                        </div>
                        <div class="panel-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <!-- CV Upload Warning -->
                            @if (!$hasCv)
                                <div class="alert alert-warning" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">CV Required for Application</h6>
                                            <p class="mb-2">We recommend uploading your CV to your profile first. This will make future applications faster and easier.</p>
                                            <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm" style="border-radius: 10px;">
                                                <i class="fas fa-upload me-1"></i>Upload CV to Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Great!</strong> You have a CV uploaded to your profile. You can still upload a specific CV for this job below if needed.
                                </div>
                            @endif

                            <form action="{{ route('jobs.apply.store', $job) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="resume" class="form-label fw-semibold"><i class="fas fa-file-upload me-2"></i>Resume/CV *</label>

                                    @if ($hasCv)
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cv_option" id="use_profile_cv" value="profile" checked>
                                                <label class="form-check-label" for="use_profile_cv">
                                                    <strong>Use CV from my profile</strong>
                                                    <br><small class="text-muted">{{ basename(Auth::user()->profile->cv_path) }}</small>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cv_option" id="upload_new_cv" value="upload">
                                                <label class="form-check-label" for="upload_new_cv">
                                                    <strong>Upload a specific CV for this job</strong>
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume" name="resume" accept=".pdf,.doc,.docx" {{ !$hasCv ? 'required' : '' }} style="border-radius: 10px;">
                                    <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</small>
                                    @error('resume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cover_letter" class="form-label fw-semibold"><i class="fas fa-edit me-2"></i>Cover Letter (Optional)</label>
                                    <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter" rows="6" placeholder="Tell us why you're the perfect fit for this role..." style="border-radius: 10px;">{{ old('cover_letter') }}</textarea>
                                    @error('cover_letter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                        </label>
                                    </div>
                                    @error('terms')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2 justify-content-between">
                                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Job
                                    </a>
                                    <button type="submit" class="btn btn-success" style="border-radius: 10px;">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="panel shadow-soft mt-4">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-info-circle me-2"></i>Application Tips</h5>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ensure your resume is up-to-date and tailored to this position</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Write a compelling cover letter that highlights your relevant experience</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Double-check all information before submitting</li>
                                <li class="mb-0"><i class="fas fa-check text-success me-2"></i>You'll receive a confirmation email after submission</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Job Snapshot -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 90px;">
                        <div class="panel shadow-soft mb-4">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0"><i class="fas fa-briefcase me-2"></i>Job Snapshot</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-building"></i></div>
                                            <small class="text-muted d-block">Company</small>
                                            <div class="fw-bold">{{ $job->company }}</div>
                                        </div>
                                    </div>
                                    @if ($job->location)
                                        <div class="col-12">
                                            <div class="quick-action">
                                                <div class="quick-icon"><i class="fas fa-map-marker-alt"></i></div>
                                                <small class="text-muted d-block">Location</small>
                                                <div class="fw-bold">{{ $job->location }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($job->type)
                                        <div class="col-12">
                                            <div class="quick-action">
                                                <div class="quick-icon"><i class="fas fa-briefcase"></i></div>
                                                <small class="text-muted d-block">Type</small>
                                                <div class="fw-bold">{{ $job->type }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($job->level)
                                        <div class="col-12">
                                            <div class="quick-action">
                                                <div class="quick-icon"><i class="fas fa-level-up-alt"></i></div>
                                                <small class="text-muted d-block">Level</small>
                                                <div class="fw-bold">{{ $job->level }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-calendar"></i></div>
                                            <small class="text-muted d-block">Posted</small>
                                            <div class="fw-bold">{{ $job->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel shadow-soft">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0"><i class="fas fa-life-ring me-2"></i>Need Help?</h5>
                            </div>
                            <div class="panel-body">
                                <p class="mb-2">• Ensure files are under 5MB and in PDF/DOC/DOCX format.</p>
                                <p class="mb-0">• If you face issues, contact support or try a different browser.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        @if ($hasCv)
        document.addEventListener('DOMContentLoaded', function() {
            const profileCvRadio = document.getElementById('use_profile_cv');
            const uploadCvRadio = document.getElementById('upload_new_cv');
            const resumeInput = document.getElementById('resume');

            function toggleResumeInput() {
                if (profileCvRadio.checked) {
                    resumeInput.disabled = true;
                    resumeInput.required = false;
                    resumeInput.style.opacity = '0.5';
                } else {
                    resumeInput.disabled = false;
                    resumeInput.required = true;
                    resumeInput.style.opacity = '1';
                }
            }

            profileCvRadio.addEventListener('change', toggleResumeInput);
            uploadCvRadio.addEventListener('change', toggleResumeInput);
            toggleResumeInput();
        });
        @endif
    </script>
</x-app-layout>
