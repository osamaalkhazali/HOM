<!-- Sidebar -->
<div class="w-64 bg-white shadow-lg h-full">
    <div class="flex flex-col h-full">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <!-- Jobs Management -->
                <div class="space-y-1">
                    <button onclick="toggleSubmenu('jobs')"
                        class="{{ request()->routeIs('admin.jobs*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-briefcase mr-3"></i>
                        Jobs Management
                        <i class="fas fa-chevron-down ml-auto transform transition-transform" id="jobs-chevron"></i>
                    </button>
                    <div class="ml-6 space-y-1 hidden" id="jobs-submenu">
                        <a href="{{ route('admin.jobs.index') }}"
                            class="{{ request()->routeIs('admin.jobs.index') && !request()->has('status') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-list mr-3"></i>All Jobs
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.jobs.create') }}"
                            class="{{ request()->routeIs('admin.jobs.create') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-plus mr-3"></i>Add New Job
                        </a>
                        <a href="{{ route('admin.jobs.index', ['status' => 'active']) }}"
                            class="{{ request()->get('status') === 'active' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-eye mr-3"></i>Active Jobs
                            <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::where('is_active', true)->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.jobs.index', ['status' => 'inactive']) }}"
                            class="{{ request()->get('status') === 'inactive' ? 'bg-yellow-100 text-yellow-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-pause mr-3"></i>Inactive Jobs
                            <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::where('is_active', false)->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.jobs.deleted') }}"
                            class="{{ request()->routeIs('admin.jobs.deleted') ? 'bg-red-100 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-trash mr-3"></i>Deleted Jobs
                            @php $deletedCount = \App\Models\Job::onlyTrashed()->count(); @endphp
                            @if ($deletedCount > 0)
                                <span class="ml-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                    {{ $deletedCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Applications -->
                <div class="space-y-1">
                    <button onclick="toggleSubmenu('applications')"
                        class="{{ request()->routeIs('admin.applications*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-file-alt mr-3"></i>
                        Applications
                        <i class="fas fa-chevron-down ml-auto transform transition-transform"
                            id="applications-chevron"></i>
                    </button>
                    <div id="applications-submenu" class="ml-6 space-y-1 hidden">
                        <a href="{{ route('admin.applications.index') }}"
                            class="{{ request()->routeIs('admin.applications.index') && !request()->has('status') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-list mr-3"></i>All Applications
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'pending']) }}"
                            class="{{ request()->get('status') === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-clock mr-3"></i>Pending
                            <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'pending')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'reviewed']) }}"
                            class="{{ request()->get('status') === 'reviewed' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-eye mr-3"></i>Reviewed
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'reviewed')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'shortlisted']) }}"
                            class="{{ request()->get('status') === 'shortlisted' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-star mr-3"></i>Shortlisted
                            <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'shortlisted')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'hired']) }}"
                            class="{{ request()->get('status') === 'hired' ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm rounded-md">
                            <i class="fas fa-user-check mr-3"></i>Hired
                            <span class="ml-auto bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'hired')->count() }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                    <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        {{ \App\Models\Category::count() }}
                    </span>
                </a>

                <!-- Users & Profiles -->
                <a href="{{ route('admin.users.index') }}"
                    class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Users & Profiles
                    <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        {{ \App\Models\User::count() }}
                    </span>
                </a>

                <!-- Admin Management -->
                <a href="{{ route('admin.admins.index') }}"
                    class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.admins.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <i class="fas fa-users-cog mr-3"></i>
                    Admin Management
                </a>

                <!-- Reports -->
                <a href="#"
                    class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Reports
                </a>

                <!-- Settings -->
                <a href="#"
                    class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSubmenu(menuId) {
        const submenu = document.getElementById(menuId + '-submenu');
        const chevron = document.getElementById(menuId + '-chevron');

        if (submenu.classList.contains('hidden')) {
            submenu.classList.remove('hidden');
            chevron.classList.remove('fa-chevron-down');
            chevron.classList.add('fa-chevron-up');
        } else {
            submenu.classList.add('hidden');
            chevron.classList.remove('fa-chevron-up');
            chevron.classList.add('fa-chevron-down');
        }
    }

    // Auto-expand active submenus and set correct chevron state
    document.addEventListener('DOMContentLoaded', function() {
        // Jobs Management - expand if we're on any jobs page
        @if (request()->routeIs('admin.jobs.*'))
            const jobsSubmenu = document.getElementById('jobs-submenu');
            const jobsChevron = document.getElementById('jobs-chevron');
            if (jobsSubmenu && jobsSubmenu.classList.contains('hidden')) {
                jobsSubmenu.classList.remove('hidden');
                jobsChevron.classList.remove('fa-chevron-down');
                jobsChevron.classList.add('fa-chevron-up');
            }
        @endif

        // Applications - expand if we're on any applications page
        @if (request()->routeIs('admin.applications.*'))
            const applicationsSubmenu = document.getElementById('applications-submenu');
            const applicationsChevron = document.getElementById('applications-chevron');
            if (applicationsSubmenu && applicationsSubmenu.classList.contains('hidden')) {
                applicationsSubmenu.classList.remove('hidden');
                applicationsChevron.classList.remove('fa-chevron-down');
                applicationsChevron.classList.add('fa-chevron-up');
            }
        @endif

        // Categories - expand if we're on any categories page
        @if (request()->routeIs('admin.categories.*'))
            const categoriesSubmenu = document.getElementById('categories-submenu');
            const categoriesChevron = document.getElementById('categories-chevron');
            if (categoriesSubmenu && categoriesSubmenu.classList.contains('hidden')) {
                categoriesSubmenu.classList.remove('hidden');
                categoriesChevron.classList.remove('fa-chevron-down');
                categoriesChevron.classList.add('fa-chevron-up');
            }
        @endif
    });
</script>
