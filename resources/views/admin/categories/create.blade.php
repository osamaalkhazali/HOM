@extends('layouts.admin.app')

@section('title', 'Add Category & Subcategories')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add Category & Subcategories</h1>
            <p class="text-gray-600 mt-2">Create a new category or add subcategories to existing ones.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}"
            class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i>Back to Categories
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Option 1: Create New Category -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                <h2 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-plus-circle text-green-600 mr-2"></i>
                    Create New Category
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add a brand new category with subcategories</p>
            </div>

            <form method="POST" action="{{ route('admin.categories.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="action" value="new_category">

                <!-- New Category Name -->
                <div class="mb-6">
                    <label for="new_category_name" class="block text-sm font-medium text-gray-700 mb-2">
                        New Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="new_category_name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., Technology, Healthcare, Finance">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subcategories for New Category -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Subcategories
                        </label>
                        <button type="button" onclick="addNewCategorySubcategory()"
                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                            <i class="fas fa-plus mr-1"></i>Add Subcategory
                        </button>
                    </div>

                    <div id="new-category-subcategories" class="space-y-3">
                        <div class="subcategory-item flex items-center space-x-2">
                            <input type="text" name="subcategories[]"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Subcategory name">
                            <button type="button" onclick="removeSubcategory(this)"
                                class="text-red-600 hover:text-red-800 p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-save mr-2"></i>Create New Category
                </button>
            </form>
        </div>

        <!-- Option 2: Add to Existing Category -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                <h2 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-layer-group text-blue-600 mr-2"></i>
                    Add to Existing Category
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add subcategories to an existing category</p>
            </div>

            <form method="POST" action="{{ route('admin.categories.add-subcategories') }}" class="p-6">
                @csrf

                <!-- Select Existing Category -->
                <div class="mb-6">
                    <label for="existing_category" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="existing_category" required
                        onchange="loadExistingSubcategories(this.value)"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a category...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }} ({{ $category->sub_categories_count }} subcategories)
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Show Existing Subcategories -->
                <div id="existing-subcategories" class="mb-6 hidden">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Current Subcategories:</h4>
                    <div id="existing-subcategories-list" class="bg-gray-50 rounded-lg p-3 mb-4">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>

                <!-- New Subcategories to Add -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            New Subcategories to Add
                        </label>
                        <button type="button" onclick="addExistingCategorySubcategory()"
                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                            <i class="fas fa-plus mr-1"></i>Add Subcategory
                        </button>
                    </div>

                    <div id="existing-category-subcategories" class="space-y-3">
                        <div class="subcategory-item flex items-center space-x-2">
                            <input type="text" name="new_subcategories[]"
                                class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="New subcategory name">
                            <button type="button" onclick="removeSubcategory(this)"
                                class="text-red-600 hover:text-red-800 p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>Add Subcategories
                </button>
            </form>
        </div>
    </div>

    <script>
        // Add subcategory for new category
        function addNewCategorySubcategory() {
            const container = document.getElementById('new-category-subcategories');
            const newItem = document.createElement('div');
            newItem.className = 'subcategory-item flex items-center space-x-2';
            newItem.innerHTML = `
                <input type="text" name="subcategories[]"
                    class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Subcategory name">
                <button type="button" onclick="removeSubcategory(this)"
                    class="text-red-600 hover:text-red-800 p-2">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            newItem.querySelector('input').focus();
        }

        // Add subcategory for existing category
        function addExistingCategorySubcategory() {
            const container = document.getElementById('existing-category-subcategories');
            const newItem = document.createElement('div');
            newItem.className = 'subcategory-item flex items-center space-x-2';
            newItem.innerHTML = `
                <input type="text" name="new_subcategories[]"
                    class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="New subcategory name">
                <button type="button" onclick="removeSubcategory(this)"
                    class="text-red-600 hover:text-red-800 p-2">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            newItem.querySelector('input').focus();
        }

        // Remove subcategory
        function removeSubcategory(button) {
            const container = button.closest('.subcategory-item').parentNode;
            if (container.children.length > 1) {
                button.closest('.subcategory-item').remove();
            }
        }

        // Load existing subcategories when category is selected
        function loadExistingSubcategories(categoryId) {
            const existingDiv = document.getElementById('existing-subcategories');
            const listDiv = document.getElementById('existing-subcategories-list');

            if (!categoryId) {
                existingDiv.classList.add('hidden');
                return;
            }

            // Show loading
            listDiv.innerHTML = '<p class="text-sm text-gray-500">Loading...</p>';
            existingDiv.classList.remove('hidden');

            // Fetch subcategories (you can replace this with actual API call)
            fetch(`/admin/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    if (data.subcategories && data.subcategories.length > 0) {
                        let html = '<div class="flex flex-wrap gap-2">';
                        data.subcategories.forEach(sub => {
                            html += `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                ${sub.name}
                                ${sub.jobs_count > 0 ? ` (${sub.jobs_count} jobs)` : ''}
                            </span>`;
                        });
                        html += '</div>';
                        listDiv.innerHTML = html;
                    } else {
                        listDiv.innerHTML = '<p class="text-sm text-gray-500 italic">No subcategories yet.</p>';
                    }
                })
                .catch(error => {
                    listDiv.innerHTML = '<p class="text-sm text-red-500">Error loading subcategories.</p>';
                });
        }
    </script>
@endsection
