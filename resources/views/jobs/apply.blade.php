<x-app-layout>
    @include('layouts.styles')

    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-paper-plane me-2"></i>{{ __('site.jobs.apply.header.title') }}</h1>
                <p class="subtitle mb-0">{{ __('site.jobs.apply.header.subtitle') }}</p>
            </div>
            <div class="actions d-flex gap-2">
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>{{ __('site.jobs.apply.buttons.back_to_job') }}
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
                            <h2 class="fw-bold mb-2">{{ $job->title_localized }}</h2>
                            <p class="mb-2 opacity-90">
                                <i class="fas fa-building me-2"></i>{{ $job->company_localized }}
                                @if ($job->location)
                                    <span class="ms-4"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location_localized }}</span>
                                @endif
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($job->subCategory && $job->subCategory->category)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-folder me-1"></i>{{ optional($job->subCategory->category)->display_name }}
                                    </span>
                                @endif
                                @if ($job->subCategory)
                                    <span class="badge bg-primary bg-opacity-25 text-white border border-light border-opacity-25" style="border-radius: 10px;">
                                        <i class="fas fa-tag me-1"></i>{{ optional($job->subCategory)->display_name }}
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
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            @if ($job->deadline)
                                <div class="opacity-90">{{ __('site.jobs.labels.apply_by') }}</div>
                                <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Main: {{ __('site.jobs.labels.application_form') }} -->
                <div class="col-lg-8">
                    <div class="panel shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-file-signature me-2"></i>{{ __('site.jobs.labels.application_form') }}</h5>
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
                                            <h6 class="fw-bold mb-1">{{ __('site.jobs.apply.alerts.missing_cv_title') }}</h6>
                                            <p class="mb-2">{{ __('site.jobs.apply.alerts.missing_cv_message') }}</p>
                                            <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-sm" style="border-radius: 10px;">
                                                <i class="fas fa-upload me-1"></i>{{ __('site.jobs.apply.alerts.missing_cv_button') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ __('site.jobs.apply.alerts.profile_cv_notice') }}
                                </div>
                            @endif

                            <form action="{{ route('jobs.apply.store', $job) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="resume" class="form-label fw-semibold">
                                        <i class="fas fa-file-upload me-2"></i>{{ __('site.jobs.apply.form.resume_label') }}
                                    </label>

                                    @if ($hasCv)
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cv_option" id="use_profile_cv" value="profile" checked>
                                                <label class="form-check-label" for="use_profile_cv">
                                                    <strong>{{ __('site.jobs.apply.form.use_profile_cv') }}</strong>
                                                    <br><small class="text-muted">{{ basename(Auth::user()->profile->cv_path) }}</small>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cv_option" id="upload_new_cv" value="upload">
                                                <label class="form-check-label" for="upload_new_cv">
                                                    <strong>{{ __('site.jobs.apply.form.upload_new_cv') }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume" name="resume" accept=".pdf,.doc,.docx" {{ !$hasCv ? 'required' : '' }} style="border-radius: 10px;">
                                    <small class="form-text text-muted">{{ __('site.jobs.apply.form.accepted_formats') }}</small>
                                    @error('resume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($job->questions->isNotEmpty())
                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-800 mb-2">{{ __('site.jobs.apply.sections.questions_title') }}</h4>
                                        <p class="text-xs text-gray-500 mb-3">{{ __('site.jobs.apply.sections.questions_help') }}</p>
                                        <div class="space-y-3">
                                            @foreach ($job->questions as $question)
                                                <div>
                                                    <label class="form-label fw-semibold d-flex align-items-center justify-content-between">
                                                        <span>{{ $question->prompt }}</span>
                                                        @if ($question->question_ar && app()->getLocale() !== 'ar')
                                                            <span class="text-xs text-gray-500" dir="rtl">{{ $question->question_ar }}</span>
                                                        @endif
                                                        @if ($question->is_required)
                                                            <span class="text-red-500 text-xs ms-2">*</span>
                                                        @endif
                                                    </label>
                                                    <textarea name="questions[{{ $question->id }}]" rows="3" class="form-control @error('questions.' . $question->id) is-invalid @enderror" style="border-radius: 10px;" {{ $question->is_required ? 'required' : '' }}>{{ old('questions.' . $question->id) }}</textarea>
                                                    @error('questions.' . $question->id)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($job->documents->isNotEmpty())
                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-800 mb-2">{{ __('site.jobs.apply.sections.documents_title') }}</h4>
                                        <p class="text-xs text-gray-500 mb-3">{{ __('site.jobs.apply.sections.documents_help') }}</p>
                                        <div class="space-y-3">
                                            @foreach ($job->documents as $document)
                                                <div>
                                                    <label class="form-label fw-semibold d-flex align-items-center justify-content-between">
                                                        <span>{{ $document->label }}</span>
                                                        @if ($document->name_ar && app()->getLocale() !== 'ar')
                                                            <span class="text-xs text-gray-500" dir="rtl">{{ $document->name_ar }}</span>
                                                        @endif
                                                        @if ($document->is_required)
                                                            <span class="text-red-500 text-xs ms-2">*</span>
                                                        @else
                                                            <span class="text-xs text-gray-500 ms-2">({{ __('site.jobs.apply.sections.optional') }})</span>
                                                        @endif
                                                    </label>
                                                    <input type="file" name="documents[{{ $document->id }}]" accept=".pdf,.doc,.docx" class="form-control @error('documents.' . $document->id) is-invalid @enderror" style="border-radius: 10px;" {{ $document->is_required ? 'required' : '' }}>
                                                    <small class="form-text text-muted">{{ __('site.jobs.apply.form.accepted_formats') }}</small>
                                                    @error('documents.' . $document->id)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="cover_letter" class="form-label fw-semibold">
                                        <i class="fas fa-edit me-2"></i>{{ __('site.jobs.apply.form.cover_letter_optional', ['label' => __('site.jobs.labels.cover_letter')]) }}
                                    </label>
                                    <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter" rows="6" placeholder="{{ __('site.jobs.apply.form.cover_letter_placeholder') }}" style="border-radius: 10px;">{{ old('cover_letter') }}</textarea>
                                    @error('cover_letter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            {{ __('site.jobs.labels.description_acknowledgement') }}
                                        </label>
                                    </div>
                                    @error('terms')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2 justify-content-between">
                                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                                        <i class="fas fa-arrow-left me-2"></i>{{ __('site.jobs.apply.buttons.back_to_job') }}
                                    </a>
                                    <button type="submit" class="btn btn-success" style="border-radius: 10px;">
                                        <i class="fas fa-paper-plane me-2"></i>{{ __('site.jobs.buttons.submit_application') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="panel shadow-soft mt-4">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-info-circle me-2"></i>{{ __('site.jobs.apply.tips.title') }}</h5>
                        </div>
                        <div class="panel-body">
                            @php($tips = (array) trans('site.jobs.apply.tips.items'))
                            <ul class="list-unstyled mb-0">
                                @foreach ($tips as $tip)
                                    <li class="mb-2 {{ $loop->last ? 'mb-0' : '' }}"><i class="fas fa-check text-success me-2"></i>{{ $tip }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: {{ __('site.jobs.labels.job_snapshot') }} -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 90px;">
                        <div class="panel shadow-soft mb-4">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0"><i class="fas fa-briefcase me-2"></i>{{ __('site.jobs.labels.job_snapshot') }}</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-building"></i></div>
                                            <small class="text-muted d-block">{{ __('site.jobs.labels.company') }}</small>
                                            <div class="fw-bold">{{ $job->company_localized }}</div>
                                        </div>
                                    </div>
                                    @if ($job->location)
                                        <div class="col-12">
                                            <div class="quick-action">
                                                <div class="quick-icon"><i class="fas fa-map-marker-alt"></i></div>
                                                <small class="text-muted d-block">{{ __('site.jobs.labels.location') }}</small>
                                                <div class="fw-bold">{{ $job->location_localized }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($job->type)
                                        <div class="col-12">
                                            <div class="quick-action">
                                                <div class="quick-icon"><i class="fas fa-briefcase"></i></div>
                                                <small class="text-muted d-block">{{ __('site.jobs.labels.job_type') }}</small>
                                                <div class="fw-bold">{{ $job->type }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($job->level)
                                        <div class="col-12">
                                            <div class="quick-action">
                                                <div class="quick-icon"><i class="fas fa-level-up-alt"></i></div>
                                                <small class="text-muted d-block">{{ __('site.jobs.labels.level') }}</small>
                                                <div class="fw-bold">{{ __('site.jobs.levels.' . $job->level) }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-calendar"></i></div>
                                            <small class="text-muted d-block">{{ __('site.jobs.labels.posted_on') }}</small>
                                            <div class="fw-bold">{{ $job->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel shadow-soft">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0"><i class="fas fa-life-ring me-2"></i>{{ __('site.jobs.apply.help.title') }}</h5>
                            </div>
                            <div class="panel-body">
                                @php($helpItems = (array) trans('site.jobs.apply.help.items'))
                                @foreach ($helpItems as $help)
                                    <p class="mb-2 {{ $loop->last ? 'mb-0' : '' }}">• {{ $help }}</p>
                                @endforeach
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

