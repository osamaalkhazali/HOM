@extends('layouts.admin.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.employees.show', $employee) }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Employee</h1>
                <p class="text-sm text-gray-600">{{ $employee->user->name }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200" style="background-color: rgba(24, 69, 143, 0.05);">
                <h3 class="text-lg font-semibold" style="color: #18458f;">Employee Information</h3>
            </div>

            <form method="POST" action="{{ route('admin.employees.update', $employee) }}" class="p-6">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    <!-- User Selection (Disabled - Cannot change) -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                            User
                        </label>
                        <div class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-gray-600">
                            {{ $employee->user->name }} ({{ $employee->user->email }})
                        </div>
                        <p class="text-xs text-gray-500 mt-1">User cannot be changed after employee creation</p>
                    </div>

                    <!-- Job (Disabled - Cannot change) -->
                    <div>
                        <label for="job" class="block text-sm font-medium text-gray-700 mb-1">
                            Job
                        </label>
                        <div class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-gray-600">
                            {{ $employee->job->title }} - {{ $employee->job->company }}
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Job cannot be changed after employee creation</p>
                    </div>

                    <!-- Position Title -->
                    <div>
                        <label for="position_title" class="block text-sm font-medium text-gray-700 mb-1">
                            Position Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="position_title" id="position_title" required
                            value="{{ old('position_title', $employee->position_title) }}"
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
                            <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="on_leave"
                                {{ old('status', $employee->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="resigned"
                                {{ old('status', $employee->status) == 'resigned' ? 'selected' : '' }}>Resigned</option>
                            <option value="terminated"
                                {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminated
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
                            value="{{ old('hire_date', $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '') }}"
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
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', $employee->end_date ? $employee->end_date->format('Y-m-d') : '') }}"
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
                            placeholder="Add any additional notes about this employee...">{{ old('notes', $employee->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                        <button type="submit" class="px-6 py-2 rounded-lg text-white font-medium transition-colors"
                            style="background-color: #18458f;">
                            <i class="fas fa-save mr-2"></i>Update Employee
                        </button>
                        <a href="{{ route('admin.employees.show', $employee) }}"
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
            // Store original status value
            let originalStatus = '{{ old('status', $employee->status) }}';

            // Show modal when changing status to resigned or terminated
            document.getElementById('status').addEventListener('change', function() {
                const endDateInput = document.getElementById('end_date');
                const statusValue = this.value;
                const statusSelect = this;

                if (statusValue === 'resigned' || statusValue === 'terminated') {
                    // Show confirmation modal
                    showStatusChangeModal(statusValue, endDateInput, statusSelect);
                } else {
                    // Update original status if changing to active or on_leave
                    originalStatus = statusValue;
                }
            });

            function showStatusChangeModal(status, endDateInput, statusSelect) {
                const modal = document.getElementById('statusChangeModal');
                const modalMessage = document.getElementById('modalMessage');
                const confirmBtn = document.getElementById('confirmStatusChange');
                const cancelBtn = document.getElementById('cancelStatusChange');

                modalMessage.textContent =
                    `Are you sure you want to change the status to ${status}? This will set today as the end date.`;
                modal.classList.remove('hidden');

                confirmBtn.onclick = function() {
                    endDateInput.value = new Date().toISOString().split('T')[0];
                    originalStatus = status;
                    modal.classList.add('hidden');
                };

                cancelBtn.onclick = function() {
                    // Revert to original status
                    statusSelect.value = originalStatus;
                    modal.classList.add('hidden');
                };
            }
        </script>
    @endpush

    <!-- Status Change Modal -->
    <div id="statusChangeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Confirm Status Change</h3>
                <p class="text-sm text-gray-600 text-center mb-6" id="modalMessage"></p>

                <div class="flex items-center gap-3">
                    <button type="button" id="confirmStatusChange"
                        class="flex-1 px-4 py-2 rounded-lg text-white font-medium transition-colors"
                        style="background-color: #18458f;">
                        Yes, Change Status
                    </button>
                    <button type="button" id="cancelStatusChange"
                        class="flex-1 px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition-colors">
                        No, Keep Original
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
