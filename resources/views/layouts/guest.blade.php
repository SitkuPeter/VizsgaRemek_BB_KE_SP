<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="dark:bg-zinc-800 dark:text-white transition duration-300">

<head>
    <link rel="icon" type="image/png" href="{{ asset('storage/img/favicon.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Spin It Clean') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #f59e0b;
            /* Yellow-500 */
            --primary-dark: #d97706;
            /* Yellow-600 */
            --primary-light: #fbbf24;
            /* Yellow-400 */
            --card-bg-light: rgba(255, 255, 255, 0.95);
            --card-bg-dark: rgba(63, 63, 70, 0.9);
            /* zinc-700 with opacity */
        }

        body {
            font-family: 'Montserrat', 'figtree', sans-serif;
        }

        .casino-bg {
            background-image: url('{{ asset('storage/img/casino-bg.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        .casino-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
            z-index: 1;
        }

        .content-container {
            position: relative;
            z-index: 2;
        }

        .card-glow {
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.3), 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .card-glow:hover {
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.5), 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .logo-text {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #000;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .link-hover {
            position: relative;
            transition: all 0.3s ease;
        }

        .link-hover::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .link-hover:hover::after {
            width: 100%;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased casino-bg">
    <!-- Navigation Bar for Guest Layout -->
    <nav class="relative z-10 bg-transparent py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="/" class="flex items-center">
                <img src="{{ asset('storage/img/favicon.png') }}" alt="Logo" class="w-12 h-12">
                <span class="ml-3 text-xl font-bold text-white logo-text">Spin It Clean</span>
            </a>

            <div class="hidden sm:flex space-x-6 items-center">
                
                <div class="ml-6">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                            class="text-yellow-400 hover:text-yellow-300 font-medium transition duration-300 mr-4">Sign
                            In</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-lg shadow-md transition duration-300">Sign
                            Up</a>
                    @endif
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden sm:hidden bg-black bg-opacity-90 mt-2 py-4 px-6">
            <a href="/" class="block text-white hover:text-yellow-400 py-2">Home</a>
            <a href="{{ route('pages.games') }}" class="block text-white hover:text-yellow-400 py-2">Games</a>
            <a href="#" class="block text-white hover:text-yellow-400 py-2">About</a>
            <div class="mt-4 flex flex-col space-y-3">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-medium">Sign
                        In</a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-lg shadow-md text-center">Sign
                        Up</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 content-container">
        <div class="w-full sm:max-w-md">
            <!-- Main Content Card -->
            <div
                class="bg-white dark:bg-zinc-700 bg-opacity-95 dark:bg-opacity-90 rounded-xl shadow-2xl overflow-hidden card-glow border border-gray-200 dark:border-gray-600 transition-all duration-300 px-6 py-8">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center text-white text-sm opacity-80">
            <p>&copy; {{ date('Y') }} Spin It Clean Casino. All rights reserved.</p>
            
        </div>
    </div>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>
