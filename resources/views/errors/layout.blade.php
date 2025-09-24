<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/hom-favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #18458f;
            --primary-dark: #123660;
            --primary-light: #4e80bb;
            --gradient-1: linear-gradient(135deg, #18458f 0%, #667eea 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #18458f;
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .error-container {
            text-align: center;
            color: var(--primary-color);
            max-width: 600px;
            padding: 3rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-shadow: none;
            opacity: 0.9;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-dark);
        }

        .error-message {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #64748b;
            line-height: 1.6;
        }

        .btn-home,
        .btn-back {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem;
            font-weight: 500;
        }

        .btn-home {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
        }

        .btn-home:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(24, 69, 143, 0.3);
        }

        .btn-back {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid rgba(24, 69, 143, 0.3);
        }

        .btn-back:hover {
            background: rgba(24, 69, 143, 0.05);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .error-icon {
            font-size: 3rem;
            color: var(--primary-light);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        @media (max-width: 768px) {
            .error-container {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }

            .error-code {
                font-size: 4rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .btn-home,
            .btn-back {
                display: block;
                width: 100%;
                text-align: center;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        @yield('content')

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn-home">
                <i class="fas fa-home"></i>
                Go to Dashboard
            </a>
            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </a>
        </div>
    </div>
</body>

</html>
