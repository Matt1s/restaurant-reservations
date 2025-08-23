<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Restaurant Reservations') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="h-full bg-gray-100">
    <nav class="bg-[#d97706] shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-sm sm:text-xl font-bold text-white">SIMPLEE Restaurant</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Desktop Menu -->
                        <div class="hidden sm:flex items-center space-x-4">
                            <a href="/reservation" class="bg-amber-800 rounded-md font-bold py-2 px-4 text-white hover:text-gray-200">New Reservation</a>
                            <a href="/my-reservations" class="text-white font-bold hover:text-gray-200">My Reservations</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-900 font-bold hover:text-gray-200">Logout</button>
                            </form>
                        </div>
                        
                        <!-- Mobile Menu Button -->
                        <div class="sm:hidden">
                            <button id="mobile-menu-button" class="text-white hover:text-gray-200 focus:outline-none">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        <a href="/login"
                            class="block bg-amber-800 rounded-md font-bold py-2 px-4 text-white hover:text-gray-200">Login</a>
                        <a href="/register"
                            class="hidden sm:block border-1 bg-amber-400 rounded-md font-bold py-2 px-4 text-white hover:text-gray-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>

        @auth
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="sm:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/reservation" class="block bg-amber-800 border-amber-700 px-3 py-2 rounded-md text-white font-bold hover:bg-amber-700 transition duration-200">
                    New Reservation
                </a>
                <a href="/my-reservations" class="block px-3 py-2 rounded-md text-white hover:bg-amber-700 transition duration-200">
                    My Reservations
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-red-900 font-bold text-left px-3 py-2 rounded-md hover:bg-amber-700 transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </nav>

    <!-- Mobile Menu JavaScript -->
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

    <main class="h-full">
        @if (session()->has('message'))
            <div class="max-w-7xl mx-auto px-4 mb-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="max-w-7xl mx-auto px-4 mb-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </main>

    @livewireScripts
</body>

</html>
