@extends('layouts.admin.app')

@section('title', 'Application Management')

@section('content')
<div class="space-y-6">
    @php
        $statusSummary = [
            ['key' => 'pending', 'icon' => 'fas fa-clock', 'bg' => 'bg-yellow-100', 'iconColor' => 'text-yellow-600'],
            ['key' => 'under_reviewing', 'icon' => 'fas fa-spinner', 'bg' => 'bg-blue-100', 'iconColor' => 'text-blue-600'],
            ['key' => 'reviewed', 'icon' => 'fas fa-eye', 'bg' => 'bg-sky-100', 'iconColor' => 'text-sky-600'],
            ['key' => 'shortlisted', 'icon' => 'fas fa-star', 'bg' => 'bg-purple-100', 'iconColor' => 'text-purple-600'],
            ['key' => 'documents_requested', 'icon' => 'fas fa-file-signature', 'bg' => 'bg-amber-100', 'iconColor' => 'text-amber-600'],
            ['key' => 'documents_submitted', 'icon' => 'fas fa-file-upload', 'bg' => 'bg-teal-100', 'iconColor' => 'text-teal-600'],
            ['key' => 'hired', 'icon' => 'fas fa-check', 'bg' => 'bg-green-100', 'iconColor' => 'text-green-600'],
        ];

        $exportFormats = [
            'excel' => ['label' => 'Excel', 'icon' => 'fas fa-file-excel text-green-600'],
            'csv' => ['label' => 'CSV', 'icon' => 'fas fa-file-code text-amber-600'],
        ];

        $filteredParams = $exportQuery ?? [];
        unset($filteredParams['scope'], $filteredParams['format']);

    $advancedFilterKeys = ['status', 'job_id', 'client_id', 'category_id', 'has_answers', 'has_documents', 'has_cover_letter', 'date_from', 'date_to'];
        $advancedActive = collect($advancedFilterKeys)->contains(fn ($key) => filled(request($key)));
    @endphp

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Application Management</h1>
            <p class="mt-1 text-sm text-gray-600">Review and manage all job applications submitted by users</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="relative">
                <button type="button"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                        data-dropdown-toggle="applications-export-menu"
                        aria-expanded="false">
                    <i class="fas fa-download"></i>
                    <span>Export</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div id="applications-export-menu"
                     class="hidden absolute right-0 mt-2 w-60 bg-white border border-gray-200 rounded-lg shadow-lg z-30"
                     data-dropdown-menu>
                    <div class="py-2 text-sm text-gray-700">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">Current results</div>
                        @foreach($exportFormats as $formatKey => $formatMeta)
                            <a href="{{ route('admin.applications.export', array_merge(['format' => $formatKey, 'scope' => 'filtered'], $filteredParams)) }}"
                               class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                <i class="{{ $formatMeta['icon'] }}"></i>
                                <span>{{ $formatMeta['label'] }} (Filtered)</span>
                            </a>
                        @endforeach
                        <div class="my-2 border-t border-gray-100"></div>
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">All records</div>
                        @foreach($exportFormats as $formatKey => $formatMeta)
                            <a href="{{ route('admin.applications.export', ['format' => $formatKey, 'scope' => 'all']) }}"
                               class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                <i class="{{ $formatMeta['icon'] }}"></i>
                                <span>{{ $formatMeta['label'] }} (All)</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards - Compact Two Rows -->
    <div class="bg-white rounded-lg shadow px-6 py-3">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-8 gap-4">
            <!-- Total Applications First -->
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-alt text-gray-600 text-xs"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-[10px] font-medium text-gray-500 truncate">Total</span>
                    <span class="text-lg font-bold text-gray-900">{{ \App\Models\Application::count() }}</span>
                </div>
            </div>

            @foreach ($statusSummary as $summary)
                @php
                    $labelEn = __('site.application_statuses.' . $summary['key'], [], 'en');
                    $count = \App\Models\Application::where('status', $summary['key'])->count();
                @endphp
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 {{ $summary['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="{{ $summary['icon'] }} {{ $summary['iconColor'] }} text-xs"></i>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[10px] font-medium text-gray-500 truncate">{{ $labelEn }}</span>
                        <span class="text-lg font-bold text-gray-900">{{ $count }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow">
        <form method="GET" action="{{ route('admin.applications.index') }}" class="p-6 space-y-4">
            @php
                $statusOptions = ['pending', 'under_reviewing', 'reviewed', 'shortlisted', 'documents_requested', 'documents_submitted', 'rejected', 'hired'];
            @endphp
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Search applications</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Search applicants, jobs, answers, notes..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-filter"></i>
                        <span>Apply</span>
                    </button>
                    <a href="{{ route('admin.applications.index') }}"
                       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-rotate-left"></i>
                        <span>Clear</span>
                    </a>
                    <button type="button"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"
                            id="applications-advanced-toggle"
                            data-advanced-toggle="applications-advanced-filters"
                            data-label-show="Show advanced filters"
                            data-label-hide="Hide advanced filters"
                            aria-expanded="{{ $advancedActive ? 'true' : 'false' }}">
                        <i class="fas fa-sliders-h"></i>
                        <span data-label>{{ $advancedActive ? 'Hide advanced filters' : 'Show advanced filters' }}</span>
                    </button>
                </div>
            </div>

            <div id="applications-advanced-filters" class="mt-4 {{ $advancedActive ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            @foreach ($statusOptions as $statusOption)
                                @php
                                    $labelEn = __('site.application_statuses.' . $statusOption, [], 'en');
                                    $labelAr = __('site.application_statuses.' . $statusOption, [], 'ar');
                                @endphp
                                <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>
                                    {{ $labelEn }} ({{ $labelAr }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="job_id" class="block text-sm font-medium text-gray-700 mb-1">Job</label>
                        <select name="job_id" id="job_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Jobs</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }} - {{ $job->company }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                        <select name="client_id" id="client_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Clients</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="has_answers" class="block text-sm font-medium text-gray-700 mb-1">Question Answers</label>
                        <select name="has_answers" id="has_answers"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Applications</option>
                            <option value="yes" {{ request('has_answers') === 'yes' ? 'selected' : '' }}>With Answers</option>
                            <option value="no" {{ request('has_answers') === 'no' ? 'selected' : '' }}>No Answers</option>
                        </select>
                    </div>

                    <div>
                        <label for="has_documents" class="block text-sm font-medium text-gray-700 mb-1">Additional Documents</label>
                        <select name="has_documents" id="has_documents"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Applications</option>
                            <option value="yes" {{ request('has_documents') === 'yes' ? 'selected' : '' }}>With Documents</option>
                            <option value="no" {{ request('has_documents') === 'no' ? 'selected' : '' }}>No Documents</option>
                        </select>
                    </div>

                    <div>
                        <label for="has_cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
                        <select name="has_cover_letter" id="has_cover_letter"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Applications</option>
                            <option value="yes" {{ request('has_cover_letter') === 'yes' ? 'selected' : '' }}>With Cover Letter</option>
                            <option value="no" {{ request('has_cover_letter') === 'no' ? 'selected' : '' }}>No Cover Letter</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Bulk Actions -->
    @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
    <div class="bg-white rounded-lg shadow p-4" id="bulk-actions" style="display: none;">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">
                    <span id="selected-count">0</span> applications selected
                </span>
                <div class="flex space-x-2">
                    <form method="POST" action="{{ route('admin.applications.bulk-update-status') }}" class="inline">
                        @csrf
                        <input type="hidden" name="application_ids" id="bulk-ids">
                        <select name="status"
                                class="border border-gray-300 rounded px-3 py-1 text-sm"
                                data-confirm-change="Update status for selected applications?"
                                data-confirm-variant="warning">
                            <option value="">Change Status</option>
                            <option value="pending">Mark as Pending</option>
                            <option value="reviewed">Mark as Reviewed</option>
                            <option value="shortlisted">Mark as Shortlisted</option>
                            <option value="rejected">Mark as Rejected</option>
                            <option value="hired">Mark as Hired</option>
                        </select>
                    </form>
                    <form method="POST" action="{{ route('admin.applications.bulk-delete') }}" class="inline"
                          data-confirm="Are you sure you want to delete selected applications?"
                          data-confirm-variant="danger"
                          data-confirm-confirm="Delete"
                          data-confirm-cancel="Cancel">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="application_ids" id="bulk-delete-ids">
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            <i class="fas fa-trash mr-1"></i>Delete Selected
                        </button>
                    </form>
                </div>
            </div>
            <button onclick="clearSelection()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Applications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Applications</h3>
                <div class="text-sm text-gray-500">
                    Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications
                </div>
            </div>
        </div>

        @if($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" id="select-all"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       onchange="toggleAll()">
                            </th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resume</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($applications as $application)
                            <tr class="hover:bg-gray-50">
                                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="application-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                           value="{{ $application->id }}" onchange="updateSelection()">
                                </td>
                                @endif
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                @if($application->user)
                                                    <span class="text-sm font-medium text-blue-600">
                                                        {{ substr($application->user->name, 0, 2) }}
                                                    </span>
                                                @else
                                                    <i class="fas fa-user-times text-gray-400"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            @if($application->user)
                                                <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                                                    <a href="{{ route('admin.users.show', $application->user) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                        {{ $application->user->name }}
                                                    </a>
                                                    @if($application->user->deleted_at)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                            <i class="fas fa-user-slash mr-1"></i>Deleted User
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                                @if($application->user->profile && $application->user->profile->phone)
                                                    <div class="text-xs text-gray-400">{{ $application->user->profile->phone }}</div>
                                                @endif
                                            @else
                                                <div class="text-sm font-medium text-gray-500">
                                                    <i class="fas fa-user-times mr-1"></i>Deleted Account
                                                </div>
                                                <div class="text-sm text-gray-400">User permanently removed</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 flex items-center flex-wrap gap-2">
                                        @if($application->job && !$application->job->deleted_at)
                                            <a href="{{ route('admin.jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ $application->job->title }}
                                            </a>
                                        @else
                                            <span>{{ $application->job->title ?? 'Job Deleted' }}</span>
                                        @endif
                                        @if(!$application->job)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-exclamation-triangle mr-1 text-[10px]"></i>Job Removed
                                            </span>
                                        @elseif($application->job->deleted_at)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-exclamation-triangle mr-1 text-[10px]"></i>Job Removed
                                            </span>
                                        @elseif($application->job->status === 'draft')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                                                <i class="fas fa-pencil-alt mr-1 text-[10px]"></i>Draft
                                            </span>
                                        @elseif($application->job->status === 'inactive')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700 border border-orange-200">
                                                <i class="fas fa-pause-circle mr-1 text-[10px]"></i>Inactive
                                            </span>
                                        @elseif($application->job->status === 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                                <i class="fas fa-check mr-1 text-[10px]"></i>Open
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $application->job->company ?? 'N/A' }}</div>
                                    <div class="flex items-center mt-1">
                                        @if($application->job)
                                            @if(!empty($application->job->location))
                                                <span class="text-xs text-gray-400">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $application->job->location }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    @if($application->job && $application->job->client)
                                        <div class="text-xs text-gray-400 mt-1">
                                            <i class="fas fa-handshake mr-1"></i>{{ $application->job->client->name }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusMeta = [
                                            'pending' => [
                                                'badge' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                                'icon' => 'fas fa-clock text-yellow-600',
                                            ],
                                            'under_reviewing' => [
                                                'badge' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                                'icon' => 'fas fa-spinner text-blue-600',
                                            ],
                                            'reviewed' => [
                                                'badge' => 'bg-sky-100 text-sky-700 border border-sky-200',
                                                'icon' => 'fas fa-eye text-sky-600',
                                            ],
                                            'shortlisted' => [
                                                'badge' => 'bg-purple-100 text-purple-700 border border-purple-200',
                                                'icon' => 'fas fa-star text-purple-600',
                                            ],
                                            'documents_requested' => [
                                                'badge' => 'bg-amber-100 text-amber-700 border border-amber-200',
                                                'icon' => 'fas fa-file-signature text-amber-600',
                                            ],
                                            'documents_submitted' => [
                                                'badge' => 'bg-teal-100 text-teal-700 border border-teal-200',
                                                'icon' => 'fas fa-file-upload text-teal-600',
                                            ],
                                            'rejected' => [
                                                'badge' => 'bg-red-100 text-red-700 border border-red-200',
                                                'icon' => 'fas fa-times text-red-600',
                                            ],
                                            'hired' => [
                                                'badge' => 'bg-green-100 text-green-700 border border-green-200',
                                                'icon' => 'fas fa-check text-green-600',
                                            ],
                                        ];
                                        $statusInfo = $statusMeta[$application->status] ?? null;
                                        $statusLabelEn = __('site.application_statuses.' . $application->status, [], 'en');
                                        $statusLabelAr = __('site.application_statuses.' . $application->status, [], 'ar');
                                        $requestedDocuments = $application->documentRequests;
                                        $submittedDocuments = $requestedDocuments->where('is_submitted', true);
                                    @endphp
                                    @if ($statusInfo)
                                        <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium {{ $statusInfo['badge'] }}">
                                            <i class="{{ $statusInfo['icon'] }} mr-1.5 text-[10px]"></i>{{ $statusLabelEn }}
                                        </span>
                                        <p class="text-[11px] text-gray-400 mt-1">{{ $statusLabelAr }}</p>
                                    @else
                                        <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                            <i class="fas fa-question-circle text-gray-500 mr-1.5 text-[10px]"></i>{{ \Illuminate\Support\Str::headline($application->status) }}
                                        </span>
                                    @endif

                                    @if ($requestedDocuments->count() > 0)
                                        <div class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-file-signature text-amber-500"></i>
                                            <span>{{ $submittedDocuments->count() }} / {{ $requestedDocuments->count() }} documents submitted</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $cvPath = $application->cv_path ?? ($application->user ? optional($application->user->profile)->cv_path : null);
                                    @endphp
                                        @if ($cvPath && \App\Support\SecureStorage::exists($cvPath))
                                            <a href="{{ route('admin.applications.cv.view', $application) }}" target="_blank"
                                           class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-eye mr-1"></i>View CV
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                            <i class="fas fa-file-slash mr-1"></i>No CV
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Application -->
                                        <a href="{{ route('admin.applications.show', $application) }}"
                                           class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                                        <!-- Edit Application -->
                                        <a href="{{ route('admin.applications.edit', $application) }}"
                                           class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded"
                                           title="Edit Application">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Quick Status Update -->
                                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                    class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <option value="">Quick Update</option>
                                                @foreach ($statusOptions as $statusOption)
                                                    @php
                                                        $labelEn = __('site.application_statuses.' . $statusOption, [], 'en');
                                                    @endphp
                                                    <option value="{{ $statusOption }}" {{ $application->status === $statusOption ? 'disabled' : '' }}>
                                                        {{ $labelEn }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>

                                        <!-- Delete Application -->
                                        <form method="POST" action="{{ route('admin.applications.destroy', $application) }}" class="inline"
                                              data-confirm="Are you sure you want to delete this application?"
                                              data-confirm-variant="danger"
                                              data-confirm-confirm="Delete"
                                              data-confirm-cancel="Cancel">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded"
                                                    title="Delete Application">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links('admin.partials.pagination') }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-file-alt text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
                <p class="text-gray-500 mb-4">
                    @if(request()->hasAny(['search', 'status', 'job_id', 'date_from', 'date_to']))
                        No applications match your current filters.
                    @else
                        No applications have been submitted yet.
                    @endif
                </p>
                <a href="{{ route('admin.applications.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-refresh mr-2"></i>Reset Filters
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleAll() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.application-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });

        updateSelection();
    }

    function updateSelection() {
        const checkboxes = document.querySelectorAll('.application-checkbox:checked');
        const selectedIds = Array.from(checkboxes).map(cb => cb.value);
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');

        selectedCount.textContent = selectedIds.length;
        document.getElementById('bulk-ids').value = selectedIds.join(',');
        document.getElementById('bulk-delete-ids').value = selectedIds.join(',');

        if (selectedIds.length > 0) {
            bulkActions.style.display = 'block';
        } else {
            bulkActions.style.display = 'none';
        }

        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.application-checkbox');
        const selectAll = document.getElementById('select-all');
        selectAll.checked = selectedIds.length === allCheckboxes.length;
        selectAll.indeterminate = selectedIds.length > 0 && selectedIds.length < allCheckboxes.length;
    }

    function clearSelection() {
        document.querySelectorAll('.application-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('select-all').checked = false;
        updateSelection();
    }

    (() => {
        const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
        const dropdownMenus = document.querySelectorAll('[data-dropdown-menu]');

        dropdownButtons.forEach(button => {
            const targetId = button.getAttribute('data-dropdown-toggle');
            const menu = document.getElementById(targetId);
            if (!menu) {
                return;
            }

            button.addEventListener('click', event => {
                event.preventDefault();
                event.stopPropagation();

                dropdownMenus.forEach(otherMenu => {
                    if (otherMenu !== menu) {
                        otherMenu.classList.add('hidden');
                        const otherButton = document.querySelector(`[data-dropdown-toggle="${otherMenu.id}"]`);
                        if (otherButton) {
                            otherButton.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                const isHidden = menu.classList.contains('hidden');
                menu.classList.toggle('hidden', !isHidden);
                button.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });
        });

        dropdownMenus.forEach(menu => {
            menu.addEventListener('click', event => event.stopPropagation());
        });

        document.addEventListener('click', () => {
            dropdownMenus.forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    const button = document.querySelector(`[data-dropdown-toggle="${menu.id}"]`);
                    if (button) {
                        button.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        });

        const advancedToggles = document.querySelectorAll('[data-advanced-toggle]');
        advancedToggles.forEach(button => {
            const targetId = button.getAttribute('data-advanced-toggle');
            const target = document.getElementById(targetId);
            if (!target) {
                return;
            }

            button.addEventListener('click', () => {
                const willHide = !target.classList.contains('hidden');
                target.classList.toggle('hidden');
                button.setAttribute('aria-expanded', willHide ? 'false' : 'true');

                const label = button.querySelector('[data-label]');
                if (label) {
                    const showText = button.getAttribute('data-label-show');
                    const hideText = button.getAttribute('data-label-hide');
                    label.textContent = willHide ? showText : hideText;
                }
            });
        });
    })();
</script>
@endsection
