@extends('layouts.admin.app')

@section('title', 'Deleted Jobs')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Deleted Jobs</h1>
                <p class="mt-1 text-sm text-gray-600">Manage deleted job postings - restore or permanently delete</p>
            </div>
            <div class="flex space-x-3">
                @if ($jobs->total() > 0)
                    <form method="POST" action="{{ route('admin.jobs.restore-all') }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Are you sure you want to restore all deleted jobs?')"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-undo mr-2"></i>Restore All
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.jobs.force-delete-all') }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to permanently delete all jobs? This action cannot be undone!')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>Delete All Permanently
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.jobs.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Jobs
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <i class="fas fa-trash text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Deleted Jobs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $jobs->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-calendar text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Recently Deleted</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Job::onlyTrashed()->where('deleted_at', '>=', now()->subDays(7))->count() }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Applications Affected</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $jobs->sum(function ($job) {return $job->applications->count();}) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow">
            <form method="GET" action="{{ route('admin.jobs.deleted') }}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Search by title, company, location..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" name="category"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
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
                        <a href="{{ route('admin.jobs.deleted') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Deleted Jobs Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Deleted Jobs</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select onchange="window.location.href=this.value"
                            class="border border-gray-300 rounded px-2 py-1 text-sm">
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort' => 'deleted_at', 'direction' => 'desc']) }}"
                                {{ request('sort') === 'deleted_at' && request('direction') === 'desc' ? 'selected' : '' }}>
                                Recently Deleted
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort' => 'deleted_at', 'direction' => 'asc']) }}"
                                {{ request('sort') === 'deleted_at' && request('direction') === 'asc' ? 'selected' : '' }}>
                                Oldest Deleted
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => 'asc']) }}"
                                {{ request('sort') === 'title' && request('direction') === 'asc' ? 'selected' : '' }}>
                                Title A-Z
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'company', 'direction' => 'asc']) }}"
                                {{ request('sort') === 'company' && request('direction') === 'asc' ? 'selected' : '' }}>
                                Company A-Z
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            @if ($jobs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Job Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Applications</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deleted</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($jobs as $job)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                                    <i class="fas fa-briefcase text-red-600"></i>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $job->title }}</p>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                        Deleted
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500">{{ $job->company }}</p>
                                                <div class="flex items-center space-x-4 mt-1">
                                                    <span class="text-xs text-gray-500">
                                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        <i
                                                            class="fas fa-dollar-sign mr-1"></i>${{ number_format($job->salary) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        <i class="fas fa-layer-group mr-1"></i>{{ ucfirst($job->level) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $job->category->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $job->subCategory->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $job->applications->count() }}</span>
                                            @if ($job->applications->count() > 0)
                                                <span
                                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>Orphaned
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>{{ $job->deleted_at->format('M d, Y') }}</div>
                                        <div class="text-xs">{{ $job->deleted_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Restore Job -->
                                            <form method="POST" action="{{ route('admin.jobs.restore', $job->id) }}"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to restore this job?')"
                                                    class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-2 py-1 rounded"
                                                    title="Restore Job">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>

                                            <!-- Permanently Delete -->
                                            <form method="POST"
                                                action="{{ route('admin.jobs.force-delete', $job->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to permanently delete this job? This action cannot be undone!')"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded"
                                                    title="Delete Permanently">
                                                    <i class="fas fa-trash-alt"></i>
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
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-trash text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No deleted jobs found</h3>
                    <p class="text-gray-500 mb-4">
                        @if (request()->has('search') || request()->has('category'))
                            No deleted jobs match your current filters.
                        @else
                            There are no deleted jobs at the moment.
                        @endif
                    </p>
                    <a href="{{ route('admin.jobs.index') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Jobs
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if ($jobs->total() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-exclamation-triangle text-yellow-400 mt-0.5 mr-3"></i>
                <div>
                    <h4 class="text-sm font-medium text-yellow-800">Important Information</h4>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Restore:</strong> Restored jobs will become active again and visible to job seekers.
                            </li>
                            <li><strong>Permanent Delete:</strong> This action cannot be undone and will remove all
                                associated data.</li>
                            <li><strong>Applications:</strong> Deleted jobs with applications will leave those applications
                                orphaned until the job is restored.</li>
                            <li><strong>Auto-cleanup:</strong> Jobs deleted more than 90 days ago may be automatically
                                purged.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
