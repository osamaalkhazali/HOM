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
                    <select name="status" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed
                        </option>
                        <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>
                            Shortlisted</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                        <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-semibold text-gray-900">
                        @switch($application->status)
                            @case('pending')
                                <span
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                    <i class="fas fa-clock text-yellow-600 mr-2 text-xs"></i>Pending
                                </span>
                            @break

                            @case('reviewed')
                                <span
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                    <i class="fas fa-eye text-blue-600 mr-2 text-xs"></i>Reviewed
                                </span>
                            @break

                            @case('shortlisted')
                                <span
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-700 border border-purple-200">
                                    <i class="fas fa-star text-purple-600 mr-2 text-xs"></i>Shortlisted
                                </span>
                            @break

                            @case('rejected')
                                <span
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-700 border border-red-200">
                                    <i class="fas fa-times text-red-600 mr-2 text-xs"></i>Rejected
                                </span>
                            @break

                            @case('hired')
                                <span
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-700 border border-green-200">
                                    <i class="fas fa-check text-green-600 mr-2 text-xs"></i>Hired
                                </span>
                            @break
                        @endswitch
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
                                    <i class="fas fa-user text-blue-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xl font-semibold text-gray-900">{{ $application->user->name }}</h4>
                                <p class="text-gray-600">{{ $application->user->email }}</p>
                                @if ($application->user->profile)
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
                                <h4 class="text-lg font-semibold text-gray-900">{{ $application->job->title }}</h4>
                                <p class="text-gray-600">{{ $application->job->company }}</p>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $application->job->location }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    ${{ number_format($application->job->salary) }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-layer-group mr-2"></i>
                                    {{ ucfirst($application->job->level) }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-tags mr-2"></i>
                                    {{ $application->job->subCategory->category->name }} >
                                    {{ $application->job->subCategory->name }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar mr-2"></i>
                                    Deadline: {{ $application->job->deadline->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('admin.jobs.show', $application->job) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Job Details →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resume/CV -->
                @if ($application->user->profile && $application->user->profile->resume_path)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Resume/CV</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <i class="fas fa-file-pdf text-red-500 text-4xl mb-4"></i>
                                <p class="text-sm text-gray-600 mb-4">Resume attached</p>
                                <a href="{{ Storage::url($application->user->profile->resume_path) }}" target="_blank"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    <i class="fas fa-download mr-2"></i>Download Resume
                                </a>
                            </div>
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
                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="shortlisted">
                            <button type="submit"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-star mr-2"></i>Shortlist Candidate
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="hired">
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to hire this candidate?')"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-check mr-2"></i>Hire Candidate
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to reject this application?')"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-times mr-2"></i>Reject Application
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.applications.destroy', $application) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this application? This action cannot be undone.')"
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
