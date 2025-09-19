   @extends('layouts.admin.app')

@section('title', 'Application Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Application Management</h1>
            <p class="mt-1 text-sm text-gray-600">Review and manage all job applications submitted by users</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ \App\Models\Application::where('status', 'pending')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-eye text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Reviewed</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ \App\Models\Application::where('status', 'reviewed')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-star text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Shortlisted</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ \App\Models\Application::where('status', 'shortlisted')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Hired</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ \App\Models\Application::where('status', 'hired')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <i class="fas fa-file-alt text-gray-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Application::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow">
        <form method="GET" action="{{ route('admin.applications.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Applicant name, email, job title..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="shortlisted" {{ request('status') === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="hired" {{ request('status') === 'hired' ? 'selected' : '' }}>Hired</option>
                    </select>
                </div>

                <!-- Job Filter -->
                <div>
                    <label for="job_id" class="block text-sm font-medium text-gray-700 mb-1">Job</label>
                    <select name="job_id" id="job_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Jobs</option>
                        @foreach ($jobs as $job)
                            <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                {{ $job->title }} - {{ $job->company }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.applications.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-times mr-1"></i>Clear
                    </a>
                </div>
            </div>

            <!-- Date Range Filters -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-white rounded-lg shadow p-4" id="bulk-actions" style="display: none;">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">
                    <span id="selected-count">0</span> applications selected
                </span>
                <div class="flex space-x-2">
                    <form method="POST" action="{{ route('admin.applications.bulk-update-status') }}" class="inline">
                        @csrf
                        <input type="hidden" name="application_ids" id="bulk-ids">
                        <select name="status" onchange="if(this.value && confirm('Update status for selected applications?')) this.form.submit()"
                                class="border border-gray-300 rounded px-3 py-1 text-sm">
                            <option value="">Change Status</option>
                            <option value="pending">Mark as Pending</option>
                            <option value="reviewed">Mark as Reviewed</option>
                            <option value="shortlisted">Mark as Shortlisted</option>
                            <option value="rejected">Mark as Rejected</option>
                            <option value="hired">Mark as Hired</option>
                        </select>
                    </form>
                    <form method="POST" action="{{ route('admin.applications.bulk-delete') }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="application_ids" id="bulk-delete-ids">
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete selected applications?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            <i class="fas fa-trash mr-1"></i>Delete Selected
                        </button>
                    </form>
                </div>
            </div>
            <button onclick="clearSelection()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Applications</h3>
                <div class="text-sm text-gray-500">
                    Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications
                </div>
            </div>
        </div>

        @if($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" id="select-all"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       onchange="toggleAll()">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resume</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($applications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="application-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                           value="{{ $application->id }}" onchange="updateSelection()">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">
                                                    {{ substr($application->user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                            @if($application->user->profile && $application->user->profile->phone)
                                                <div class="text-xs text-gray-400">{{ $application->user->profile->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $application->job->title ?? 'Job Deleted' }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $application->job->company ?? 'N/A' }}</div>
                                    <div class="flex items-center mt-1">
                                        @if($application->job)
                                            <span class="text-xs text-gray-400">
                                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $application->job->location }}
                                            </span>
                                            <span class="text-xs text-gray-400 ml-3">
                                                <i class="fas fa-dollar-sign mr-1"></i>${{ number_format($application->job->salary) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @switch($application->status)
                                        @case('pending')
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                <i class="fas fa-clock text-yellow-600 mr-1.5 text-[10px]"></i>Pending
                                            </span>
                                            @break
                                        @case('reviewed')
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                                <i class="fas fa-eye text-blue-600 mr-1.5 text-[10px]"></i>Reviewed
                                            </span>
                                            @break
                                        @case('shortlisted')
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 border border-purple-200">
                                                <i class="fas fa-star text-purple-600 mr-1.5 text-[10px]"></i>Shortlisted
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-times text-red-600 mr-1.5 text-[10px]"></i>Rejected
                                            </span>
                                            @break
                                        @case('hired')
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                                <i class="fas fa-check text-green-600 mr-1.5 text-[10px]"></i>Hired
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($application->user->profile && $application->user->profile->resume_path)
                                        <a href="{{ Storage::url($application->user->profile->resume_path) }}" target="_blank"
                                           class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-file-pdf mr-1"></i>View CV
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                            <i class="fas fa-file-slash mr-1"></i>No CV
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Application -->
                                        <a href="{{ route('admin.applications.show', $application) }}"
                                           class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Application -->
                                        <a href="{{ route('admin.applications.edit', $application) }}"
                                           class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded"
                                           title="Edit Application">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Quick Status Update -->
                                        <form method="POST" action="{{ route('admin.applications.update-status', $application) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                    class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <option value="">Quick Update</option>
                                                <option value="pending" {{ $application->status === 'pending' ? 'disabled' : '' }}>Pending</option>
                                                <option value="reviewed" {{ $application->status === 'reviewed' ? 'disabled' : '' }}>Reviewed</option>
                                                <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'disabled' : '' }}>Shortlisted</option>
                                                <option value="rejected" {{ $application->status === 'rejected' ? 'disabled' : '' }}>Rejected</option>
                                                <option value="hired" {{ $application->status === 'hired' ? 'disabled' : '' }}>Hired</option>
                                            </select>
                                        </form>

                                        <!-- Delete Application -->
                                        <form method="POST" action="{{ route('admin.applications.destroy', $application) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this application?')"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded"
                                                    title="Delete Application">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-file-alt text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
                <p class="text-gray-500 mb-4">
                    @if(request()->hasAny(['search', 'status', 'job_id', 'date_from', 'date_to']))
                        No applications match your current filters.
                    @else
                        No applications have been submitted yet.
                    @endif
                </p>
                <a href="{{ route('admin.applications.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-refresh mr-2"></i>Reset Filters
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleAll() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.application-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });

        updateSelection();
    }

    function updateSelection() {
        const checkboxes = document.querySelectorAll('.application-checkbox:checked');
        const selectedIds = Array.from(checkboxes).map(cb => cb.value);
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');

        selectedCount.textContent = selectedIds.length;
        document.getElementById('bulk-ids').value = selectedIds.join(',');
        document.getElementById('bulk-delete-ids').value = selectedIds.join(',');

        if (selectedIds.length > 0) {
            bulkActions.style.display = 'block';
        } else {
            bulkActions.style.display = 'none';
        }

        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.application-checkbox');
        const selectAll = document.getElementById('select-all');
        selectAll.checked = selectedIds.length === allCheckboxes.length;
        selectAll.indeterminate = selectedIds.length > 0 && selectedIds.length < allCheckboxes.length;
    }

    function clearSelection() {
        document.querySelectorAll('.application-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('select-all').checked = false;
        updateSelection();
    }
</script>
@endsection
