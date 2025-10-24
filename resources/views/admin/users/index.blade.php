@extends('layouts.admin.app')

@section('title', 'Users & Profiles Management')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Users & Profiles Management</h1>
            <p class="text-gray-600 mt-2">Manage user accounts and their professional profiles in one unified view.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.deleted') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <i class="fas fa-trash mr-2"></i>Deleted Users ({{ \App\Models\User::onlyTrashed()->count() }})
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Name, email, phone, position, skills, location, education, jobs applied..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Account
                            Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Deactivated
                            </option>
                        </select>
                    </div>

                    <!-- Email Verification Filter -->
                    <div>
                        <label for="verified" class="block text-sm font-medium text-gray-700 mb-1">Email Verified</label>
                        <select name="verified" id="verified"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Users</option>
                            <option value="yes" {{ request('verified') === 'yes' ? 'selected' : '' }}>Verified</option>
                            <option value="no" {{ request('verified') === 'no' ? 'selected' : '' }}>Not Verified</option>
                        </select>
                    </div>

                    <!-- Profile Filter -->
                    <div>
                        <label for="profile" class="block text-sm font-medium text-gray-700 mb-1">Profile Status</label>
                        <select name="profile" id="profile"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Users</option>
                            <option value="with_profile" {{ request('profile') === 'with_profile' ? 'selected' : '' }}>With
                                Profile</option>
                            <option value="without_profile"
                                {{ request('profile') === 'without_profile' ? 'selected' : '' }}>Without Profile</option>
                        </select>
                    </div>

                    <!-- CV Filter -->
                    <div>
                        <label for="has_cv" class="block text-sm font-medium text-gray-700 mb-1">CV Status</label>
                        <select name="has_cv" id="has_cv"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Users</option>
                            <option value="yes" {{ request('has_cv') === 'yes' ? 'selected' : '' }}>With CV</option>
                            <option value="no" {{ request('has_cv') === 'no' ? 'selected' : '' }}>Without CV</option>
                        </select>
                    </div>

                    <!-- Applications Filter -->
                    <div>
                        <label for="has_applications" class="block text-sm font-medium text-gray-700 mb-1">Applications</label>
                        <select name="has_applications" id="has_applications"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Users</option>
                            <option value="yes" {{ request('has_applications') === 'yes' ? 'selected' : '' }}>With Applications</option>
                            <option value="no" {{ request('has_applications') === 'no' ? 'selected' : '' }}>No Applications</option>
                        </select>
                    </div>

                    <!-- Experience Range -->
                    <div>
                        <label for="experience_min" class="block text-sm font-medium text-gray-700 mb-1">Min Experience (Years)</label>
                        <input type="number" name="experience_min" id="experience_min" value="{{ request('experience_min') }}"
                            placeholder="Min years"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="experience_max" class="block text-sm font-medium text-gray-700 mb-1">Max Experience (Years)</label>
                        <input type="number" name="experience_max" id="experience_max" value="{{ request('experience_max') }}"
                            placeholder="Max years"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <div class="flex space-x-2">
                            <select name="sort" id="sort"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>
                                    Registration Date</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                                <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                            </select>
                            <select name="direction"
                                class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>↓</option>
                                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>↑</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                    <div class="text-sm text-gray-600">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                        users
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User & Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-64">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <!-- Sequential Number -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <!-- User & Contact (Merged) -->
                            <td class="px-6 py-4">
                                <div class="flex items-start">
                                    <img class="h-12 w-12 rounded-full flex-shrink-0"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                        alt="{{ $user->name }}">
                                    <div class="ml-4 min-w-0 flex-1">
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        @if ($user->profile && $user->profile->current_position)
                                            <div class="text-xs text-gray-600 mt-0.5">
                                                <i class="fas fa-briefcase mr-1"></i>{{ $user->profile->current_position }}
                                            </div>
                                        @endif
                                        <div class="text-sm text-gray-600 mt-1.5">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-xs text-gray-500 mt-0.5" dir="ltr">
                                                <i class="fas fa-phone mr-1"></i>{{ $user->phone }}
                                            </div>
                                        @endif
                                        @if ($user->profile && $user->profile->location)
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $user->profile->location }}
                                            </div>
                                        @endif
                                        <div class="text-xs text-gray-400 mt-1">
                                            <i class="fas fa-calendar-plus mr-1"></i>{{ $user->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status (2 columns layout with smaller badges) -->
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-1.5">
                                    @if ($user->is_active)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                            <i class="fas fa-check-circle text-[10px] mr-1"></i>Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                            <i class="fas fa-times-circle text-[10px] mr-1"></i>Inactive
                                        </span>
                                    @endif

                                    @if ($user->email_verified_at)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            <i class="fas fa-check text-[10px] mr-1"></i>Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                            <i class="fas fa-envelope text-[10px] mr-1"></i>Unverified
                                        </span>
                                    @endif

                                    @if ($user->profile)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            <i class="fas fa-user text-[10px] mr-1"></i>Profile
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                            <i class="fas fa-user-slash text-[10px] mr-1"></i>No Profile
                                        </span>
                                    @endif

                                    @if ($user->profile && $user->profile->cv_path)
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                            <i class="fas fa-file-pdf text-[10px] mr-1"></i>CV
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-400 border border-gray-200">
                                            <i class="fas fa-file text-[10px] mr-1"></i>No CV
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Activity -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm space-y-1.5">
                                    @php $applicationsCount = $user->applications ? $user->applications->count() : 0; @endphp
                                    <div class="text-xs text-gray-700">
                                        <i class="fas fa-paper-plane mr-1.5 text-blue-500"></i><span class="font-medium">{{ $applicationsCount }}</span> {{ Str::plural('application', $applicationsCount) }}
                                    </div>
                                    @if ($user->profile)
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1.5"></i>{{ $user->profile->created_at->diffForHumans() }}
                                        </div>
                                    @endif
                                    @if ($user->profile && $user->profile->skills)
                                        @php
                                            $skillsArray = explode(',', $user->profile->skills);
                                            $skillCount = count($skillsArray);
                                        @endphp
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-tags mr-1.5"></i>{{ $skillCount }} {{ Str::plural('skill', $skillCount) }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded transition-colors"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($user->profile && $user->profile->cv_path)
                                        <a href="{{ Storage::url($user->profile->cv_path) }}" target="_blank"
                                            class="text-purple-600 hover:text-purple-800 hover:bg-purple-50 p-2 rounded transition-colors"
                                            title="View CV">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-{{ $user->is_active ? 'orange' : 'green' }}-600 hover:text-{{ $user->is_active ? 'orange' : 'green' }}-800 hover:bg-{{ $user->is_active ? 'orange' : 'green' }}-50 p-2 rounded transition-colors"
                                            title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'user-lock' : 'user-check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                        data-confirm="{{ __('site.confirm.actions.users.delete_soft.message', [], 'en') }}"
                                        data-confirm-title="{{ __('site.confirm.delete.title', [], 'en') }}"
                                        data-confirm-variant="danger"
                                        data-confirm-confirm="{{ __('site.confirm.actions.users.delete_soft.confirm', [], 'en') }}"
                                        data-confirm-cancel="{{ __('site.confirm.cancel', [], 'en') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded transition-colors"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg">No users found</p>
                                <p class="text-sm">Try adjusting your search filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $users->links('admin.partials.pagination') }}
            </div>
        @endif
    </div>
@endsection
