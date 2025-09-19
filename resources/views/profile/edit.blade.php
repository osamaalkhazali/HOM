<x-app-layout>
    <x-slot name="header">
        <div class="text-center" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-white mb-3">
                <i class="fas fa-user-circle me-3"></i>Profile Settings
            </h1>
            <p class="lead text-white opacity-90 mb-0">
                Manage your account information and security settings
            </p>
        </div>
    </x-slot>

    <!-- Profile Overview Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- User Info Card -->
                    <div class="glass-card p-4 mb-5 hover-lift" data-aos="fade-up">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 120px; height: 120px; background: var(--gradient-1);">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h3 class="fw-bold mb-2" style="color: var(--primary-color);">
                                    {{ Auth::user()->name }}
                                </h3>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                                </p>
                                <div class="d-flex flex-wrap gap-2">
                                    @if (Auth::user()->email_verified_at)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-shield-alt me-1"></i>Verified Account
                                        </span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Email Pending
                                        </span>
                                    @endif
                                    <span class="badge bg-info px-3 py-2">
                                        <i class="fas fa-calendar me-1"></i>Member since
                                        {{ Auth::user()->created_at->format('M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Cards -->
                    <div class="row g-4">
                        <!-- Profile Information -->
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="card border-0 shadow-lg h-100 hover-lift">
                                <div class="card-header text-white text-center py-4"
                                    style="background: var(--gradient-1);">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="service-icon me-3" style="background: rgba(255,255,255,0.2);">
                                            <i class="fas fa-user-edit text-white"></i>
                                        </div>
                                        <h4 class="mb-0 fw-bold">Profile Information</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>
                        </div>

                        <!-- Update Password -->
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="card border-0 shadow-lg h-100 hover-lift">
                                <div class="card-header text-white text-center py-4"
                                    style="background: var(--gradient-3);">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="service-icon me-3" style="background: rgba(255,255,255,0.2);">
                                            <i class="fas fa-lock text-white"></i>
                                        </div>
                                        <h4 class="mb-0 fw-bold">Security Settings</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>
                        </div>

                        <!-- Delete Account -->
                        <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                            <div class="card border-0 shadow-lg hover-lift">
                                <div class="card-header text-white text-center py-4"
                                    style="background: var(--gradient-2);">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="service-icon me-3" style="background: rgba(255,255,255,0.2);">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                        <h4 class="mb-0 fw-bold">Danger Zone</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-5" data-aos="fade-up" data-aos-delay="400">
                        <div class="col-12">
                            <div class="glass-card p-4 text-center">
                                <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                                    <i class="fas fa-rocket me-2"></i>Quick Actions
                                </h5>
                                <div class="d-flex flex-wrap gap-3 justify-content-center">
                                    <a href="{{ route('dashboard') }}"
                                        class="btn morph-btn fw-semibold px-4 py-2 text-white"
                                        style="background: var(--gradient-1); border: none; border-radius: 25px;">
                                        <i class="fas fa-home me-2"></i>Back to Dashboard
                                    </a>
                                    <a href="#" class="btn morph-btn fw-semibold px-4 py-2 text-white"
                                        style="background: var(--gradient-4); border: none; border-radius: 25px;">
                                        <i class="fas fa-download me-2"></i>Export Data
                                    </a>
                                    <a href="#" class="btn morph-btn fw-semibold px-4 py-2 text-white"
                                        style="background: var(--gradient-3); border: none; border-radius: 25px;">
                                        <i class="fas fa-cog me-2"></i>Preferences
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
