<section>
    <header class="mb-4">
        <h5 class="fw-bold mb-2" style="color: var(--primary-color);">
            <i class="fas fa-user me-2"></i>{{ __('Profile Information') }}
        </h5>
        <p class="text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label fw-medium">{{ __('Name') }}</label>
                <input type="text" class="form-control form-control-lg" id="name" name="name"
                    value="{{ old('name', $user->name) }}" required autocomplete="name"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
                @if ($errors->get('name'))
                    <div class="text-danger small mt-1">
                        @foreach ($errors->get('name') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
                <input type="email" class="form-control form-control-lg" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required autocomplete="username"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
                @if ($errors->get('email'))
                    <div class="text-danger small mt-1">
                        @foreach ($errors->get('email') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="headline" class="form-label fw-medium">{{ __('Professional Headline') }}</label>
            <input type="text" class="form-control form-control-lg" id="headline" name="headline"
                value="{{ old('headline', $user->profile->headline ?? '') }}"
                placeholder="e.g., Senior Software Developer" style="border-radius: 15px; border: 2px solid #e9ecef;">
            @if ($errors->get('headline'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('headline') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label fw-medium">{{ __('Location') }}</label>
                <input type="text" class="form-control form-control-lg" id="location" name="location"
                    value="{{ old('location', $user->profile->location ?? '') }}" placeholder="City, Country"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
                @if ($errors->get('location'))
                    <div class="text-danger small mt-1">
                        @foreach ($errors->get('location') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label for="current_position" class="form-label fw-medium">{{ __('Current Position') }}</label>
                <input type="text" class="form-control form-control-lg" id="current_position" name="current_position"
                    value="{{ old('current_position', $user->profile->current_position ?? '') }}"
                    placeholder="Current job title" style="border-radius: 15px; border: 2px solid #e9ecef;">
                @if ($errors->get('current_position'))
                    <div class="text-danger small mt-1">
                        @foreach ($errors->get('current_position') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="experience_years" class="form-label fw-medium">{{ __('Years of Experience') }}</label>
                <select class="form-select form-select-lg" id="experience_years" name="experience_years"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
                    <option value="">Select experience level</option>
                    <option value="0-1"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '0-1' ? 'selected' : '' }}>
                        0-1 years</option>
                    <option value="2-3"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '2-3' ? 'selected' : '' }}>
                        2-3 years</option>
                    <option value="4-5"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '4-5' ? 'selected' : '' }}>
                        4-5 years</option>
                    <option value="6-10"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '6-10' ? 'selected' : '' }}>
                        6-10 years</option>
                    <option value="10+"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '10+' ? 'selected' : '' }}>
                        10+ years</option>
                </select>
                @if ($errors->get('experience_years'))
                    <div class="text-danger small mt-1">
                        @foreach ($errors->get('experience_years') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label for="website" class="form-label fw-medium">{{ __('Website/Portfolio') }}</label>
                <input type="url" class="form-control form-control-lg" id="website" name="website"
                    value="{{ old('website', $user->profile->website ?? '') }}" placeholder="https://your-website.com"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
                @if ($errors->get('website'))
                    <div class="text-danger small mt-1">
                        @foreach ($errors->get('website') as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="linkedin_url" class="form-label fw-medium">{{ __('LinkedIn Profile') }}</label>
            <input type="url" class="form-control form-control-lg" id="linkedin_url" name="linkedin_url"
                value="{{ old('linkedin_url', $user->profile->linkedin_url ?? '') }}"
                placeholder="https://linkedin.com/in/your-profile"
                style="border-radius: 15px; border: 2px solid #e9ecef;">
            @if ($errors->get('linkedin_url'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('linkedin_url') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="education" class="form-label fw-medium">{{ __('Education') }}</label>
            <textarea class="form-control" id="education" name="education" rows="3"
                placeholder="Degree, University/Institution, Year" style="border-radius: 15px; border: 2px solid #e9ecef;">{{ old('education', $user->profile->education ?? '') }}</textarea>
            @if ($errors->get('education'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('education') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="skills" class="form-label fw-medium">{{ __('Skills') }}</label>
            <textarea class="form-control" id="skills" name="skills" rows="3"
                placeholder="List your key skills separated by commas" style="border-radius: 15px; border: 2px solid #e9ecef;">{{ old('skills', $user->profile->skills ?? '') }}</textarea>
            @if ($errors->get('skills'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('skills') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="about" class="form-label fw-medium">{{ __('About / Bio') }}</label>
            <textarea class="form-control" id="about" name="about" rows="4"
                placeholder="Tell us about yourself, your experience, and career goals"
                style="border-radius: 15px; border: 2px solid #e9ecef;">{{ old('about', $user->profile->about ?? '') }}</textarea>
            @if ($errors->get('about'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('about') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="cv" class="form-label fw-medium">{{ __('CV/Resume') }}</label>
            @if ($user->profile && $user->profile->cv_path)
                <div class="mb-2">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-file-pdf me-2"></i>
                        Current CV: <strong>{{ basename($user->profile->cv_path) }}</strong>
                        <a href="{{ asset('storage/' . $user->profile->cv_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary ms-2">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                    </div>
                </div>
            @endif
            <input type="file" class="form-control form-control-lg" id="cv" name="cv"
                accept=".pdf,.doc,.docx" style="border-radius: 15px; border: 2px solid #e9ecef;">
            <div class="form-text">Upload your CV/Resume (PDF, DOC, DOCX formats only. Max size: 2MB)</div>
            @if ($errors->get('cv'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('cv') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="alert alert-warning mt-2" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>{{ __('Your email address is unverified.') }}</strong>
                <button form="send-verification" class="btn btn-link p-0 text-decoration-underline small">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success mt-2" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ __('A new verification link has been sent to your email address.') }}
                </div>
            @endif
        @endif

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white"
                style="background: var(--gradient-1); border: none; border-radius: 25px;">
                <i class="fas fa-save me-2"></i>{{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success d-inline-block mb-0 py-2 px-3"
                    style="border-radius: 15px; font-size: 0.875rem;" x-data="{ show: true }" x-show="show"
                    x-init="setTimeout(() => show = false, 3000)">
                    <i class="fas fa-check-circle me-1"></i>{{ __('Saved successfully!') }}
                </div>
            @endif
        </div>
    </form>
</section>
