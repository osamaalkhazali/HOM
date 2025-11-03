@extends('layouts.admin.app')

@section('title', 'Edit Application')

@section('content')
    @php
        // Only show manual statuses - documents_requested and documents_submitted are automatic
        $statusOptions = [
            'pending' => [
                'label' => 'Pending Review',
                'hint' => 'Application awaiting initial screening',
                'badge' => ['classes' => 'bg-yellow-100 text-yellow-700 border border-yellow-200', 'icon' => 'fas fa-clock text-yellow-600', 'text' => 'Pending Review'],
            ],
            'under_reviewing' => [
                'label' => 'Under Reviewing',
                'hint' => 'Actively being assessed by the team',
                'badge' => ['classes' => 'bg-sky-100 text-sky-700 border border-sky-200', 'icon' => 'fas fa-spinner text-sky-600', 'text' => 'Under Reviewing'],
            ],
            'reviewed' => [
                'label' => 'Reviewed',
                'hint' => 'Initial review completed',
                'badge' => ['classes' => 'bg-blue-100 text-blue-700 border border-blue-200', 'icon' => 'fas fa-eye text-blue-600', 'text' => 'Reviewed'],
            ],
            'shortlisted' => [
                'label' => 'Shortlisted',
                'hint' => 'Candidate selected for shortlist - you can add document requests',
                'badge' => ['classes' => 'bg-purple-100 text-purple-700 border border-purple-200', 'icon' => 'fas fa-star text-purple-600', 'text' => 'Shortlisted'],
            ],
            'rejected' => [
                'label' => 'Rejected',
                'hint' => 'Application declined',
                'badge' => ['classes' => 'bg-red-100 text-red-700 border border-red-200', 'icon' => 'fas fa-times text-red-600', 'text' => 'Rejected'],
            ],
            'hired' => [
                'label' => 'Hired',
                'hint' => 'Candidate accepted the offer',
                'badge' => ['classes' => 'bg-green-100 text-green-700 border border-green-200', 'icon' => 'fas fa-check text-green-600', 'text' => 'Hired'],
            ],
        ];

        // Add current status if it's one of the automatic ones (for display only)
        $currentStatus = old('status', $application->status);
        if (in_array($currentStatus, ['documents_requested', 'documents_submitted'])) {
            $autoStatusLabels = [
                'documents_requested' => [
                    'label' => 'Documents Requested (Current - Auto)',
                    'hint' => 'This status was set automatically when documents were requested',
                    'badge' => ['classes' => 'bg-amber-100 text-amber-700 border border-amber-200', 'icon' => 'fas fa-file-signature text-amber-600', 'text' => 'Documents Requested'],
                ],
                'documents_submitted' => [
                    'label' => 'Documents Submitted (Current - Auto)',
                    'hint' => 'This status was set automatically when candidate submitted documents',
                    'badge' => ['classes' => 'bg-teal-100 text-teal-700 border border-teal-200', 'icon' => 'fas fa-file-upload text-teal-600', 'text' => 'Documents Submitted'],
                ],
            ];
            if (isset($autoStatusLabels[$currentStatus])) {
                // Add the current automatic status at the beginning for display
                $statusOptions = [$currentStatus => $autoStatusLabels[$currentStatus]] + $statusOptions;
            }
        }

        $documentRequestFormData = old('document_requests', $application->documentRequests->map(fn ($request) => [
            'id' => $request->id,
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'notes' => $request->notes,
            'is_submitted' => $request->is_submitted,
        ])->values()->toArray());

        $documentStatusAllowed = in_array($currentStatus, ['shortlisted', 'documents_requested', 'documents_submitted']);
    @endphp
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Application</h1>
                <p class="mt-1 text-sm text-gray-600">Update application status, capture notes, and manage requested documents</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.applications.show', $application) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Details
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Application Management</h3>
                    </div>
                    <form method="POST" action="{{ route('admin.applications.update', $application) }}" class="p-6" id="updateApplicationForm">
                        @csrf
                        @method('PUT')

                        <!-- Application Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Application Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                @foreach ($statusOptions as $value => $meta)
                                    <option value="{{ $value }}"
                                        data-hint="{{ $meta['hint'] }}"
                                        {{ old('status', $application->status) === $value ? 'selected' : '' }}>
                                        {{ $meta['label'] }}
                                    </option>
                                @endforeach
                            </select>                        <!-- Document Requests -->
                        <div id="document-requests-section" class="border-t pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Requested Documents</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Only available once the application is shortlisted. English and Arabic names are required for each document.
                                    </p>
                                </div>
                                <button type="button" id="add-document-request" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800 {{ $documentStatusAllowed ? '' : 'opacity-50 cursor-not-allowed' }}"
                                    {{ $documentStatusAllowed ? '' : 'disabled' }}>
                                    <i class="fas fa-plus mr-2"></i>Add Document Request
                                </button>
                            </div>

                            <div data-doc-disabled-message class="{{ $documentStatusAllowed ? 'hidden' : '' }} bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg px-4 py-3 mb-4">
                                Set the status to <span class="font-semibold">Shortlisted</span> to start requesting documents from the candidate.
                            </div>

                            <div data-doc-auto-status-message class="hidden bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-lg px-4 py-3 mb-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Adding document requests will automatically change the status to <span class="font-semibold">Documents Requested</span>.
                            </div>

                            <p class="text-sm text-gray-400 mb-4">These requests are visible to the candidate once you move to the "Documents Requested" status.</p>

                            <div id="document-request-rows" class="space-y-4" data-count="{{ count($documentRequestFormData) }}">
                                @forelse ($documentRequestFormData as $index => $request)
                                    @php
                                        $markedForDeletion = !empty($request['_delete']);
                                    @endphp
                                    <div class="document-request-row bg-gray-50 border border-gray-200 rounded-lg p-4 {{ $markedForDeletion ? 'opacity-50' : '' }}" data-index="{{ $index }}" data-existing="{{ !empty($request['id']) ? '1' : '0' }}" data-marked-delete="{{ $markedForDeletion ? '1' : '0' }}">
                                        @if (!empty($request['id']))
                                            <input type="hidden" name="document_requests[{{ $index }}][id]" value="{{ $request['id'] }}">
                                        @endif
                                        <input type="hidden" name="document_requests[{{ $index }}][_delete]" value="{{ $markedForDeletion ? 1 : 0 }}" data-delete-flag>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (English) *</label>
                                                <input type="text" name="document_requests[{{ $index }}][name]" value="{{ $request['name'] ?? '' }}" maxlength="255" data-doc-input {{ $documentStatusAllowed && ! $markedForDeletion ? '' : 'disabled' }} required
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('document_requests.' . $index . '.name') border-red-500 @enderror">
                                                @error('document_requests.' . $index . '.name')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (Arabic) *</label>
                                                <input type="text" name="document_requests[{{ $index }}][name_ar]" value="{{ $request['name_ar'] ?? '' }}" maxlength="255" dir="rtl" data-doc-input {{ $documentStatusAllowed && ! $markedForDeletion ? '' : 'disabled' }} required
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('document_requests.' . $index . '.name_ar') border-red-500 @enderror">
                                                @error('document_requests.' . $index . '.name_ar')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <button type="button" class="text-red-600 text-sm hover:text-red-800" data-remove-row {{ $documentStatusAllowed ? '' : 'disabled' }}>
                                                @if ($markedForDeletion)
                                                    <i class="fas fa-undo mr-1"></i>Undo
                                                @else
                                                    <i class="fas fa-times mr-1"></i>Remove
                                                @endif
                                            </button>
                                        </div>
                                        <div class="mt-4 text-sm text-red-600{{ $markedForDeletion ? '' : ' hidden' }}" data-deleted-message>This request will be removed when you save.</div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-4" data-empty-state>
                                        No documents requested yet. Once shortlisted, add each document you need with both English and Arabic titles.
                                    </p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3 pt-6 border-t">
                            <a href="{{ route('admin.applications.show', $application) }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>Update Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Information Sidebar -->
            <div class="space-y-6">
                <!-- Current Status -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Current Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                            <div class="text-sm">
                                @php
                                    $currentStatus = $application->status;
                                    $badgeMeta = $statusOptions[$currentStatus]['badge'] ?? null;
                                @endphp
                                @if ($badgeMeta)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badgeMeta['classes'] }}">
                                        @if (!empty($badgeMeta['icon']))
                                            <i class="{{ $badgeMeta['icon'] }} mr-1.5 text-[10px]"></i>
                                        @endif
                                        {{ $badgeMeta['text'] }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ \Illuminate\Support\Str::of($currentStatus)->replace('_', ' ')->title() }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Applied On</label>
                            <p class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                        </div>

                        @if ($application->updated_at != $application->created_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <p class="text-sm text-gray-900">{{ $application->updated_at->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500">{{ $application->updated_at->diffForHumans() }}</p>
                            </div>
                        @endif

                        @if ($application->interview_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Interview</label>
                                <p class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($application->interview_date)->format('M d, Y g:i A') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($application->interview_date)->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Applicant Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Applicant Summary</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $application->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                            </div>
                        </div>

                        @if ($application->user->profile)
                            <div class="space-y-2 text-sm">
                                @if ($application->user->profile->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $application->user->profile->phone }}</span>
                                    </div>
                                @endif
                                @if ($application->user->profile->location)
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $application->user->profile->location }}</span>
                                    </div>
                                @endif
                                @if ($application->user->profile->experience_years)
                                    <div class="flex items-center">
                                        <i class="fas fa-briefcase text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $application->user->profile->experience_years }} years experience</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Job Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Job Summary</h3>
                    </div>
                    <div class="p-6">
                        <h4 class="font-medium text-gray-900 mb-2">{{ $application->job->title }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ $application->job->company }}</p>

                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2 w-4"></i>
                                <span>{{ $application->job->location }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-layer-group text-gray-400 mr-2 w-4"></i>
                                <span>{{ ucfirst($application->job->level) }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 mr-2 w-4"></i>
                                <span>Deadline: {{ $application->job->deadline->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('admin.jobs.show', $application->job) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Full Job Details →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const statusHint = document.getElementById('status-hint');
            const autoStatusNotice = document.getElementById('auto-status-notice');
            const addDocButton = document.getElementById('add-document-request');
            const docRows = document.getElementById('document-request-rows');
            const disabledMessage = document.querySelector('[data-doc-disabled-message]');
            const autoStatusMessage = document.querySelector('[data-doc-auto-status-message]');
            const allowedForDocs = ['shortlisted', 'documents_requested', 'documents_submitted'];
            let docIndex = Number(docRows?.dataset.count || 0);

            if (docRows) {
                docRows.querySelectorAll('.document-request-row').forEach((row) => {
                    const currentIndex = Number(row.dataset.index);
                    if (!Number.isNaN(currentIndex) && currentIndex >= docIndex) {
                        docIndex = currentIndex + 1;
                    }
                });
            }

            const updateStatusHint = () => {
                if (!statusSelect || !statusHint) {
                    return;
                }
                const selected = statusSelect.options[statusSelect.selectedIndex];
                statusHint.textContent = selected?.dataset.hint || 'Select the current status of this application';
            };

            const toggleDocumentSection = () => {
                if (!docRows) {
                    return;
                }
                const allowed = allowedForDocs.includes(statusSelect.value);
                if (addDocButton) {
                    addDocButton.disabled = !allowed;
                    addDocButton.classList.toggle('opacity-50', !allowed);
                    addDocButton.classList.toggle('cursor-not-allowed', !allowed);
                }
                docRows.querySelectorAll('[data-doc-input]').forEach((input) => {
                    const row = input.closest('.document-request-row');
                    const isMarkedForDeletion = row?.dataset.markedDelete === '1';
                    input.disabled = !allowed || isMarkedForDeletion;
                });
                docRows.querySelectorAll('[data-remove-row]').forEach((button) => {
                    button.disabled = !allowed;
                });
                if (disabledMessage) {
                    disabledMessage.classList.toggle('hidden', allowed);
                }
                if (autoStatusMessage) {
                    autoStatusMessage.classList.toggle('hidden', !allowed);
                }
            };

            const ensureEmptyState = () => {
                if (!docRows) {
                    return;
                }
                const activeRow = docRows.querySelector('.document-request-row:not([data-marked-delete="1"])');
                const emptyState = docRows.querySelector('[data-empty-state]');
                if (!activeRow) {
                    if (!emptyState) {
                        const placeholder = document.createElement('p');
                        placeholder.className = 'text-sm text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-4';
                        placeholder.dataset.emptyState = 'true';
                        placeholder.textContent = 'No documents requested yet. Once shortlisted, add each document you need with both English and Arabic titles.';
                        docRows.appendChild(placeholder);
                    }
                } else if (emptyState) {
                    emptyState.remove();
                }
            };

            const buildRow = (index) => {
                const row = document.createElement('div');
                row.className = 'document-request-row bg-gray-50 border border-gray-200 rounded-lg p-4';
                row.dataset.index = index;
                row.dataset.existing = '0';
                row.dataset.markedDelete = '0';
                row.innerHTML = `
                    <input type="hidden" name="document_requests[${index}][_delete]" value="0" data-delete-flag>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (English) *</label>
                            <input type="text" name="document_requests[${index}][name]" maxlength="255" data-doc-input required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Document Name (Arabic) *</label>
                            <input type="text" name="document_requests[${index}][name_ar]" maxlength="255" dir="rtl" data-doc-input required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button type="button" class="text-red-600 text-sm hover:text-red-800" data-remove-row>
                            <i class="fas fa-times mr-1"></i>Remove
                        </button>
                    </div>
                    <div class="mt-4 hidden text-sm text-red-600" data-deleted-message>This request will be removed when you save.</div>
                `;
                return row;
            };

            addDocButton?.addEventListener('click', () => {
                if (!docRows) {
                    return;
                }

                const row = buildRow(docIndex++);
                docRows.appendChild(row);
                row.querySelectorAll('[data-doc-input]').forEach((input) => {
                    input.disabled = false;
                });

                const shouldAutoSetDocumentsStatus = statusSelect && statusSelect.value === 'shortlisted';

                if (shouldAutoSetDocumentsStatus) {
                    let autoOption = statusSelect.querySelector('option[value="documents_requested"]');

                    if (!autoOption) {
                        autoOption = document.createElement('option');
                        autoOption.value = 'documents_requested';
                        autoOption.dataset.hint = 'This status was set automatically when documents were requested';
                        autoOption.textContent = 'Documents Requested (Auto)';
                        autoOption.dataset.autoGenerated = 'true';
                        statusSelect.appendChild(autoOption);
                    }

                    statusSelect.value = 'documents_requested';
                    if (autoStatusNotice) {
                        autoStatusNotice.classList.remove('hidden');
                    }
                }

                ensureEmptyState();
                updateStatusHint();
                toggleDocumentSection();
            });

            docRows?.addEventListener('click', (event) => {
                const target = event.target instanceof HTMLElement ? event.target.closest('[data-remove-row]') : null;
                if (!target) {
                    return;
                }
                const row = target.closest('.document-request-row');
                if (!row) {
                    return;
                }
                const deleteFlag = row.querySelector('[data-delete-flag]');
                const isExisting = row.dataset.existing === '1';
                const isMarked = row.dataset.markedDelete === '1';

                if (isExisting) {
                    if (!isMarked) {
                        row.dataset.markedDelete = '1';
                        row.classList.add('opacity-50');
                        if (deleteFlag) {
                            deleteFlag.value = '1';
                        }
                        row.querySelector('[data-deleted-message]')?.classList.remove('hidden');
                        target.innerHTML = '<i class="fas fa-undo mr-1"></i>Undo';
                    } else {
                        row.dataset.markedDelete = '0';
                        row.classList.remove('opacity-50');
                        if (deleteFlag) {
                            deleteFlag.value = '0';
                        }
                        row.querySelector('[data-deleted-message]')?.classList.add('hidden');
                        target.innerHTML = '<i class="fas fa-times mr-1"></i>Remove';
                    }
                } else {
                    row.remove();
                }

                ensureEmptyState();
                toggleDocumentSection();
            });

            updateStatusHint();
            toggleDocumentSection();
            ensureEmptyState();

            statusSelect?.addEventListener('change', () => {
                updateStatusHint();
                toggleDocumentSection();
                if (autoStatusNotice) {
                    autoStatusNotice.classList.add('hidden');
                }

                if (statusSelect) {
                    const autoOption = statusSelect.querySelector('option[value="documents_requested"][data-auto-generated="true"]');
                    if (autoOption && statusSelect.value !== 'documents_requested') {
                        autoOption.remove();
                    }
                }
            });

            // Status change confirmation
            const form = document.getElementById('updateApplicationForm');
            const statusSelect = document.getElementById('status');
            const initialStatus = '{{ $application->status }}';
            let pendingSubmit = false;

            form?.addEventListener('submit', function(e) {
                if (pendingSubmit) {
                    return true;
                }

                const newStatus = statusSelect?.value;

                if (newStatus === 'hired' && newStatus !== initialStatus) {
                    e.preventDefault();
                    showStatusConfirmModal('hired');
                    return false;
                } else if (newStatus === 'rejected' && newStatus !== initialStatus) {
                    e.preventDefault();
                    showStatusConfirmModal('rejected');
                    return false;
                }
            });

            function showStatusConfirmModal(status) {
                const modal = document.getElementById('statusConfirmModal');
                const title = document.getElementById('statusConfirmTitle');
                const message = document.getElementById('statusConfirmMessage');
                const confirmBtn = document.getElementById('statusConfirmBtn');

                if (status === 'hired') {
                    title.textContent = 'Hire Candidate';
                    message.innerHTML = `
                        <p class="text-sm text-gray-700 mb-3">Are you sure you want to mark this application as <strong>Hired</strong>?</p>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-[10px]">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-2"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Important:</p>
                                    <p>This candidate will be added to the Employees section. Once added, the employee record can only be removed by the Client HR.</p>
                                </div>
                            </div>
                        </div>
                    `;
                    confirmBtn.textContent = 'Hire Candidate';
                    confirmBtn.className = 'flex-1 px-4 py-2 rounded-[10px] bg-green-600 hover:bg-green-700 text-white transition-colors font-medium';
                } else if (status === 'rejected') {
                    title.textContent = 'Reject Application';
                    message.innerHTML = `
                        <p class="text-sm text-gray-700 mb-3">Are you sure you want to mark this application as <strong>Rejected</strong>?</p>
                        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-[10px]">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 mr-2"></i>
                                <div class="text-sm text-amber-800">
                                    <p>The candidate will be notified that their application was not successful.</p>
                                </div>
                            </div>
                        </div>
                    `;
                    confirmBtn.textContent = 'Reject Application';
                    confirmBtn.className = 'flex-1 px-4 py-2 rounded-[10px] bg-red-600 hover:bg-red-700 text-white transition-colors font-medium';
                }

                modal.classList.remove('hidden');
            }

            function closeStatusConfirmModal() {
                document.getElementById('statusConfirmModal').classList.add('hidden');
            }

            function confirmStatusChange() {
                pendingSubmit = true;
                closeStatusConfirmModal();
                form.submit();
            }

            // Close modal when clicking outside
            document.getElementById('statusConfirmModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeStatusConfirmModal();
                }
            });
        });
    </script>

    <!-- Status Confirmation Modal -->
    <div id="statusConfirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-[10px] bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-[10px]">
                    <i class="fas fa-user-check text-blue-600 text-2xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 id="statusConfirmTitle" class="text-lg font-medium text-gray-900 mb-3">Confirm Status Change</h3>
                    <div id="statusConfirmMessage" class="text-left"></div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeStatusConfirmModal()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors font-medium">
                        Cancel
                    </button>
                    <button id="statusConfirmBtn" onclick="confirmStatusChange()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-blue-600 hover:bg-blue-700 text-white transition-colors font-medium">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
