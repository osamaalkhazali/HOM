<x-app-layout>
    <x-slot name="header">
        <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-paper-plane me-3"></i>Apply for Job
        </h1>
        <p class="lead mb-0 opacity-90">
            Submit your application for this position
        </p>
    </x-slot>

    <style>
        .application-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .job-header {
            background: var(--gradient-1);
            color: white;
            padding: 2rem;
            margin: -1px -1px 0 -1px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-apply {
            background: var(--gradient-1);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-back {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
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
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="application-card">
                    <!-- Job Information Header -->
                    <div class="job-header text-center">
                        <h2 class="h3 mb-3">{{ $job->title }}</h2>
                        <p class="mb-2">
                            <i class="fas fa-building me-2"></i>{{ $job->company }}
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $job->location }}
                        </p>
                        <div class="d-flex justify-content-center flex-wrap">
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
                            @if ($job->type)
                                <span class="job-badge">
                                    <i class="fas fa-briefcase me-1"></i>{{ $job->type }}
                                </span>
                            @endif
                            @if ($job->schedule)
                                <span class="job-badge">
                                    <i class="fas fa-clock me-1"></i>{{ $job->schedule }}
                                </span>
                            @endif
                            @if ($job->salary_min && $job->salary_max)
                                <span class="job-badge">
                                    <i class="fas fa-dollar-sign me-1"></i>${{ number_format($job->salary_min) }} -
                                    ${{ number_format($job->salary_max) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Application Form -->
                    <div class="p-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- CV Upload Warning -->
                        @if (!$hasCv)
                            <div class="alert alert-warning" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">CV Required for Application</h6>
                                        <p class="mb-2">We recommend uploading your CV to your profile first. This
                                            will make future applications faster and easier.</p>
                                        <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-upload me-1"></i>Upload CV to Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Great!</strong> You have a CV uploaded to your profile. You can still upload a
                                specific CV for this job below if needed.
                            </div>
                        @endif

                        <form action="{{ route('jobs.apply.store', $job) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="resume" class="form-label">
                                    <i class="fas fa-file-upload me-2"></i>Resume/CV *
                                </label>

                                @if ($hasCv)
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cv_option"
                                                id="use_profile_cv" value="profile" checked>
                                            <label class="form-check-label" for="use_profile_cv">
                                                <strong>Use CV from my profile</strong>
                                                <br><small
                                                    class="text-muted">{{ basename(Auth::user()->profile->cv_path) }}</small>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cv_option"
                                                id="upload_new_cv" value="upload">
                                            <label class="form-check-label" for="upload_new_cv">
                                                <strong>Upload a specific CV for this job</strong>
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <input type="file" class="form-control @error('resume') is-invalid @enderror"
                                    id="resume" name="resume" accept=".pdf,.doc,.docx"
                                    {{ !$hasCv ? 'required' : '' }}>
                                <small class="form-text text-muted">
                                    Accepted formats: PDF, DOC, DOCX (Max: 5MB)
                                </small>
                                @error('resume')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cover_letter" class="form-label">
                                    <i class="fas fa-edit me-2"></i>Cover Letter (Optional)
                                </label>
                                <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter"
                                    rows="6" placeholder="Tell us why you're the perfect fit for this role...">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms"
                                        required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary">Terms and Conditions</a>
                                        and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex gap-3 justify-content-between">
                                <a href="{{ route('jobs.show', $job) }}" class="btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Job
                                </a>
                                <button type="submit" class="btn-apply">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="application-card mt-4">
                    <div class="p-4">
                        <h5 class="mb-3">
                            <i class="fas fa-info-circle me-2"></i>Application Tips
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Ensure your resume is up-to-date and tailored to this position
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Write a compelling cover letter that highlights your relevant experience
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Double-check all information before submitting
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check text-success me-2"></i>
                                You'll receive a confirmation email once your application is submitted
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if ($hasCv)
            // Handle CV option selection
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

                // Initialize
                toggleResumeInput();
            });
        @endif
    </script>
</x-app-layout>
