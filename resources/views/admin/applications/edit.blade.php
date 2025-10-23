@extends('layouts.admin.app')

@section('title', 'Edit Application')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Application</h1>
                <p class="mt-1 text-sm text-gray-600">Update application status and manage interview details</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.applications.show', $application) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Details
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Application Management</h3>
                    </div>
                    <form method="POST" action="{{ route('admin.applications.update', $application) }}" class="p-6">
                        @csrf
                        @method('PUT')

                        <!-- Application Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Application Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                <option value="pending"
                                    {{ old('status', $application->status) === 'pending' ? 'selected' : '' }}>
                                    📋 Pending Review
                                </option>
                                <option value="reviewed"
                                    {{ old('status', $application->status) === 'reviewed' ? 'selected' : '' }}>
                                    👁️ Reviewed
                                </option>
                                <option value="shortlisted"
                                    {{ old('status', $application->status) === 'shortlisted' ? 'selected' : '' }}>
                                    ⭐ Shortlisted
                                </option>
                                <option value="rejected"
                                    {{ old('status', $application->status) === 'rejected' ? 'selected' : '' }}>
                                    ❌ Rejected
                                </option>
                                <option value="hired"
                                    {{ old('status', $application->status) === 'hired' ? 'selected' : '' }}>
                                    ✅ Hired
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Select the current status of this application</p>
                        </div>

                        <!-- Internal Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Internal Notes
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                placeholder="Add internal notes about this application (visible only to admin)"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes', $application->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
                        </div>

                        <!-- Interview Management -->
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Interview Management</h4>

                            <!-- Interview Date -->
                            <div class="mb-6">
                                <label for="interview_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Interview Date & Time
                                </label>
                                <input type="datetime-local" id="interview_date" name="interview_date"
                                    value="{{ old('interview_date', $application->interview_date ? \Carbon\Carbon::parse($application->interview_date)->format('Y-m-d\TH:i') : '') }}"
                                    min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('interview_date') border-red-500 @enderror">
                                @error('interview_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Schedule an interview (must be at least 24 hours in
                                    advance)</p>
                            </div>

                            <!-- Interview Notes -->
                            <div class="mb-6">
                                <label for="interview_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Interview Notes
                                </label>
                                <textarea id="interview_notes" name="interview_notes" rows="3"
                                    placeholder="Add notes about the interview (meeting link, location, special instructions, etc.)"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('interview_notes') border-red-500 @enderror">{{ old('interview_notes', $application->interview_notes) }}</textarea>
                                @error('interview_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Include meeting details, location, or special
                                    instructions</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3 pt-6 border-t">
                            <a href="{{ route('admin.applications.show', $application) }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>Update Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Information Sidebar -->
            <div class="space-y-6">
                <!-- Current Status -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Current Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                            <div class="text-sm">
                                @switch($application->status)
                                    @case('pending')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            <i class="fas fa-clock text-yellow-600 mr-1.5 text-[10px]"></i>Pending
                                        </span>
                                    @break

                                    @case('reviewed')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                            <i class="fas fa-eye text-blue-600 mr-1.5 text-[10px]"></i>Reviewed
                                        </span>
                                    @break

                                    @case('shortlisted')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 border border-purple-200">
                                            <i class="fas fa-star text-purple-600 mr-1.5 text-[10px]"></i>Shortlisted
                                        </span>
                                    @break

                                    @case('rejected')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                            <i class="fas fa-times text-red-600 mr-1.5 text-[10px]"></i>Rejected
                                        </span>
                                    @break

                                    @case('hired')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                            <i class="fas fa-check text-green-600 mr-1.5 text-[10px]"></i>Hired
                                        </span>
                                    @break
                                @endswitch
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Applied On</label>
                            <p class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                        </div>

                        @if ($application->updated_at != $application->created_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <p class="text-sm text-gray-900">{{ $application->updated_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500">{{ $application->updated_at->diffForHumans() }}</p>
                            </div>
                        @endif

                        @if ($application->interview_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Interview</label>
                                <p class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($application->interview_date)->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($application->interview_date)->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Applicant Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Applicant Summary</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $application->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                            </div>
                        </div>

                        @if ($application->user->profile)
                            <div class="space-y-2 text-sm">
                                @if ($application->user->profile->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $application->user->profile->phone }}</span>
                                    </div>
                                @endif
                                @if ($application->user->profile->location)
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $application->user->profile->location }}</span>
                                    </div>
                                @endif
                                @if ($application->user->profile->experience_years)
                                    <div class="flex items-center">
                                        <i class="fas fa-briefcase text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $application->user->profile->experience_years }} years experience</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Job Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Job Summary</h3>
                    </div>
                    <div class="p-6">
                        <h4 class="font-medium text-gray-900 mb-2">{{ $application->job->title }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ $application->job->company }}</p>

                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2 w-4"></i>
                                <span>{{ $application->job->location }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-layer-group text-gray-400 mr-2 w-4"></i>
                                <span>{{ ucfirst($application->job->level) }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 mr-2 w-4"></i>
                                <span>Deadline: {{ $application->job->deadline->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('admin.jobs.show', $application->job) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Full Job Details →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-update status description
        document.getElementById('status').addEventListener('change', function() {
            const status = this.value;
            const statusDescriptions = {
                'pending': 'Application is awaiting initial review',
                'reviewed': 'Application has been reviewed by HR/hiring manager',
                'shortlisted': 'Candidate has been selected for interview process',
                'rejected': 'Application has been declined',
                'hired': 'Candidate has been offered and accepted the position'
            };

            // You can add a description element if needed
            console.log('Status changed to:', status, '-', statusDescriptions[status]);
        });
    </script>
@endsection
