@extends('layouts.admin.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Profile</h1>
                <p class="mt-1 text-sm text-gray-600">Update your personal information and password</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.profile.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Profile Information Section -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-amber-600">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Changing your email will require verification and log you out.
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                                placeholder="+962 7X XXX XXXX">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role (Read-only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <input type="text" value="{{ ucfirst(str_replace('_', ' ', $admin->role)) }}" disabled
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-500">Your role cannot be changed from your profile.</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Change Password Section -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>
                    <p class="text-sm text-gray-600 mb-4">Leave password fields empty if you don't want to change your
                        password.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Current Password -->
                        <div class="md:col-span-2">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current
                                Password</label>
                            <div class="position-relative">
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror"
                                    placeholder="Enter your current password">
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <div class="position-relative">
                                <input type="password" id="password" name="password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                    placeholder="Enter new password (min. 8 characters)">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                                New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Account Information (Read-only) -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($admin->client_id)
                            <!-- Client -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Assigned Client</label>
                                <input type="text" value="{{ $admin->client->name ?? 'N/A' }}" disabled
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
                            </div>
                        @endif

                        <!-- Last Login -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Login</label>
                            <input type="text"
                                value="{{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y h:i A') : 'Never' }}"
                                disabled
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
                        </div>

                        <!-- Account Created -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Created</label>
                            <input type="text" value="{{ $admin->created_at->format('M d, Y') }}" disabled
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
