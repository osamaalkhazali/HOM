@php
    $fieldName = $name ?? 'content';
    $fieldId = $id ?? \Illuminate\Support\Str::slug($fieldName, '_') . '_' . \Illuminate\Support\Str::random(6);
    $fieldLabel = $label ?? \Illuminate\Support\Str::title(str_replace(['_', '-'], ' ', $fieldName));
    $isRequired = $required ?? false;
    $helperText = $helper ?? null;
    $placeholder = $placeholder ?? '';
    $direction = $dir ?? 'ltr';
    $initialValue = \App\Support\RichText::forEditor($value ?? '');
@endphp

<div class="rich-text-field space-y-2">
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-gray-700 mb-1">
        {!! $fieldLabel !!}
        @if ($isRequired && !Str::contains($fieldLabel, '*'))
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div class="rich-text-wrapper border border-gray-300 rounded-lg overflow-hidden focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200"
        data-rich-editor>
        <div class="flex items-center justify-between bg-gray-50 border-b border-gray-200 px-3 py-2">
            <div class="flex items-center gap-2">
                <button type="button" class="rich-text-button" data-command="bold" title="Bold (Ctrl+B)">
                    <i class="fas fa-bold"></i>
                </button>
                <button type="button" class="rich-text-button" data-command="italic" title="Italic (Ctrl+I)">
                    <i class="fas fa-italic"></i>
                </button>
                <span class="h-5 border-l border-gray-300"></span>
                <button type="button" class="rich-text-button" data-command="insertUnorderedList" title="Bullet list">
                    <i class="fas fa-list-ul"></i>
                </button>
                <button type="button" class="rich-text-button" data-command="insertOrderedList" title="Numbered list">
                    <i class="fas fa-list-ol"></i>
                </button>
                <span class="h-5 border-l border-gray-300"></span>
                <button type="button" class="rich-text-button" data-command="removeFormat" title="Clear formatting">
                    <i class="fas fa-eraser"></i>
                </button>
            </div>
            <span class="text-xs text-gray-400 hidden md:inline">Use Shift+Enter for a line break</span>
        </div>
        <div class="rich-text-editor px-3 py-3" contenteditable="true" data-editor
            data-placeholder="{{ $placeholder }}" dir="{{ $direction }}">{!! $initialValue !!}</div>
        <textarea id="{{ $fieldId }}" name="{{ $fieldName }}" data-editor-input
            @if ($isRequired) required @endif style="display:none;">@php echo $initialValue; @endphp</textarea>
    </div>

    @if ($helperText)
        <p class="mt-1 text-xs text-gray-500">{{ $helperText }}</p>
    @endif

    @error($fieldName)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@once
    @push('styles')
        <style>
            .rich-text-wrapper {
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
                background-color: #fff;
            }

            .rich-text-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 2rem;
                width: 2rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                color: #4b5563;
                background: transparent;
                border: none;
                cursor: pointer;
                transition: background-color 0.2s ease, color 0.2s ease;
            }

            .rich-text-button:hover {
                background-color: #f3f4f6;
                color: #1f2937;
            }

            .rich-text-button:focus {
                outline: none;
                box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.45);
            }

            .rich-text-editor {
                min-height: 180px;
                outline: none;
                font-size: 0.95rem;
                line-height: 1.6;
                color: #1f2937;
                overflow-y: auto;
            }

            .rich-text-editor:empty:before {
                content: attr(data-placeholder);
                color: #9ca3af;
            }

            .rich-text-editor ul,
            .rich-text-editor ol {
                padding-left: 1.5rem;
                margin: 0.5rem 0;
                list-style-position: outside;
            }

            .rich-text-editor ul {
                list-style-type: disc;
            }

            .rich-text-editor ol {
                list-style-type: decimal;
            }

            .rich-text-editor[dir="rtl"] ul,
            .rich-text-editor[dir="rtl"] ol {
                padding-left: 0;
                padding-right: 1.5rem;
            }

            .rich-text-editor ul li,
            .rich-text-editor ol li {
                margin-bottom: 0.25rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function() {
                const initializeWrapper = (wrapper) => {
                    if (wrapper.dataset.richEditorInited === 'true') {
                        return;
                    }

                    const editor = wrapper.querySelector('[data-editor]');
                    const input = wrapper.querySelector('[data-editor-input]');

                    if (!editor || !input) {
                        return;
                    }

                    wrapper.dataset.richEditorInited = 'true';

                    const normalizeHtml = (html) => {
                        if (!html) {
                            return '';
                        }

                        let normalized = html;
                        normalized = normalized.replace(/<\/?div[^>]*>/gi, (match) => match.startsWith('</') ?
                            '</p>' : '<p>');
                        normalized = normalized.replace(/<span[^>]*>|<\/span>/gi, '');
                        normalized = normalized.replace(/&nbsp;/gi, ' ');
                        normalized = normalized.replace(/\s+$/g, '');
                        normalized = normalized.replace(/<p>\s*<\/p>/gi, '');

                        if (!/<(p|ul|ol|li|br)/i.test(normalized)) {
                            const lines = normalized
                                .split(/\n+/)
                                .map((line) => line.trim())
                                .filter((line) => line.length > 0);

                            if (lines.length) {
                                normalized = lines.map((line) => `<p>${line}</p>`).join('');
                            }
                        }

                        return normalized.trim();
                    };

                    const sync = () => {
                        const html = normalizeHtml(editor.innerHTML);
                        input.value = html;
                    };

                    sync();

                    wrapper.querySelectorAll('[data-command]').forEach((button) => {
                        button.addEventListener('click', (event) => {
                            event.preventDefault();
                            const command = button.dataset.command;
                            editor.focus();

                            switch (command) {
                                case 'bold':
                                case 'italic':
                                    document.execCommand(command, false);
                                    break;
                                case 'insertUnorderedList':
                                    document.execCommand('insertUnorderedList', false);
                                    break;
                                case 'insertOrderedList':
                                    document.execCommand('insertOrderedList', false);
                                    break;
                                case 'removeFormat':
                                    document.execCommand('removeFormat', false);
                                    document.execCommand('unlink', false);
                                    break;
                                default:
                                    break;
                            }

                            sync();
                        });
                    });

                    editor.addEventListener('paste', (event) => {
                        event.preventDefault();
                        const text = (event.clipboardData || window.clipboardData).getData('text/plain');
                        document.execCommand('insertText', false, text);
                        sync();
                    });

                    editor.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' && event.shiftKey) {
                            event.preventDefault();
                            document.execCommand('insertLineBreak');
                            sync();
                        }
                    });

                    editor.addEventListener('input', () => {
                        if (editor.innerHTML.trim() === '<br>') {
                            editor.innerHTML = '';
                        }
                        sync();
                    });

                    editor.addEventListener('blur', sync);

                    const form = wrapper.closest('form');
                    if (form) {
                        form.addEventListener('submit', sync);
                    }
                };

                const initializeEditors = () => {
                    document.querySelectorAll('[data-rich-editor]').forEach(initializeWrapper);
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initializeEditors, {
                        once: true
                    });
                } else {
                    initializeEditors();
                }
            })
            ();
        </script>
    @endpush
@endonce
