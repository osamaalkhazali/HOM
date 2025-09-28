@extends('layouts.admin.app')

@section('title', 'Category Management')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Category Management</h1>
            <p class="text-gray-600 mt-2">Manage job categories and their subcategories.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.deleted') }}"
                class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                <i class="fas fa-trash mr-2"></i>Deleted Categories
            </a>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="fas fa-plus mr-2"></i>Add Category/Subcategory
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Categories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-layer-group text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Subcategories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_subcategories'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-briefcase text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Categories with Jobs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['categories_with_jobs'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-center space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search categories or subcategories..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Actions -->
                <div class="flex space-x-3">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="space-y-6">
        @forelse($categories as $category)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Category Header -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-tags text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                    <span>{{ $category->sub_categories_count }}
                                        {{ Str::plural('subcategory', $category->sub_categories_count) }}</span>
                                    <span>•</span>
                                    <span>Created {{ $category->created_at->format('M d, Y') }}</span>
                                    @php
                                        $totalJobs = isset($subCategories[$category->id])
                                            ? $subCategories[$category->id]->sum('jobs_count')
                                            : 0;
                                    @endphp
                                    @if ($totalJobs > 0)
                                        <span>•</span>
                                        <span class="text-blue-600 font-medium">{{ $totalJobs }}
                                            {{ Str::plural('job', $totalJobs) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="text-yellow-600 hover:text-yellow-900 p-2 rounded" title="Edit Category">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline"
                                onsubmit="return confirmDelete('{{ $category->name }}', {{ $totalJobs }})">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded"
                                    title="Delete Category">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Subcategories -->
                @if (isset($subCategories[$category->id]) && $subCategories[$category->id]->count() > 0)
                    <div class="px-6 py-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Subcategories:</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach ($subCategories[$category->id] as $subCategory)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-layer-group text-gray-400 mr-2"></i>
                                        <span class="text-sm text-gray-900 font-medium">{{ $subCategory->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if ($subCategory->jobs_count > 0)
                                            <span
                                                class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">
                                                {{ $subCategory->jobs_count }}
                                                {{ Str::plural('job', $subCategory->jobs_count) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">No jobs</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-500 italic flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            No subcategories yet. <a href="{{ route('admin.categories.create') }}"
                                class="text-blue-600 hover:text-blue-800 ml-1">Add some subcategories</a>
                        </p>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-12 text-center text-gray-500">
                    <i class="fas fa-tags text-4xl mb-4 text-gray-300"></i>
                    <p class="text-lg font-medium">No categories found</p>
                    <p class="text-sm mt-2">
                        @if (request()->has('search'))
                            Try adjusting your search or
                        @endif
                        <a href="{{ route('admin.categories.create') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium">create a new category</a>
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links('admin.partials.pagination') }}
        </div>
    @endif

    <script>
        // Simple confirmation dialog
        function confirmDelete(categoryName, jobCount) {
            if (jobCount > 0) {
                return confirm(
                    `Are you sure you want to delete "${categoryName}"? This category has ${jobCount} job(s) that will need to be moved or deleted first.`
                    );
            }
            return confirm(
                `Are you sure you want to delete "${categoryName}"? This will also delete all its subcategories.`);
        }
    </script>
@endsection
