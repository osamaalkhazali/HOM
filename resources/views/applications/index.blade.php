<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="title mb-1">
                    <i class="fas fa-paper-plane me-2"></i>{{ __('site.applications_index.header.title') }}
                </h1>
                <p class="subtitle mb-0">{{ __('site.applications_index.header.subtitle') }}</p>
            </div>
            <div class="actions d-flex gap-2 flex-wrap">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-tachometer-alt me-1"></i>{{ __('site.applications_index.header.dashboard') }}
                </a>
                <a href="{{ route('jobs.index') }}" class="btn btn-light btn-sm text-primary">
                    <i class="fas fa-search me-1"></i>{{ __('site.applications_index.header.browse_jobs') }}
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $hasFilters = request()->hasAny(['search', 'status', 'sort']);
    @endphp

    <section class="py-3 dashboard">
        <div class="container">
            <!-- Document Upload Warning -->
            @if ($hasPendingDocuments)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fas fa-exclamation-triangle mt-1"></i>
                        <div class="flex-grow-1">
                            <strong>{{ __('site.applications_index.alerts.pending_documents.title') }}</strong>
                            {{ __('site.applications_index.alerts.pending_documents.message') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-2 mb-4">
                <div class="col">
                    <div class="kpi-card kpi-1 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->total() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.total') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-2 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'pending')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.pending') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-3 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'under_reviewing')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.under_reviewing') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-4 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'reviewed')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.reviewed') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-5 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'shortlisted')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.shortlisted') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-6 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'documents_requested')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.documents_requested') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-7 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'documents_submitted')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.documents_submitted') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-8 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'rejected')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.rejected') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="kpi-card kpi-9 shadow-soft shadow-hover d-flex align-items-center justify-content-center" style="height: 90px;">
                        <div class="text-center">
                            <div class="kpi-number mb-0" style="font-size: 1.75rem; line-height: 1; font-weight: 700;">{{ $applications->where('status', 'hired')->count() }}</div>
                            <div class="kpi-label mt-1" style="font-size: 0.75rem; white-space: nowrap;">{{ __('site.applications_index.stats.hired') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel mb-4 shadow-soft">
                <div class="panel-header">
                    <h5 class="panel-title mb-0">
                        <i class="fas fa-filter me-2"></i>{{ __('site.applications_index.filters.title') }}
                    </h5>
                </div>
                <div class="panel-body">
                    <form method="GET" action="{{ route('applications.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small" for="applications-search">
                                    {{ __('site.applications_index.filters.search_label') }}
                                </label>
                                <input
                                    id="applications-search"
                                    type="text"
                                    class="form-control"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="{{ __('site.applications_index.filters.search_placeholder') }}"
                                >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small" for="applications-status">
                                    {{ __('site.applications_index.filters.status_label') }}
                                </label>
                                <select id="applications-status" class="form-select" name="status">
                                    <option value="">{{ __('site.applications_index.filters.status.all') }}</option>
                                    @foreach (['pending', 'under_reviewing', 'reviewed', 'shortlisted', 'documents_requested', 'documents_submitted', 'rejected', 'hired'] as $status)
                                        <option value="{{ $status }}" @selected(request('status') === $status)>
                                            {{ __('site.applications_index.status.labels.' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small" for="applications-sort">
                                    {{ __('site.applications_index.filters.sort_label') }}
                                </label>
                                <select id="applications-sort" class="form-select" name="sort">
                                    @foreach (['newest', 'oldest', 'job_title', 'company'] as $sort)
                                        <option value="{{ $sort }}" @selected(request('sort', 'newest') === $sort)>
                                            {{ __('site.applications_index.filters.sort.' . $sort) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                                    <i class="fas fa-search me-1"></i>{{ __('site.applications_index.filters.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($applications->count() > 0)
                <div class="application-list">
                    @foreach ($applications as $application)
                        @php
                            $job = $application->job;
                            $detailsId = 'application-details-' . $application->id;
                            $status = $application->status;
                            $statusLabel = __('site.applications_index.status.labels.' . $status);
                            $answers = $application->questionAnswers
                                ->filter(fn ($answer) => $answer->question)
                                ->sortBy(fn ($answer) => $answer->question->display_order ?? PHP_INT_MAX)
                                ->values();
                            $documents = $application->documents
                                ->filter(fn ($document) => $document->jobDocument)
                                ->sortBy(fn ($document) => $document->jobDocument->display_order ?? PHP_INT_MAX)
                                ->values();
                        @endphp
                        <div class="panel application-card shadow-soft shadow-hover mb-3">
                            <div class="panel-body p-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-12 col-lg-8">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="application-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <h5 class="mb-0">
                                                        {{ $job?->title_localized ?? $job?->title ?? __('site.applications_index.list.deleted_job') }}
                                                    </h5>
                                                    <span class="status status-{{ $application->status }}">
                                                        @if ($application->status === 'pending')
                                                            <i class="fas fa-clock me-1"></i>{{ __('site.applications_index.status.labels.pending') }}
                                                        @elseif($application->status === 'under_reviewing')
                                                            <i class="fas fa-search me-1"></i>{{ __('site.applications_index.status.labels.under_reviewing') }}
                                                        @elseif($application->status === 'reviewed')
                                                            <i class="fas fa-eye me-1"></i>{{ __('site.applications_index.status.labels.reviewed') }}
                                                        @elseif($application->status === 'shortlisted')
                                                            <i class="fas fa-star me-1"></i>{{ __('site.applications_index.status.labels.shortlisted') }}
                                                        @elseif($application->status === 'documents_requested')
                                                            <i class="fas fa-file-upload me-1"></i>{{ __('site.applications_index.status.labels.documents_requested') }}
                                                        @elseif($application->status === 'documents_submitted')
                                                            <i class="fas fa-file-check me-1"></i>{{ __('site.applications_index.status.labels.documents_submitted') }}
                                                        @elseif($application->status === 'rejected')
                                                            <i class="fas fa-times me-1"></i>{{ __('site.applications_index.status.labels.rejected') }}
                                                        @elseif($application->status === 'hired')
                                                            <i class="fas fa-trophy me-1"></i>{{ __('site.applications_index.status.labels.hired') }}
                                                        @else
                                                            {{ $statusLabel }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    @if ($job)
                                                        @if ($job->company_localized ?? $job->company)
                                                            <span class="me-3">
                                                                <i class="fas fa-building me-1"></i>{{ $job->company_localized ?? $job->company }}
                                                            </span>
                                                        @endif
                                                        @if ($job->location_localized ?? $job->location)
                                                            <span class="me-3">
                                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location_localized ?? $job->location }}
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span><i class="fas fa-info-circle me-1"></i>{{ __('site.applications_index.list.job_deleted_note') }}</span>
                                                    @endif
                                                </div>
                                                @if ($job?->subCategory?->display_name)
                                                    <div class="text-muted small mt-1">
                                                        <i class="fas fa-layer-group me-1"></i>{{ $job->subCategory->display_name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 text-lg-end">
                                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                                            @if ($job && !$job->trashed())
                                                @if ($job->status === 'draft')
                                                    <span class="btn btn-sm btn-outline-secondary disabled">
                                                        <i class="fas fa-ban me-1"></i>{{ __('site.applications_index.list.job_unavailable') }}
                                                    </span>
                                                @else
                                                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>{{ __('site.applications_index.list.view_job') }}
                                                    </a>
                                                @endif
                                            @else
                                                <span class="btn btn-sm btn-outline-secondary disabled">
                                                    <i class="fas fa-ban me-1"></i>{{ __('site.applications_index.list.job_unavailable') }}
                                                </span>
                                            @endif
                                            @if ($application->cv_path)
                                                <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download me-1"></i>{{ __('site.applications_index.list.download_cv') }}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="text-muted small mt-2 d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                                            <span>{{ __('site.applications_index.list.reference', ['id' => $application->id]) }}</span>
                                            <span aria-hidden="true">&bull;</span>
                                            <span>{{ $application->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-1"></i>{{ __('site.applications_index.list.applied_on', ['date' => $application->created_at->translatedFormat(__('site.applications_index.list.date_format'))]) }}
                                    </div>
                                    <button
                                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $detailsId }}"
                                        aria-expanded="false"
                                        aria-controls="{{ $detailsId }}"
                                    >
                                        <span>{{ __('site.applications_index.list.toggle') }}</span>
                                        <i class="fas fa-chevron-down application-card-toggle"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="{{ $detailsId }}" class="collapse border-top">
                                <div class="panel-body p-4">
                                    @if ($application->status === 'documents_requested' && $application->documentRequests->whereNull('submitted_at')->count() > 0)
                                        <div class="alert alert-warning mb-4">
                                            <div class="d-flex align-items-start gap-2">
                                                <i class="fas fa-exclamation-triangle mt-1"></i>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ __('site.applications_index.documents_requested.alert_title') }}</h6>
                                                    <p class="mb-0 small">{{ __('site.applications_index.documents_requested.alert_message') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($application->documentRequests->count() > 0)
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="fas fa-file-upload me-2"></i>{{ __('site.applications_index.documents_requested.title') }}
                                            </h6>
                                            <form action="{{ route('applications.upload-documents', $application) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @php($hasPendingDocRequests = $application->documentRequests->whereNull('submitted_at')->count() > 0)
                                                <div class="row g-3">
                                                    @foreach ($application->documentRequests as $docRequest)
                                                        <div class="col-12">
                                                            <div class="border rounded p-3 @if($docRequest->is_submitted) bg-light @endif">
                                                                <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                                                                    <div class="flex-grow-1">
                                                                        <label class="form-label fw-semibold mb-1 d-flex align-items-center gap-2 flex-wrap">
                                                                            <span>{{ $docRequest->name_localized }}</span>
                                                                            @if($docRequest->is_submitted)
                                                                                <span class="badge bg-success-subtle text-success">
                                                                                    <i class="fas fa-check me-1"></i>{{ __('site.applications_index.documents_requested.submitted') }}
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-warning-subtle text-warning">
                                                                                    <i class="fas fa-clock me-1"></i>{{ __('site.applications_index.documents_requested.pending') }}
                                                                                </span>
                                                                            @endif
                                                                        </label>
                                                                        @if($docRequest->notes)
                                                                            <div class="text-muted small mb-2">{{ $docRequest->notes }}</div>
                                                                        @endif
                                                                        @if($docRequest->is_submitted)
                                                                            <div class="d-flex align-items-center gap-2 text-muted small">
                                                                                <i class="fas fa-paperclip"></i>
                                                                                <span>{{ $docRequest->original_name }}</span>
                                                                                <span>&bull;</span>
                                                                                <span>{{ $docRequest->submitted_at?->diffForHumans() }}</span>
                                                                            </div>
                                                                        @endif
                                                                        <div class="mt-3">
                                                                            <input
                                                                                type="file"
                                                                                name="documents[{{ $docRequest->id }}]"
                                                                                class="form-control @error('documents.' . $docRequest->id) is-invalid @enderror"
                                                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                                                {{ $docRequest->is_submitted ? '' : 'required' }}
                                                                            >
                                                                            <div class="form-text">
                                                                                {{ $docRequest->is_submitted
                                                                                    ? __('site.applications_index.documents_requested.replace_hint')
                                                                                    : __('site.applications_index.documents_requested.file_hint') }}
                                                                            </div>
                                                                            @error('documents.' . $docRequest->id)
                                                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    @if($docRequest->file_path)
                                                                        <a href="{{ Storage::url($docRequest->file_path) }}"
                                                                           class="btn btn-sm btn-outline-primary align-self-start"
                                                                           target="_blank">
                                                                            <i class="fas fa-download me-1"></i>{{ __('site.applications_index.documents_requested.download') }}
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-3">
                                                    <button type="submit" class="btn {{ $hasPendingDocRequests ? 'btn-warning' : 'btn-primary' }}">
                                                        <i class="fas fa-upload me-1"></i>{{ $hasPendingDocRequests ? __('site.applications_index.documents_requested.submit_button') : __('site.applications_index.documents_requested.update_button') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <hr>
                                    @endif

                                    @if ($application->cover_letter)
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-2">
                                                <i class="fas fa-file-alt me-2"></i>{{ __('site.applications_index.details.cover_letter.title') }}
                                            </h6>
                                            <div class="text-muted">{!! nl2br(e($application->cover_letter)) !!}</div>
                                        </div>
                                    @endif
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="fas fa-question-circle me-2"></i>{{ __('site.applications_index.details.questions.title') }}
                                            </h6>
                                            @if ($answers->isNotEmpty())
                                                <ul class="list-unstyled mb-0 application-details-list">
                                                    @foreach ($answers as $answer)
                                                        <li class="mb-3">
                                                            <div class="fw-semibold">{{ $answer->question->prompt }}</div>
                                                            <div class="text-muted small">{{ $answer->answer }}</div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="text-muted small">{{ __('site.applications_index.details.questions.empty') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="fas fa-paperclip me-2"></i>{{ __('site.applications_index.details.documents.title') }}
                                            </h6>
                                            @if ($documents->isNotEmpty())
                                                <ul class="list-unstyled mb-0 application-details-list">
                                                    @foreach ($documents as $document)
                                                        @php($shouldShowReplace = old('document_id') == $document->id && $errors->has('document'))
                                                        <li class="mb-3">
                                                            <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-stretch">
                                                                <div class="flex-grow-1">
                                                                    <div class="fw-semibold">{{ $document->jobDocument->label }}</div>
                                                                    <div class="text-muted small">{{ $document->original_name }}</div>
                                                                    @if ($application->status === 'pending')
                                                                        <form action="{{ route('applications.documents.update', [$application, $document]) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                                                            @csrf
                                                                            <input type="hidden" name="document_id" value="{{ $document->id }}">
                                                                            <button
                                                                                type="button"
                                                                                class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1 js-replace-trigger"
                                                                                data-target="replace-input-{{ $document->id }}"
                                                                                style="{{ $shouldShowReplace ? 'display:none;' : '' }}"
                                                                            >
                                                                                <i class="fas fa-sync"></i>
                                                                                {{ __('site.applications_index.details.documents.replace_button') }}
                                                                            </button>
                                                                            <div id="replace-input-{{ $document->id }}" class="mt-3 {{ $shouldShowReplace ? '' : 'd-none' }}">
                                                                                <div class="d-flex flex-column flex-md-row gap-2 align-items-stretch align-items-md-center">
                                                                                    <input
                                                                                        type="file"
                                                                                        name="document"
                                                                                        class="form-control form-control-sm @if($shouldShowReplace && $errors->has('document')) is-invalid @endif"
                                                                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                                                        {{ $shouldShowReplace ? 'autofocus' : '' }}
                                                                                        required
                                                                                    >
                                                                                    <button type="submit" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                                                                        <i class="fas fa-save"></i>
                                                                                        {{ __('site.applications_index.documents_requested.update_button') }}
                                                                                    </button>
                                                                                </div>
                                                                                <div class="form-text mt-1">{{ __('site.applications_index.details.documents.replace_hint') }}</div>
                                                                                @if ($shouldShowReplace && $errors->has('document'))
                                                                                    <div class="text-danger small mt-1">{{ $errors->first('document') }}</div>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex align-items-start gap-2">
                                                                    <a href="{{ $document->download_url }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                                        <i class="fas fa-download me-1"></i>{{ __('site.applications_index.details.documents.download') }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="text-muted small">{{ __('site.applications_index.details.documents.empty') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($applications->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $applications->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="panel mx-auto" style="max-width: 500px;">
                        <div class="panel-body p-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-4"></i>
                            <h5 class="fw-bold mb-3">{{ __('site.applications_index.empty.title') }}</h5>
                            <p class="text-muted mb-4">
                                @if ($hasFilters)
                                    {{ __('site.applications_index.empty.filtered') }}
                                @else
                                    {{ __('site.applications_index.empty.default') }}
                                @endif
                            </p>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                @if ($hasFilters)
                                    <a href="{{ route('applications.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-refresh me-2"></i>{{ __('site.applications_index.empty.reset') }}
                                    </a>
                                @endif
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>{{ __('site.applications_index.empty.browse') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-replace-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    var targetId = button.getAttribute('data-target');
                    var container = document.getElementById(targetId);

                    if (!container) {
                        return;
                    }

                    container.classList.remove('d-none');
                    button.style.display = 'none';

                    var input = container.querySelector('input[type="file"]');
                    if (input) {
                        input.focus();
                    }
                });
            });
        });
    </script>
</x-app-layout>

@push('styles')
    <style>
        .application-icon {
            width: 48px;
            height: 48px;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            flex-shrink: 0;
        }

        .application-card-toggle {
            transition: transform .2s ease;
        }

        [data-bs-toggle="collapse"][aria-expanded="true"] .application-card-toggle {
            transform: rotate(180deg);
        }

        .application-details-list li:last-child {
            margin-bottom: 0;
        }
    </style>
@endpush
