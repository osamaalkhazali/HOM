@extends('layouts.admin.app')

@section('title', 'Job Management')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Job Management</h1>
            <p class="text-gray-600 mt-2">Manage all job postings and their status on your portal.</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            <i class="fas fa-plus mr-2"></i>Add New Job
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Title, company, location..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <!-- Level Filter -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                        <select name="level" id="level"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Levels</option>
                            <option value="entry" {{ request('level') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                            <option value="mid" {{ request('level') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                            <option value="senior" {{ request('level') === 'senior' ? 'selected' : '' }}>Senior Level
                            </option>
                            <option value="executive" {{ request('level') === 'executive' ? 'selected' : '' }}>Executive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Salary Range -->
                    <div class="flex space-x-2">
                        <div class="flex-1">
                            <label for="min_salary" class="block text-sm font-medium text-gray-700 mb-1">Min Salary</label>
                            <input type="number" name="min_salary" id="min_salary" value="{{ request('min_salary') }}"
                                placeholder="0"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex-1">
                            <label for="max_salary" class="block text-sm font-medium text-gray-700 mb-1">Max Salary</label>
                            <input type="number" name="max_salary" id="max_salary" value="{{ request('max_salary') }}"
                                placeholder="999999"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <div class="flex space-x-2">
                            <select name="sort" id="sort"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Post
                                    Date</option>
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                                <option value="company" {{ request('sort') === 'company' ? 'selected' : '' }}>Company
                                </option>
                                <option value="salary" {{ request('sort') === 'salary' ? 'selected' : '' }}>Salary</option>
                                <option value="deadline" {{ request('sort') === 'deadline' ? 'selected' : '' }}>Deadline
                                </option>
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
                        <a href="{{ route('admin.jobs.index') }}"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job
                            Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company &
                            Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary &
                            Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applications</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                    <div class="text-sm text-gray-500">#{{ $job->id }}</div>
                                    <div class="text-xs text-gray-400">{{ $job->created_at->format('M d, Y') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $job->company }}</div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($job->category)
                                    <div class="text-sm text-gray-900">{{ $job->category->name }}</div>
                                @endif
                                @if ($job->subCategory)
                                    <div class="text-xs text-gray-500">{{ $job->subCategory->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    @if ($job->salary && $job->salary > 0)
                                        ${{ number_format($job->salary) }}
                                    @else
                                        Negotiable
                                    @endif
                                </div>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                    {{ $job->level }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($job->isExpired())
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 mb-1">
                                        <i class="fas fa-calendar-times text-red-600 mr-1.5 text-[10px]"></i>Expired
                                    </span>
                                @else
                                    @if ($job->status === 'active')
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                            <i class="fas fa-check text-green-600 mr-1.5 text-[10px]"></i>Active
                                        </span>
                                    @elseif ($job->status === 'inactive')
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            <i class="fas fa-pause text-yellow-600 mr-1.5 text-[10px]"></i>Inactive
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                            <i class="fas fa-file-alt text-gray-600 mr-1.5 text-[10px]"></i>Draft
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $job->applications_count ?? 0 }}</div>
                                <div class="text-xs text-gray-500">applications</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $job->deadline->format('M d, Y') }}</div>
                                @if ($job->deadline->isPast())
                                    <div class="text-xs text-red-500">Expired</div>
                                @else
                                    <div class="text-xs text-gray-500">{{ $job->deadline->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.jobs.show', $job) }}"
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}"
                                        class="text-yellow-600 hover:text-yellow-900 p-1 rounded" title="Edit Job">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this job?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded"
                                            title="Delete Job">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-briefcase text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg">No jobs found</p>
                                <p class="text-sm">Try adjusting your search filters or <a
                                        href="{{ route('admin.jobs.create') }}"
                                        class="text-blue-600 hover:text-blue-800">create a new job</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($jobs->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
@endsection
