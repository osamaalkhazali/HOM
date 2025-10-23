@extends('layouts.admin.app')

@section('title', 'Edit Job')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Job</h1>
                <p class="mt-1 text-sm text-gray-600">Update job posting information</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.jobs.show', $job) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-eye mr-2"></i>View Job
                </a>
                <a href="{{ route('admin.jobs.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Jobs
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.jobs.update', $job) }}" class="p-6 space-y-6">
                @csrf
                @php
                    $questionFormData = old('questions', $job->questions->map(fn($question) => [
                        'question' => $question->question,
                        'question_ar' => $question->question_ar,
                        'is_required' => $question->is_required,
                    ])->values()->toArray());

                    $documentFormData = old('documents', $job->documents->map(fn($document) => [
                        'name' => $document->name,
                        'name_ar' => $document->name_ar,
                        'is_required' => $document->is_required,
                    ])->values()->toArray());
                @endphp
                @method('PATCH')

                <!-- Basic Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}"
                                required placeholder="e.g. Senior Frontend Developer"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="title_ar" class="block text-sm font-medium text-gray-700 mb-1">Job Title (Arabic)</label>
                            <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar', $job->title_ar) }}"
                                placeholder="مثال: مطور واجهات أمامية أول" dir="rtl"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title_ar') border-red-500 @enderror">
                            @error('title_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name
                                *</label>
                            <input type="text" id="company" name="company" value="{{ old('company', $job->company) }}"
                                required placeholder="e.g. Tech Solutions Inc."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('company') border-red-500 @enderror">
                            @error('company')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="company_ar" class="block text-sm font-medium text-gray-700 mb-1">Company Name (Arabic)</label>
                            <input type="text" id="company_ar" name="company_ar" value="{{ old('company_ar', $job->company_ar) }}" dir="rtl"
                                placeholder="مثال: شركة الحلول التقنية"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('company_ar') border-red-500 @enderror">
                            @error('company_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                            <input type="text" id="location" name="location"
                                value="{{ old('location', $job->location) }}" required
                                placeholder="e.g. New York, NY / Remote"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location_ar" class="block text-sm font-medium text-gray-700 mb-1">Location (Arabic)</label>
                            <input type="text" id="location_ar" name="location_ar" value="{{ old('location_ar', $job->location_ar) }}" dir="rtl"
                                placeholder="مثال: عمّان، الأردن / عن بُعد"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location_ar') border-red-500 @enderror">
                            @error('location_ar')
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
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select id="category_id" name="category_id" required onchange="updateSubcategories()"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $job->category_id ?? ($job->subCategory ? $job->subCategory->category->id : '')) == $category->id ? 'selected' : '' }}>
                                        {{ $category->admin_label ?? $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <label for="sub_category_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategory (Optional)</label>
                            <select id="sub_category_id" name="sub_category_id" data-selected="{{ old('sub_category_id', $job->sub_category_id) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sub_category_id') border-red-500 @enderror">
                                <option value="">Select Subcategory</option>
                                @foreach ($categories as $category)
                                    @foreach ($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            {{ old('sub_category_id', $job->sub_category_id) == $subCategory->id ? 'selected' : '' }}>
                                            {{ $subCategory->name }}
                                        </option>
                                    @endforeach
                                @endforeach
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
                                <option value="entry" {{ old('level', $job->level) === 'entry' ? 'selected' : '' }}>Entry
                                    Level</option>
                                <option value="mid" {{ old('level', $job->level) === 'mid' ? 'selected' : '' }}>Mid
                                    Level</option>
                                <option value="senior" {{ old('level', $job->level) === 'senior' ? 'selected' : '' }}>
                                    Senior Level</option>
                                <option value="executive"
                                    {{ old('level', $job->level) === 'executive' ? 'selected' : '' }}>Executive</option>
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
                                            {{ (!old('salary_type') && (!$job->salary || $job->salary == 0)) || old('salary_type') == 'negotiable' ? 'checked' : '' }}
                                            class="mr-2" onchange="toggleSalaryInput()">
                                        <span class="text-sm">Negotiable</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="salary_type" value="fixed"
                                            {{ old('salary_type') == 'fixed' || (!old('salary_type') && $job->salary && $job->salary > 0) ? 'checked' : '' }}
                                            class="mr-2" onchange="toggleSalaryInput()">
                                        <span class="text-sm">Fixed Amount</span>
                                    </label>
                                </div>
                            </div>

                            <div id="salary_input_div"
                                class="mt-3 {{ (!old('salary_type') && (!$job->salary || $job->salary == 0)) || old('salary_type') == 'negotiable' ? 'hidden' : '' }}">
                                <label for="salary" class="block text-sm font-medium text-gray-700 mb-1">Annual
                                    Salary</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" id="salary" name="salary"
                                        value="{{ old('salary', $job->salary && $job->salary > 0 ? $job->salary : '') }}"
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
                            <input type="date" id="deadline" name="deadline"
                                value="{{ old('deadline', $job->deadline->format('Y-m-d')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deadline') border-red-500 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Application Questions -->
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Application Questions</h3>
                        <button type="button" onclick="addQuestionRow()" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus mr-2"></i>Add Question
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Applicants will answer these questions when applying for the job. Leave the Arabic field blank if you only need an English prompt.</p>
                    <div id="question-rows" class="space-y-4" data-count="{{ count($questionFormData) }}">
                        @foreach ($questionFormData as $index => $question)
                            <div class="question-row bg-gray-50 border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Question (English)</label>
                                        <input type="text" name="questions[{{ $index }}][question]" value="{{ $question['question'] ?? '' }}" maxlength="500"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('questions.' . $index . '.question') border-red-500 @enderror">
                                        @error('questions.' . $index . '.question')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Question (Arabic)</label>
                                        <input type="text" name="questions[{{ $index }}][question_ar]" value="{{ $question['question_ar'] ?? '' }}" maxlength="500" dir="rtl"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('questions.' . $index . '.question_ar') border-red-500 @enderror">
                                        @error('questions.' . $index . '.question_ar')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <label class="inline-flex items-center text-sm text-gray-700">
                                        <input type="hidden" name="questions[{{ $index }}][is_required]" value="0">
                                        <input type="checkbox" name="questions[{{ $index }}][is_required]" value="1" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            {{ !empty($question['is_required']) ? 'checked' : '' }}>
                                        Required
                                    </label>
                                    <button type="button" class="text-red-600 text-sm hover:text-red-800" onclick="removeQuestionRow(this)"><i class="fas fa-times mr-1"></i>Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Questions marked as required must be answered before the application can be submitted.</p>
                </div>

                <!-- Required Documents -->
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Required Documents</h3>
                        <button type="button" onclick="addDocumentRow()" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus mr-2"></i>Add Document
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Specify any additional documents applicants must upload (e.g., certificates, portfolios). Applicants will see these during the application process.</p>
                    <div id="document-rows" class="space-y-4" data-count="{{ count($documentFormData) }}">
                        @foreach ($documentFormData as $index => $document)
                            <div class="document-row bg-gray-50 border border-gray-200 rounded-lg p-4" data-index="{{ $index }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (English)</label>
                                        <input type="text" name="documents[{{ $index }}][name]" value="{{ $document['name'] ?? '' }}" maxlength="255"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('documents.' . $index . '.name') border-red-500 @enderror">
                                        @error('documents.' . $index . '.name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (Arabic)</label>
                                        <input type="text" name="documents[{{ $index }}][name_ar]" value="{{ $document['name_ar'] ?? '' }}" maxlength="255" dir="rtl"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('documents.' . $index . '.name_ar') border-red-500 @enderror">
                                        @error('documents.' . $index . '.name_ar')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <label class="inline-flex items-center text-sm text-gray-700">
                                        <input type="hidden" name="documents[{{ $index }}][is_required]" value="0">
                                        <input type="checkbox" name="documents[{{ $index }}][is_required]" value="1" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            {{ !empty($document['is_required']) ? 'checked' : '' }}>
                                        Required
                                    </label>
                                    <button type="button" class="text-red-600 text-sm hover:text-red-800" onclick="removeDocumentRow(this)"><i class="fas fa-times mr-1"></i>Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Applicants will be prevented from submitting their application until all required documents are attached.</p>
                </div>

                <!-- Job Description -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Description</h3>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description
                            *</label>
                        <textarea id="description" name="description" rows="8" required
                            placeholder="Provide a detailed job description including responsibilities, requirements, benefits, etc."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $job->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-1">Description (Arabic)</label>
                        <textarea id="description_ar" name="description_ar" rows="8" dir="rtl"
                            placeholder="اكتب وصف الوظيفة باللغة العربية متضمناً المسؤوليات والمتطلبات والمزايا وغيرها."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description_ar') border-red-500 @enderror">{{ old('description_ar', $job->description_ar) }}</textarea>
                        @error('description_ar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Status</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="active"
                                {{ old('status', $job->status) === 'active' ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Active (Visible and accepting applications)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status', $job->status) === 'inactive' ? 'checked' : '' }}
                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Inactive (Visible but not accepting applications)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="draft"
                                {{ old('status', $job->status) === 'draft' ? 'checked' : '' }}
                                class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Draft (Hidden from job seekers)</span>
                        </label>
                    </div>
                </div>

                <!-- Current Information -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-gray-400 mt-0.5 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-gray-800">Current Information</h4>
                            <div class="mt-2 text-sm text-gray-600 space-y-1">
                                <p><strong>Created:</strong> {{ $job->created_at->format('F d, Y \a\t H:i') }}</p>
                                <p><strong>Last Updated:</strong> {{ $job->updated_at->format('F d, Y \a\t H:i') }}</p>
                                <p><strong>Posted By:</strong> {{ $job->postedBy->name }}</p>
                                <p><strong>Applications:</strong> {{ $job->applications->count() }} received</p>
                                <p><strong>Current Status:</strong>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($job->status === 'active') bg-green-100 text-green-800
                                    @elseif($job->status === 'inactive') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.jobs.show', $job) }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Job
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const categoriesData = @json($categories);
        const questionRowsContainer = document.getElementById('question-rows');
        const documentRowsContainer = document.getElementById('document-rows');
        let questionIndex = questionRowsContainer ? questionRowsContainer.querySelectorAll('.question-row').length : 0;
        let documentIndex = documentRowsContainer ? documentRowsContainer.querySelectorAll('.document-row').length : 0;

        function createEl(tag, attrs = {}, children = []) {
            const el = document.createElement(tag);
            Object.entries(attrs).forEach(([key, value]) => {
                if (value === null || value === undefined) return;
                if (key === 'class') el.className = value;
                else if (key === 'text') el.textContent = value;
                else if (key === 'html') el.innerHTML = value;
                else if (key === 'value') el.value = value;
                else if (key === 'checked') el.checked = Boolean(value);
                else el.setAttribute(key, value);
            });
            children.forEach(child => el.appendChild(child));
            return el;
        }

        function buildQuestionRow(index, data = {}) {
            const row = createEl('div', {
                class: 'question-row bg-gray-50 border border-gray-200 rounded-lg p-4',
            });
            row.dataset.index = index;

            const grid = createEl('div', { class: 'grid grid-cols-1 md:grid-cols-2 gap-4' }, [
                createEl('div', {}, [
                    createEl('label', { class: 'block text-sm font-medium text-gray-700 mb-1', text: 'Question (English)' }),
                    createEl('input', {
                        class: 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                        type: 'text',
                        name: `questions[${index}][question]`,
                        maxlength: '500',
                        value: data.question || '',
                    }),
                ]),
                createEl('div', {}, [
                    createEl('label', { class: 'block text-sm font-medium text-gray-700 mb-1', text: 'Question (Arabic)' }),
                    createEl('input', {
                        class: 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                        type: 'text',
                        name: `questions[${index}][question_ar]`,
                        maxlength: '500',
                        dir: 'rtl',
                        value: data.question_ar || '',
                    }),
                ]),
            ]);

            const controls = createEl('div', { class: 'flex items-center justify-between mt-4' });
            const requiredWrapper = createEl('label', { class: 'inline-flex items-center text-sm text-gray-700' }, [
                createEl('input', {
                    type: 'hidden',
                    name: `questions[${index}][is_required]`,
                    value: '0',
                }),
            ]);
            const checkbox = createEl('input', {
                type: 'checkbox',
                name: `questions[${index}][is_required]`,
                value: '1',
                class: 'mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500',
            });
            checkbox.checked = data.is_required === undefined ? true : Boolean(data.is_required);
            requiredWrapper.appendChild(checkbox);
            requiredWrapper.appendChild(createEl('span', { text: 'Required' }));

            const removeBtn = createEl('button', {
                type: 'button',
                class: 'text-red-600 text-sm hover:text-red-800',
                html: '<i class="fas fa-times mr-1"></i>Remove',
            });
            removeBtn.addEventListener('click', () => row.remove());

            controls.appendChild(requiredWrapper);
            controls.appendChild(removeBtn);

            row.appendChild(grid);
            row.appendChild(controls);
            return row;
        }

        function addQuestionRow(prefill = {}) {
            if (!questionRowsContainer) return;
            const row = buildQuestionRow(questionIndex++, prefill);
            questionRowsContainer.appendChild(row);
        }

        function buildDocumentRow(index, data = {}) {
            const row = createEl('div', {
                class: 'document-row bg-gray-50 border border-gray-200 rounded-lg p-4',
            });
            row.dataset.index = index;

            const grid = createEl('div', { class: 'grid grid-cols-1 md:grid-cols-2 gap-4' }, [
                createEl('div', {}, [
                    createEl('label', { class: 'block text-sm font-medium text-gray-700 mb-1', text: 'Document Name (English)' }),
                    createEl('input', {
                        class: 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                        type: 'text',
                        name: `documents[${index}][name]`,
                        maxlength: '255',
                        value: data.name || '',
                    }),
                ]),
                createEl('div', {}, [
                    createEl('label', { class: 'block text-sm font-medium text-gray-700 mb-1', text: 'Document Name (Arabic)' }),
                    createEl('input', {
                        class: 'w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                        type: 'text',
                        name: `documents[${index}][name_ar]`,
                        maxlength: '255',
                        dir: 'rtl',
                        value: data.name_ar || '',
                    }),
                ]),
            ]);

            const controls = createEl('div', { class: 'flex items-center justify-between mt-4' });
            const requiredWrapper = createEl('label', { class: 'inline-flex items-center text-sm text-gray-700' }, [
                createEl('input', {
                    type: 'hidden',
                    name: `documents[${index}][is_required]`,
                    value: '0',
                }),
            ]);
            const checkbox = createEl('input', {
                type: 'checkbox',
                name: `documents[${index}][is_required]`,
                value: '1',
                class: 'mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500',
            });
            checkbox.checked = Boolean(data.is_required);
            requiredWrapper.appendChild(checkbox);
            requiredWrapper.appendChild(createEl('span', { text: 'Required' }));

            const removeBtn = createEl('button', {
                type: 'button',
                class: 'text-red-600 text-sm hover:text-red-800',
                html: '<i class="fas fa-times mr-1"></i>Remove',
            });
            removeBtn.addEventListener('click', () => row.remove());

            controls.appendChild(requiredWrapper);
            controls.appendChild(removeBtn);

            row.appendChild(grid);
            row.appendChild(controls);
            return row;
        }

        function addDocumentRow(prefill = {}) {
            if (!documentRowsContainer) return;
            const row = buildDocumentRow(documentIndex++, prefill);
            documentRowsContainer.appendChild(row);
        }

        function updateSubcategories() {
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('sub_category_id');
            if (!categorySelect || !subcategorySelect) return;

            const selectedCategoryId = categorySelect.value;
            const preselected = subcategorySelect.dataset.selected || '';
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            if (selectedCategoryId) {
                const category = categoriesData.find(cat => String(cat.id) === String(selectedCategoryId));
                if (category && Array.isArray(category.sub_categories) && category.sub_categories.length) {
                    category.sub_categories.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.admin_label ?? subcat.name;
                        if (preselected && String(preselected) === String(subcat.id)) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No subcategories available';
                    option.disabled = true;
                    subcategorySelect.appendChild(option);
                }
            }

            subcategorySelect.dataset.selected = '';
        }

        window.addQuestionRow = addQuestionRow;
        window.addDocumentRow = addDocumentRow;
        window.removeQuestionRow = (trigger) => {
            const row = trigger.closest('.question-row');
            if (row) row.remove();
        };
        window.removeDocumentRow = (trigger) => {
            const row = trigger.closest('.document-row');
            if (row) row.remove();
        };
        window.updateSubcategories = updateSubcategories;

        function toggleSalaryInput() {
            const salaryDiv = document.getElementById('salary_input_div');
            const salaryInput = document.getElementById('salary');
            const fixedRadio = document.querySelector('input[name="salary_type"][value="fixed"]');
            if (!salaryDiv || !salaryInput || !fixedRadio) return;

            if (fixedRadio.checked) {
                salaryDiv.classList.remove('hidden');
                salaryInput.required = true;
            } else {
                salaryDiv.classList.add('hidden');
                salaryInput.required = false;
                salaryInput.value = '';
            }
        }

        function setDeadlineMin() {
            const deadlineInput = document.getElementById('deadline');
            if (deadlineInput) {
                deadlineInput.min = new Date(Date.now() + 86400000).toISOString().split('T')[0];
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            setDeadlineMin();
            updateSubcategories();

            if (questionRowsContainer && questionRowsContainer.querySelectorAll('.question-row').length === 0) {
                addQuestionRow({ is_required: true });
            }

            if (documentRowsContainer && documentRowsContainer.querySelectorAll('.document-row').length === 0) {
                addDocumentRow({ is_required: false });
            }

            document.querySelectorAll('input[name="salary_type"]').forEach(radio => {
                radio.addEventListener('change', toggleSalaryInput);
            });
            toggleSalaryInput();
        });
    </script>
@endsection
