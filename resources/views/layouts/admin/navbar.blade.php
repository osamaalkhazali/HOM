<!-- Navigation -->
<nav class="bg-white border-b border-gray-200 fixed w-full z-30 top-0">
    <div class="max-w-full mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="Logo" class="h-10 w-auto">
                        <span class="text-xl font-bold" style="color: var(--primary-color);">Admin Dashboard</span>
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    @php($admin = Auth::guard('admin')->user())
                    @php($unread = $admin ? \Illuminate\Notifications\DatabaseNotification::where('notifiable_id', $admin->id)->where('notifiable_type', get_class($admin))->whereNull('read_at')->latest()->limit(10)->get() : collect())
                    <button class="btn position-relative" type="button" onclick="toggleAdminNotif()" style="border-radius: 10px;">
                        <i class="fas fa-bell" style="font-size: 1.2rem; color: var(--primary-color);"></i>
                        @if($unread && $unread->count() > 0)
                            <span style="position: absolute; top: 0%; left: 60%; background: #dc3545; color: #fff; border-radius: 9999px; padding: 2px 6px; font-size: 0.5rem; line-height: 1;">{{ $unread->count() }}</span>
                        @endif
                    </button>
                    <div id="adminNotifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-2 z-10">
                        <div class="px-4 py-1 text-gray-500 text-sm">Notifications</div>
                        @if($unread && $unread->count())
                            @foreach($unread as $notification)
                                <a href="{{ route('admin.notifications.open', $notification->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-circle mt-1" style="font-size: 0.6rem; color: var(--primary-color);"></i>
                                        <div>
                                            <div class="font-medium">{{ $notification->data['title_' . app()->getLocale()] ?? $notification->data['title'] ?? __('site.nav.notifications') }}</div>
                                            <div class="text-gray-500">{{ $notification->data['message_' . app()->getLocale()] ?? $notification->data['message'] ?? '' }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-2 text-sm text-gray-500">No new notifications</div>
                        @endif
                        <div class="border-t mt-2 px-3 py-2 flex gap-2">
                            <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                                @csrf
                                <button class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">Mark all as read</button>
                            </form>
                            <a href="{{ route('admin.notifications.index') }}" class="ml-auto px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">View all</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <img class="h-8 w-8 rounded-full"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name) }}&background=3b82f6&color=fff"
                        alt="Admin">
                    <span class="text-gray-700 font-medium">{{ Auth::guard('admin')->user()->name }}</span>
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div id="dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('admin.profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-edit mr-2"></i>Edit Profile
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        dropdown.classList.toggle('hidden');
    }

    function toggleAdminNotif() {
        const dd = document.getElementById('adminNotifDropdown');
        dd.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown');
        const button = event.target.closest('button[onclick="toggleDropdown()"]');

        if (!button && dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }

        const notifBtn = event.target.closest('button[onclick="toggleAdminNotif()"]');
        const notifDropdown = document.getElementById('adminNotifDropdown');
        if (!notifBtn && notifDropdown && !notifDropdown.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    });
</script>
