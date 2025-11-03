@extends('layouts.admin.app')

@section('title', 'Admin Management')

@section('content')
    <div class="space-y-6">
        @php
            $exportFormats = [
                'excel' => ['label' => 'Excel', 'icon' => 'fas fa-file-excel text-green-600'],
                'csv' => ['label' => 'CSV', 'icon' => 'fas fa-file-code text-amber-600'],
                'pdf' => ['label' => 'PDF', 'icon' => 'fas fa-file-pdf text-red-600'],
            ];

            $filteredParams = $exportQuery ?? [];
            unset($filteredParams['scope'], $filteredParams['format']);

            $advancedFilterKeys = ['status', 'role'];
            $advancedActive = collect($advancedFilterKeys)->contains(fn ($key) => filled(request($key)));
        @endphp

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Admin Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage administrator accounts and permissions</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.admins.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add New Admin
                </a>
                <div class="relative">
                    <button type="button"
                            class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                            data-dropdown-toggle="admins-export-menu"
                            aria-expanded="false">
                        <i class="fas fa-download"></i>
                        <span>Export</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div id="admins-export-menu"
                         class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-30"
                         data-dropdown-menu>
                        <div class="py-2 text-sm text-gray-700">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">Current results</div>
                            @foreach($exportFormats as $formatKey => $formatMeta)
                                <a href="{{ route('admin.admins.export', array_merge(['format' => $formatKey, 'scope' => 'filtered'], $filteredParams)) }}"
                                   class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <i class="{{ $formatMeta['icon'] }}"></i>
                                    <span>{{ $formatMeta['label'] }} (Filtered)</span>
                                </a>
                            @endforeach
                            <div class="my-2 border-t border-gray-100"></div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">All records</div>
                            @foreach($exportFormats as $formatKey => $formatMeta)
                                <a href="{{ route('admin.admins.export', ['format' => $formatKey, 'scope' => 'all']) }}"
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-users-cog text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Admins</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $admins->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-user-check text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Admin::whereNotNull('email_verified_at')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-user-times text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Inactive</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Admin::whereNull('email_verified_at')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-crown text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Super Admins</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Admin::where('role', 'super')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow">
            <form method="GET" action="{{ route('admin.admins.index') }}" class="p-6 space-y-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search admins</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                   placeholder="Search by name or email..."
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-filter"></i>
                            <span>Apply</span>
                        </button>
                        <a href="{{ route('admin.admins.index') }}"
                           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-rotate-left"></i>
                            <span>Clear</span>
                        </a>
                        <button type="button"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50"
                                id="admins-advanced-toggle"
                                data-advanced-toggle="admins-advanced-filters"
                                data-label-show="Show advanced filters"
                                data-label-hide="Hide advanced filters"
                                aria-expanded="{{ $advancedActive ? 'true' : 'false' }}">
                            <i class="fas fa-sliders-h"></i>
                            <span data-label>{{ $advancedActive ? 'Hide advanced filters' : 'Show advanced filters' }}</span>
                        </button>
                    </div>
                </div>

                <div id="admins-advanced-filters" class="mt-2 {{ $advancedActive ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select id="role" name="role"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Roles</option>
                                <option value="super" {{ request('role') === 'super' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="client_hr" {{ request('role') === 'client_hr' ? 'selected' : '' }}>Client HR</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Admins Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Administrators</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select onchange="window.location.href=this.value"
                            class="border border-gray-300 rounded px-2 py-1 text-sm">
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => 'desc']) }}"
                                {{ request('sort_by') === 'created_at' && request('sort_direction') === 'desc' ? 'selected' : '' }}>
                                Newest First
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => 'asc']) }}"
                                {{ request('sort_by') === 'created_at' && request('sort_direction') === 'asc' ? 'selected' : '' }}>
                                Oldest First
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => 'asc']) }}"
                                {{ request('sort_by') === 'name' && request('sort_direction') === 'asc' ? 'selected' : '' }}>
                                Name A-Z
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => 'desc']) }}"
                                {{ request('sort_by') === 'name' && request('sort_direction') === 'desc' ? 'selected' : '' }}>
                                Name Z-A
                            </option>
                            <option
                                value="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_direction' => 'asc']) }}"
                                {{ request('sort_by') === 'email' && request('sort_direction') === 'asc' ? 'selected' : '' }}>
                                Email A-Z
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            @if ($admins->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Admin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Login</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($admins as $admin)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user-shield text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $admin->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $admin->role === 'super' ? 'bg-purple-100 text-purple-800' : ($admin->role === 'client_hr' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800') }}">
                                            @if ($admin->role === 'super')
                                                <i class="fas fa-crown mr-1"></i>Super Admin
                                            @elseif ($admin->role === 'client_hr')
                                                <i class="fas fa-building mr-1"></i>Client HR
                                            @else
                                                <i class="fas fa-user-cog mr-1"></i>Admin
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $admin->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <span
                                                class="w-1.5 h-1.5 mr-1.5 rounded-full
                                            {{ $admin->status === 'active' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                            {{ ucfirst($admin->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y H:i') : 'Never' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $admin->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.admins.show', $admin) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.admins.edit', $admin) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('admin.admins.toggle-status', $admin) }}"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                    <i
                                                        class="fas fa-toggle-{{ $admin->status === 'active' ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                            @if ($admin->id !== auth('admin')->id())
                                                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}"
                                                    class="inline"
                                                    data-confirm="{{ __('site.confirm.actions.admins.delete.message', [], 'en') }}"
                                                    data-confirm-title="{{ __('site.confirm.delete.title', [], 'en') }}"
                                                    data-confirm-variant="danger"
                                                    data-confirm-confirm="{{ __('site.confirm.actions.admins.delete.confirm', [], 'en') }}"
                                                    data-confirm-cancel="{{ __('site.confirm.cancel', [], 'en') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $admins->links('admin.partials.pagination') }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-users-cog text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No administrators found</h3>
                    <p class="text-gray-500 mb-4">Get started by creating your first admin account.</p>
                    <a href="{{ route('admin.admins.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add New Admin
                    </a>
                </div>
            @endif
        </div>
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
