@extends('layouts.admin.app')

@section('title', 'Company Settings')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Company Settings') }}</h1>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Manage company information, contact details, and downloadable resources') }}</p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg border border-green-200">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Company Information -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-building me-2 text-blue-600"></i>{{ __('Company Information') }}
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Company Name EN -->
                        <div>
                            <label for="company_name_en" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Company Name (English)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="company_name_en" name="company_name_en"
                                value="{{ old('company_name_en', $settings['company_name_en']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            @error('company_name_en')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Name AR -->
                        <div>
                            <label for="company_name_ar" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Company Name (Arabic)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="company_name_ar" name="company_name_ar"
                                value="{{ old('company_name_ar', $settings['company_name_ar']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                dir="rtl" required>
                            @error('company_name_ar')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Tagline EN -->
                        <div>
                            <label for="company_tagline_en" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Company Tagline (English)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="company_tagline_en" name="company_tagline_en"
                                value="{{ old('company_tagline_en', $settings['company_tagline_en']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            @error('company_tagline_en')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Tagline AR -->
                        <div>
                            <label for="company_tagline_ar" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Company Tagline (Arabic)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="company_tagline_ar" name="company_tagline_ar"
                                value="{{ old('company_tagline_ar', $settings['company_tagline_ar']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                dir="rtl" required>
                            @error('company_tagline_ar')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-phone me-2 text-green-600"></i>{{ __('Contact Information') }}
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Phone Number') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', $settings['phone']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="+962 6 566 2289" required>
                            @error('phone')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fax -->
                        <div>
                            <label for="fax" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Fax Number') }}
                            </label>
                            <input type="text" id="fax" name="fax" value="{{ old('fax', $settings['fax']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="+962 6 566 7289">
                            @error('fax')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Email Address') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $settings['email']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="info@hom-intl.com" required>
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Website') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="website" name="website"
                                value="{{ old('website', $settings['website']) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="www.hom-intl.com" required>
                            @error('website')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-map-marker-alt me-2 text-red-600"></i>{{ __('Address Information') }}
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Office Address EN -->
                    <div>
                        <label for="office_address_en" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Office Address (English)') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea id="office_address_en" name="office_address_en" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>{{ old('office_address_en', $settings['office_address_en']) }}</textarea>
                        @error('office_address_en')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Office Address AR -->
                    <div>
                        <label for="office_address_ar" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Office Address (Arabic)') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea id="office_address_ar" name="office_address_ar" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            dir="rtl" required>{{ old('office_address_ar', $settings['office_address_ar']) }}</textarea>
                        @error('office_address_ar')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PO Box -->
                    <div>
                        <label for="po_box" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('P.O. Box / Mail Address') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="po_box" name="po_box"
                            value="{{ old('po_box', $settings['po_box']) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="P.O.Box: 17651, Amman 11195, Jordan" required>
                        @error('po_box')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- HOM Profile PDF -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-file-pdf me-2 text-purple-600"></i>{{ __('HOM Profile PDF') }}
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="profile_pdf" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Upload Profile PDF') }}
                        </label>
                        <input type="file" id="profile_pdf" name="profile_pdf" accept="application/pdf"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        @error('profile_pdf')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">{{ __('Max size 10MB. Only PDF files are allowed.') }}</p>
                    </div>

                    @php
                        $defaultAsset = asset('assets/HOM-profile/HOM%20Profile%202023.pdf');
                        $currentUrl = $settings['hom_profile_pdf_path']
                            ? Storage::url($settings['hom_profile_pdf_path'])
                            : $defaultAsset;
                    @endphp

                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        @if ($settings['hom_profile_pdf_path'])
                            <div class="text-sm text-gray-700">
                                {{ __('Current file:') }}
                                <a class="text-blue-600 hover:underline"
                                    href="{{ Storage::url($settings['hom_profile_pdf_path']) }}" target="_blank">
                                    {{ __('View current PDF') }}
                                </a>
                            </div>
                        @else
                            <div class="text-sm text-gray-500">
                                {{ __('No file uploaded yet. The site uses the default asset.') }}
                                <a href="{{ $defaultAsset }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ __('View default PDF') }}
                                </a>
                            </div>
                        @endif
                        <a class="text-sm text-blue-600 hover:underline" href="{{ $currentUrl }}" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i>{{ __('Open in new tab') }}
                        </a>
                    </div>

                    <!-- Inline Preview -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">{{ __('Preview') }}</h3>
                        <div class="border rounded-lg overflow-hidden" style="height: 600px;">
                            <object id="pdfPreview" data="{{ $currentUrl }}" type="application/pdf"
                                class="w-full h-full">
                                <div class="p-4 text-sm text-gray-600 text-center">
                                    {{ __('Your browser may not support inline PDF preview.') }}
                                    <a href="{{ $currentUrl }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ __('Click here to open the PDF') }}
                                    </a>.
                                </div>
                            </object>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ __('Selecting a new file will update the preview before uploading.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors">
                    <i class="fas fa-save me-2"></i>{{ __('Save All Settings') }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('profile_pdf');
                const preview = document.getElementById('pdfPreview');

                input.addEventListener('change', function() {
                    if (input.files && input.files[0]) {
                        const file = input.files[0];
                        if (file.type === 'application/pdf') {
                            const url = URL.createObjectURL(file);
                            preview.setAttribute('data', url);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
