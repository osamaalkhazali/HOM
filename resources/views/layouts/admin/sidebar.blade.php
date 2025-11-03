<!-- Sidebar -->
<div class="w-64 bg-white shadow-lg h-full" style="font-family: 'Poppins', sans-serif;">
    <div class="flex flex-col h-full">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    style="{{ request()->routeIs('admin.dashboard*') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <!-- Jobs -->
                <div class="space-y-1">
                    <button onclick="toggleSubmenu('jobs')"
                        class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.jobs*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        style="{{ request()->routeIs('admin.jobs*') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                        <i class="fas fa-briefcase mr-3"></i>
                        @if(auth('admin')->user()->isClientHr())
                            Jobs
                        @else
                            Jobs Management
                        @endif
                        <i class="fas fa-chevron-down ml-auto transform transition-transform" id="jobs-chevron"></i>
                    </button>
                    <div class="ml-6 space-y-1 hidden" id="jobs-submenu">
                        <a href="{{ route('admin.jobs.index') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.jobs.index') && !request()->has('status') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.jobs.index') && !request()->has('status') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-list mr-3"></i>All Jobs
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::count() }}
                            </span>
                        </a>
                        @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                        <a href="{{ route('admin.jobs.create') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.jobs.create') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.jobs.create') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-plus mr-3"></i>Add New Job
                        </a>
                        @endif
                        <a href="{{ route('admin.jobs.index', ['status' => 'active']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'active' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'active' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-eye mr-3"></i>Active Jobs
                            <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::where('status', 'active')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.jobs.index', ['status' => 'inactive']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'inactive' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'inactive' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-pause mr-3"></i>Inactive Jobs
                            <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::where('status', 'inactive')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.jobs.index', ['status' => 'draft']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'draft' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'draft' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-file-alt mr-3"></i>Draft Jobs
                            <span class="ml-auto bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Job::where('status', 'draft')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.jobs.deleted') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.jobs.deleted') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.jobs.deleted') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
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
                        class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.applications*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        style="{{ request()->routeIs('admin.applications*') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                        <i class="fas fa-file-alt mr-3"></i>
                        Applications
                        <i class="fas fa-chevron-down ml-auto transform transition-transform"
                            id="applications-chevron"></i>
                    </button>
                    <div id="applications-submenu" class="ml-6 space-y-1 hidden">
                        <a href="{{ route('admin.applications.index') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.applications.index') && !request()->has('status') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.applications.index') && !request()->has('status') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-list mr-3"></i>All Applications
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'pending']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'pending' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'pending' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-clock mr-3"></i>Pending
                            <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'pending')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'reviewed']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'reviewed' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'reviewed' ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-eye mr-3"></i>Reviewed
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'reviewed')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'shortlisted']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'shortlisted' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'shortlisted' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-star mr-3"></i>Shortlisted
                            <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'shortlisted')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'hired']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'hired' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'hired' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-user-check mr-3"></i>Hired
                            <span class="ml-auto bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Application::where('status', 'hired')->count() }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Employees -->
                <div class="space-y-1">
                    <button onclick="toggleSubmenu('employees')"
                        class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.employees*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        style="{{ request()->routeIs('admin.employees*') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                        <i class="fas fa-user-tie mr-3"></i>
                        Employees
                        <i class="fas fa-chevron-down ml-auto transform transition-transform" id="employees-chevron"></i>
                    </button>
                    <div class="ml-6 space-y-1 hidden" id="employees-submenu">
                        <a href="{{ route('admin.employees.index') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.employees.index') && !request()->has('status') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.employees.index') && !request()->has('status') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-list mr-3"></i>All Employees
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Employee::count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.employees.index', ['status' => 'active']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'active' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'active' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-check-circle mr-3"></i>Active Employees
                            <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Employee::where('status', 'active')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.employees.index', ['status' => 'on_leave']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'on_leave' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'on_leave' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-plane mr-3"></i>On Leave
                            <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Employee::where('status', 'on_leave')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.employees.index', ['status' => 'resigned']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'resigned' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'resigned' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-user-minus mr-3"></i>Resigned
                            <span class="ml-auto bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Employee::where('status', 'resigned')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.employees.index', ['status' => 'terminated']) }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->get('status') === 'terminated' ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->get('status') === 'terminated' ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-ban mr-3"></i>Terminated
                            <span class="ml-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Employee::where('status', 'terminated')->count() }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Clients -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                <a href="{{ route('admin.clients.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.clients.*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    style="{{ request()->routeIs('admin.clients.*') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                    <i class="fas fa-handshake mr-3"></i>
                    Clients
                    <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        {{ \App\Models\Client::count() }}
                    </span>
                </a>
                @endif

                <!-- Categories -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                <a href="{{ route('admin.categories.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    style="{{ request()->routeIs('admin.categories*') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                    <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        {{ \App\Models\Category::count() }}
                    </span>
                </a>
                @endif

                <!-- Users & Profiles -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                <div class="space-y-1">
                    <button onclick="toggleSubmenu('users')"
                        class="group flex items-center w-full px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        style="{{ request()->routeIs('admin.users*') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Users & Profiles
                        <i class="fas fa-chevron-down ml-auto transform transition-transform" id="users-chevron"></i>
                    </button>
                    <div class="ml-6 space-y-1 hidden" id="users-submenu">
                        <a href="{{ route('admin.users.index') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.users.index') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.users.index') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-list mr-3"></i>All Users
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\User::count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.users.deleted') }}"
                            class="group flex items-center px-2 py-2 text-sm rounded-md {{ request()->routeIs('admin.users.deleted') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('admin.users.deleted') ? 'background: rgba(13,110,253,0.08); color: var(--primary-color);' : '' }}">
                            <i class="fas fa-trash mr-3"></i>Deleted Users
                            <span class="ml-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\User::onlyTrashed()->count() }}
                            </span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Admin Management -->
                @if(auth('admin')->user()->isSuperAdmin())
                <a href="{{ route('admin.admins.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.admins.*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    style="{{ request()->routeIs('admin.admins.*') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                    <i class="fas fa-users-cog mr-3"></i>
                    Admin Management
                </a>
                @endif

                <!-- Settings -->
                @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->isAdmin())
                <a href="{{ route('admin.settings.index') }}"
                    class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings.*') ? '' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    style="{{ request()->routeIs('admin.settings.*') ? 'background: rgba(13,110,253,0.06); color: var(--primary-color);' : '' }}">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
                @endif
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

        // Employees - expand if we're on any employees page
        @if (request()->routeIs('admin.employees.*'))
            const employeesSubmenu = document.getElementById('employees-submenu');
            const employeesChevron = document.getElementById('employees-chevron');
            if (employeesSubmenu && employeesSubmenu.classList.contains('hidden')) {
                employeesSubmenu.classList.remove('hidden');
                employeesChevron.classList.remove('fa-chevron-down');
                employeesChevron.classList.add('fa-chevron-up');
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

        // Users - expand if we're on any users page
        @if (request()->routeIs('admin.users.*'))
            const usersSubmenu = document.getElementById('users-submenu');
            const usersChevron = document.getElementById('users-chevron');
            if (usersSubmenu && usersSubmenu.classList.contains('hidden')) {
                usersSubmenu.classList.remove('hidden');
                usersChevron.classList.remove('fa-chevron-down');
                usersChevron.classList.add('fa-chevron-up');
            }
        @endif
    });
</script>
