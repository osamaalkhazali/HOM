<!-- HOM Profile PDF small section -->
<section class="py-4">
    <div class="container">
        @php
            $profileText = trans('site.profile');
            $customProfilePath = \App\Models\Setting::where('key', 'hom_profile_pdf_path')->value('value');
            $profilePdfUrl = $customProfilePath
                ? Storage::url($customProfilePath)
                : asset('assets/HOM-profile/HOM%20Profile%202023.pdf');
        @endphp
        <div class="panel shadow-soft" style="border-radius: 10px;">
            <div class="panel-body d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center"
                        style="width: 56px; height: 56px; border-radius: 10px; background: var(--primary-color); color: #fff; box-shadow: 0 6px 18px rgba(0,0,0,0.08);">
                        <i class="fas fa-file-pdf fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $profileText['title'] }}</h6>
                        <small class="text-muted">{{ $profileText['subtitle'] }}</small>
                    </div>
                </div>
                <a href="{{ $profilePdfUrl }}" class="btn btn-primary btn-lg" style="border-radius: 10px;"
                    target="_blank" rel="noopener">
                    <i class="fas fa-download me-2"></i>{{ $profileText['button'] }}
                </a>
            </div>
        </div>
    </div>
</section>
