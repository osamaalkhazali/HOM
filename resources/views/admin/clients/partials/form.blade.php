@php($isEdit = isset($client) && $client)

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Client Name<span
                    class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $client->name ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                required maxlength="255">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $client->slug ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                maxlength="255" placeholder="Auto-generated from the name if left blank">
            <p class="mt-1 text-xs text-gray-500">Lowercase letters, numbers, and hyphens only.</p>
            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="website_url" class="block text-sm font-medium text-gray-700">Website URL</label>
            <input type="url" name="website_url" id="website_url"
                value="{{ old('website_url', $client->website_url ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                maxlength="255" placeholder="https://example.com">
            @error('website_url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center space-x-3">
            <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-gray-500">Inactive clients are hidden from the public site.</span>
            @error('is_active')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="6"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $client->description ?? '') }}</textarea>
            <p class="mt-1 text-xs text-gray-500">Optional description to feature alongside the client in marketing
                material.</p>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
            <input type="file" name="logo" id="logo"
                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                accept=".jpg,.jpeg,.png,.webp,.svg">
            <p class="mt-1 text-xs text-gray-500">Accepted formats: JPG, PNG, WebP, or SVG (max 2MB).</p>
            @error('logo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($isEdit && $client->logo_url)
                <div class="mt-4 p-4 border border-gray-200 rounded-md bg-gray-50">
                    <p class="text-sm font-medium text-gray-700 mb-2">Current logo</p>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $client->logo_url }}" alt="{{ $client->name }} logo" class="h-16 object-contain">
                        <label class="inline-flex items-center text-sm text-gray-600">
                            <input type="checkbox" name="remove_logo" value="1"
                                class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="ml-2">Remove logo</span>
                        </label>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="mt-8 flex justify-end space-x-3">
    <a href="{{ route('admin.clients.index') }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
        Cancel
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        {{ $submitLabel ?? ($isEdit ? 'Update Client' : 'Create Client') }}
    </button>
</div>
