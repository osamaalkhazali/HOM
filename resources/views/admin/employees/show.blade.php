@extends('layouts.admin.app')

@section('title', 'Employee Details')

@push('styles')
    <style>
        .folder-card {
            position: relative;
            overflow: hidden;
        }

        .folder-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .folder-card:hover::before {
            opacity: 1;
        }

        .folders-grid {
            animation: fadeIn 0.3s ease-in;
        }

        .file-card {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="h-full">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.employees.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $employee->user->name }}</h1>
                    <p class="text-sm text-gray-600">{{ $employee->position_title }}</p>
                </div>
            </div>
            @if (auth('admin')->user()->canManageEmployees())
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.employees.edit', $employee) }}"
                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-[10px] transition-colors">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <button type="button"
                        onclick="confirmDeleteEmployee({{ $employee->id }}, '{{ $employee->user->name }}')"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-[10px] transition-colors">
                        <i class="fas fa-trash"></i>
                        <span>Delete</span>
                    </button>
                    <form id="delete-employee-form-{{ $employee->id }}" method="POST"
                        action="{{ route('admin.employees.destroy', $employee) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endif
        </div>

        <!-- Main Layout: Sidebar + Documents -->
        <div class="flex gap-6 h-full">
            <!-- Left Sidebar: Employee Info -->
            <div class="w-80 flex-shrink-0 space-y-4">
                <!-- User Profile Card -->
                <div class="bg-white rounded-[10px] shadow overflow-hidden">
                    <div class="p-6 text-center border-b border-gray-200">
                        <div class="h-24 w-24 rounded-[10px] mx-auto flex items-center justify-center text-white text-3xl font-bold mb-4"
                            style="background-color: #18458f;">
                            {{ substr($employee->user->name, 0, 2) }}
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">{{ $employee->user->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $employee->user->email }}</p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $employee->status_color }}-100 text-{{ $employee->status_color }}-800 mt-2">
                            {{ $employee->status_label }}
                        </span>
                    </div>

                    @if ($employee->user->profile)
                        <div class="p-4 space-y-3 text-sm">
                            @if ($employee->user->profile->phone)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-phone text-gray-400 w-5"></i>
                                    <span class="text-gray-700">{{ $employee->user->profile->phone }}</span>
                                </div>
                            @endif
                            @if ($employee->user->profile->date_of_birth)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-birthday-cake text-gray-400 w-5"></i>
                                    <span
                                        class="text-gray-700">{{ $employee->user->profile->date_of_birth->format('M d, Y') }}</span>
                                </div>
                            @endif
                            @if ($employee->user->profile->nationality)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-flag text-gray-400 w-5"></i>
                                    <span class="text-gray-700">{{ $employee->user->profile->nationality }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Employment Info Card -->
                <div class="bg-white rounded-[10px] shadow overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200" style="background-color: rgba(24, 69, 143, 0.05);">
                        <h3 class="text-sm font-semibold" style="color: #18458f;">Employment Details</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Position</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $employee->position_title }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Hire Date</label>
                            <p class="text-sm text-gray-900">
                                {{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        @if ($employee->end_date)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">End Date</label>
                                <p class="text-sm text-gray-900">{{ $employee->end_date->format('M d, Y') }}</p>
                            </div>
                        @endif
                        @if ($employee->notes)
                            <div class="pt-3 border-t border-gray-200">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Notes</label>
                                <p class="text-xs text-gray-700 whitespace-pre-wrap">{{ $employee->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Job Info Card -->
                @if ($employee->job)
                    <div class="bg-white rounded-[10px] shadow overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200" style="background-color: rgba(24, 69, 143, 0.05);">
                            <h3 class="text-sm font-semibold" style="color: #18458f;">Job Information</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Job Title</label>
                                <p class="text-sm font-semibold text-gray-900">{{ $employee->job->title }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Company</label>
                                <p class="text-sm text-gray-900">{{ $employee->job->company }}</p>
                            </div>
                            @if ($employee->client)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Client</label>
                                    <p class="text-sm text-gray-900">{{ $employee->client->name }}</p>
                                </div>
                            @endif
                            @if ($employee->job->location)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Location</label>
                                    <p class="text-sm text-gray-900">{{ $employee->job->location }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-[10px] shadow overflow-hidden">
                    <div class="p-4 space-y-2">
                        <a href="{{ route('admin.users.show', $employee->user) }}"
                            class="flex items-center gap-2 text-sm px-3 py-2 rounded-[10px] border border-gray-300 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user"></i>
                            <span>View Full Profile</span>
                        </a>
                        @if ($employee->application)
                            <a href="{{ route('admin.applications.show', $employee->application) }}"
                                class="flex items-center gap-2 text-sm px-3 py-2 rounded-[10px] border border-gray-300 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-file-alt"></i>
                                <span>View Application</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side: Documents (Google Drive Style) -->
            <div class="flex-1 bg-white rounded-[10px] shadow overflow-hidden flex flex-col">
                <!-- Documents Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between"
                    style="background-color: rgba(24, 69, 143, 0.05);">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-folder-open text-2xl" style="color: #18458f;"></i>
                        <div>
                            <h3 class="text-lg font-semibold" style="color: #18458f;">Documents</h3>
                            <p class="text-xs text-gray-600">
                                <span id="breadcrumb">Employee Documents</span>
                            </p>
                        </div>
                    </div>
                    @if (auth('admin')->user()->canManageEmployeeDocuments())
                        <button type="button" onclick="openUploadModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-[10px] text-white font-medium shadow-sm hover:shadow transition-all"
                            style="background-color: #18458f;">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Upload</span>
                        </button>
                    @endif
                </div>

                <!-- Documents Content Area -->
                <div class="flex-1 overflow-y-auto p-6 bg-gray-50" id="documentsArea">
                    <!-- Folder View (Default) -->
                    <div id="folderView" class="folders-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        @php
                            $folders = \App\Models\EmployeeDocument::getDocumentTypes();
                            $documentCounts = $employee->documents->countBy('document_type');
                            $totalCount = $employee->documents->count();
                        @endphp

                        @foreach ($folders as $type => $config)
                            @php
                                $count = $type === 'all' ? $totalCount : $documentCounts[$type] ?? 0;
                            @endphp
                            <div class="folder-card bg-white border-2 border-gray-200 p-4 hover:shadow-2xl hover:border-gray-300 transition-all duration-300 cursor-pointer hover:-translate-y-2"
                                style="border-radius: 10px;" onclick="openFolder('{{ $type }}')"
                                data-type="{{ $type }}">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 flex items-center justify-center text-2xl mb-3 transition-all duration-300"
                                        style="border-radius: 10px; background: linear-gradient(135deg, {{ $config['color'] }}20 0%, {{ $config['color'] }}35 100%); box-shadow: 0 4px 15px {{ $config['color'] }}25;">
                                        <i class="{{ $config['icon'] }}" style="color: {{ $config['color'] }};"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-2">{{ $config['name'] }}</h4>
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold"
                                        style="border-radius: 10px; background-color: {{ $config['color'] }}15; color: {{ $config['color'] }};">
                                        <i class="fas fa-file text-xs"></i>
                                        <span class="folder-count">{{ $count }}</span>
                                        <span>{{ $count === 1 ? 'file' : 'files' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Files View (Hidden by default) -->
                    <div id="filesView" class="hidden">
                        <!-- Back Button -->
                        <div class="mb-6">
                            <button onclick="backToFolders()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-[10px] font-semibold text-white shadow-lg hover:shadow-xl transition-all"
                                style="background-color: #18458f;">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Folders</span>
                            </button>
                        </div>

                        <!-- Files Grid -->
                        <div id="filesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                            <!-- Files will be injected here via JavaScript -->
                        </div>

                        <!-- Empty State -->
                        <div id="emptyState" class="hidden">
                            <div class="flex flex-col items-center justify-center py-16">
                                <div class="w-32 h-32 rounded-[10px] flex items-center justify-center mb-6"
                                    style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                                    <i class="fas fa-folder-open text-gray-400 text-5xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No documents in this folder</h3>
                                <p class="text-sm text-gray-500 mb-6 text-center max-w-sm">
                                    This folder is empty. Upload documents to get started.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Document Preview View (Hidden by default) -->
                    <div id="documentPreview" class="hidden">
                        <!-- Back Button -->
                        <div class="mb-6">
                            <button onclick="closeDocumentPreview()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-[10px] font-semibold text-white shadow-lg hover:shadow-xl transition-all"
                                style="background-color: #18458f;">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Files</span>
                            </button>
                        </div>

                        <!-- Preview Content -->
                        <div id="previewContent" class="bg-white rounded-[10px] shadow-lg overflow-hidden">
                            <!-- Content will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Data (Hidden) -->
    <script>
        const employeeDocuments = @json($employee->documents->toArray());
        const documentTypes = @json(\App\Models\EmployeeDocument::getDocumentTypes());
        let currentFolder = null;
    </script>

    <!-- Upload Document Modal -->
    @if (auth('admin')->user()->canManageEmployeeDocuments())
        <div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-[10px] bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Upload Document</h3>
                    <button type="button" onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.employees.documents.store', $employee) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="document_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Document Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="document_name" id="document_name" required
                                class="w-full border border-gray-300 rounded-[10px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., Employment Contract">
                        </div>

                        <div>
                            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Document Type <span class="text-red-500">*</span>
                            </label>
                            <select name="document_type" id="document_type" required
                                class="w-full border border-gray-300 rounded-[10px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select type...</option>
                                <option value="contract">Contract</option>
                                <option value="warning">Warning</option>
                                <option value="appreciation">Appreciation</option>
                                <option value="medical">Medical</option>
                                <option value="evaluation">Evaluation</option>
                                <option value="promotion">Promotion</option>
                                <option value="resignation">Resignation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
                                File <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="file" id="file" required
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip"
                                class="w-full border border-gray-300 rounded-[10px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP (Max:
                                10MB)</p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes
                                (Optional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full border border-gray-300 rounded-[10px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Add any additional notes about this document..."></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-4">
                            <button type="submit" class="flex-1 px-4 py-2 rounded-[10px] text-white transition-colors"
                                style="background-color: #18458f;">
                                <i class="fas fa-upload mr-2"></i>Upload Document
                            </button>
                            <button type="button" onclick="closeUploadModal()"
                                class="flex-1 px-4 py-2 rounded-[10px] bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openUploadModal() {
                const modal = document.getElementById('uploadModal');
                const typeSelect = document.getElementById('document_type');
                const availableOptions = typeSelect ? Array.from(typeSelect.options).map(option => option.value) : [];
                const targetType = currentFolder && currentFolder !== 'all' && availableOptions.includes(currentFolder)
                    ? currentFolder
                    : '';

                if (typeSelect) {
                    typeSelect.value = targetType;
                }

                if (modal) {
                    modal.classList.remove('hidden');
                }
            }

            function closeUploadModal() {
                document.getElementById('uploadModal').classList.add('hidden');
                document.getElementById('document_name').value = '';
                document.getElementById('document_type').value = '';
                document.getElementById('file').value = '';
                document.getElementById('notes').value = '';
            }

            // Folder Navigation Functions
            function openFolder(type) {
                currentFolder = type;

                // Update breadcrumb
                const folderName = documentTypes[type]?.name || 'Unknown';
                document.getElementById('breadcrumb').textContent = `Employee Documents / ${folderName}`;

                // Hide folder view, show files view
                document.getElementById('folderView').classList.add('hidden');
                document.getElementById('filesView').classList.remove('hidden');

                // Filter and display documents
                const filteredDocs = type === 'all' ?
                    employeeDocuments :
                    employeeDocuments.filter(doc => doc.document_type === type);

                displayFiles(filteredDocs);
            }

            function backToFolders() {
                currentFolder = null;
                document.getElementById('breadcrumb').textContent = 'Employee Documents';
                document.getElementById('filesView').classList.add('hidden');
                document.getElementById('folderView').classList.remove('hidden');
            }

            function displayFiles(documents) {
                const filesGrid = document.getElementById('filesGrid');
                const emptyState = document.getElementById('emptyState');

                if (!documents || documents.length === 0) {
                    filesGrid.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    return;
                }

                emptyState.classList.add('hidden');
                filesGrid.classList.remove('hidden');

                try {
                    filesGrid.innerHTML = documents.map(doc => createFileCard(doc)).join('');
                } catch (error) {
                    console.error('Error creating file cards:', error);
                    filesGrid.innerHTML = '<div class="col-span-full text-center text-red-500">Error loading documents</div>';
                }
            }

            function createFileCard(doc) {
                if (!doc) {
                    console.error('Document is null or undefined');
                    return '';
                }

                const typeConfig = documentTypes[doc.document_type] || documentTypes.other || {
                    name: 'Other',
                    icon: '📦',
                    color: '#18458f'
                };

                const fileIcon = getFileIcon(doc.file_path || '');
                const notes = doc.notes || '';
                const hasNotes = notes.trim() !== '';
                const canManage = {{ auth('admin')->user()->canManageEmployeeDocuments() ? 'true' : 'false' }};
                const docName = doc.document_name || 'Untitled Document';
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                return `
        <div class="group bg-white border-2 border-gray-200 p-4 hover:shadow-2xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1 cursor-pointer relative"
             style="border-radius: 10px;"
             onclick="previewDocument(${doc.id}, ${doc.employee_id})">

            <!-- File Icon with Dropdown -->
            <div class="relative mb-3">
                <div class="flex items-center justify-center h-20 transition-all duration-300"
                     style="border-radius: 10px; background: linear-gradient(135deg, ${typeConfig.color}15 0%, ${typeConfig.color}25 100%);">
                    <i class="${fileIcon} text-4xl transition-transform group-hover:scale-110"></i>

                    <!-- Actions Dropdown Menu (inside icon container) -->
                    <div class="absolute top-2 right-2 z-10" onclick="event.stopPropagation();">
                        <button onclick="toggleDropdown(${doc.id})"
                                class="w-7 h-7 flex items-center justify-center transition-all"
                                style="border-radius: 10px; background-color: rgba(255, 255, 255, 0.9);"
                                onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 1)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)'"
                                onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.9)'; this.style.boxShadow='none'"
                                title="Actions">
                            <i class="fas fa-ellipsis-v text-gray-700 text-sm"></i>
                        </button>
                <div id="dropdown-${doc.id}" class="hidden absolute right-0 mt-1 w-40 bg-white shadow-xl border border-gray-200 py-1 z-20"
                     style="border-radius: 10px;">
                    <button onclick="event.stopPropagation(); previewDocument(${doc.id}, ${doc.employee_id}); toggleDropdown(${doc.id})"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2"
                            style="color: #18458f;">
                        <i class="fas fa-eye w-4"></i>
                        <span>View</span>
                    </button>
                    <a href="/admin/employees/${doc.employee_id}/documents/${doc.id}/download"
                       class="block px-4 py-2 text-sm text-emerald-600 hover:bg-gray-50 flex items-center gap-2"
                       onclick="event.stopPropagation(); toggleDropdown(${doc.id})">
                        <i class="fas fa-download w-4"></i>
                        <span>Download</span>
                    </a>
                    ${canManage ? `
                                    <hr class="my-1">
                                    <button type="button"
                                            onclick="event.stopPropagation(); confirmDeleteDocument(${doc.id}, '${docName}', ${doc.employee_id}); toggleDropdown(${doc.id})"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 flex items-center gap-2">
                                        <i class="fas fa-trash-alt w-4"></i>
                                        <span>Delete</span>
                                    </button>
                                    ` : ''}
                </div>
                    </div>
                </div>
            </div>

            <!-- Document Name -->
            <h4 class="text-sm font-bold text-gray-900 mb-2 truncate group-hover:text-blue-600 transition-colors" title="${docName}">
                ${docName}
            </h4>

            <!-- Type Badge and Note Badge -->
            <div class="flex items-center gap-2 mb-2 flex-wrap">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold text-white"
                      style="border-radius: 10px; background-color: ${typeConfig.color};">
                    <i class="${typeConfig.icon} text-xs"></i>
                    <span>${typeConfig.name}</span>
                </span>
                ${hasNotes ? '<span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold bg-amber-500 text-white" style="border-radius: 10px;"><i class="fas fa-sticky-note"></i> Note</span>' : ''}
            </div>

            <!-- Date -->
            <div class="flex items-center gap-1 text-xs text-gray-500">
                <i class="fas fa-calendar text-gray-400"></i>
                <span>${formatDate(doc.created_at)}</span>
            </div>
        </div>
    `;
            }

            function getFileIcon(filePath) {
                const ext = filePath.split('.').pop().toLowerCase();
                const iconMap = {
                    'pdf': 'fas fa-file-pdf text-red-500',
                    'doc': 'fas fa-file-word text-blue-500',
                    'docx': 'fas fa-file-word text-blue-500',
                    'xls': 'fas fa-file-excel text-green-500',
                    'xlsx': 'fas fa-file-excel text-green-500',
                    'jpg': 'fas fa-file-image text-purple-500',
                    'jpeg': 'fas fa-file-image text-purple-500',
                    'png': 'fas fa-file-image text-purple-500',
                    'gif': 'fas fa-file-image text-purple-500',
                    'zip': 'fas fa-file-archive text-yellow-500',
                    'rar': 'fas fa-file-archive text-yellow-500',
                };
                return iconMap[ext] || 'fas fa-file text-gray-500';
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return date.toLocaleDateString('en-US', options);
            }

            function previewDocument(docId, employeeId) {
                const doc = employeeDocuments.find(d => d.id === docId);
                if (!doc) return;

                const typeConfig = documentTypes[doc.document_type] || documentTypes.other;
                const fileExt = doc.file_path.split('.').pop().toLowerCase();

                // Update breadcrumb
                const folderName = documentTypes[currentFolder]?.name || 'Unknown';
                document.getElementById('breadcrumb').textContent = `Employee Documents / ${folderName} / ${doc.document_name}`;

                // Hide files view, show preview
                document.getElementById('filesView').classList.add('hidden');
                document.getElementById('documentPreview').classList.remove('hidden');

                const previewContent = document.getElementById('previewContent');
                let previewHTML = '';

                // Add file-specific preview
                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                    // Image preview
                    previewHTML = `
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[10px] text-sm font-semibold text-white"
                              style="background-color: ${typeConfig.color};">
                            <i class="${typeConfig.icon}"></i>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">${doc.document_name}</h3>
                            <p class="text-sm text-gray-500">${formatDate(doc.created_at)}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/admin/employees/${employeeId}/documents/${docId}/download"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-[10px] bg-emerald-600 text-white hover:bg-emerald-700 transition-all"
                           title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                ${doc.notes ? `
                                <div class="mb-4 p-3 bg-amber-50 border-l-4 border-amber-500 rounded-r">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-sticky-note text-amber-600 mt-0.5"></i>
                                        <div>
                                            <div class="text-xs font-semibold text-amber-900 mb-1">Note:</div>
                                            <p class="text-sm text-gray-700">${doc.notes}</p>
                                        </div>
                                    </div>
                                </div>
                                ` : ''}
                <div class="bg-gray-50 rounded-[10px] p-4 flex items-center justify-center">
                    <img src="/admin/employees/${employeeId}/documents/${docId}/view"
                         alt="${doc.document_name}"
                         class="max-w-full h-auto rounded-[10px] shadow-lg">
                </div>
            </div>
        `;
                } else if (fileExt === 'pdf') {
                    // PDF preview with iframe
                    previewHTML = `
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[10px] text-sm font-semibold text-white"
                              style="background-color: ${typeConfig.color};">
                            <i class="${typeConfig.icon}"></i>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">${doc.document_name}</h3>
                            <p class="text-sm text-gray-500">${formatDate(doc.created_at)}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/admin/employees/${employeeId}/documents/${docId}/view"
                           target="_blank"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-[10px] text-white transition-all"
                           style="background-color: #18458f;"
                           title="Open in New Tab">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="/admin/employees/${employeeId}/documents/${docId}/download"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-[10px] bg-emerald-600 text-white hover:bg-emerald-700 transition-all"
                           title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                ${doc.notes ? `
                                <div class="mb-4 p-3 bg-amber-50 border-l-4 border-amber-500 rounded-r">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-sticky-note text-amber-600 mt-0.5"></i>
                                        <div>
                                            <div class="text-xs font-semibold text-amber-900 mb-1">Note:</div>
                                            <p class="text-sm text-gray-700">${doc.notes}</p>
                                        </div>
                                    </div>
                                </div>
                                ` : ''}
                <div class="bg-gray-100 rounded-[10px] overflow-hidden" style="height: 800px;">
                    <iframe src="/admin/employees/${employeeId}/documents/${docId}/view"
                            class="w-full h-full border-0"
                            title="${doc.document_name}">
                    </iframe>
                </div>
            </div>
        `;
                } else if (['doc', 'docx', 'xls', 'xlsx'].includes(fileExt)) {
                    // Word/Excel document - not previewable, download only
                    previewHTML = `
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[10px] text-sm font-semibold text-white"
                              style="background-color: ${typeConfig.color};">
                            <i class="${typeConfig.icon}"></i>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">${doc.document_name}</h3>
                            <p class="text-sm text-gray-500">${formatDate(doc.created_at)}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/admin/employees/${employeeId}/documents/${docId}/view"
                           target="_blank"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-[10px] text-white transition-all"
                           style="background-color: #18458f;"
                           title="Open in New Tab">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="/admin/employees/${employeeId}/documents/${docId}/download"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-[10px] bg-emerald-600 text-white hover:bg-emerald-700 transition-all"
                           title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                ${doc.notes ? `
                                <div class="mb-4 p-3 bg-amber-50 border-l-4 border-amber-500 rounded-r">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-sticky-note text-amber-600 mt-0.5"></i>
                                        <div>
                                            <div class="text-xs font-semibold text-amber-900 mb-1">Note:</div>
                                            <p class="text-sm text-gray-700">${doc.notes}</p>
                                        </div>
                                    </div>
                                </div>
                                ` : ''}
                <div class="flex flex-col items-center justify-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-[10px] border-2 border-dashed border-gray-300">
                    <div class="w-24 h-24 rounded-[10px] flex items-center justify-center mb-6"
                         style="background: linear-gradient(135deg, ${typeConfig.color}15 0%, ${typeConfig.color}25 100%);">
                        <i class="${getFileIcon(doc.file_path)} text-5xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">${fileExt.toUpperCase()} Document</h4>
                    <p class="text-sm text-gray-600 mb-1 text-center max-w-md">Preview not available for ${['doc', 'docx'].includes(fileExt) ? 'Word' : 'Excel'} documents</p>
                    <p class="text-xs text-gray-500 mb-6 text-center max-w-md">Please download the file to view it in Microsoft ${['doc', 'docx'].includes(fileExt) ? 'Word' : 'Excel'}</p>
                    <a href="/admin/employees/${employeeId}/documents/${docId}/download"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-[10px] bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-download"></i>
                        <span>Download to View</span>
                    </a>
                </div>
            </div>
        `;
                } else {
                    // Other file types - download only
                    previewHTML = `
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[10px] text-sm font-semibold text-white"
                              style="background-color: ${typeConfig.color};">
                            <i class="${typeConfig.icon}"></i>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">${doc.document_name}</h3>
                            <p class="text-sm text-gray-500">${formatDate(doc.created_at)}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="/admin/employees/${employeeId}/documents/${docId}/download"
                           class="inline-flex items-center justify-center w-10 h-10 rounded-[10px] bg-emerald-600 text-white hover:bg-emerald-700 transition-all"
                           title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                ${doc.notes ? `
                                <div class="mb-4 p-3 bg-amber-50 border-l-4 border-amber-500 rounded-r">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-sticky-note text-amber-600 mt-0.5"></i>
                                        <div>
                                            <div class="text-xs font-semibold text-amber-900 mb-1">Note:</div>
                                            <p class="text-sm text-gray-700">${doc.notes}</p>
                                        </div>
                                    </div>
                                </div>
                                ` : ''}
                <div class="flex flex-col items-center justify-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-[10px] border-2 border-dashed border-gray-300">
                    <div class="w-24 h-24 rounded-[10px] flex items-center justify-center mb-6"
                         style="background: linear-gradient(135deg, ${typeConfig.color}15 0%, ${typeConfig.color}25 100%);">
                        <i class="${getFileIcon(doc.file_path)} text-5xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">${fileExt.toUpperCase()} File</h4>
                    <p class="text-sm text-gray-600 mb-6 text-center max-w-md">Preview not available for this file type. Please download to view.</p>
                    <a href="/admin/employees/${employeeId}/documents/${docId}/download"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-[10px] bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-download"></i>
                        <span>Download to View</span>
                    </a>
                </div>
            </div>
        `;
                }

                previewContent.innerHTML = previewHTML;
            }

            function closeDocumentPreview() {
                // Update breadcrumb back to folder
                const folderName = documentTypes[currentFolder]?.name || 'Unknown';
                document.getElementById('breadcrumb').textContent = `Employee Documents / ${folderName}`;

                // Show files view, hide preview
                document.getElementById('documentPreview').classList.add('hidden');
                document.getElementById('filesView').classList.remove('hidden');
            }

            function closePreview() {
                // This function is no longer needed but keeping for compatibility
                closeDocumentPreview();
            }

            function toggleDropdown(docId) {
                const dropdown = document.getElementById(`dropdown-${docId}`);
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

                // Close all other dropdowns
                allDropdowns.forEach(d => {
                    if (d.id !== `dropdown-${docId}`) {
                        d.classList.add('hidden');
                    }
                });

                // Toggle current dropdown
                dropdown.classList.toggle('hidden');
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('[id^="dropdown-"]') && !event.target.closest('button')) {
                    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                    allDropdowns.forEach(d => d.classList.add('hidden'));
                }
            });

            // Delete confirmation functions
            let deleteEmployeeFormId = null;
            let deleteDocumentData = null;

            function confirmDeleteEmployee(employeeId, employeeName) {
                deleteEmployeeFormId = 'delete-employee-form-' + employeeId;
                document.getElementById('deleteEmployeeName').textContent = employeeName;
                document.getElementById('deleteEmployeeModal').classList.remove('hidden');
            }

            function confirmDeleteDocument(docId, docName, employeeId) {
                deleteDocumentData = {
                    docId: docId,
                    employeeId: employeeId
                };
                document.getElementById('deleteDocumentName').textContent = docName;
                document.getElementById('deleteDocumentModal').classList.remove('hidden');
            }

            function closeDeleteEmployeeModal() {
                document.getElementById('deleteEmployeeModal').classList.add('hidden');
                deleteEmployeeFormId = null;
            }

            function closeDeleteDocumentModal() {
                document.getElementById('deleteDocumentModal').classList.add('hidden');
                deleteDocumentData = null;
            }

            function submitDeleteEmployeeForm() {
                if (deleteEmployeeFormId) {
                    document.getElementById(deleteEmployeeFormId).submit();
                }
            }

            function submitDeleteDocumentForm() {
                if (deleteDocumentData) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/employees/${deleteDocumentData.employeeId}/documents/${deleteDocumentData.docId}`;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Close modals when clicking outside
            document.getElementById('deleteEmployeeModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteEmployeeModal();
                }
            });

            document.getElementById('deleteDocumentModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteDocumentModal();
                }
            });
        </script>

        <!-- Delete Employee Confirmation Modal -->
        <div id="deleteEmployeeModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-[10px] bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-[10px]">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Employee Record</h3>
                        <p class="text-sm text-gray-500 mb-1">Are you sure you want to delete</p>
                        <p class="text-sm font-semibold text-gray-900 mb-4" id="deleteEmployeeName"></p>
                        <p class="text-sm text-red-600">This action cannot be undone and will delete all associated
                            documents.</p>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button onclick="closeDeleteEmployeeModal()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors font-medium">
                            Cancel
                        </button>
                        <button onclick="submitDeleteEmployeeForm()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-red-600 hover:bg-red-700 text-white transition-colors font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Document Confirmation Modal -->
        <div id="deleteDocumentModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-[10px] bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-[10px]">
                        <i class="fas fa-file-times text-red-600 text-2xl"></i>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Document</h3>
                        <p class="text-sm text-gray-500 mb-1">Are you sure you want to delete</p>
                        <p class="text-sm font-semibold text-gray-900 mb-4" id="deleteDocumentName"></p>
                        <p class="text-sm text-red-600">This action cannot be undone.</p>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button onclick="closeDeleteDocumentModal()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors font-medium">
                            Cancel
                        </button>
                        <button onclick="submitDeleteDocumentForm()"
                            class="flex-1 px-4 py-2 rounded-[10px] bg-red-600 hover:bg-red-700 text-white transition-colors font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
