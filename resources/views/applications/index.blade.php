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
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-1 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->total() }}</div>
                        <div class="kpi-label">{{ __('site.applications_index.stats.total') }}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-2 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->where('status', 'pending')->count() }}</div>
                        <div class="kpi-label">{{ __('site.applications_index.stats.pending') }}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-3 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->where('status', 'accepted')->count() }}</div>
                        <div class="kpi-label">{{ __('site.applications_index.stats.accepted') }}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="kpi-card kpi-4 shadow-soft shadow-hover">
                        <div class="kpi-icon mb-2">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="kpi-number">{{ $applications->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                        <div class="kpi-label">{{ __('site.applications_index.stats.monthly') }}</div>
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
                                    @foreach (['pending', 'reviewed', 'accepted', 'rejected'] as $status)
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
                            $statusClass = match ($status) {
                                'pending' => 'badge bg-warning-subtle text-warning',
                                'reviewed' => 'badge bg-info-subtle text-info',
                                'accepted' => 'badge bg-success-subtle text-success',
                                'rejected' => 'badge bg-danger-subtle text-danger',
                                default => 'badge bg-secondary-subtle text-secondary',
                            };
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
                                                    <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
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
                                                        <li class="mb-3 d-flex align-items-center justify-content-between gap-3">
                                                            <div>
                                                                <div class="fw-semibold">{{ $document->jobDocument->label }}</div>
                                                                <div class="text-muted small">{{ $document->original_name }}</div>
                                                            </div>
                                                            <a href="{{ $document->download_url }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                                <i class="fas fa-download me-1"></i>{{ __('site.applications_index.details.documents.download') }}
                                                            </a>
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
