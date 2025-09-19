@extends('layouts.admin.app')

@section('title', 'Admin Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Admin Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage administrator accounts and permissions</p>
            </div>
            <a href="{{ route('admin.admins.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Add New Admin
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-users-cog text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Admins</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $admins->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-user-check text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Admin::whereNotNull('email_verified_at')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-user-times text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Inactive</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Admin::whereNull('email_verified_at')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-crown text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Super Admins</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Admin::where('is_super', true)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow">
            <form method="GET" action="{{ route('admin.admins.index') }}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Search by name or email..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role" name="role"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Roles</option>
                            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super
                                Admin</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.admins.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Admins Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Administrators</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select onchange="window.location.href=this.value"
                            class="border border-gray-300 rounded px-2 py-1 text-sm">
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => 'desc']) }}"
                                {{ request('sort_by') === 'created_at' && request('sort_direction') === 'desc' ? 'selected' : '' }}>
                                Newest First
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => 'asc']) }}"
                                {{ request('sort_by') === 'created_at' && request('sort_direction') === 'asc' ? 'selected' : '' }}>
                                Oldest First
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => 'asc']) }}"
                                {{ request('sort_by') === 'name' && request('sort_direction') === 'asc' ? 'selected' : '' }}>
                                Name A-Z
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => 'desc']) }}"
                                {{ request('sort_by') === 'name' && request('sort_direction') === 'desc' ? 'selected' : '' }}>
                                Name Z-A
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_direction' => 'asc']) }}"
                                {{ request('sort_by') === 'email' && request('sort_direction') === 'asc' ? 'selected' : '' }}>
                                Email A-Z
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            @if ($admins->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Admin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Login</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($admins as $admin)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user-shield text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $admin->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $admin->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            @if ($admin->role === 'super_admin')
                                                <i class="fas fa-crown mr-1"></i>Super Admin
                                            @else
                                                <i class="fas fa-user-cog mr-1"></i>Admin
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $admin->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <span
                                                class="w-1.5 h-1.5 mr-1.5 rounded-full
                                            {{ $admin->status === 'active' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                            {{ ucfirst($admin->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y H:i') : 'Never' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $admin->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.admins.show', $admin) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.admins.edit', $admin) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('admin.admins.toggle-status', $admin) }}"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                    <i
                                                        class="fas fa-toggle-{{ $admin->status === 'active' ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                            @if ($admin->id !== auth('admin')->id())
                                                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
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
                    {{ $admins->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-users-cog text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No administrators found</h3>
                    <p class="text-gray-500 mb-4">Get started by creating your first admin account.</p>
                    <a href="{{ route('admin.admins.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add New Admin
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
