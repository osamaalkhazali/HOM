<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Job Portal</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('hom-favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('hom-favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Site Fonts & Shared Styles (for primary color variable and typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @include('layouts.styles')
    @stack('styles')
    <style>
        /* Admin pagination styling to match main site look (Bootstrap-5 markup rendered by Laravel) */
        .pagination {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            justify-content: center;
            padding-left: 0;
            margin: 0;
            list-style: none;
        }

        .pagination .page-item { list-style: none; }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 0.5rem;
            background-color: #ffffff;
            border: 1px solid #e5e7eb; /* gray-200 */
            color: #1f2937; /* gray-800 */
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all .2s ease;
            font-size: .875rem;
        }

        .pagination .page-link:hover {
            border-color: rgba(24,69,143,0.5);
            color: var(--primary-color, #18458f);
            box-shadow: 0 4px 12px rgba(24,69,143,0.12);
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color, #18458f);
            color: #fff;
            border-color: var(--primary-color, #18458f);
            box-shadow: 0 4px 12px rgba(24,69,143,0.18);
        }

        .pagination .page-item.disabled .page-link {
            opacity: .5;
            pointer-events: none;
        }

        /* Force single-row, centered layout with summary + page links */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
        }
        /* Ensure our custom pagination block is visible */
        /* Center the combined summary + links block */
        nav[role="navigation"] > div {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 1.25rem; /* more space between summary and buttons */
            flex-wrap: nowrap; /* keep on one line on desktop */
        }
        /* Summary text style (first inner div before ul) */
        nav[role="navigation"] > div > div:first-child {
            color: #6b7280; /* gray-500 */
            font-size: .95rem;
            margin-right: .25rem; /* tiny extra breathing room */
        }
        nav[role="navigation"] ul.pagination { margin: 0; }

        /* No aggressive hiding here; custom partial omits Prev/Next entirely */

        /* Allow wrapping on small screens to prevent overflow */
        @media (max-width: 575.98px) {
            nav[role="navigation"] > div { flex-wrap: wrap; }
        }
    </style>
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

    @include('components.confirm-modal')
    @stack('scripts')
</body>

</html>
