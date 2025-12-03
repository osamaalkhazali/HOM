<footer id="contact" class="text-white pt-5" style="background: var(--primary-color);" role="contentinfo">
    <div class="container">
        <!-- Brand row -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6 d-flex align-items-center" data-aos="fade-up">
                <div class="footer-logo-wrapper me-3">
                    <div class="footer-logo-backdrop">
                        <div class="footer-logo-border"></div>
                        <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="HOM Logo">
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ app()->getLocale() === 'ar' ? $companySettings['company_name_ar'] : $companySettings['company_name_en'] }}</h5>
                    <p class="mb-0 small opacity-75">{{ app()->getLocale() === 'ar' ? $companySettings['company_tagline_ar'] : $companySettings['company_tagline_en'] }}</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0" data-aos="fade-up" data-aos-delay="50">
                <div class="d-inline-flex">
                    <a href="mailto:{{ $companySettings['email'] }}" class="btn btn-sm btn-light text-primary me-2"
                        style="border-radius:10px;"><i class="fas fa-envelope me-1"></i> {{ __('site.footer.email') }}</a>
                    <a href="tel:{{ str_replace(' ', '', $companySettings['phone']) }}" class="btn btn-sm btn-outline-light" style="border-radius:10px;"><i
                            class="fas fa-phone me-1"></i> {{ __('site.footer.call') }}</a>
                </div>
            </div>
        </div>

        <!-- Details row -->
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <h6 class="fw-semibold mb-2"><i class="fas fa-building me-2"></i>{{ __('site.footer.office_address_title') }}</h6>
                <address class="mb-2 small opacity-75">
                    {!! nl2br(e(app()->getLocale() === 'ar' ? $companySettings['office_address_ar'] : $companySettings['office_address_en'])) !!}
                </address>
                <p class="mb-1 small opacity-75"><i class="fas fa-phone me-2"></i>{{ __('site.footer.tel') }} <span dir="ltr">{{ $companySettings['phone'] }}</span></p>
                @if($companySettings['fax'])
                    <p class="mb-0 small opacity-75"><i class="fas fa-fax me-2"></i>{{ __('site.footer.fax') }} <span dir="ltr">{{ $companySettings['fax'] }}</span></p>
                @endif
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
                <h6 class="fw-semibold mb-2"><i class="fas fa-envelope me-2"></i>{{ __('site.footer.mail_address_title') }}</h6>
                <p class="mb-3 small opacity-75">{{ $companySettings['po_box'] }}</p>
                <h6 class="fw-semibold mb-2"><i class="fas fa-at me-2"></i>{{ __('site.footer.electronic_address_title') }}</h6>
                <p class="mb-1 small opacity-75"><i class="fas fa-paper-plane me-2"></i>{{ __('site.footer.email_label') }} <a
                        href="mailto:{{ $companySettings['email'] }}" class="link-light text-decoration-none">{{ $companySettings['email'] }}</a>
                </p>
                <p class="mb-0 small opacity-75"><i class="fas fa-globe me-2"></i>{{ __('site.footer.website_label') }} <a
                        href="https://{{ $companySettings['website'] }}" target="_blank" rel="noopener"
                        class="link-light text-decoration-none">{{ $companySettings['website'] }}</a></p>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <h6 class="fw-semibold mb-2"><i class="fas fa-link me-2"></i>{{ __('site.footer.useful_links_title') }}</h6>
                <ul class="list-unstyled small mb-0">
            <li class="mb-2"><i class="fas fa-angle-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} me-2 opacity-75"></i><a href="{{ url('/#services') }}"
                class="link-light text-decoration-none">{{ __('site.footer.services') }}</a></li>
            <li class="mb-2"><i class="fas fa-angle-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} me-2 opacity-75"></i><a href="{{ url('/#about') }}"
                class="link-light text-decoration-none">{{ __('site.footer.our_focus') }}</a></li>
            <li class="mb-2"><i class="fas fa-angle-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} me-2 opacity-75"></i><a href="{{ url('/#clients') }}"
                class="link-light text-decoration-none">{{ __('site.footer.clients') }}</a></li>
            <li class="mb-2"><i class="fas fa-angle-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} me-2 opacity-75"></i><a href="{{ url('/#partners') }}"
                class="link-light text-decoration-none">{{ __('site.footer.partners') }}</a></li>
            <li><i class="fas fa-angle-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} me-2 opacity-75"></i><a href="{{ url('/#top') }}"
                class="link-light text-decoration-none">{{ __('site.footer.back_to_top') }}</a></li>
                </ul>
            </div>
        </div>

        <hr class="border-light opacity-25 my-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pb-3">
            <small class="opacity-75">© {{ date('Y') }} {{ app()->getLocale() === 'ar' ? $companySettings['company_name_ar'] : $companySettings['company_name_en'] }}. {{ __('site.footer.all_rights_reserved') }}</small>
        </div>
    </div>
</footer>

<style>
    .footer-logo-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .footer-logo-backdrop {
        position: relative;
        padding: 0.65rem 1rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 8px 24px rgba(3, 26, 54, 0.25);
    }

    .footer-logo-border {
        position: absolute;
        inset: 0;
        border-radius: 999px;
        border: 2px solid rgba(255, 255, 255, 0.9);
        box-shadow: inset 0 0 12px rgba(255, 255, 255, 0.5);
        pointer-events: none;
    }

    .footer-logo-border::after {
        content: none;
    }

    .footer-logo-backdrop img {
        position: relative;
        z-index: 1;
        height: 42px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
    }

    @media (max-width: 576px) {
        .footer-logo-backdrop {
            padding: 0.5rem 0.85rem;
        }

        .footer-logo-backdrop img {
            height: 36px;
        }
    }
</style>
