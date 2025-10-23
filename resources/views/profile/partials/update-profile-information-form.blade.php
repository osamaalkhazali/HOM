<section>
    <header class="mb-4">
        <h5 class="fw-bold mb-2" style="color: var(--primary-color);">
            <i class="fas fa-user me-2"></i>{{ __('site.profile_form.profile_information.title') }}
        </h5>
        <p class="text-muted small">
            {{ __('site.profile_form.profile_information.description') }}
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
                <label for="name" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.name') }}</label>
                <input type="text" class="form-control form-control-lg" id="name" name="name"
                    value="{{ old('name', $user->name) }}" autocomplete="name"
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
                <label for="email" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.email') }}</label>
                <input type="email" class="form-control form-control-lg" id="email" name="email"
                    value="{{ old('email', $user->email) }}" autocomplete="username"
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
            <label for="headline" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.headline.label') }}</label>
            <input type="text" class="form-control form-control-lg" id="headline" name="headline"
                value="{{ old('headline', $user->profile->headline ?? '') }}"
                placeholder="{{ __('site.profile_form.profile_information.fields.headline.placeholder') }}"
                style="border-radius: 15px; border: 2px solid #e9ecef;">
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
                <label for="location" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.location.label') }}</label>
                <input type="text" class="form-control form-control-lg" id="location" name="location"
                    value="{{ old('location', $user->profile->location ?? '') }}"
                    placeholder="{{ __('site.profile_form.profile_information.fields.location.placeholder') }}"
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
                <label for="current_position" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.current_position.label') }}</label>
                <input type="text" class="form-control form-control-lg" id="current_position" name="current_position"
                    value="{{ old('current_position', $user->profile->current_position ?? '') }}"
                    placeholder="{{ __('site.profile_form.profile_information.fields.current_position.placeholder') }}"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
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
                <label for="experience_years" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.experience.label') }}</label>
                <select class="form-select form-select-lg" id="experience_years" name="experience_years"
                    style="border-radius: 15px; border: 2px solid #e9ecef;">
                    <option value="">{{ __('site.profile_form.profile_information.fields.experience.placeholder') }}</option>
                    <option value="0-1"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '0-1' ? 'selected' : '' }}>
                        {{ __('site.profile_form.profile_information.fields.experience.options.0-1') }}
                    </option>
                    <option value="2-4"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '2-4' ? 'selected' : '' }}>
                        {{ __('site.profile_form.profile_information.fields.experience.options.2-4') }}
                    </option>
                    <option value="5-7"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '5-7' ? 'selected' : '' }}>
                        {{ __('site.profile_form.profile_information.fields.experience.options.5-7') }}
                    </option>
                    <option value="8-10"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '8-10' ? 'selected' : '' }}>
                        {{ __('site.profile_form.profile_information.fields.experience.options.8-10') }}
                    </option>
                    <option value="10+"
                        {{ old('experience_years', $user->profile->experience_years ?? '') == '10+' ? 'selected' : '' }}>
                        {{ __('site.profile_form.profile_information.fields.experience.options.10+') }}
                    </option>
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
                <label for="website" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.website.label') }}</label>
                <input type="url" class="form-control form-control-lg" id="website" name="website"
                    value="{{ old('website', $user->profile->website ?? '') }}"
                    placeholder="{{ __('site.profile_form.profile_information.fields.website.placeholder') }}"
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
            <label for="linkedin_url" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.linkedin.label') }}</label>
            <input type="url" class="form-control form-control-lg" id="linkedin_url" name="linkedin_url"
                value="{{ old('linkedin_url', $user->profile->linkedin_url ?? '') }}"
                placeholder="{{ __('site.profile_form.profile_information.fields.linkedin.placeholder') }}"
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
            <label for="education" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.education.label') }}</label>
            <textarea class="form-control" id="education" name="education" rows="3"
                placeholder="{{ __('site.profile_form.profile_information.fields.education.placeholder') }}"
                style="border-radius: 15px; border: 2px solid #e9ecef;">{{ old('education', $user->profile->education ?? '') }}</textarea>
            @if ($errors->get('education'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('education') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="skills" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.skills.label') }}</label>
            <textarea class="form-control" id="skills" name="skills" rows="3"
                placeholder="{{ __('site.profile_form.profile_information.fields.skills.placeholder') }}"
                style="border-radius: 15px; border: 2px solid #e9ecef;">{{ old('skills', $user->profile->skills ?? '') }}</textarea>
            <div class="form-text">{{ __('site.profile_form.profile_information.fields.skills.tip', ['example' => 'PHP, Laravel, MySQL']) }}</div>
            <div class="mt-2">
                <small class="text-muted d-block mb-1">{{ __('site.profile_form.profile_information.fields.skills.preview_label') }}</small>
                <div id="skills-preview" class="d-flex flex-wrap gap-2"></div>
            </div>
            @if ($errors->get('skills'))
                <div class="text-danger small mt-1">
                    @foreach ($errors->get('skills') as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="about" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.about.label') }}</label>
            <textarea class="form-control" id="about" name="about" rows="4"
                placeholder="{{ __('site.profile_form.profile_information.fields.about.placeholder') }}"
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
            <label for="cv" class="form-label fw-medium">{{ __('site.profile_form.profile_information.fields.cv.label') }}</label>
            @if ($user->profile && $user->profile->cv_path)
                <div class="mb-2">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-file-pdf me-2"></i>
                        {{ __('site.profile_form.profile_information.fields.cv.current') }} <strong>{{ basename($user->profile->cv_path) }}</strong>
                        <a href="{{ asset('storage/' . $user->profile->cv_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary ms-2">
                            <i class="fas fa-eye me-1"></i>{{ __('site.profile_form.profile_information.fields.cv.view') }}
                        </a>
                    </div>
                </div>
            @endif
            <input type="file" class="form-control form-control-lg" id="cv" name="cv"
                accept=".pdf,.doc,.docx" style="border-radius: 15px; border: 2px solid #e9ecef;">
            <div class="form-text">{{ __('site.profile_form.profile_information.fields.cv.hint') }}</div>
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
                <strong>{{ __('site.profile_form.profile_information.verification.unverified') }}</strong>
                <button form="send-verification" class="btn btn-link p-0 text-decoration-underline small">
                    {{ __('site.profile_form.profile_information.verification.resend') }}
                </button>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success mt-2" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ __('site.profile_form.profile_information.verification.sent') }}
                </div>
            @endif
        @endif

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn morph-btn pulse-btn fw-semibold px-4 py-2 text-white"
                style="background: var(--gradient-1); border: none; border-radius: 25px;">
                <i class="fas fa-save me-2"></i>{{ __('site.profile_form.profile_information.buttons.save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success d-inline-block mb-0 py-2 px-3"
                    style="border-radius: 15px; font-size: 0.875rem;" x-data="{ show: true }" x-show="show"
                    x-init="setTimeout(() => show = false, 3000)">
                    <i class="fas fa-check-circle me-1"></i>{{ __('site.profile_form.profile_information.messages.saved') }}
                </div>
            @endif
        </div>
    </form>
    <script>
        (function() {
            function renderSkillsPreview() {
                var textarea = document.getElementById('skills');
                var preview = document.getElementById('skills-preview');
                if (!textarea || !preview) return;

                preview.innerHTML = '';

                var raw = textarea.value || '';
                var items = raw.split(',')
                    .map(function(s) { return s.trim(); })
                    .filter(function(s) { return s.length > 0; });

                var seen = new Set();
                items.forEach(function(skill) {
                    if (seen.has(skill.toLowerCase())) return;
                    seen.add(skill.toLowerCase());
                    var span = document.createElement('span');
                    span.className = 'badge rounded-pill bg-light text-primary border border-primary';
                    span.textContent = skill;
                    preview.appendChild(span);
                });

                if (items.length === 0) {
                    var none = document.createElement('span');
                    none.className = 'text-muted small';
                    none.textContent = @json(__('site.profile_form.profile_information.fields.skills.preview_empty'));
                    preview.appendChild(none);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                renderSkillsPreview();
                var textarea = document.getElementById('skills');
                if (textarea) {
                    textarea.addEventListener('input', renderSkillsPreview);
                    textarea.addEventListener('change', renderSkillsPreview);
                    textarea.addEventListener('blur', renderSkillsPreview);
                }
            });
        })();
    </script>
</section>
