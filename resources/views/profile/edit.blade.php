<x-app-layout>
    @include('layouts.styles')

    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="title"><i class="fas fa-user-circle me-2"></i>{{ __('site.profile_edit.header.title') }}</h1>
                <p class="subtitle mb-0">{{ __('site.profile_edit.header.subtitle') }}</p>
            </div>
            <div class="actions d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-home me-1"></i>{{ __('site.profile_edit.header.buttons.dashboard') }}
                </a>
                <a href="{{ route('jobs.index') }}" class="btn btn-light btn-sm text-primary">
                    <i class="fas fa-search me-1"></i>{{ __('site.profile_edit.header.buttons.browse_jobs') }}
                </a>
            </div>
        </div>
    </x-slot>

    <section class="py-3 dashboard">
        <div class="container">
            <div class="row g-4">
                <!-- Main content -->
                <div class="col-lg-8">
                    <!-- Profile Information -->
                    <div class="panel shadow-soft mb-4">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-user-edit me-2"></i>{{ __('site.profile_edit.sections.profile_information') }}</h5>
                        </div>
                        <div class="panel-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="panel shadow-soft mb-4">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0"><i class="fas fa-lock me-2"></i>{{ __('site.profile_edit.sections.security') }}</h5>
                        </div>
                        <div class="panel-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="panel shadow-soft">
                        <div class="panel-header">
                            <h5 class="panel-title mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>{{ __('site.profile_edit.sections.danger') }}</h5>
                        </div>
                        <div class="panel-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 90px;">
                        <!-- Profile Summary -->
                        <div class="panel shadow-soft mb-4 profile-card">
                            <div class="panel-body">
                                @if (Auth::user()->email_verified_at)
                                    <span class="badge bg-success verified-badge"><i class="fas fa-shield-check me-1"></i>{{ __('site.profile_edit.sidebar.verified') }}</span>
                                @endif
                                <div class="text-center mb-3">
                                    <div class="avatar-lg profile-avatar mb-2">
                                        <i class="fas fa-user fa-lg text-white"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">{{ Auth::user()->name }}</h5>
                                    <div class="text-muted small">{{ Auth::user()->email }}</div>
                                </div>

                                <div class="row g-0 text-center meta">
                                    <div class="col-6 py-2">
                                        <div class="label">{{ __('site.profile_edit.sidebar.joined') }}</div>
                                        <div class="value">{{ Auth::user()->created_at->format('M Y') }}</div>
                                    </div>
                                    <div class="col-6 py-2 border-start">
                                        <div class="label">{{ __('site.profile_edit.sidebar.last_login') }}</div>
                                        <div class="value">{{ now()->format('M d') }}</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('applications.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                                        {{ __('site.profile_edit.sidebar.buttons.applications') }}
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary" style="border-radius: 10px;">
                                        {{ __('site.profile_edit.sidebar.buttons.dashboard') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="panel shadow-soft mb-4">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0"><i class="fas fa-bolt me-2"></i>{{ __('site.profile_edit.quick_actions.title') }}</h5>
                            </div>
                            <div class="panel-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('jobs.index') }}" class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-search"></i></div>
                                            <small class="fw-semibold">{{ __('site.profile_edit.quick_actions.browse_jobs') }}</small>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('applications.index') }}" class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-file-alt"></i></div>
                                            <small class="fw-semibold">{{ __('site.profile_edit.quick_actions.applications') }}</small>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('dashboard') }}" class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-home"></i></div>
                                            <small class="fw-semibold">{{ __('site.profile_edit.quick_actions.dashboard') }}</small>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="#" class="quick-action">
                                            <div class="quick-icon"><i class="fas fa-download"></i></div>
                                            <small class="fw-semibold">{{ __('site.profile_edit.quick_actions.export') }}</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips / Help -->
                        <div class="panel shadow-soft">
                            <div class="panel-header">
                                <h5 class="panel-title mb-0"><i class="fas fa-info-circle me-2"></i>{{ __('site.profile_edit.tips.title') }}</h5>
                            </div>
                            <div class="panel-body">
                                <ul class="mb-0 ps-3">
                                    <li>{{ __('site.profile_edit.tips.items.strong_password') }}</li>
                                    <li>{{ __('site.profile_edit.tips.items.keep_profile_updated') }}</li>
                                    <li>{{ __('site.profile_edit.tips.items.verify_email') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
