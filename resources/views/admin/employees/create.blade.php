@extends('layouts.admin.app')

@section('title', 'Add New Employee')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.employees.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Add New Employee</h1>
                <p class="text-sm text-gray-600">Create a new employee record</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200" style="background-color: rgba(24, 69, 143, 0.05);">
                <h3 class="text-lg font-semibold" style="color: #18458f;">Employee Information</h3>
            </div>

            <form method="POST" action="{{ route('admin.employees.store') }}" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- User Selection -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                            User <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                            <option value="">Select a user...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Selection -->
                    <div>
                        <label for="job_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Job <span class="text-red-500">*</span>
                        </label>
                        <select name="job_id" id="job_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('job_id') border-red-500 @enderror">
                            <option value="">Select a job...</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}" {{ old('job_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }} - {{ $job->company }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position Title -->
                    <div>
                        <label for="position_title" class="block text-sm font-medium text-gray-700 mb-1">
                            Position Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="position_title" id="position_title" required
                            value="{{ old('position_title') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('position_title') border-red-500 @enderror"
                            placeholder="e.g., Senior Software Engineer">
                        @error('position_title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="resigned" {{ old('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                            <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>Terminated
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hire Date -->
                    <div>
                        <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Hire Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="hire_date" id="hire_date" required
                            value="{{ old('hire_date', date('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hire_date') border-red-500 @enderror">
                        @error('hire_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            End Date (Optional)
                        </label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Leave empty for active employees</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notes (Optional)
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror"
                            placeholder="Add any additional notes about this employee...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                        <button type="submit" class="px-6 py-2 rounded-lg text-white font-medium transition-colors"
                            style="background-color: #18458f;">
                            <i class="fas fa-save mr-2"></i>Create Employee
                        </button>
                        <a href="{{ route('admin.employees.index') }}"
                            class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition-colors">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-fill position title from job selection
            document.getElementById('job_id').addEventListener('change', function() {
                if (this.value && !document.getElementById('position_title').value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const jobTitle = selectedOption.text.split(' - ')[0];
                    document.getElementById('position_title').value = jobTitle;
                }
            });
        </script>
    @endpush
@endsection
