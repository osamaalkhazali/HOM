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
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Name, email, phone, skills, position..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Verification
                            Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified
                            </option>
                            <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Unverified
                            </option>
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
                                <option value="email_verified_at"
                                    {{ request('sort') === 'email_verified_at' ? 'selected' : '' }}>Verification Date
                                </option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Professional</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-12 w-12 rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                        alt="{{ $user->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">#{{ $user->id }} •
                                            {{ $user->created_at->format('M d, Y') }}</div>
                                        @if ($user->profile && $user->profile->headline)
                                            <div class="text-xs text-blue-600 mt-1 max-w-xs truncate">
                                                {{ $user->profile->headline }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500">{{ $user->phone ?? 'No phone' }}</div>
                                @if ($user->profile && $user->profile->location)
                                    <div class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $user->profile->location }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->profile)
                                    <div class="space-y-1">
                                        @if ($user->profile->current_position)
                                            <div class="text-sm text-gray-900">{{ $user->profile->current_position }}</div>
                                        @endif
                                        @if ($user->profile->experience_years !== null)
                                            <div class="text-xs text-gray-500">{{ $user->profile->experience_years }} years
                                                exp.</div>
                                        @endif
                                        @if ($user->profile->skills)
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach (array_slice(explode(',', $user->profile->skills), 0, 3) as $skill)
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endforeach
                                                @if (count(explode(',', $user->profile->skills)) > 3)
                                                    <span
                                                        class="text-xs text-gray-400">+{{ count(explode(',', $user->profile->skills)) - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">No profile</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-2">
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Verified
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Unverified
                                        </span>
                                    @endif

                                    @if ($user->profile)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user mr-1"></i>Profile
                                        </span>
                                        @if ($user->profile->cv_path)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class="fas fa-file-pdf mr-1"></i>CV
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <i class="fas fa-user-slash mr-1"></i>No Profile
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @php $applicationsCount = $user->applications ? $user->applications->count() : 0; @endphp
                                    <div class="text-xs text-gray-500">{{ $applicationsCount }}
                                        {{ Str::plural('application', $applicationsCount) }}</div>
                                    @if ($user->profile)
                                        <div class="text-xs text-gray-400">Profile:
                                            {{ $user->profile->created_at->diffForHumans() }}</div>
                                    @endif
                                    <div class="text-xs text-gray-400">Joined: {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded" title="View Full Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($user->profile && $user->profile->cv_path)
                                        <a href="{{ Storage::url($user->profile->cv_path) }}" target="_blank"
                                            class="text-purple-600 hover:text-purple-900 p-1 rounded" title="View CV">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-{{ $user->email_verified_at ? 'red' : 'green' }}-600 hover:text-{{ $user->email_verified_at ? 'red' : 'green' }}-900 p-1 rounded"
                                            title="{{ $user->email_verified_at ? 'Remove Verification' : 'Verify Email' }}">
                                            <i class="fas fa-{{ $user->email_verified_at ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                        class="inline"
                                        data-confirm="{{ __('site.confirm.actions.users.delete_soft.message', [], 'en') }}"
                                        data-confirm-title="{{ __('site.confirm.delete.title', [], 'en') }}"
                                        data-confirm-variant="danger"
                                        data-confirm-confirm="{{ __('site.confirm.actions.users.delete_soft.confirm', [], 'en') }}"
                                        data-confirm-cancel="{{ __('site.confirm.cancel', [], 'en') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded"
                                            title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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
