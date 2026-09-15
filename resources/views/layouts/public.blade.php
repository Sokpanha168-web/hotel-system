<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-stone-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Serenity Villa') - Luxury Boutique Guest House</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:400,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
    </style>
</head>
<body class="min-h-full flex flex-col font-sans text-stone-800 antialiased selection:bg-amber-200 selection:text-stone-900" x-data="{ mobileMenu: false }">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-stone-200 transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-xl bg-amber-700 text-amber-50 flex items-center justify-center shadow-md shadow-amber-900/10 group-hover:bg-amber-800 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-stone-900 block leading-tight">Serenity Villa</span>
                        <span class="text-xs uppercase tracking-widest text-amber-700 font-semibold">Guest House & Spa</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition {{ request()->routeIs('home') ? 'text-amber-800 font-semibold' : 'text-stone-600 hover:text-stone-900' }}">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-sm font-medium transition {{ request()->routeIs('rooms.*') ? 'text-amber-800 font-semibold' : 'text-stone-600 hover:text-stone-900' }}">Rooms & Suites</a>
                    <a href="{{ route('home') }}#amenities" class="text-sm font-medium text-stone-600 hover:text-stone-900 transition">Amenities</a>
                    <a href="{{ route('home') }}#experience" class="text-sm font-medium text-stone-600 hover:text-stone-900 transition">Experience</a>
                </nav>

                <!-- Actions / Staff Portal -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-stone-700 bg-stone-100 hover:bg-stone-200 rounded-lg transition">
                            <svg class="w-4 h-4 mr-1.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            Staff Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-stone-600 hover:text-stone-900 transition">
                            Staff Login
                        </a>
                    @endauth

                    <a href="{{ route('booking.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-amber-700 hover:bg-amber-800 shadow-sm shadow-amber-900/10 transition">
                        Book a Room
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenu = !mobileMenu" type="button" class="p-2 rounded-md text-stone-600 hover:text-stone-900 hover:bg-stone-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-cloak class="md:hidden border-b border-stone-200 bg-white px-4 pt-2 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-stone-100">Home</a>
            <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-stone-100">Rooms & Suites</a>
            <a href="{{ route('booking.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-amber-800 bg-amber-50">Book Now</a>
            <div class="border-t border-stone-200 pt-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-stone-700 hover:bg-stone-100">Staff Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-stone-600 hover:bg-stone-100">Staff Portal Login</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-start space-x-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 mb-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-900 flex items-start space-x-3 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-sky-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('info') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-900 text-stone-300 mt-20 border-t border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-700 text-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-serif text-2xl font-bold text-white tracking-tight">Serenity Villa</span>
                    </div>
                    <p class="text-stone-400 text-sm max-w-md leading-relaxed">
                        A peaceful sanctuary nestled in lush tropical gardens, offering boutique guest rooms, authentic hospitality, modern amenities, and convenient access to local attractions.
                    </p>
                    <div class="text-xs text-stone-400 space-y-1">
                        <p class="flex items-center space-x-2">
                            <span>📍 128 River Road, Wat Bo Village, Siem Reap, Cambodia</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <span>📞 +855 23 998 877 | ✉️ stay@serenityvilla.com</span>
                        </p>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-white transition">Available Rooms</a></li>
                        <li><a href="{{ route('booking.create') }}" class="hover:text-white transition">Direct Reservation</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Staff Management Portal</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 mb-4">Payment & Check-in</h4>
                    <p class="text-xs text-stone-400 leading-relaxed mb-3">
                        Check-in: <strong>14:00 PM</strong> | Check-out: <strong>12:00 PM</strong>
                    </p>
                    <p class="text-xs text-stone-400 leading-relaxed mb-3">
                        Accepted payments: Cash (USD/KHR), Visa/Mastercard, and instant Bakong KHQR transfers.
                    </p>
                    <div class="inline-flex items-center px-3 py-1.5 rounded-md bg-stone-800 border border-stone-700 text-xs text-amber-400 font-mono">
                        KHQR Transfer Compatible
                    </div>
                </div>
            </div>

            <div class="border-t border-stone-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-stone-400">
                <p>&copy; {{ date('Y') }} Serenity Villa Guest House Management System. All rights reserved.</p>
                <p class="mt-2 sm:mt-0">Powered by Laravel, MySQL & Tailwind CSS.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
