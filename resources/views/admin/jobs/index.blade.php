@extends('layouts.admin.app')

@section('title', 'Job Management')

@section('content')
    @php
        $exportFormats = [
            'excel' => ['label' => 'Excel', 'icon' => 'fas fa-file-excel text-green-600'],
            'csv' => ['label' => 'CSV', 'icon' => 'fas fa-file-code text-amber-600'],
            'pdf' => ['label' => 'PDF', 'icon' => 'fas fa-file-pdf text-red-600'],
        ];

        $filteredParams = $exportQuery ?? [];
        unset($filteredParams['scope'], $filteredParams['format']);

        $advancedFilterKeys = ['category', 'status', 'level', 'deadline_status', 'has_applications', 'has_questions', 'has_documents', 'sort', 'direction'];
        $advancedActive = collect($advancedFilterKeys)->contains(fn ($key) => filled(request($key)));
    @endphp

    <!-- Header -->
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Job Management</h1>
            <p class="text-gray-600 mt-2">Manage all job postings and their status on your portal.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.jobs.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="fas fa-plus mr-2"></i>Add New Job
            </a>
            <div class="relative">
                <button type="button"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                        data-dropdown-toggle="jobs-export-menu"
                        aria-expanded="false">
                    <i class="fas fa-download"></i>
                    <span>Export</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div id="jobs-export-menu"
                     class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-30"
                     data-dropdown-menu>
                    <div class="py-2 text-sm text-gray-700">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">Current results</div>
                        @foreach($exportFormats as $formatKey => $formatMeta)
                            <a href="{{ route('admin.jobs.export', array_merge(['format' => $formatKey, 'scope' => 'filtered'], $filteredParams)) }}"
                               class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                <i class="{{ $formatMeta['icon'] }}"></i>
                                <span>{{ $formatMeta['label'] }} (Filtered)</span>
                            </a>
                        @endforeach
                        <div class="my-2 border-t border-gray-100"></div>
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">All records</div>
                        @foreach($exportFormats as $formatKey => $formatMeta)
                            <a href="{{ route('admin.jobs.export', ['format' => $formatKey, 'scope' => 'all']) }}"
                               class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                <i class="{{ $formatMeta['icon'] }}"></i>
                                <span>{{ $formatMeta['label'] }} (All)</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="space-y-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search jobs</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Search titles, companies, locations, requirements..."
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-filter"></i>
                            <span>Apply</span>
                        </button>
                        <a href="{{ route('admin.jobs.index') }}"
                           class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-200">
                            <i class="fas fa-rotate-left"></i>
                            <span>Clear</span>
                        </a>
                        <button type="button"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm"
                                id="jobs-advanced-toggle"
                                data-advanced-toggle="jobs-advanced-filters"
                                data-label-show="Show advanced filters"
                                data-label-hide="Hide advanced filters"
                                aria-expanded="{{ $advancedActive ? 'true' : 'false' }}">
                            <i class="fas fa-sliders-h"></i>
                            <span data-label>{{ $advancedActive ? 'Hide advanced filters' : 'Show advanced filters' }}</span>
                        </button>
                    </div>
                </div>

                <div id="jobs-advanced-filters" class="mt-4 {{ $advancedActive ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="category"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->admin_label ?: $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>

                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                            <select name="level" id="level"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Levels</option>
                                @foreach (['entry', 'mid', 'senior', 'executive'] as $levelKey)
                                    <option value="{{ $levelKey }}" {{ request('level') === $levelKey ? 'selected' : '' }}>
                                        {{ trans('site.jobs.levels.' . $levelKey, [], 'en') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="deadline_status" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                            <select name="deadline_status" id="deadline_status"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Jobs</option>
                                <option value="active" {{ request('deadline_status') === 'active' ? 'selected' : '' }}>Active (Not Expired)</option>
                                <option value="expired" {{ request('deadline_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>

                        <div>
                            <label for="has_applications" class="block text-sm font-medium text-gray-700 mb-1">Applications</label>
                            <select name="has_applications" id="has_applications"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Jobs</option>
                                <option value="yes" {{ request('has_applications') === 'yes' ? 'selected' : '' }}>With Applications</option>
                                <option value="no" {{ request('has_applications') === 'no' ? 'selected' : '' }}>No Applications</option>
                            </select>
                        </div>

                        <div>
                            <label for="has_questions" class="block text-sm font-medium text-gray-700 mb-1">Questions</label>
                            <select name="has_questions" id="has_questions"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Jobs</option>
                                <option value="yes" {{ request('has_questions') === 'yes' ? 'selected' : '' }}>With Questions</option>
                                <option value="no" {{ request('has_questions') === 'no' ? 'selected' : '' }}>No Questions</option>
                            </select>
                        </div>

                        <div>
                            <label for="has_documents" class="block text-sm font-medium text-gray-700 mb-1">Documents</label>
                            <select name="has_documents" id="has_documents"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Jobs</option>
                                <option value="yes" {{ request('has_documents') === 'yes' ? 'selected' : '' }}>With Documents</option>
                                <option value="no" {{ request('has_documents') === 'no' ? 'selected' : '' }}>No Documents</option>
                            </select>
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                            <div class="flex space-x-2">
                                <select name="sort" id="sort"
                                        class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Post Date</option>
                                    <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                                    <option value="company" {{ request('sort') === 'company' ? 'selected' : '' }}>Company</option>
                                    <option value="deadline" {{ request('sort') === 'deadline' ? 'selected' : '' }}>Deadline</option>
                                </select>
                                <select name="direction"
                                        class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>↓</option>
                                    <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>↑</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600">
                    Showing {{ $jobs->firstItem() ?? 0 }} to {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                </div>
            </form>
        </div>
    </div>
    <!-- Jobs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job
                            Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company &
                            Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applications</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                    <div class="text-sm text-gray-500">#{{ $job->id }}</div>
                                    <div class="text-xs text-gray-400">{{ $job->created_at->format('M d, Y') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $job->company }}</div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($job->category)
                                    <div class="text-sm text-gray-900">{{ $job->category->admin_label ?: $job->category->name }}</div>
                                @endif
                                @if ($job->subCategory)
                                    <div class="text-xs text-gray-500">{{ $job->subCategory->admin_label ?: $job->subCategory->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                    {{ trans('site.jobs.levels.' . $job->level, [], 'en') }}
                                    ({{ trans('site.jobs.levels.' . $job->level, [], 'ar') }})
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($job->isExpired())
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 mb-1">
                                        <i class="fas fa-calendar-times text-red-600 mr-1.5 text-[10px]"></i>Expired
                                    </span>
                                @else
                                    @if ($job->status === 'active')
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                            <i class="fas fa-check text-green-600 mr-1.5 text-[10px]"></i>Active
                                        </span>
                                    @elseif ($job->status === 'inactive')
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            <i class="fas fa-pause text-yellow-600 mr-1.5 text-[10px]"></i>Inactive
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                            <i class="fas fa-file-alt text-gray-600 mr-1.5 text-[10px]"></i>Draft
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $job->applications_count ?? 0 }}</div>
                                <div class="text-xs text-gray-500">applications</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $job->deadline->format('M d, Y') }}</div>
                                @if ($job->deadline->isPast())
                                    <div class="text-xs text-red-500">Expired</div>
                                @else
                                    <div class="text-xs text-gray-500">{{ $job->deadline->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.jobs.show', $job) }}"
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}"
                                        class="text-yellow-600 hover:text-yellow-900 p-1 rounded" title="Edit Job">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" class="inline"
                                        data-confirm="{{ __('site.confirm.actions.jobs.delete_soft.message', [], 'en') }}"
                                        data-confirm-title="{{ __('site.confirm.delete.title', [], 'en') }}"
                                        data-confirm-variant="danger"
                                        data-confirm-confirm="{{ __('site.confirm.actions.jobs.delete_soft.confirm', [], 'en') }}"
                                        data-confirm-cancel="{{ __('site.confirm.cancel', [], 'en') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded"
                                            title="Delete Job">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-briefcase text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg">No jobs found</p>
                                <p class="text-sm">Try adjusting your search filters or <a
                                        href="{{ route('admin.jobs.create') }}"
                                        class="text-blue-600 hover:text-blue-800">create a new job</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($jobs->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $jobs->links('admin.partials.pagination') }}
            </div>
        @endif
    </div>

    <script>
        (() => {
            const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
            const dropdownMenus = document.querySelectorAll('[data-dropdown-menu]');

            dropdownButtons.forEach(button => {
                const targetId = button.getAttribute('data-dropdown-toggle');
                const menu = document.getElementById(targetId);
                if (!menu) {
                    return;
                }

                button.addEventListener('click', event => {
                    event.preventDefault();
                    event.stopPropagation();

                    dropdownMenus.forEach(otherMenu => {
                        if (otherMenu !== menu) {
                            otherMenu.classList.add('hidden');
                            const otherButton = document.querySelector(`[data-dropdown-toggle="${otherMenu.id}"]`);
                            if (otherButton) {
                                otherButton.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });

                    const isHidden = menu.classList.contains('hidden');
                    menu.classList.toggle('hidden', !isHidden);
                    button.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                });
            });

            dropdownMenus.forEach(menu => {
                menu.addEventListener('click', event => event.stopPropagation());
            });

            document.addEventListener('click', () => {
                dropdownMenus.forEach(menu => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        const button = document.querySelector(`[data-dropdown-toggle="${menu.id}"]`);
                        if (button) {
                            button.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            });

            const advancedToggles = document.querySelectorAll('[data-advanced-toggle]');
            advancedToggles.forEach(button => {
                const targetId = button.getAttribute('data-advanced-toggle');
                const target = document.getElementById(targetId);
                if (!target) {
                    return;
                }

                button.addEventListener('click', () => {
                    const willHide = !target.classList.contains('hidden');
                    target.classList.toggle('hidden');
                    button.setAttribute('aria-expanded', willHide ? 'false' : 'true');

                    const label = button.querySelector('[data-label]');
                    if (label) {
                        const showText = button.getAttribute('data-label-show');
                        const hideText = button.getAttribute('data-label-hide');
                        label.textContent = willHide ? showText : hideText;
                    }
                });
            });
        })();
    </script>
@endsection
