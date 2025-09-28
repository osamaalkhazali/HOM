@extends('layouts.admin.app')

@section('title', 'Profile Management')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Profile Management</h1>
        <p class="text-gray-600 mt-2">Manage and review all user profiles with their professional information.</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.profiles.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Name, email, skills, position..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Experience Filter -->
                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Experience
                            Level</label>
                        <select name="experience" id="experience"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Experience</option>
                            <option value="0-2" {{ request('experience') === '0-2' ? 'selected' : '' }}>0-2 years
                            </option>
                            <option value="3-5" {{ request('experience') === '3-5' ? 'selected' : '' }}>3-5 years
                            </option>
                            <option value="6-10" {{ request('experience') === '6-10' ? 'selected' : '' }}>6-10 years
                            </option>
                            <option value="10+" {{ request('experience') === '10+' ? 'selected' : '' }}>10+ years
                            </option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" id="location" value="{{ request('location') }}"
                            placeholder="City or region..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- CV Status Filter -->
                    <div>
                        <label for="cv_status" class="block text-sm font-medium text-gray-700 mb-1">CV Status</label>
                        <select name="cv_status" id="cv_status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Profiles</option>
                            <option value="with_cv" {{ request('cv_status') === 'with_cv' ? 'selected' : '' }}>With CV
                            </option>
                            <option value="without_cv" {{ request('cv_status') === 'without_cv' ? 'selected' : '' }}>Without
                                CV</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <div class="flex space-x-2">
                            <select name="sort" id="sort"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Profile
                                    Created</option>
                                <option value="user_name" {{ request('sort') === 'user_name' ? 'selected' : '' }}>User Name
                                </option>
                                <option value="experience_years"
                                    {{ request('sort') === 'experience_years' ? 'selected' : '' }}>Experience Years
                                </option>
                                <option value="current_position"
                                    {{ request('sort') === 'current_position' ? 'selected' : '' }}>Current Position
                                </option>
                                <option value="location" {{ request('sort') === 'location' ? 'selected' : '' }}>Location
                                </option>
                            </select>
                            <select name="direction"
                                class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>↓</option>
                                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>↑</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.profiles.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                        <div class="text-sm text-gray-600">
                            Showing {{ $profiles->firstItem() ?? 0 }} to {{ $profiles->lastItem() ?? 0 }} of
                            {{ $profiles->total() }} profiles
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Profiles Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($profiles as $profile)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                <!-- Profile Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full"
                                src="https://ui-avatars.com/api/?name={{ urlencode($profile->user->name) }}&background=random"
                                alt="{{ $profile->user->name }}">
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $profile->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $profile->user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.profiles.show', $profile) }}"
                                class="text-blue-600 hover:text-blue-900 p-1 rounded" title="View Full Profile">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.profiles.destroy', $profile) }}" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this profile?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded"
                                    title="Delete Profile">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="p-6">
                    <div class="space-y-3">
                        <!-- Headline -->
                        @if ($profile->headline)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Headline</p>
                                <p class="text-sm text-gray-900">{{ $profile->headline }}</p>
                            </div>
                        @endif

                        <!-- Current Position & Experience -->
                        <div class="grid grid-cols-2 gap-4">
                            @if ($profile->current_position)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Current Position</p>
                                    <p class="text-sm text-gray-900">{{ $profile->current_position }}</p>
                                </div>
                            @endif

                            @if ($profile->experience_years !== null)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Experience</p>
                                    <p class="text-sm text-gray-900">{{ $profile->experience_years }} years</p>
                                </div>
                            @endif
                        </div>

                        <!-- Location -->
                        @if ($profile->location)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Location</p>
                                <p class="text-sm text-gray-900">
                                    <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>{{ $profile->location }}
                                </p>
                            </div>
                        @endif

                        <!-- Skills -->
                        @if ($profile->skills)
                            <div>
                                <p class="text-sm font-medium text-gray-700 mb-2">Skills</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach (explode(',', $profile->skills) as $skill)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Links & CV -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if ($profile->linkedin_url)
                                    <a href="{{ $profile->linkedin_url }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800" title="LinkedIn Profile">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                @endif

                                @if ($profile->website)
                                    <a href="{{ $profile->website }}" target="_blank"
                                        class="text-gray-600 hover:text-gray-800" title="Personal Website">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2">
                                @if ($profile->cv_path)
                                    <a href="{{ Storage::url($profile->cv_path) }}" target="_blank"
                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200">
                                        <i class="fas fa-file-pdf mr-1"></i>CV
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="fas fa-file-slash mr-1"></i>No CV
                                    </span>
                                @endif

                                <span class="text-xs text-gray-500">
                                    {{ $profile->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-user-circle text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg">No profiles found</p>
                        <p class="text-sm">Try adjusting your search filters</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($profiles->hasPages())
        <div class="mt-6">
            {{ $profiles->links('admin.partials.pagination') }}
        </div>
    @endif
@endsection
