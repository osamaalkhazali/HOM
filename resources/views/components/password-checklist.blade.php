@props(['for'])

@php
    $requirements = [
        ['key' => 'length', 'label' => __('password.requirements.length')],
        ['key' => 'uppercase', 'label' => __('password.requirements.uppercase')],
        ['key' => 'number', 'label' => __('password.requirements.number')],
        ['key' => 'symbol', 'label' => __('password.requirements.symbol')],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'password-requirements mt-2']) }} data-password-target="{{ $for }}">
    @foreach ($requirements as $requirement)
        <div class="password-requirements-item" data-requirement="{{ $requirement['key'] }}">
            <span class="password-requirements-icon" aria-hidden="true">❌</span>
            <span>{{ $requirement['label'] }}</span>
        </div>
    @endforeach
</div>

@once
    <style>
        .password-requirements {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.75rem;
            background-color: #f8fafc;
            font-size: 0.85rem;
            line-height: 1.25rem;
        }

        .password-requirements-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            margin-bottom: 0.35rem;
            transition: color 0.2s ease;
        }

        .password-requirements-item:last-child {
            margin-bottom: 0;
        }

        .password-requirements-icon {
            font-weight: 600;
            color: #9ca3af;
            width: 1rem;
            text-align: center;
        }

        .password-requirements-item.is-valid {
            color: #16a34a;
        }

        .password-requirements-item.is-valid .password-requirements-icon {
            color: #16a34a;
        }

        .password-requirements-item:not(.is-valid) .password-requirements-icon {
            color: #9ca3af;
        }
    </style>

    <script>
        (function() {
            const RULES = {
                length: (value) => value.length >= 8,
                uppercase: (value) => /[A-Z]/.test(value),
                number: (value) => /\d/.test(value),
                symbol: (value) => /[!@#$%^&*()\-_=+\[\]{};:"'|,.<>\/`~\\]/.test(value),
            };

            function initPasswordRequirements(root = document) {
                root.querySelectorAll('.password-requirements[data-password-target]').forEach((wrapper) => {
                    if (wrapper.dataset.passwordChecklistInit === 'true') {
                        return;
                    }

                    const inputId = wrapper.getAttribute('data-password-target');
                    const input = document.getElementById(inputId);

                    if (!input) {
                        return;
                    }

                    const updateState = () => {
                        const value = input.value || '';

                        wrapper.querySelectorAll('[data-requirement]').forEach((item) => {
                            const key = item.getAttribute('data-requirement');
                            const passed = RULES[key] ? RULES[key](value) : false;
                            item.classList.toggle('is-valid', passed);

                            const icon = item.querySelector('.password-requirements-icon');
                            if (icon) {
                                icon.textContent = passed ? '✔' : '❌';
                            }
                        });
                    };

                    input.addEventListener('input', updateState);
                    input.addEventListener('change', updateState);

                    wrapper.dataset.passwordChecklistInit = 'true';
                    updateState();
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => initPasswordRequirements());
            } else {
                initPasswordRequirements();
            }

            window.HOMPasswordChecklist = {
                init: initPasswordRequirements,
            };
        })
        ();
    </script>
@endonce
