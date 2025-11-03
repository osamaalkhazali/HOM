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
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                <a href="{{ route('admin.applications.edit', $application) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Application
                </a>
                @endif
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
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                <form method="POST" action="{{ route('admin.applications.update-status', $application) }}"
                    class="flex items-center space-x-2" id="statusChangeFormTop">
                    @csrf
                    @method('PATCH')
                    @php
                        // Only manual statuses - documents_requested and documents_submitted are automatic
                        $manualStatuses = ['pending', 'under_reviewing', 'reviewed', 'shortlisted', 'rejected', 'hired'];
                        $currentStatus = $application->status;
                        $isAutoStatus = in_array($currentStatus, ['documents_requested', 'documents_submitted']);
                    @endphp
                    <select name="status" id="statusSelectTop" onchange="handleTopStatusChange(this.value, '{{ $application->user->name }}')"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @if ($isAutoStatus)
                            @php
                                $labelEn = __('site.application_statuses.' . $currentStatus, [], 'en');
                                $labelAr = __('site.application_statuses.' . $currentStatus, [], 'ar');
                            @endphp
                            <option value="{{ $currentStatus }}" selected>
                                {{ $labelEn }} ({{ $labelAr }}) - Auto
                            </option>
                        @endif
                        @foreach ($manualStatuses as $statusOption)
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
                @endif
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
            $hasPendingDocuments = $documentRequests->contains(fn($doc) => !$doc->is_submitted);
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

                @if (in_array($application->status, ['documents_requested', 'documents_submitted']) && $hasPendingDocuments)
                    <div class="px-6 py-4 bg-amber-50 border-b border-gray-200">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-amber-900">Upload Documents on Behalf of Applicant</p>
                                <p class="text-xs text-amber-700 mt-1">You can upload the requested documents directly as the admin. The status will automatically update to "Documents Submitted" once all documents are uploaded.</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <form action="{{ route('admin.applications.upload-documents', $application) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                @foreach ($documentRequests as $docRequest)
                                    @if (!$docRequest->is_submitted)
                                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                                            <label class="block text-sm font-semibold text-gray-900 mb-1">
                                                {{ $docRequest->name }}
                                                @if ($docRequest->name_ar)
                                                    <span class="text-gray-500 font-normal">({{ $docRequest->name_ar }})</span>
                                                @endif
                                                <span class="text-red-500">*</span>
                                            </label>
                                            @if ($docRequest->notes)
                                                <p class="text-xs text-gray-600 mb-3">{{ $docRequest->notes }}</p>
                                            @endif
                                            <input
                                                type="file"
                                                name="documents[{{ $docRequest->id }}]"
                                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('documents.' . $docRequest->id) border-red-500 @enderror"
                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                required
                                            >
                                            <p class="text-xs text-gray-500 mt-1">Allowed: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</p>
                                            @error('documents.' . $docRequest->id)
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-upload mr-2"></i>Upload Documents
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

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
                                    @if ($request->file_path && \App\Support\SecureStorage::exists($request->file_path))
                                        <div class="mt-2 flex gap-2 justify-end">
                                            <a href="{{ route('admin.applications.requested-documents.view', $request) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-eye mr-1.5"></i>View
                                            </a>
                                            <a href="{{ route('admin.applications.requested-documents.download', [$application, $request]) }}"
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
                                        <a href="{{ route('admin.users.show', $application->user) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $application->user->name }}
                                        </a>
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

                <!-- Application Questions & Answers -->
                @if ($application->questionAnswers && $application->questionAnswers->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Application Questions & Answers</h3>
                            <p class="text-sm text-gray-500 mt-1">Applicant's responses to job-specific questions</p>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach ($application->questionAnswers as $index => $answer)
                                <div class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-600">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">
                                                @if ($answer->question)
                                                    {{ $answer->question->question ?? 'Question' }}
                                                    @if ($answer->question->question_ar)
                                                        <span class="text-gray-600" dir="rtl">({{ $answer->question->question_ar }})</span>
                                                    @endif
                                                    @if ($answer->question->is_required)
                                                        <span class="ml-1 text-red-500">*</span>
                                                    @endif
                                                @else
                                                    Question
                                                @endif
                                            </h4>
                                            <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <p class="text-sm text-gray-900">{{ $answer->answer ?? 'No answer provided' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Uploaded Documents (Required by Job) -->
                @if ($application->documents && $application->documents->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Uploaded Documents</h3>
                            <p class="text-sm text-gray-500 mt-1">Additional documents submitted with the application</p>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach ($application->documents as $document)
                                <div class="px-6 py-4 flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">
                                            @if ($document->jobDocument)
                                                {{ $document->jobDocument->name ?? 'Document' }}
                                                @if ($document->jobDocument->name_ar)
                                                    <span class="text-gray-600" dir="rtl">({{ $document->jobDocument->name_ar }})</span>
                                                @endif
                                                @if ($document->jobDocument->is_required)
                                                    <span class="ml-1 text-red-500">*</span>
                                                @endif
                                            @else
                                                Document
                                            @endif
                                        </h4>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Uploaded: {{ $document->created_at->format('M d, Y g:i A') }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        @if ($document->file_path && \App\Support\SecureStorage::exists($document->file_path))
                                            <a href="{{ route('admin.applications.documents.download', [$application, $document]) }}" target="_blank"
                                               class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                                                <i class="fas fa-download mr-2"></i>Download
                                            </a>
                                        @else
                                            <span class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-500 text-sm rounded-lg">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>File Missing
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                </div>
                    @endforeach
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
                                        @if(!$application->job->deleted_at)
                                            <a href="{{ route('admin.jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ $application->job->title }}
                                            </a>
                                        @else
                                            {{ $application->job->title }}
                                        @endif
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
                                        $categoryLabel = optional(optional($application->job?->subCategory)->category)->name
                                            ?? 'Uncategorized';
                                        $subLabel = optional($application->job?->subCategory)->name;
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
                @if ($cvPath && \App\Support\SecureStorage::exists($cvPath))
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Resume/CV</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <i class="fas fa-file-pdf text-red-500 text-4xl mb-4"></i>
                                <p class="text-sm text-gray-600 mb-4">Resume attached</p>
                                <a href="{{ route('admin.applications.cv.view', $application) }}" target="_blank"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    <i class="fas fa-eye mr-2"></i>View Resume
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
                        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
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

                        <hr class="my-2">

                        <!-- Hired Status -->
                        @if ($application->status !== 'hired')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}"
                              id="hireForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="hired">
                            <button type="button"
                                onclick="confirmStatusChange('hired')"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-check mr-2"></i>Hire Candidate
                            </button>
                        </form>
                        @endif

                        <!-- Rejected Status -->
                        @if ($application->status !== 'rejected')
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}"
                              id="rejectForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="button"
                                onclick="confirmStatusChange('rejected')"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-times mr-2"></i>Reject Application
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Confirmation Modal -->
    <div id="statusConfirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-[10px] bg-white">
            <div class="mt-3">
                <div id="modalIcon" class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-[10px]">
                    <i class="fas fa-user-check text-blue-600 text-2xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 id="statusConfirmTitle" class="text-lg font-medium text-gray-900 mb-3">Confirm Status Change</h3>
                    <div id="statusConfirmMessage" class="text-left"></div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeStatusConfirmModal()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors font-medium">
                        Cancel
                    </button>
                    <button id="statusConfirmBtn" onclick="submitStatusForm()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-blue-600 hover:bg-blue-700 text-white transition-colors font-medium">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let activeFormId = null;

        function confirmStatusChange(status) {
            const modal = document.getElementById('statusConfirmModal');
            const title = document.getElementById('statusConfirmTitle');
            const message = document.getElementById('statusConfirmMessage');
            const confirmBtn = document.getElementById('statusConfirmBtn');
            const iconDiv = document.getElementById('modalIcon');

            if (status === 'hired') {
                activeFormId = 'hireForm';
                title.textContent = 'Hire Candidate';
                message.innerHTML = `
                    <p class="text-sm text-gray-700 mb-3">Are you sure you want to mark this application as <strong>Hired</strong>?</p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-[10px]">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-2"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Important:</p>
                                <p>This candidate will be added to the Employees section. Once added, the employee record can only be removed by the Client HR.</p>
                            </div>
                        </div>
                    </div>
                `;
                confirmBtn.textContent = 'Hire Candidate';
                confirmBtn.className = 'flex-1 px-4 py-2 rounded-[10px] bg-green-600 hover:bg-green-700 text-white transition-colors font-medium';
                iconDiv.className = 'flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-[10px]';
                iconDiv.innerHTML = '<i class="fas fa-user-check text-green-600 text-2xl"></i>';
            } else if (status === 'rejected') {
                activeFormId = 'rejectForm';
                title.textContent = 'Reject Application';
                message.innerHTML = `
                    <p class="text-sm text-gray-700 mb-3">Are you sure you want to mark this application as <strong>Rejected</strong>?</p>
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-[10px]">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 mr-2"></i>
                            <div class="text-sm text-amber-800">
                                <p>The candidate will be notified that their application was not successful.</p>
                            </div>
                        </div>
                    </div>
                `;
                confirmBtn.textContent = 'Reject Application';
                confirmBtn.className = 'flex-1 px-4 py-2 rounded-[10px] bg-red-600 hover:bg-red-700 text-white transition-colors font-medium';
                iconDiv.className = 'flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-[10px]';
                iconDiv.innerHTML = '<i class="fas fa-times-circle text-red-600 text-2xl"></i>';
            }

            modal.classList.remove('hidden');
        }

        function closeStatusConfirmModal() {
            document.getElementById('statusConfirmModal').classList.add('hidden');
            activeFormId = null;
            // Reset top dropdown if it was used
            const topSelect = document.getElementById('statusSelectTop');
            if (topSelect) {
                topSelect.value = '{{ $application->status }}';
            }
        }

        function submitStatusForm() {
            if (activeFormId) {
                document.getElementById(activeFormId).submit();
            }
        }

        // Handle status change from top dropdown
        function handleTopStatusChange(status, candidateName) {
            if (!status || status === '{{ $application->status }}') return;

            if (status === 'hired' || status === 'rejected') {
                activeFormId = 'statusChangeFormTop';
                confirmStatusChange(status);
            } else {
                document.getElementById('statusChangeFormTop').submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('statusConfirmModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusConfirmModal();
            }
        });
    </script>
@endsection

