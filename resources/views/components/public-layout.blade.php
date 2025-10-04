<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <!-- Public Navigation -->
            <nav class="bg-white shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-600">
                                Delicious Restaurant
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex space-x-8">
                            <a href="{{ route('home') }}" 
                               class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium">
                                Home
                            </a>
                            <a href="{{ route('menu') }}" 
                               class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium">
                                Menu
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" 
                                   class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium">
                                    Dashboard
                                </a>
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-sm font-medium">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="bg-orange-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-700">
                                    Register
                                </a>
                            @endauth
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden">
                            <button type="button" class="text-gray-700 hover:text-orange-600 focus:outline-none"
                                    onclick="toggleMobileMenu()">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div id="mobile-menu" class="md:hidden hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="{{ route('home') }}" 
                           class="text-gray-700 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                            Home
                        </a>
                        <a href="{{ route('menu') }}" 
                           class="text-gray-700 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                            Menu
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="text-gray-700 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();"
                               class="text-gray-700 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                                Logout
                            </a>
                            <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-orange-600 block px-3 py-2 rounded-md text-base font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                               class="bg-orange-600 text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-700">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-500 text-white px-4 py-2 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white px-4 py-2 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }
        </script>
    </body>
</html>