@extends('layouts.admin.app')

@section('title', 'Deleted Categories')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Deleted Categories</h1>
            <p class="text-gray-600 mt-2">Manage soft-deleted categories. You can restore or permanently delete them.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trash text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Deleted</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_deleted'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Deleted This Month</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['deleted_this_month'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.categories.deleted') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search deleted categories..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                    <a href="{{ route('admin.categories.deleted') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Deleted Categories List -->
    <div class="space-y-4">
        @forelse($deletedCategories as $category)
            <div class="bg-white rounded-lg shadow border-l-4 border-red-500">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-trash text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                    <span>{{ $category->sub_categories_count }}
                                        {{ Str::plural('subcategory', $category->sub_categories_count) }}</span>
                                    <span>•</span>
                                    <span>Deleted {{ $category->deleted_at->format('M d, Y \a\t H:i') }}</span>
                                    <span>•</span>
                                    <span>Created {{ $category->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Restore Button -->
                            <form method="POST" action="{{ route('admin.categories.restore', $category->id) }}"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-600 text-white px-3 py-2 rounded-md text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    title="Restore Category"
                                    onclick="return confirm('Are you sure you want to restore \'{{ $category->name }}\'?')">
                                    <i class="fas fa-undo mr-1"></i>Restore
                                </button>
                            </form>

                            <!-- Permanent Delete Button -->
                            <form method="POST" action="{{ route('admin.categories.force-delete', $category->id) }}"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 text-white px-3 py-2 rounded-md text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    title="Permanently Delete"
                                    onclick="return confirmPermanentDelete('{{ $category->name }}', {{ $category->sub_categories_count }})">
                                    <i class="fas fa-trash-alt mr-1"></i>Delete Forever
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-12 text-center text-gray-500">
                    <i class="fas fa-trash text-4xl mb-4 text-gray-300"></i>
                    <p class="text-lg font-medium">No deleted categories found</p>
                    <p class="text-sm mt-2">
                        @if (request()->has('search'))
                            Try adjusting your search or
                        @endif
                        <a href="{{ route('admin.categories.index') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium">go back to categories</a>
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($deletedCategories->hasPages())
        <div class="mt-6">
            {{ $deletedCategories->links('admin.partials.pagination') }}
        </div>
    @endif

    <script>
        function confirmPermanentDelete(categoryName, subCategoriesCount) {
            if (subCategoriesCount > 0) {
                return confirm(
                    `⚠️ WARNING: You are about to permanently delete "${categoryName}" and its ${subCategoriesCount} subcategory(ies). This action CANNOT be undone! Are you absolutely sure?`
                    );
            }
            return confirm(
                `⚠️ WARNING: You are about to permanently delete "${categoryName}". This action CANNOT be undone! Are you absolutely sure?`
                );
        }
    </script>
@endsection
