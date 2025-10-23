@once
    <div id="hom-confirm-modal" class="hom-confirm-modal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="hom-confirm-modal__backdrop" data-confirm-cancel></div>

        <div class="hom-confirm-modal__dialog" role="document">
            <div class="hom-confirm-modal__icon" data-confirm-icon>!</div>

            <div class="hom-confirm-modal__body">
                <h2 class="hom-confirm-modal__title" data-confirm-title>{{ __('site.confirm.title') }}</h2>
                <p class="hom-confirm-modal__message" data-confirm-message>{{ __('site.confirm.message') }}</p>
            </div>

            <div class="hom-confirm-modal__actions">
                <button type="button" class="hom-confirm-modal__button hom-confirm-modal__button--ghost"
                    data-confirm-cancel>{{ __('site.confirm.cancel') }}</button>
                <button type="button" class="hom-confirm-modal__button hom-confirm-modal__button--danger"
                    data-confirm-approve>{{ __('site.confirm.approve') }}</button>
            </div>
        </div>
    </div>

    <style>
        .hom-confirm-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            z-index: 9999;
        }

        .hom-confirm-modal.is-visible {
            display: flex;
        }

        .hom-confirm-modal__backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(2px);
        }

        .hom-confirm-modal__dialog {
            position: relative;
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.18);
            padding: 1.75rem 1.75rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .hom-confirm-modal__icon {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            background: rgba(220, 38, 38, 0.12);
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .hom-confirm-modal__body {
            flex: 1;
        }

        .hom-confirm-modal__title {
            margin: 0 0 0.5rem;
            font-size: 1.15rem;
            font-weight: 600;
            color: #0f172a;
        }

        .hom-confirm-modal__message {
            margin: 0;
            font-size: 0.95rem;
            color: #475569;
            line-height: 1.55;
        }

        .hom-confirm-modal__actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .hom-confirm-modal__button {
            appearance: none;
            border: none;
            border-radius: 999px;
            padding: 0.6rem 1.4rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease-in-out;
        }

        .hom-confirm-modal__button--ghost {
            background: #f8fafc;
            color: #0f172a;
            border: 1px solid rgba(148, 163, 184, 0.35);
        }

        .hom-confirm-modal__button--ghost:hover {
            background: #e2e8f0;
        }

        .hom-confirm-modal__button--danger {
            background: #dc2626;
            color: #ffffff;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.25);
        }

        .hom-confirm-modal__button--danger:hover {
            background: #b91c1c;
        }

        .hom-confirm-modal__button:focus-visible {
            outline: 3px solid rgba(59, 130, 246, 0.35);
            outline-offset: 2px;
        }

        @media (max-width: 480px) {
            .hom-confirm-modal__dialog {
                padding: 1.5rem 1.25rem 1.25rem;
            }

            .hom-confirm-modal__actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .hom-confirm-modal__button {
                width: 100%;
            }
        }
    </style>

    <script>
        (function () {
            if (window.homConfirm) {
                return;
            }

            const modal = document.getElementById('hom-confirm-modal');
            if (!modal) {
                return;
            }

            const dialog = modal.querySelector('.hom-confirm-modal__dialog');
            const messageEl = modal.querySelector('[data-confirm-message]');
            const titleEl = modal.querySelector('[data-confirm-title]');
            const iconEl = modal.querySelector('[data-confirm-icon]');
            const approveBtn = modal.querySelector('[data-confirm-approve]');
            const cancelTargets = modal.querySelectorAll('[data-confirm-cancel]');

            const defaultOptions = {
                title: 'Confirm Action',
                message: 'Are you sure you want to continue?',
                confirmText: 'Confirm',
                cancelText: 'Cancel',
                hideCancel: false,
                variant: 'danger',
            };

            let resolveAction = null;
            let rejectAction = null;
            let activeTrigger = null;
            let previousFocus = null;

            function applyVariant(variant) {
                const variants = {
                    danger: {
                        icon: '!',
                        iconColor: '#dc2626',
                        iconBg: 'rgba(220, 38, 38, 0.12)',
                        confirmColor: '#dc2626',
                        confirmShadow: '0 10px 30px rgba(220, 38, 38, 0.25)',
                    },
                    warning: {
                        icon: '!',
                        iconColor: '#d97706',
                        iconBg: 'rgba(217, 119, 6, 0.15)',
                        confirmColor: '#d97706',
                        confirmShadow: '0 10px 30px rgba(217, 119, 6, 0.22)',
                    },
                    info: {
                        icon: 'i',
                        iconColor: '#2563eb',
                        iconBg: 'rgba(37, 99, 235, 0.15)',
                        confirmColor: '#2563eb',
                        confirmShadow: '0 10px 30px rgba(37, 99, 235, 0.22)',
                    },
                    success: {
                        icon: '✓',
                        iconColor: '#16a34a',
                        iconBg: 'rgba(22, 163, 74, 0.15)',
                        confirmColor: '#16a34a',
                        confirmShadow: '0 10px 30px rgba(22, 163, 74, 0.22)',
                    },
                };

                const config = variants[variant] || variants.danger;
                iconEl.textContent = config.icon;
                iconEl.style.color = config.iconColor;
                iconEl.style.backgroundColor = config.iconBg;
                approveBtn.style.backgroundColor = config.confirmColor;
                approveBtn.style.boxShadow = config.confirmShadow;
            }

            function open(options = {}) {
                const settings = { ...defaultOptions, ...(options || {}) };

                messageEl.textContent = settings.message;
                titleEl.textContent = settings.title;
                approveBtn.textContent = settings.confirmText;

                applyVariant(settings.variant);

                if (settings.hideCancel) {
                    cancelTargets.forEach((el) => {
                        el.setAttribute('hidden', 'hidden');
                        el.setAttribute('aria-hidden', 'true');
                        el.style.display = 'none';
                    });
                } else {
                    cancelTargets.forEach((el) => {
                        el.removeAttribute('hidden');
                        el.removeAttribute('aria-hidden');
                        el.style.display = '';
                        el.textContent = settings.cancelText;
                    });
                }

                previousFocus = document.activeElement instanceof HTMLElement ? document.activeElement : null;

                modal.classList.add('is-visible');
                modal.setAttribute('aria-hidden', 'false');

                setTimeout(() => {
                    approveBtn.focus();
                }, 10);

                return new Promise((resolve, reject) => {
                    resolveAction = resolve;
                    rejectAction = reject;
                }).finally(() => {
                    resolveAction = null;
                    rejectAction = null;
                });
            }

            function close() {
                modal.classList.remove('is-visible');
                modal.setAttribute('aria-hidden', 'true');

                if (previousFocus && typeof previousFocus.focus === 'function') {
                    previousFocus.focus();
                }
            }

            function handleApprove() {
                close();
                if (typeof resolveAction === 'function') {
                    resolveAction();
                }
            }

            function handleCancel() {
                close();
                if (typeof rejectAction === 'function') {
                    rejectAction();
                }
            }

            approveBtn.addEventListener('click', handleApprove);
            cancelTargets.forEach((element) => {
                element.addEventListener('click', handleCancel);
            });

            document.addEventListener('keydown', (event) => {
                if (!modal.classList.contains('is-visible')) {
                    return;
                }

                if (event.key === 'Escape') {
                    event.preventDefault();
                    handleCancel();
                }

                if (event.key === 'Tab') {
                    const focusable = dialog.querySelectorAll(
                        'button:not([disabled]):not([hidden])'
                    );

                    if (!focusable.length) {
                        return;
                    }

                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];

                    if (event.shiftKey) {
                        if (document.activeElement === first) {
                            event.preventDefault();
                            last.focus();
                        }
                    } else if (document.activeElement === last) {
                        event.preventDefault();
                        first.focus();
                    }
                }
            });

            function datasetValue(el, name, fallback) {
                return el.dataset[name] || fallback;
            }

            function confirmWithOptions({ message, trigger, onConfirm, onCancel }) {
                const title = datasetValue(trigger, 'confirmTitle', defaultOptions.title);
                const confirmText = datasetValue(trigger, 'confirmConfirm', defaultOptions.confirmText);
                const cancelText = datasetValue(trigger, 'confirmCancel', defaultOptions.cancelText);
                const hideCancel = trigger.dataset.confirmHideCancel === 'true';
                const variant = datasetValue(trigger, 'confirmVariant', defaultOptions.variant);

                activeTrigger = trigger;

                return open({
                    message,
                    title,
                    confirmText,
                    cancelText,
                    hideCancel,
                    variant,
                })
                    .then(() => {
                        if (typeof onConfirm === 'function') {
                            onConfirm();
                        }
                    })
                    .catch(() => {
                        if (typeof onCancel === 'function') {
                            onCancel();
                        }
                    });
            }

            document.addEventListener(
                'submit',
                (event) => {
                    const form = event.target;
                    if (!(form instanceof HTMLFormElement)) {
                        return;
                    }

                    const message = form.dataset.confirm;
                    if (!message) {
                        return;
                    }

                    event.preventDefault();

                    confirmWithOptions({
                        message,
                        trigger: form,
                        onConfirm: () => {
                            if (form.dataset.confirmMethod === 'delete') {
                                const methodInput = form.querySelector('input[name="_method"]');
                                if (!methodInput) {
                                    const spoof = document.createElement('input');
                                    spoof.type = 'hidden';
                                    spoof.name = '_method';
                                    spoof.value = 'DELETE';
                                    form.appendChild(spoof);
                                }
                            }

                            form.submit();
                        },
                        onCancel: () => {
                            if (form.dataset.confirmReset === 'true') {
                                form.reset();
                            }
                        },
                    });
                },
                true
            );

            document.addEventListener('click', (event) => {
                const trigger = event.target.closest('[data-confirm-trigger]');
                if (!trigger) {
                    return;
                }

                const message = trigger.dataset.confirmTrigger;
                if (!message) {
                    return;
                }

                event.preventDefault();

                const selector = trigger.dataset.confirmTarget;
                const targetForm = selector ? document.querySelector(selector) : trigger.closest('form');

                const href = trigger.dataset.confirmHref || trigger.getAttribute('href');

                confirmWithOptions({
                    message,
                    trigger,
                    onConfirm: () => {
                        if (targetForm) {
                            targetForm.submit();
                            return;
                        }

                        if (href) {
                            window.location.href = href;
                        }
                    },
                });
            });

            document.addEventListener('focusin', (event) => {
                const el = event.target;
                if (!(el instanceof HTMLElement)) {
                    return;
                }

                if (el.dataset && el.dataset.confirmChange) {
                    el.dataset.confirmPrevious = el.value || '';
                }
            });

            document.addEventListener('change', (event) => {
                const el = event.target;
                if (!(el instanceof HTMLElement)) {
                    return;
                }

                const message = el.dataset.confirmChange;
                if (!message || !el.value) {
                    return;
                }

                const form = el.closest('form');
                const previousValue = el.dataset.confirmPrevious || '';

                event.preventDefault();

                confirmWithOptions({
                    message,
                    trigger: el,
                    onConfirm: () => {
                        if (form) {
                            form.submit();
                        }
                    },
                    onCancel: () => {
                        el.value = previousValue;
                    },
                });
            });

            window.homConfirm = {
                open,
                close,
                confirmWithOptions,
            };
        })();
    </script>
@endonce
