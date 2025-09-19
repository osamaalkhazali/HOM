@extends('layouts.admin.app')

@section('title', 'Admin Details')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Admin Details</h1>
                <p class="mt-1 text-sm text-gray-600">View administrator information and permissions</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.admins.edit', $admin) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Admin
                </a>
                <a href="{{ route('admin.admins.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Admins
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Admin Profile -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                <div class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user-shield text-blue-600 text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $admin->name }}</h2>
                                <p class="text-gray-600">{{ $admin->email }}</p>
                                <div class="mt-2 flex items-center space-x-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $admin->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        @if ($admin->role === 'super_admin')
                                            <i class="fas fa-crown mr-1"></i>Super Admin
                                        @else
                                            <i class="fas fa-user-cog mr-1"></i>Admin
                                        @endif
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $admin->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span
                                            class="w-1.5 h-1.5 mr-1.5 rounded-full
                                        {{ $admin->status === 'active' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                        {{ ucfirst($admin->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Account Details</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Admin ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">#{{ $admin->id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->created_at->format('F d, Y \a\t H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->updated_at->format('F d, Y \a\t H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $admin->last_login_at ? $admin->last_login_at->format('F d, Y \a\t H:i') : 'Never logged in' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Actions & Permissions -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <form method="POST" action="{{ route('admin.admins.toggle-status', $admin) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white
                                {{ $admin->status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} transition-colors">
                                <i class="fas fa-toggle-{{ $admin->status === 'active' ? 'off' : 'on' }} mr-2"></i>
                                {{ $admin->status === 'active' ? 'Deactivate' : 'Activate' }} Account
                            </button>
                        </form>

                        <a href="{{ route('admin.admins.edit', $admin) }}"
                            class="w-full flex items-center justify-center px-4 py-2 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Admin
                        </a>

                        @if ($admin->id !== auth('admin')->id())
                            <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                                onsubmit="return confirm('Are you sure you want to delete this admin? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                                    <i class="fas fa-trash mr-2"></i>Delete Admin
                                </button>
                            </form>
                        @else
                            <div
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                <i class="fas fa-ban mr-2"></i>Cannot Delete Own Account
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Permissions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Permissions</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @if ($admin->role === 'super_admin')
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span class="text-sm text-gray-900">Manage Administrators</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-900">Manage Users</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-900">Manage Jobs</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-900">Manage Applications</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-900">Manage Categories</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-900">Manage Profiles</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-900">View Reports</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Stats -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Admin Stats</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Account Age</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $admin->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Logins</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $admin->login_count ?? 0 }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $admin->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
