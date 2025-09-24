@extends('layouts.admin.app')

@section('title', 'HOM Profile PDF')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">HOM Profile PDF</h1>
            <p class="mt-1 text-sm text-gray-600">Upload or replace the downloadable HOM Profile PDF shown on the landing
                page.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            @php
                $defaultAsset = asset('assets/HOM-profile/HOM%20Profile%202023.pdf');
                $currentUrl = $path ? Storage::url($path) : $defaultAsset;
            @endphp
            <form method="POST" action="{{ route('admin.settings.hom-profile.update') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label for="profile_pdf" class="block text-sm font-medium text-gray-700 mb-1">Profile PDF</label>
                    <input type="file" id="profile_pdf" name="profile_pdf" accept="application/pdf"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    @error('profile_pdf')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Max size 10MB. Only PDF files are allowed.</p>
                </div>

                <div class="flex items-center justify-between bg-gray-50 rounded p-3">
                    @if ($path)
                        <div class="text-sm text-gray-700">
                            Current file: <a class="text-blue-600 hover:underline" href="{{ Storage::url($path) }}"
                                target="_blank">View current PDF</a>
                        </div>
                    @else
                        <div class="text-sm text-gray-500">No file uploaded yet. The site uses the default asset. <a
                                href="{{ $defaultAsset }}" target="_blank" class="text-blue-600 hover:underline">View
                                default PDF</a></div>
                    @endif
                    <a class="text-sm text-blue-600 hover:underline" href="{{ $currentUrl }}" target="_blank"><i
                            class="fas fa-download mr-1"></i>Open in new tab</a>
                </div>

                <!-- Inline Preview -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Preview</h3>
                    <div class="border rounded-lg overflow-hidden" style="height: 600px;">
                        <object id="pdfPreview" data="{{ $currentUrl }}" type="application/pdf" class="w-full h-full">
                            <div class="p-4 text-sm text-gray-600">
                                Your browser may not support inline PDF preview. <a href="{{ $currentUrl }}"
                                    target="_blank" class="text-blue-600 hover:underline">Click here to open the PDF</a>.
                            </div>
                        </object>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Selecting a new file will update the preview before uploading.</p>
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                </div>
            </form>
        </div>
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
