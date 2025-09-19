<!-- Navigation -->
<nav class="bg-white border-b border-gray-200 fixed w-full z-30 top-0">
    <div class="max-w-full mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-briefcase text-blue-600 mr-2"></i>
                        Job Portal Admin
                    </h1>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="bg-gray-100 p-2 rounded-full text-gray-600 hover:text-gray-800">
                        <i class="fas fa-bell"></i>
                        <span
                            class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                    </button>
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

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown');
        const button = event.target.closest('button[onclick="toggleDropdown()"]');

        if (!button && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
