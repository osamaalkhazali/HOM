@extends('layouts.admin.app')

@section('title', 'Application Management')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Application Management</h1>
        <p class="text-gray-600 mt-2">Review and manage all job applications submitted by users.</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.applications.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Applicant name, email, job title..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Application
                            Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed
                            </option>
                            <option value="shortlisted" {{ request('status') === 'shortlisted' ? 'selected' : '' }}>
                                Shortlisted</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                            <option value="hired" {{ request('status') === 'hired' ? 'selected' : '' }}>Hired</option>
                        </select>
                    </div>

                    <!-- Job Filter -->
                    <div>
                        <label for="job_id" class="block text-sm font-medium text-gray-700 mb-1">Specific Job</label>
                        <select name="job_id" id="job_id"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Jobs</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }} - {{ $job->company }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <div class="flex space-x-2">
                            <select name="sort" id="sort"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>
                                    Application Date</option>
                                <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Status</option>
                                <option value="user_name" {{ request('sort') === 'user_name' ? 'selected' : '' }}>Applicant
                                    Name</option>
                                <option value="job_title" {{ request('sort') === 'job_title' ? 'selected' : '' }}>Job Title
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Date Range -->
                    <div class="flex space-x-2">
                        <div class="flex-1">
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex-1">
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.applications.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>

                    <!-- Results Info -->
                    <div class="flex items-end">
                        <div class="text-sm text-gray-600">
                            Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of
                            {{ $applications->total() }} applications
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job
                            Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied
                            Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CV</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($applications as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($application->user->name) }}&background=random"
                                        alt="{{ $application->user->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $application->job->title ?? 'Job Deleted' }}</div>
                                <div class="text-sm text-gray-500">#{{ $application->job_id }}</div>
                                @if ($application->job && $application->job->subCategory)
                                    <div class="text-xs text-gray-400">
                                        {{ $application->job->subCategory->category->name ?? '' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $application->job->company ?? 'N/A' }}</div>
                                @if ($application->job)
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $application->job->location }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST"
                                    action="{{ route('admin.applications.update-status', $application) }}"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs px-2 py-1 rounded-full border-0 focus:ring-2 focus:ring-blue-500
                                           {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                           {{ $application->status === 'reviewed' ? 'bg-blue-100 text-blue-800' : '' }}
                                           {{ $application->status === 'shortlisted' ? 'bg-purple-100 text-purple-800' : '' }}
                                           {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                           {{ $application->status === 'hired' ? 'bg-green-100 text-green-800' : '' }}">
                                        <option value="pending"
                                            {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="reviewed"
                                            {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                        <option value="shortlisted"
                                            {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted
                                        </option>
                                        <option value="rejected"
                                            {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>
                                            Hired</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $application->created_at->format('H:i') }}</div>
                                <div class="text-xs text-gray-400">{{ $application->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($application->cv_path)
                                    <a href="{{ Storage::url($application->cv_path) }}" target="_blank"
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200">
                                        <i class="fas fa-file-pdf mr-1"></i>View CV
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="fas fa-file-slash mr-1"></i>No CV
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.applications.show', $application) }}"
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.applications.destroy', $application) }}"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this application?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded"
                                            title="Delete Application">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-file-alt text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg">No applications found</p>
                                <p class="text-sm">Try adjusting your search filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($applications->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection
