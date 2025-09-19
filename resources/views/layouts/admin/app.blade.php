<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Job Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>

<body class="bg-gray-50 h-screen overflow-hidden">
    @include('layouts.admin.navbar')

    <div class="flex h-full pt-16">
        @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
