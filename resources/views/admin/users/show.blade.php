@extends('layouts.admin.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">User Details</h1>
            <p class="text-gray-600 mt-2">Complete profile and account information for {{ $user->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Account Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <!-- User Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <img class="h-16 w-16 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128"
                            alt="{{ $user->name }}">
                        <div class="ml-4">
                            <h2 class="text-xl font-medium text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500">User ID: #{{ $user->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <p class="text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Verification</label>
                        <div class="mt-1">
                            @if ($user->email_verified_at)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Verified
                                    {{ $user->email_verified_at->format('M d, Y') }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Unverified
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Registration Date</label>
                        <p class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y \a\t H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Account Activity</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Applications:</span>
                                <span class="font-medium">{{ $user->applications->count() }}</span>
                            </div>
                            @if ($user->profile)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Profile created:</span>
                                    <span class="font-medium">{{ $user->profile->created_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full bg-{{ $user->email_verified_at ? 'red' : 'green' }}-600 text-white px-3 py-2 rounded-md text-sm hover:bg-{{ $user->email_verified_at ? 'red' : 'green' }}-700">
                                <i class="fas fa-{{ $user->email_verified_at ? 'ban' : 'check' }} mr-1"></i>
                                {{ $user->email_verified_at ? 'Remove Verification' : 'Verify Email' }}
                            </button>
                        </form>
                    </div>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="mt-2"
                        onsubmit="return confirm('Are you sure you want to delete this user and their profile? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 text-white px-3 py-2 rounded-md text-sm hover:bg-red-700">
                            <i class="fas fa-trash mr-1"></i>Delete User & Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="lg:col-span-2">
            @if ($user->profile)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Professional Profile</h3>
                        <p class="text-sm text-gray-500">Created {{ $user->profile->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        <!-- Headline -->
                        @if ($user->profile->headline)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Professional Headline</label>
                                <p class="mt-1 text-sm text-gray-900 font-medium">{{ $user->profile->headline }}</p>
                            </div>
                        @endif

                        <!-- Summary -->
                        @if ($user->profile->summary)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Professional Summary</label>
                                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $user->profile->summary }}</p>
                            </div>
                        @endif

                        <!-- Current Position & Experience -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($user->profile->current_position)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Position</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->profile->current_position }}</p>
                                </div>
                            @endif

                            @if ($user->profile->experience_years !== null)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->profile->experience_years }} years</p>
                                </div>
                            @endif
                        </div>

                        <!-- Location & Salary -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($user->profile->location)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Location</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        <i
                                            class="fas fa-map-marker-alt mr-1 text-gray-400"></i>{{ $user->profile->location }}
                                    </p>
                                </div>
                            @endif

                            @if ($user->profile->expected_salary)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Expected Salary</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->profile->expected_salary }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Skills -->
                        @if ($user->profile->skills)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $user->profile->skills) as $skill)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Education -->
                        @if ($user->profile->education)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Education</label>
                                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $user->profile->education }}
                                </p>
                            </div>
                        @endif

                        <!-- Experience -->
                        @if ($user->profile->experience)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Work Experience</label>
                                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $user->profile->experience }}
                                </p>
                            </div>
                        @endif

                        <!-- Links & CV -->
                        <div class="border-t border-gray-200 pt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Links & Documents</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Links -->
                                <div class="space-y-3">
                                    @if ($user->profile->linkedin_url)
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">LinkedIn</label>
                                            <a href="{{ $user->profile->linkedin_url }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 text-sm break-all">
                                                <i class="fab fa-linkedin mr-1"></i>{{ $user->profile->linkedin_url }}
                                            </a>
                                        </div>
                                    @endif

                                    @if ($user->profile->website)
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Website</label>
                                            <a href="{{ $user->profile->website }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 text-sm break-all">
                                                <i class="fas fa-globe mr-1"></i>{{ $user->profile->website }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- CV -->
                                <div>
                                    @if ($user->profile->cv_path)
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-2">CV/Resume</label>
                                            <a href="{{ Storage::url($user->profile->cv_path) }}" target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 transition-colors">
                                                <i class="fas fa-file-pdf mr-2"></i>
                                                <span class="text-sm font-medium">View CV/Resume</span>
                                            </a>
                                        </div>
                                    @else
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-2">CV/Resume</label>
                                            <span
                                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-600 rounded-lg">
                                                <i class="fas fa-file-slash mr-2"></i>
                                                <span class="text-sm">No CV uploaded</span>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Profile -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-user-circle text-4xl mb-4 text-gray-300"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Profile Created</h3>
                        <p class="text-sm">This user hasn't created their professional profile yet.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- User Applications -->
    @if ($user->applications->count() > 0)
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Job Applications ({{ $user->applications->count() }})
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        @foreach ($user->applications as $application)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $application->job->title }}</h4>
                                    <p class="text-sm text-gray-500">Applied
                                        {{ $application->created_at->format('M d, Y') }} •
                                        {{ $application->created_at->diffForHumans() }}</p>
                                    @if ($application->cover_letter)
                                        <p class="text-xs text-gray-600 mt-1">Cover letter included</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($application->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                                        @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                    <a href="{{ route('admin.applications.show', $application) }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
