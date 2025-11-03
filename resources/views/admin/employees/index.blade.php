@extends('layouts.admin.app')

@section('title', 'Employees Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Employees Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage employee records and employment history</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full" style="background-color: rgba(24, 69, 143, 0.1);">
                        <i class="fas fa-users text-xl" style="color: #18458f;"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Employees</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $employees->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-user-check text-xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Employee::where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100">
                        <i class="fas fa-user-minus text-xl text-orange-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Resigned</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Employee::where('status', 'resigned')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100">
                        <i class="fas fa-user-times text-xl text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Terminated</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Employee::where('status', 'terminated')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow">
            <form method="GET" action="{{ route('admin.employees.index') }}" class="p-6 space-y-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search employees</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search by name, email, or position..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white transition-colors"
                            style="background-color: #18458f;">
                            <i class="fas fa-filter"></i>
                            <span>Apply</span>
                        </button>
                        <a href="{{ route('admin.employees.index') }}"
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-rotate-left"></i>
                            <span>Clear</span>
                        </a>
                        <button type="button"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"
                            onclick="toggleAdvancedFilters()">
                            <i class="fas fa-sliders-h"></i>
                            <span>Advanced Filters</span>
                        </button>
                    </div>
                </div>

                <div id="advanced-filters" class="hidden mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>
                                    Terminated</option>
                                <option value="resigned" {{ request('status') === 'resigned' ? 'selected' : '' }}>Resigned
                                </option>
                                <option value="transferred" {{ request('status') === 'transferred' ? 'selected' : '' }}>
                                    Transferred</option>
                            </select>
                        </div>

                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-1">Has Document
                                Type</label>
                            <select name="document_type" id="document_type"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Documents</option>
                                @foreach ($documentTypes as $type => $config)
                                    @if ($type !== 'all')
                                        <option value="{{ $type }}"
                                            {{ request('document_type') === $type ? 'selected' : '' }}>
                                            {{ $config['name'] }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        @if (auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                            <div>
                                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                                <select name="client_id" id="client_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Clients</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div>
                            <label for="job_id" class="block text-sm font-medium text-gray-700 mb-1">Job</label>
                            <select name="job_id" id="job_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Jobs</option>
                                @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}"
                                        {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                        {{ $job->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Hired From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Hired To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Employees Grid -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Employees</h3>
                    <div class="text-sm text-gray-500">
                        Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of
                        {{ $employees->total() }} employees
                    </div>
                </div>
            </div>

            @if ($employees->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hire Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Documents</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($employees as $employee)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-medium"
                                                    style="background-color: #18458f;">
                                                    {{ substr($employee->user->name, 0, 2) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $employee->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $employee->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $employee->position_title }}</div>
                                        @if ($employee->job)
                                            <div class="text-xs text-gray-500">{{ $employee->job->title }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($employee->client)
                                            <div class="text-sm text-gray-900">{{ $employee->client->name }}</div>
                                        @else
                                            <span class="text-sm text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $employee->status_color }}-100 text-{{ $employee->status_color }}-800">
                                            {{ $employee->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}
                                        </div>
                                        @if ($employee->end_date)
                                            <div class="text-xs text-gray-500">Ended:
                                                {{ $employee->end_date->format('M d, Y') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-file text-gray-400"></i>
                                            <span class="text-sm text-gray-900">{{ $employee->documents->count() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.employees.show', $employee) }}"
                                                class="text-blue-600 hover:text-blue-900 p-2 rounded bg-blue-50 hover:bg-blue-100"
                                                title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if (auth('admin')->user()->isClientHr())
                                                <a href="{{ route('admin.employees.edit', $employee) }}"
                                                    class="text-green-600 hover:text-green-900 p-2 rounded bg-green-50 hover:bg-green-100"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button type="button"
                                                    onclick="confirmDeleteEmployee({{ $employee->id }}, '{{ $employee->user->name }}')"
                                                    class="text-red-600 hover:text-red-900 p-2 rounded bg-red-50 hover:bg-red-100"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <form id="delete-employee-form-{{ $employee->id }}" method="POST"
                                                    action="{{ route('admin.employees.destroy', $employee) }}"
                                                    class="hidden">
                                                    @csrf
                                                    @method('DELETE')
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
                    {{ $employees->links('admin.partials.pagination') }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No employees found</h3>
                    <p class="text-gray-500 mb-4">
                        @if (request()->hasAny(['search', 'status', 'document_type', 'client_id', 'job_id', 'date_from', 'date_to']))
                            No employees match your current filters.
                        @else
                            No employee records have been created yet.
                        @endif
                    </p>
                    @if (request()->hasAny(['search', 'status', 'document_type', 'client_id', 'job_id', 'date_from', 'date_to']))
                        <a href="{{ route('admin.employees.index') }}"
                            class="px-4 py-2 rounded-lg text-white transition-colors inline-flex items-center gap-2"
                            style="background-color: #18458f;">
                            <i class="fas fa-refresh"></i>Reset Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteEmployeeModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-[10px] bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-[10px]">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Employee Record</h3>
                    <p class="text-sm text-gray-500 mb-1">Are you sure you want to delete</p>
                    <p class="text-sm font-semibold text-gray-900 mb-4" id="deleteEmployeeName"></p>
                    <p class="text-sm text-red-600">This action cannot be undone.</p>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 rounded-[10px] bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors font-medium">
                        Cancel
                    </button>
                    <button onclick="submitDeleteForm()"
                        class="flex-1 px-4 py-2 rounded-[10px] bg-red-600 hover:bg-red-700 text-white transition-colors font-medium">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteFormId = null;

        function confirmDeleteEmployee(employeeId, employeeName) {
            deleteFormId = 'delete-employee-form-' + employeeId;
            document.getElementById('deleteEmployeeName').textContent = employeeName;
            document.getElementById('deleteEmployeeModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteEmployeeModal').classList.add('hidden');
            deleteFormId = null;
        }

        function submitDeleteForm() {
            if (deleteFormId) {
                document.getElementById(deleteFormId).submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('deleteEmployeeModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        function toggleAdvancedFilters() {
            const filters = document.getElementById('advanced-filters');
            filters.classList.toggle('hidden');
        }

        // Auto-expand filters if any advanced filter is active
        document.addEventListener('DOMContentLoaded', function() {
            const hasAdvancedFilters =
                {{ request()->hasAny(['status', 'document_type', 'client_id', 'job_id', 'date_from', 'date_to']) ? 'true' : 'false' }};
            if (hasAdvancedFilters) {
                document.getElementById('advanced-filters').classList.remove('hidden');
            }
        });
    </script>
@endsection
