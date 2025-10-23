<section>
    <header class="mb-4">
        <h5 class="fw-bold mb-2 text-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('site.profile_form.delete.title') }}
        </h5>
        <p class="text-muted small">
            {{ __('site.profile_form.delete.description') }}
        </p>
    </header>

    <button type="button" class="btn btn-outline-danger fw-semibold px-4 py-2"
        style="border-radius: 25px; border-width: 2px;" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        <i class="fas fa-trash-alt me-2"></i>{{ __('site.profile_form.delete.button') }}
    </button>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header text-white py-4"
                    style="background: var(--gradient-2); border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold" id="confirmUserDeletionLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('site.profile_form.delete.modal_title') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="{{ __('site.profile_form.delete.cancel') }}"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="text-center mb-4">
                            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px; background: rgba(220, 53, 69, 0.1); border-radius: 50%;">
                                <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                            </div>
                            <h6 class="fw-bold text-danger mb-2">
                                {{ __('site.profile_form.delete.modal_question') }}
                            </h6>
                            <p class="text-muted small">
                                {{ __('site.profile_form.delete.modal_description') }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">{{ __('site.profile_form.delete.password_label') }}</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                placeholder="{{ __('site.profile_form.delete.password_placeholder') }}"
                                style="border-radius: 15px; border: 2px solid #e9ecef;">
                            @if ($errors->userDeletion->get('password'))
                                <div class="text-danger small mt-1">
                                    @foreach ($errors->userDeletion->get('password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-outline-secondary fw-semibold px-4 py-2"
                                data-bs-dismiss="modal" style="border-radius: 25px;">
                                <i class="fas fa-times me-2"></i>{{ __('site.profile_form.delete.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-danger fw-semibold px-4 py-2"
                                style="border-radius: 25px;">
                                <i class="fas fa-trash-alt me-2"></i>{{ __('site.profile_form.delete.button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
