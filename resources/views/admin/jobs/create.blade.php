@extends('layouts.admin.app')

@section('title', 'Add New Job')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Add New Job</h1>
                <p class="mt-1 text-sm text-gray-600">Create a new job posting for the portal</p>
            </div>
            <a href="{{ route('admin.jobs.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Jobs
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.jobs.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                placeholder="e.g. Senior Frontend Developer"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name
                                *</label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}" required
                                placeholder="e.g. Tech Solutions Inc."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('company') border-red-500 @enderror">
                            @error('company')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}" required
                                placeholder="e.g. New York, NY / Remote"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category & Details -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Category & Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select id="category" name="category" required onchange="updateSubcategories()"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <label for="sub_category_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategory
                                *</label>
                            <select id="sub_category_id" name="sub_category_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sub_category_id') border-red-500 @enderror">
                                <option value="">Select Subcategory</option>
                                @if (old('sub_category_id'))
                                    @foreach ($categories as $category)
                                        @foreach ($category->subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}"
                                                {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                                                {{ $subCategory->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endif
                            </select>
                            @error('sub_category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Experience Level -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Experience Level
                                *</label>
                            <select id="level" name="level" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('level') border-red-500 @enderror">
                                <option value="">Select Level</option>
                                <option value="entry" {{ old('level') === 'entry' ? 'selected' : '' }}>Entry Level
                                </option>
                                <option value="mid" {{ old('level') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                                <option value="senior" {{ old('level') === 'senior' ? 'selected' : '' }}>Senior Level
                                </option>
                                <option value="executive" {{ old('level') === 'executive' ? 'selected' : '' }}>Executive
                                </option>
                            </select>
                            @error('level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salary -->
                        <div>
                            <label for="salary_type" class="block text-sm font-medium text-gray-700 mb-1">Salary Type
                                *</label>
                            <div class="space-y-3">
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="salary_type" value="negotiable"
                                            {{ old('salary_type', 'negotiable') == 'negotiable' ? 'checked' : '' }}
                                            class="mr-2" onchange="toggleSalaryInputCreate()">
                                        <span class="text-sm">Negotiable</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="salary_type" value="fixed"
                                            {{ old('salary_type') == 'fixed' ? 'checked' : '' }} class="mr-2"
                                            onchange="toggleSalaryInputCreate()">
                                        <span class="text-sm">Fixed Amount</span>
                                    </label>
                                </div>
                            </div>

                            <div id="salary_input_div_create"
                                class="mt-3 {{ old('salary_type') == 'fixed' ? '' : 'hidden' }}">
                                <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Annual
                                    Salary</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" id="salary" name="salary" value="{{ old('salary') }}"
                                        min="1" step="1000" placeholder="50000"
                                        class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('salary') border-red-500 @enderror">
                                </div>
                            </div>
                            @error('salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Application Deadline -->
                        <div class="md:col-span-2">
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Application
                                Deadline
                                *</label>
                            <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deadline') border-red-500 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Description</h3>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description
                            *</label>
                        <textarea id="description" name="description" rows="8" required
                            placeholder="Provide a detailed job description including responsibilities, requirements, benefits, etc."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Publication Status</h3>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="1"
                                {{ old('is_active', '1') === '1' ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Active (Visible to job seekers)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="0"
                                {{ old('is_active') === '0' ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Draft (Hidden from job seekers)</span>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.jobs.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Create Job
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Categories data for dynamic subcategory loading
        const categoriesData = @json($categories);

        function updateSubcategories() {
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('sub_category_id');
            const selectedCategoryId = categorySelect.value;

            // Clear existing subcategories
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            if (selectedCategoryId) {
                const category = categoriesData.find(cat => cat.id == selectedCategoryId);
                if (category && category.sub_categories) {
                    category.sub_categories.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.name;
                        subcategorySelect.appendChild(option);
                    });
                }
            }
        }

        // Set minimum date for deadline to tomorrow
        document.getElementById('deadline').min = new Date(Date.now() + 86400000).toISOString().split("T")[0];

        // Toggle salary input visibility for create form
        function toggleSalaryInputCreate() {
            const salaryDiv = document.getElementById('salary_input_div_create');
            const fixedRadio = document.querySelector('input[name="salary_type"][value="fixed"]');
            const salaryInput = document.getElementById('salary');

            if (fixedRadio.checked) {
                salaryDiv.classList.remove('hidden');
                salaryInput.required = true;
            } else {
                salaryDiv.classList.add('hidden');
                salaryInput.required = false;
                salaryInput.value = '';
            }
        }
    </script>

    // Toggle salary input visibility for create form
    function toggleSalaryInputCreate() {
    const salaryDiv = document.getElementById('salary_input_div_create');
    const fixedRadio = document.querySelector('input[name="salary_type"][value="fixed"]');
    const salaryInput = document.getElementById('salary');

    if (fixedRadio.checked) {
    salaryDiv.classList.remove('hidden');
    salaryInput.required = true;
    } else {
    salaryDiv.classList.add('hidden');
    salaryInput.required = false;
    salaryInput.value = '';
    }
    }
    </script>
@endsection
