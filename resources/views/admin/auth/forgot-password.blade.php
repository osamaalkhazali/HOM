<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - {{ config('app.name', 'HOM') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-card p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="mb-4">
                <img src="{{ asset('assets/images/HOM-logo.png') }}" alt="{{ config('app.name') }}"
                    class="h-16 mx-auto">
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Forgot Password?
            </h1>
            <p class="text-gray-600">No problem. Just let us know your email address and we will email you a password
                reset link.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                        placeholder="admin@example.com" required autofocus>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-4 rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-200 font-semibold shadow-lg">
                <i class="fas fa-paper-plane mr-2"></i>Email Password Reset Link
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <a href="{{ route('admin.login') }}" class="text-sm text-gray-600 hover:text-gray-800 transition">
                <i class="fas fa-arrow-left mr-1"></i>Back to Login
            </a>
        </div>

        <div class="mt-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
