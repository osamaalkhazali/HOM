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
                @php
                    $questionFormData = old('questions', []);
                    $documentFormData = old('documents', []);
                @endphp

                <!-- Basic Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Job Title (English) *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                placeholder="e.g. Senior Frontend Developer"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="title_ar" class="block text-sm font-medium text-gray-700 mb-1">Job Title (Arabic)</label>
                            <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar') }}"
                                placeholder="مثال: مطور واجهات أمامية أول" dir="rtl"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title_ar') border-red-500 @enderror">
                            @error('title_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company Name (English) *</label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}" required
                                placeholder="e.g. Tech Solutions Inc."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('company') border-red-500 @enderror">
                            @error('company')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="company_ar" class="block text-sm font-medium text-gray-700 mb-1">Company Name (Arabic)</label>
                            <input type="text" id="company_ar" name="company_ar" value="{{ old('company_ar') }}" dir="rtl"
                                placeholder="مثال: شركة الحلول التقنية"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('company_ar') border-red-500 @enderror">
                            @error('company_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location (English) *</label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}" required
                                placeholder="e.g. New York, NY / Remote"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location_ar" class="block text-sm font-medium text-gray-700 mb-1">Location (Arabic)</label>
                            <input type="text" id="location_ar" name="location_ar" value="{{ old('location_ar') }}" dir="rtl"
                                placeholder="مثال: نيويورك، نيويورك / عن بُعد"
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
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->admin_label ?: $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <label for="sub_category_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategory
                                <span class="text-gray-400">(Optional)</span></label>
                            <select id="sub_category_id" name="sub_category_id" data-selected="{{ old('sub_category_id') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sub_category_id') border-red-500 @enderror">
                                <option value="">No Subcategory</option>
                                @if (old('sub_category_id'))
                                    @foreach ($categories as $category)
                                        @foreach ($category->subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}"
                                                {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                                                {{ $subCategory->admin_label ?: $subCategory->name }}
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
                                @foreach (['entry', 'mid', 'senior', 'executive'] as $levelKey)
                                    <option value="{{ $levelKey }}" {{ old('level') === $levelKey ? 'selected' : '' }}>
                                        {{ trans('site.jobs.levels.' . $levelKey, [], 'en') }}
                                        ({{ trans('site.jobs.levels.' . $levelKey, [], 'ar') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('level')
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
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (English)
                                *</label>
                            <textarea id="description" name="description" rows="8" required
                                placeholder="Provide a detailed job description including responsibilities, requirements, benefits, etc."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-1">Description (Arabic)</label>
                            <textarea id="description_ar" name="description_ar" rows="8" dir="rtl"
                                placeholder="اكتب وصفاً تفصيلياً للوظيفة يتضمن المسؤوليات والمتطلبات والمزايا وغير ذلك."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description_ar') border-red-500 @enderror">{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Publication Status</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Status</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="active"
                                {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Active (Visible and accepting applications)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status') === 'inactive' ? 'checked' : '' }}
                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Inactive (Visible but not accepting applications)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="draft"
                                {{ old('status') === 'draft' ? 'checked' : '' }}
                                class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Draft (Hidden from job seekers)</span>
                        </label>
                    </div>
                </div>
                </div>

                                <template id="question-template">
                    <div class="question-row bg-gray-50 border border-gray-200 rounded-lg p-4" data-index="__INDEX__">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Question (English)</label>
                                <input type="text" name="questions[__INDEX__][question]" maxlength="500"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Question (Arabic)</label>
                                <input type="text" name="questions[__INDEX__][question_ar]" maxlength="500" dir="rtl"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <label class="inline-flex items-center text-sm text-gray-700">
                                <input type="hidden" name="questions[__INDEX__][is_required]" value="0">
                                <input type="checkbox" name="questions[__INDEX__][is_required]" value="1" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500" __CHECKED__>
                                Required
                            </label>
                            <button type="button" class="text-red-600 text-sm hover:text-red-800" onclick="removeQuestionRow(this)"><i class="fas fa-times mr-1"></i>Remove</button>
                        </div>
                    </div>
                </template>

                <template id="document-template">
                    <div class="document-row bg-gray-50 border border-gray-200 rounded-lg p-4" data-index="__INDEX__">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (English)</label>
                                <input type="text" name="documents[__INDEX__][name]" maxlength="255"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (Arabic)</label>
                                <input type="text" name="documents[__INDEX__][name_ar]" maxlength="255" dir="rtl"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <label class="inline-flex items-center text-sm text-gray-700">
                                <input type="hidden" name="documents[__INDEX__][is_required]" value="0">
                                <input type="checkbox" name="documents[__INDEX__][is_required]" value="1" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500" __CHECKED__>
                                Required
                            </label>
                            <button type="button" class="text-red-600 text-sm hover:text-red-800" onclick="removeDocumentRow(this)"><i class="fas fa-times mr-1"></i>Remove</button>
                        </div>
                    </div>
                </template>

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
            subcategorySelect.innerHTML = '<option value="">No Subcategory</option>';

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







