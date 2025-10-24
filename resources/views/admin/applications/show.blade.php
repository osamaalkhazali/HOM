@extends('layouts.admin.app')

@section('title', 'Application Details')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Application Details</h1>
                <p class="mt-1 text-sm text-gray-600">Review and manage job application</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.applications.edit', $application) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Application
                </a>
                <a href="{{ route('admin.applications.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Applications
                </a>
            </div>
        </div>

        <!-- Application Status Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Application Status</h2>
                <form method="POST" action="{{ route('admin.applications.update-status', $application) }}"
                    class="flex items-center space-x-2">
                    @csrf
                    @method('PATCH')
                    @php
                        $statusOptions = ['pending', 'under_reviewing', 'reviewed', 'shortlisted', 'documents_requested', 'documents_submitted', 'rejected', 'hired'];
                    @endphp
                    <select name="status" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($statusOptions as $statusOption)
                            @php
                                $labelEn = __('site.application_statuses.' . $statusOption, [], 'en');
                                $labelAr = __('site.application_statuses.' . $statusOption, [], 'ar');
                            @endphp
                            <option value="{{ $statusOption }}" {{ $application->status === $statusOption ? 'selected' : '' }}>
                                {{ $labelEn }} ({{ $labelAr }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-semibold text-gray-900">
                        @php
                            $statusMeta = [
                                'pending' => ['badge' => 'bg-yellow-100 text-yellow-700 border border-yellow-200', 'icon' => 'fas fa-clock text-yellow-600'],
                                'under_reviewing' => ['badge' => 'bg-blue-100 text-blue-700 border border-blue-200', 'icon' => 'fas fa-spinner text-blue-600'],
                                'reviewed' => ['badge' => 'bg-sky-100 text-sky-700 border border-sky-200', 'icon' => 'fas fa-eye text-sky-600'],
                                'shortlisted' => ['badge' => 'bg-purple-100 text-purple-700 border border-purple-200', 'icon' => 'fas fa-star text-purple-600'],
                                'documents_requested' => ['badge' => 'bg-amber-100 text-amber-700 border border-amber-200', 'icon' => 'fas fa-file-signature text-amber-600'],
                                'documents_submitted' => ['badge' => 'bg-teal-100 text-teal-700 border border-teal-200', 'icon' => 'fas fa-file-upload text-teal-600'],
                                'rejected' => ['badge' => 'bg-red-100 text-red-700 border border-red-200', 'icon' => 'fas fa-times text-red-600'],
                                'hired' => ['badge' => 'bg-green-100 text-green-700 border border-green-200', 'icon' => 'fas fa-check text-green-600'],
                            ];
                            $statusInfo = $statusMeta[$application->status] ?? null;
                            $statusLabelEn = __('site.application_statuses.' . $application->status, [], 'en');
                            $statusLabelAr = __('site.application_statuses.' . $application->status, [], 'ar');
                        @endphp
                        @if ($statusInfo)
                            <span class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium {{ $statusInfo['badge'] }}">
                                <i class="{{ $statusInfo['icon'] }} mr-2 text-xs"></i>{{ $statusLabelEn }}
                            </span>
                            <p class="text-xs text-gray-400 mt-2">{{ $statusLabelAr }}</p>
                        @else
                            <span class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                <i class="fas fa-question-circle text-gray-500 mr-2 text-xs"></i>{{ \Illuminate\Support\Str::headline($application->status) }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Current Status</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-semibold text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                    <p class="text-sm text-gray-500">Applied On</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-semibold text-gray-900">{{ $application->created_at->diffForHumans() }}</div>
                    <p class="text-sm text-gray-500">Time Ago</p>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-semibold text-gray-900">
                        @if ($application->updated_at != $application->created_at)
                            {{ $application->updated_at->format('M d, Y') }}
                        @else
                            -
                        @endif
                    </div>
                    <p class="text-sm text-gray-500">Last Updated</p>
                </div>
            </div>
        </div>

        @php
            $documentRequests = $application->documentRequests;
        @endphp

        @if ($documentRequests->count() > 0)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Requested Documents</h3>
                        <p class="text-sm text-gray-500">Additional documents requested for this candidate.</p>
                    </div>
                    <a href="{{ route('admin.applications.edit', $application) }}"
                       class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit mr-1"></i>Manage
                    </a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($documentRequests as $request)
                        <div class="px-6 py-4 flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900">{{ $request->name }}</p>
                                @if ($request->name_ar)
                                    <p class="text-xs text-gray-500">{{ $request->name_ar }}</p>
                                @endif
                                @if ($request->notes)
                                    <p class="text-xs text-gray-500 mt-2">{{ $request->notes }}</p>
                                @endif
                                @if ($request->is_submitted && $request->original_name)
                                    <p class="text-xs text-gray-600 mt-2">
                                        <i class="fas fa-file-alt mr-1"></i>{{ $request->original_name }}
                                    </p>
                                @endif
                                <p class="text-[11px] text-gray-400 mt-2">Requested {{ $request->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right min-w-[200px]">
                                @if ($request->is_submitted)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-teal-100 text-teal-700 border border-teal-200">
                                        <i class="fas fa-check-circle text-teal-600 mr-1.5 text-[10px]"></i>Submitted
                                    </span>
                                    @if ($request->submitted_at)
                                        <p class="text-[11px] text-gray-400 mt-1">Received {{ $request->submitted_at->diffForHumans() }}</p>
                                    @endif
                                    @if ($request->file_path)
                                        <div class="mt-2 flex gap-2 justify-end">
                                            <a href="{{ route('admin.applications.documents.view', $request) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-eye mr-1.5"></i>View
                                            </a>
                                            <a href="{{ route('admin.applications.documents.view', $request) }}" download="{{ $request->original_name }}"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-green-600 text-white hover:bg-green-700 transition-colors">
                                                <i class="fas fa-download mr-1.5"></i>Download
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 border border-amber-200">
                                        <i class="fas fa-hourglass-half text-amber-600 mr-1.5 text-[10px]"></i>Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif (in_array($application->status, ['shortlisted', 'documents_requested', 'documents_submitted']))
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Requested Documents</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600">
                        No additional documents have been requested yet. Use the edit page to add requested documents for shortlisted candidates.
                    </p>
                    <a href="{{ route('admin.applications.edit', $application) }}"
                       class="mt-4 inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-file-signature mr-2"></i>Add Document Request
                    </a>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Applicant Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Applicant Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                    @if($application->user)
                                        <i class="fas fa-user text-blue-600 text-xl"></i>
                                    @else
                                        <i class="fas fa-user-times text-gray-400 text-xl"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                @if($application->user)
                                    <h4 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                        {{ $application->user->name }}
                                        @if($application->user->deleted_at)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-user-slash mr-1"></i>Deleted User
                                            </span>
                                        @endif
                                    </h4>
                                    <p class="text-gray-600">{{ $application->user->email }}</p>
                                @else
                                    <h4 class="text-xl font-semibold text-gray-500">
                                        <i class="fas fa-user-times mr-2"></i>Deleted Account
                                    </h4>
                                    <p class="text-gray-400">User permanently removed</p>
                                @endif
                                @if ($application->user && $application->user->profile)
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if ($application->user->profile->phone)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                                <p class="text-sm text-gray-900">{{ $application->user->profile->phone }}
                                                </p>
                                            </div>
                                        @endif
                                        @if ($application->user->profile->location)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                                <p class="text-sm text-gray-900">
                                                    {{ $application->user->profile->location }}</p>
                                            </div>
                                        @endif
                                        @if ($application->user->profile->experience_years)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Experience</label>
                                                <p class="text-sm text-gray-900">
                                                    {{ $application->user->profile->experience_years }} years</p>
                                            </div>
                                        @endif
                                        @if ($application->user->profile->education)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Education</label>
                                                <p class="text-sm text-gray-900">
                                                    {{ $application->user->profile->education }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($application->user->profile->bio)
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                            <p class="text-sm text-gray-900">{{ $application->user->profile->bio }}</p>
                                        </div>
                                    @endif
                                    @if ($application->user->profile->skills)
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach (explode(',', $application->user->profile->skills) as $skill)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @elseif($application->user)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500">No profile information available</p>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-400 italic">All user data permanently removed</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cover Letter -->
                @if ($application->cover_letter)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Cover Letter</h3>
                        </div>
                        <div class="p-6">
                            <div class="prose max-w-none">
                                {!! nl2br(e($application->cover_letter)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Application Notes -->
                @if ($application->notes)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Internal Notes</h3>
                        </div>
                        <div class="p-6">
                            <div class="prose max-w-none">
                                {!! nl2br(e($application->notes)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Job Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Job Details</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">
                                    @if($application->job)
                                        {{ $application->job->title }}
                                        @if($application->job->deleted_at)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-exclamation-triangle mr-1 text-[10px]"></i>Job Removed
                                            </span>
                                        @elseif($application->job->status === 'draft')
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                                                <i class="fas fa-pencil-alt mr-1 text-[10px]"></i>Draft
                                            </span>
                                        @endif
                                    @else
                                        Job Deleted
                                    @endif
                                </h4>
                                <p class="text-gray-600">{{ $application->job->company ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-2">
                                @if($application->job)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ $application->job->location ?? 'N/A' }}
                                    </div>
                                    @if(optional($application->job)->level)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-layer-group mr-2"></i>
                                        {{ ucfirst($application->job->level) }}
                                    </div>
                                    @endif
                                    @php
                                        $categoryLabel = optional(optional($application->job?->subCategory)->category)->admin_label
                                            ?? optional(optional($application->job?->subCategory)->category)->name;
                                        $subLabel = optional($application->job?->subCategory)->admin_label
                                            ?? optional($application->job?->subCategory)->name;
                                    @endphp
                                    @if($categoryLabel || $subLabel)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-tags mr-2"></i>
                                            {{ $categoryLabel ?? 'Uncategorized' }}
                                            @if($subLabel)
                                                <span class="mx-1">></span>
                                                {{ $subLabel }}
                                            @endif
                                        </div>
                                    @endif
                                    @if(optional($application->job)->deadline)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar mr-2"></i>
                                        Deadline: {{ $application->job->deadline->format('M d, Y') }}
                                    </div>
                                    @endif
                                @else
                                    <div class="text-sm text-gray-600">N/A</div>
                                @endif
                            </div>
                            <div class="pt-4">
                                    @if($application->job && !$application->job->deleted_at)
                                    @if($application->job->status === 'draft')
                                        <span class="text-gray-500 text-sm inline-flex items-center">
                                            <i class="fas fa-pencil-alt mr-2"></i>Draft
                                        </span>
                                    @else
                                        <a href="{{ route('admin.jobs.show', $application->job) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Job Details →
                                        </a>
                                    @endif
                                @else
                                    <span class="text-gray-500 text-sm inline-flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>Job Removed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resume/CV -->
                @php
                    $cvPath = $application->cv_path ?? ($application->user ? optional($application->user->profile)->cv_path : null);
                @endphp
                @if ($cvPath)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Resume/CV</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <i class="fas fa-file-pdf text-red-500 text-4xl mb-4"></i>
                                <p class="text-sm text-gray-600 mb-4">Resume attached</p>
                                <a href="{{ Storage::url($cvPath) }}" target="_blank"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    <i class="fas fa-download mr-2"></i>Download Resume
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Resume/CV</h3>
                        </div>
                        <div class="p-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                <i class="fas fa-file-slash mr-1"></i>No CV
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Interview Information -->
                @if ($application->interview_date)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Interview Scheduled</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <i class="fas fa-calendar-alt text-blue-500 text-3xl mb-3"></i>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($application->interview_date)->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($application->interview_date)->format('g:i A') }}</p>
                                @if ($application->interview_notes)
                                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-700">{{ $application->interview_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.applications.edit', $application) }}"
                           class="w-full inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors text-sm">
                            <i class="fas fa-sliders-h mr-2"></i>Edit & Manage Documents
                        </a>

                        <!-- Pending Status -->
                        @if ($application->status !== 'pending')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-clock mr-2"></i>Mark as Pending
                            </button>
                        </form>
                        @endif

                        <!-- Under Reviewing Status -->
                        @if ($application->status !== 'under_reviewing')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="under_reviewing">
                            <button type="submit"
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-spinner mr-2"></i>Mark as Under Review
                            </button>
                        </form>
                        @endif

                        <!-- Reviewed Status -->
                        @if ($application->status !== 'reviewed')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="reviewed">
                            <button type="submit"
                                class="w-full bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-eye mr-2"></i>Mark as Reviewed
                            </button>
                        </form>
                        @endif

                        <!-- Shortlisted Status -->
                        @if ($application->status !== 'shortlisted')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="shortlisted">
                            <button type="submit"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-star mr-2"></i>Shortlist Candidate
                            </button>
                        </form>
                        @endif

                        <!-- Documents Requested Status -->
                        @if ($application->status !== 'documents_requested')
                        @php
                            $canRequestDocuments = $application->status === 'shortlisted' && $documentRequests->count() > 0;
                        @endphp
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="documents_requested">
                            <button type="submit" {{ $canRequestDocuments ? '' : 'disabled' }}
                                class="w-full bg-amber-500 text-white px-4 py-2 rounded-lg transition-colors text-sm {{ $canRequestDocuments ? 'hover:bg-amber-600' : 'opacity-60 cursor-not-allowed' }}">
                                <i class="fas fa-file-signature mr-2"></i>Request Documents
                            </button>
                        </form>
                        @if (! $canRequestDocuments && $application->status !== 'documents_requested')
                            <p class="text-xs text-amber-600">Shortlist first and add document requests to enable this.</p>
                        @endif
                        @endif

                        <!-- Documents Submitted Status -->
                        @if ($application->status !== 'documents_submitted')
                        @php
                            $canMarkDocumentsSubmitted = $documentRequests->count() > 0;
                        @endphp
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="documents_submitted">
                            <button type="submit" {{ $canMarkDocumentsSubmitted ? '' : 'disabled' }}
                                class="w-full bg-teal-600 text-white px-4 py-2 rounded-lg transition-colors text-sm {{ $canMarkDocumentsSubmitted ? 'hover:bg-teal-700' : 'opacity-60 cursor-not-allowed' }}">
                                <i class="fas fa-file-upload mr-2"></i>Mark Docs Submitted
                            </button>
                        </form>
                        @if (! $canMarkDocumentsSubmitted && $application->status !== 'documents_submitted')
                            <p class="text-xs text-teal-600">Add document requests to enable this action.</p>
                        @endif
                        @endif

                        <hr class="my-2">

                        <!-- Hired Status -->
                        @if ($application->status !== 'hired')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}"
                              data-confirm="Are you sure you want to hire this candidate?"
                              data-confirm-variant="success"
                              data-confirm-confirm="Hire">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="hired">
                            <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-check mr-2"></i>Hire Candidate
                            </button>
                        </form>
                        @endif

                        <!-- Rejected Status -->
                        @if ($application->status !== 'rejected')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}"
                              data-confirm="Are you sure you want to reject this application?"
                              data-confirm-variant="warning"
                              data-confirm-confirm="Reject">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-times mr-2"></i>Reject Application
                            </button>
                        </form>
                        @endif

                        <hr class="my-2">

                        <!-- Delete Application -->
                        <form method="POST" action="{{ route('admin.applications.destroy', $application) }}"
                              data-confirm="Are you sure you want to delete this application? This action cannot be undone."
                              data-confirm-variant="danger"
                              data-confirm-confirm="Delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-trash mr-2"></i>Delete Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

