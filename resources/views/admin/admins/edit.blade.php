@extends('layouts.admin.app')

@section('title', 'Edit Admin')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Admin</h1>
                <p class="mt-1 text-sm text-gray-600">Update administrator information and permissions</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.admins.show', $admin) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-eye mr-2"></i>View Admin
                </a>
                <a href="{{ route('admin.admins.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Admins
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" id="password" name="password"
                            placeholder="Leave blank to keep current password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                            Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm new password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role" name="role" required onchange="toggleClientField()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror">
                            <option value="">Select Role</option>
                            <option value="admin" {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super" {{ old('role', $admin->role) === 'super' ? 'selected' : '' }}>Super Admin</option>
                            <option value="client_hr" {{ old('role', $admin->role) === 'client_hr' ? 'selected' : '' }}>Client HR</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Client Selection (for Client HR only) -->
                    <div id="client-field" style="display: {{ old('role', $admin->role) === 'client_hr' ? 'block' : 'none' }};">
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Client <span class="text-red-500">*</span>
                        </label>
                        <select id="client_id" name="client_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('client_id') border-red-500 @enderror">
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $admin->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="active" {{ old('status', $admin->status) === 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="inactive" {{ old('status', $admin->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Current Info -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-gray-400 mt-0.5 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-gray-800">Current Information</h4>
                            <div class="mt-2 text-sm text-gray-600 space-y-1">
                                <p><strong>Current Role:</strong>
                                    {{ $admin->role === 'super_admin' ? 'Super Admin' : 'Admin' }}</p>
                                <p><strong>Current Status:</strong>
                                    {{ $admin->status === 'active' ? 'Active' : 'Inactive' }}</p>
                                <p><strong>Created:</strong> {{ $admin->created_at->format('F d, Y \a\t H:i') }}</p>
                                <p><strong>Last Login:</strong>
                                    {{ $admin->last_login_at ? $admin->last_login_at->format('F d, Y \a\t H:i') : 'Never' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Description -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-shield-alt text-blue-400 mt-0.5 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800">Role Permissions</h4>
                            <div class="mt-2 text-sm text-blue-700 space-y-1">
                                <p><strong>Admin:</strong> Can manage users, jobs, applications, categories, and profiles.</p>
                                <p><strong>Super Admin:</strong> Has all admin permissions plus ability to manage other administrators.</p>
                                <p><strong>Client HR:</strong> Can manage only their assigned client's jobs, applications, and employees.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($admin->id === auth('admin')->id())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-yellow-400 mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-800">Warning</h4>
                                <p class="mt-1 text-sm text-yellow-700">You are editing your own account. Be careful not to
                                    remove your own admin privileges.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.admins.show', $admin) }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleClientField() {
            const roleSelect = document.getElementById('role');
            const clientField = document.getElementById('client-field');
            const clientSelect = document.getElementById('client_id');

            if (roleSelect.value === 'client_hr') {
                clientField.style.display = 'block';
                clientSelect.required = true;
            } else {
                clientField.style.display = 'none';
                clientSelect.required = false;
                if (!clientSelect.dataset.originalValue) {
                    clientSelect.value = '';
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const clientSelect = document.getElementById('client_id');
            clientSelect.dataset.originalValue = clientSelect.value;
            toggleClientField();
        });
    </script>
@endsection
