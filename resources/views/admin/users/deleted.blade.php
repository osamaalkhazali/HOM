@extends('layouts.admin.app')

@section('title', 'Deleted Users')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Deleted Users</h1>
            <p class="text-gray-600 mt-2">Manage deleted users - restore them or permanently delete them.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.users.deleted') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Name, email, phone..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <div class="flex space-x-2">
                            <select name="sort" id="sort"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="deleted_at" {{ request('sort') === 'deleted_at' ? 'selected' : '' }}>
                                    Deletion Date</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                                <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>
                                    Registration Date</option>
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
                        <a href="{{ route('admin.users.deleted') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                    deleted users
                </div>
            </form>
        </div>
    </div>

    <!-- Deleted Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deletion
                            Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128"
                                        alt="{{ $user->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">ID: #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500">{{ $user->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->profile)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-user mr-1"></i>Has Profile
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-user-slash mr-1"></i>No Profile
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    Deleted: {{ $user->deleted_at->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $user->deleted_at->diffForHumans() }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    Applications: {{ $user->applications->count() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <!-- Restore Button -->
                                    <form method="POST" action="{{ route('admin.users.restore', $user->id) }}"
                                        class="inline"
                                        data-confirm="{{ __('site.confirm.actions.users.restore.message', [], 'en') }}"
                                        data-confirm-title="{{ __('site.confirm.restore.title', [], 'en') }}"
                                        data-confirm-variant="success"
                                        data-confirm-confirm="{{ __('site.confirm.actions.users.restore.confirm', [], 'en') }}"
                                        data-confirm-cancel="{{ __('site.confirm.cancel', [], 'en') }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <i class="fas fa-undo mr-1"></i>Restore
                                        </button>
                                    </form>

                                    <!-- Permanent Delete Button -->
                                    <form method="POST" action="{{ route('admin.users.force-delete', $user->id) }}"
                                        class="inline"
                                        data-confirm="{{ __('site.confirm.actions.users.delete_force.message', [], 'en') }}"
                                        data-confirm-title="{{ __('site.confirm.delete.title', [], 'en') }}"
                                        data-confirm-variant="danger"
                                        data-confirm-confirm="{{ __('site.confirm.actions.users.delete_force.confirm', [], 'en') }}"
                                        data-confirm-cancel="{{ __('site.confirm.cancel', [], 'en') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            <i class="fas fa-trash-alt mr-1"></i>Permanent Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-trash text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg">No deleted users found</p>
                                <p class="text-sm">All user deletions will appear here</p>
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

    @if ($users->count() > 0)
        <!-- Warning Notice -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Important Notice</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>• <strong>Restore:</strong> Brings the user back with all their data intact</p>
                        <p>• <strong>Permanent Delete:</strong> Completely removes the user, their profile, and all related
                            data forever</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
