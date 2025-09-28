<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HOM') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('hom-favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('hom-favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @include('layouts.styles')
    <style>
        /* Site pagination styling to match admin look (Bootstrap-5 markup) */
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

        /* Center the pagination nav */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
        }

        /* Space between summary and buttons (matches admin) */
        nav[role="navigation"] > div {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 1.25rem; /* space between summary and page buttons */
            flex-wrap: nowrap; /* keep on one line on desktop */
        }

        /* Optional: style summary text and add a tiny extra margin */
        nav[role="navigation"] > div > div:first-child {
            color: #6b7280; /* gray-500 */
            font-size: .95rem;
            margin-right: .25rem;
        }

        nav[role="navigation"] ul.pagination { margin: 0; }

        /* Allow wrapping on small screens to prevent overflow */
        @media (max-width: 575.98px) {
            nav[role="navigation"] > div { flex-wrap: wrap; }
        }
    </style>
</head>

<body id="top" class="app">
    @include('layouts.navigation')

    <!-- Page Content -->
    <main>
        @isset($header)
            <div class="page-header">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center" data-aos="fade-up">
                            {{ $header }}
                        </div>
                    </div>
                </div>
            </div>
        @endisset

        <div class="container">
            <div class="content-wrapper" data-aos="fade-up">
                {{ $slot }}
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 100) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Add loading animation to page
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>

</html>
