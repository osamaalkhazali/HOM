@extends('layouts.admin.app')

@section('title', 'Edit Category')

@section('content')
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
            <p class="text-gray-600 mt-2">Update "{{ $category->name }}" category and its subcategories.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6">
            @csrf
            @method('PATCH')

            <!-- Category Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="e.g., Technology, Healthcare, Finance">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Manage All Subcategories -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Manage Subcategories
                        @if ($category->subCategories->count() > 0)
                            <span class="text-sm text-gray-500 font-normal">({{ $category->subCategories->count() }}
                                subcategories)</span>
                        @endif
                    </label>
                    <button type="button" onclick="addNewSubcategory()"
                        class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                        <i class="fas fa-plus mr-1"></i>Add New Subcategory
                    </button>
                </div>

                <div id="subcategories-container" class="space-y-3">
                    @if ($category->subCategories->count() > 0)
                        @foreach ($category->subCategories as $index => $subCategory)
                            @php $jobCount = $subCategory->jobs->count(); @endphp
                            <div
                                class="existing-subcategory-item flex items-start gap-2 p-3 bg-gray-50 rounded-lg border">
                                <!-- Hidden ID for existing subcategories -->
                                <input type="hidden" name="existing_subcategories[{{ $index }}][id]"
                                    value="{{ $subCategory->id }}">

                                <!-- Editable name fields -->
                                <div class="flex-1">
                                    <input type="text" name="existing_subcategories[{{ $index }}][name]"
                                        value="{{ old('existing_subcategories.' . $index . '.name', $subCategory->name) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Subcategory name (EN)">
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="existing_subcategories[{{ $index }}][name_ar]"
                                        value="{{ old('existing_subcategories.' . $index . '.name_ar', $subCategory->name_ar) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Arabic name (optional)">
                                </div>

                                <!-- Job count indicator -->
                                <div class="flex items-center space-x-2">
                                    @if ($jobCount > 0)
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">
                                            {{ $jobCount }} {{ Str::plural('job', $jobCount) }}
                                        </span>
                                        <i class="fas fa-edit text-blue-600" title="Editable - Jobs will remain linked"></i>
                                    @else
                                        <span class="text-xs text-gray-500">No jobs</span>
                                        <i class="fas fa-edit text-green-600" title="Editable - Safe to modify"></i>
                                    @endif
                                </div>

                                <!-- Delete button -->
                                <button type="button" onclick="removeExistingSubcategory(this, {{ $jobCount }})"
                                    class="text-red-600 hover:text-red-800 p-2 rounded"
                                    title="{{ $jobCount > 0 ? 'Cannot delete - has jobs' : 'Delete subcategory' }}"
                                    {{ $jobCount > 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif

                    <!-- New subcategories will be added here -->
                </div>

                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                        <div class="text-xs text-blue-800">
                            <p class="font-medium mb-1">Editing subcategories:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>With jobs:</strong> Name can be changed, jobs will remain linked</li>
                                <li><strong>Without jobs:</strong> Name can be changed or subcategory can be deleted</li>
                                <li><strong>New subcategories:</strong> Can be added and removed freely</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Update Category
                </button>
            </div>
        </form>
    </div>

    <script>
        let newSubcategoryIndex = 0;

        function openHomConfirmModal(config = {}) {
            if (window.homConfirm && typeof window.homConfirm.open === 'function') {
                return window.homConfirm.open(config);
            }

            console.warn('Confirmation modal is not available.');
            return Promise.resolve();
        }

        function confirmWithModal(message, options = {}) {
            return openHomConfirmModal({
                title: options.title || 'Please Confirm',
                message,
                confirmText: options.confirmText || 'Confirm',
                cancelText: options.cancelText || 'Cancel',
                hideCancel: Boolean(options.hideCancel),
                variant: options.variant || 'danger',
            });
        }

        function showInfoModal(message, options = {}) {
            return openHomConfirmModal({
                title: options.title || 'Notice',
                message,
                confirmText: options.confirmText || 'Got it',
                hideCancel: true,
                variant: options.variant || 'info',
            }).catch(() => undefined);
        }

        function addNewSubcategory() {
            const container = document.getElementById('subcategories-container');
            const newItem = document.createElement('div');
            newItem.className =
                'new-subcategory-item flex items-center gap-2 p-3 bg-green-50 rounded-lg border border-green-200';
            newItem.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="new_subcategories[]"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Subcategory name (EN)">
                </div>
                <div class="flex-1">
                    <input type="text" name="new_subcategories_ar[]"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Arabic name (optional)">
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-green-700 bg-green-100 px-2 py-1 rounded-full">New</span>
                </div>
                <button type="button" onclick="removeNewSubcategory(this)"
                    class="text-red-600 hover:text-red-800 p-2 rounded">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            newItem.querySelector('input[name="new_subcategories[]"]').focus();
            newSubcategoryIndex++;
        }

        function removeNewSubcategory(button) {
            button.closest('.new-subcategory-item').remove();
        }

        function removeExistingSubcategory(button, jobCount) {
            if (jobCount > 0) {
                showInfoModal('Cannot delete subcategory with existing jobs. Please move or delete the jobs first.', {
                    variant: 'warning',
                    confirmText: 'Understood',
                });
                return;
            }

            confirmWithModal('Are you sure you want to delete this subcategory?', {
                confirmText: 'Delete',
                cancelText: 'Cancel',
                variant: 'danger',
            })
                .then(() => {
                    const item = button.closest('.existing-subcategory-item');
                    if (!item) {
                        return;
                    }

                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_subcategories[]';
                    deleteInput.value = item.querySelector('input[name*="[id]"]').value;
                    item.appendChild(deleteInput);

                    item.style.display = 'none';
                    item.style.opacity = '0.5';

                    const deletionIndicator = document.createElement('div');
                    deletionIndicator.className = 'text-xs text-red-600 bg-red-100 px-2 py-1 rounded mb-2';
                    deletionIndicator.innerHTML = '<i class="fas fa-trash mr-1"></i>Marked for deletion';
                    item.parentNode.insertBefore(deletionIndicator, item);
                })
                .catch(() => undefined);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('subcategories-container');
            const hasExisting = container.querySelector('.existing-subcategory-item');
            if (!hasExisting) {
                addNewSubcategory();
            }
        });
    </script>
@endsection










