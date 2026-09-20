<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#fdfdfd] scroll-smooth">
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
<body class="min-h-full flex flex-col font-sans text-[#161513] bg-[#fdfdfd] antialiased selection:bg-[#ebbf7d] selection:text-[#161513]" x-data="{ mobileMenu: false }" :class="{ 'overflow-hidden': mobileMenu }">

    <!-- Top Page Scroll Progress Indicator (Driven by Motion.dev) -->
    <div class="fixed top-0 left-0 right-0 h-[3px] bg-[#e2ded5]/40 z-50 pointer-events-none">
        <div id="scroll-progress-bar" class="h-full w-full bg-gradient-to-r from-[#ebbf7d] via-[#f2e9cf] to-[#ebbf7d] origin-left scale-x-0 transition-transform duration-75"></div>
    </div>

    <!-- Header Navigation (Auto-hide on scroll down, reveal on scroll up like Studenterkilden) -->
    <header data-nav class="sticky top-0 z-40 bg-[#fdfdfd]/95 backdrop-blur-md border-b border-[#e2ded5] transition-transform duration-300 ease-out will-change-transform">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-xl bg-[#161513] text-[#ebbf7d] flex items-center justify-center shadow-md shadow-[#161513]/10 group-hover:bg-[#262422] transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-[#161513] block leading-tight">Serenity Villa</span>
                        <span class="text-xs uppercase tracking-widest text-[#8c6d3b] font-semibold">Guest House & Spa</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition {{ request()->routeIs('home') ? 'text-[#161513] font-bold border-b-2 border-[#ebbf7d] pb-0.5' : 'text-[#39393b] hover:text-[#161513]' }}">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-sm font-medium transition {{ request()->routeIs('rooms.*') ? 'text-[#161513] font-bold border-b-2 border-[#ebbf7d] pb-0.5' : 'text-[#39393b] hover:text-[#161513]' }}">Rooms & Suites</a>
                    <a href="{{ route('amenities') }}" class="text-sm font-medium transition {{ request()->routeIs('amenities') ? 'text-[#161513] font-bold border-b-2 border-[#ebbf7d] pb-0.5' : 'text-[#39393b] hover:text-[#161513]' }}">Amenities</a>
                    <a href="{{ route('experience') }}" class="text-sm font-medium transition {{ request()->routeIs('experience') ? 'text-[#161513] font-bold border-b-2 border-[#ebbf7d] pb-0.5' : 'text-[#39393b] hover:text-[#161513]' }}">Experience</a>
                </nav>

                <!-- Actions / Staff Portal & Round Burger Menu Trigger -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hidden lg:inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#161513] bg-[#f2e9cf]/60 hover:bg-[#f2e9cf] rounded-full border border-[#e2ded5] transition">
                            <svg class="w-4 h-4 mr-1.5 text-[#39393b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            Staff Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden lg:inline-flex text-xs font-semibold text-[#39393b] hover:text-[#161513] px-2.5 py-1.5 transition">
                            Staff Login
                        </a>
                    @endauth

                    <!-- Authentic Scandinavian Boutique Round Burger Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" 
                            type="button" 
                            class="group relative inline-flex items-center space-x-2.5 px-4 py-2 rounded-full border border-[#e2ded5] hover:border-[#ebbf7d] bg-[#fdfdfd] hover:bg-[#f7f4ec] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#ebbf7d]/50 cursor-pointer shadow-xs"
                            aria-label="Toggle navigation menu"
                            :aria-expanded="mobileMenu">
                        <span class="text-xs uppercase tracking-widest font-bold text-[#161513] group-hover:text-[#8c6d3b] transition-colors select-none" 
                              x-text="mobileMenu ? 'Close' : 'Menu'">Menu</span>
                        
                        <!-- Animated 3-Bar Burger Icon morphing to 'X' -->
                        <div class="w-4 h-3 relative flex flex-col justify-between items-center" aria-hidden="true">
                            <span class="w-full h-0.5 bg-[#161513] group-hover:bg-[#8c6d3b] rounded-full transition-all duration-300 origin-center"
                                  :class="mobileMenu ? 'rotate-45 translate-y-[5px] bg-[#ebbf7d] group-hover:bg-[#ebbf7d]' : ''"></span>
                            <span class="w-full h-0.5 bg-[#161513] group-hover:bg-[#8c6d3b] rounded-full transition-all duration-200"
                                  :class="mobileMenu ? 'opacity-0 scale-x-0' : ''"></span>
                            <span class="w-full h-0.5 bg-[#161513] group-hover:bg-[#8c6d3b] rounded-full transition-all duration-300 origin-center"
                                  :class="mobileMenu ? '-rotate-45 -translate-y-[5px] bg-[#ebbf7d] group-hover:bg-[#ebbf7d]' : ''"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- High-End Off-Canvas Burger Menu Drawer (Slide-Over & Dimmed Backdrop) -->
    <div x-show="mobileMenu" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-hidden" 
         aria-labelledby="burger-menu-title" 
         role="dialog" 
         aria-modal="true">

        <!-- Dimmed Backdrop with Blur -->
        <div x-show="mobileMenu"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenu = false"
             class="fixed inset-0 bg-[#161513]/70 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex">
            <!-- Slide Panel -->
            <div x-show="mobileMenu"
                 x-transition:enter="transform transition ease-out duration-400"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     @keydown.escape.window="mobileMenu = false"
                     class="w-screen max-w-full sm:max-w-md h-full min-h-screen bg-[#161513] text-white shadow-2xl sm:border-l border-[#e2ded5]/15 flex flex-col justify-between overflow-y-auto">

                    <!-- Drawer Header -->
                    <div class="p-6 sm:p-8 flex items-center justify-between border-b border-[#e2ded5]/15">
                        <a href="{{ route('home') }}" @click="mobileMenu = false" class="flex items-center space-x-3 group">
                            <div class="w-10 h-10 rounded-xl bg-[#ebbf7d] text-[#161513] flex items-center justify-center font-bold shadow-sm group-hover:bg-[#deaf6b] transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <span class="font-serif text-xl font-bold tracking-tight text-[#fdfdfd] block leading-tight">Serenity Villa</span>
                                <span class="text-[10px] uppercase tracking-widest text-[#ebbf7d] font-semibold">Boutique Guest House</span>
                            </div>
                        </a>

                        <!-- Close Button -->
                        <button @click="mobileMenu = false" 
                                type="button" 
                                class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full border border-[#e2ded5]/20 hover:border-[#ebbf7d] text-stone-300 hover:text-[#ebbf7d] hover:bg-white/5 transition-all duration-200 group focus:outline-none cursor-pointer"
                                aria-label="Close menu">
                            <span class="text-[11px] font-bold uppercase tracking-wider">Close</span>
                            <svg class="w-4 h-4 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Drawer Navigation Menu Links -->
                    <div class="p-6 sm:p-8 flex-1 flex flex-col justify-center space-y-6">
                        <div class="flex items-center space-x-2 text-[11px] uppercase tracking-widest text-[#ebbf7d] font-bold">
                            <span>Hotel Directory & Suites</span>
                            <span class="h-px flex-1 bg-[#ebbf7d]/20"></span>
                        </div>

                        <nav class="space-y-4">
                            <!-- 01 Home -->
                            <a href="{{ route('home') }}" 
                               @click="mobileMenu = false" 
                               class="group flex items-center justify-between py-2.5 border-b border-[#e2ded5]/10 hover:border-[#ebbf7d]/40 transition-colors">
                                <div class="flex items-baseline space-x-3.5">
                                    <span class="text-xs font-mono text-[#ebbf7d]/70 group-hover:text-[#ebbf7d]">01</span>
                                    <span class="font-serif text-2xl sm:text-3xl font-bold text-[#fdfdfd] group-hover:text-[#ebbf7d] group-hover:translate-x-2 transition-all duration-200">Home</span>
                                </div>
                                <svg class="w-4 h-4 text-stone-500 group-hover:text-[#ebbf7d] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <!-- 02 Rooms & Suites -->
                            <a href="{{ route('rooms.index') }}" 
                               @click="mobileMenu = false" 
                               class="group flex items-center justify-between py-2.5 border-b border-[#e2ded5]/10 hover:border-[#ebbf7d]/40 transition-colors">
                                <div class="flex items-baseline space-x-3.5">
                                    <span class="text-xs font-mono text-[#ebbf7d]/70 group-hover:text-[#ebbf7d]">02</span>
                                    <span class="font-serif text-2xl sm:text-3xl font-bold text-[#fdfdfd] group-hover:text-[#ebbf7d] group-hover:translate-x-2 transition-all duration-200">Rooms & Suites</span>
                                </div>
                                <svg class="w-4 h-4 text-stone-500 group-hover:text-[#ebbf7d] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <!-- 03 Amenities & Spa -->
                            <a href="{{ route('amenities') }}" 
                               @click="mobileMenu = false" 
                               class="group flex items-center justify-between py-2.5 border-b border-[#e2ded5]/10 hover:border-[#ebbf7d]/40 transition-colors {{ request()->routeIs('amenities') ? 'border-[#ebbf7d]/50' : '' }}">
                                <div class="flex items-baseline space-x-3.5">
                                    <span class="text-xs font-mono {{ request()->routeIs('amenities') ? 'text-[#ebbf7d]' : 'text-[#ebbf7d]/70' }} group-hover:text-[#ebbf7d]">03</span>
                                    <span class="font-serif text-2xl sm:text-3xl font-bold {{ request()->routeIs('amenities') ? 'text-[#ebbf7d]' : 'text-[#fdfdfd]' }} group-hover:text-[#ebbf7d] group-hover:translate-x-2 transition-all duration-200">Resort Amenities</span>
                                </div>
                                <svg class="w-4 h-4 text-stone-500 group-hover:text-[#ebbf7d] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <!-- 04 The Experience -->
                            <a href="{{ route('experience') }}" 
                               @click="mobileMenu = false" 
                               class="group flex items-center justify-between py-2.5 border-b border-[#e2ded5]/10 hover:border-[#ebbf7d]/40 transition-colors {{ request()->routeIs('experience') ? 'border-[#ebbf7d]/50' : '' }}">
                                <div class="flex items-baseline space-x-3.5">
                                    <span class="text-xs font-mono {{ request()->routeIs('experience') ? 'text-[#ebbf7d]' : 'text-[#ebbf7d]/70' }} group-hover:text-[#ebbf7d]">04</span>
                                    <span class="font-serif text-2xl sm:text-3xl font-bold {{ request()->routeIs('experience') ? 'text-[#ebbf7d]' : 'text-[#fdfdfd]' }} group-hover:text-[#ebbf7d] group-hover:translate-x-2 transition-all duration-200">The Experience</span>
                                </div>
                                <svg class="w-4 h-4 text-stone-500 group-hover:text-[#ebbf7d] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <!-- 05 Direct Reservation -->
                            <a href="{{ route('booking.create') }}" 
                               @click="mobileMenu = false" 
                               class="group flex items-center justify-between py-2.5 border-b border-[#e2ded5]/10 hover:border-[#ebbf7d]/40 transition-colors">
                                <div class="flex items-baseline space-x-3.5">
                                    <span class="text-xs font-mono text-[#ebbf7d]/70 group-hover:text-[#ebbf7d]">05</span>
                                    <span class="font-serif text-2xl sm:text-3xl font-bold text-[#fdfdfd] group-hover:text-[#ebbf7d] group-hover:translate-x-2 transition-all duration-200">Direct Reservation</span>
                                </div>
                                <svg class="w-4 h-4 text-stone-500 group-hover:text-[#ebbf7d] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </nav>

                        <!-- Direct Booking Privilege Card -->
                        <div class="p-4 sm:p-5 rounded-2xl bg-[#f7f4ec]/5 border border-[#e2ded5]/15 space-y-3">
                            <div class="flex items-center space-x-2">
                                <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-full bg-[#ebbf7d]/15 text-[#ebbf7d] border border-[#ebbf7d]/30">
                                    ★ Direct Booking Privilege
                                </span>
                            </div>
                            <p class="text-xs text-stone-300 leading-relaxed">
                                Enjoy guaranteed best rates, complimentary artisan breakfast, and flexible 24-hour cancellation.
                            </p>
                            <a href="{{ route('booking.create') }}" 
                               @click="mobileMenu = false"
                               class="w-full inline-flex items-center justify-center py-3.5 px-5 rounded-full font-bold text-xs uppercase tracking-wider text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-md shadow-[#ebbf7d]/15 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                                <span>Reserve A Room Online</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Drawer Footer: Guest Concierge Details & Staff Access -->
                    <div class="p-6 sm:p-8 bg-[#1a1917] border-t border-[#e2ded5]/15 space-y-4">
                        <div class="text-xs space-y-2 text-[#cfcfcf]">
                            <div class="flex items-center space-x-2.5">
                                <svg class="w-4 h-4 text-[#ebbf7d] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Wat Bo Village, Siem Reap, Kingdom of Cambodia</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <svg class="w-4 h-4 text-[#ebbf7d] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+855 63 965 888 • concierge@serenityvilla.com</span>
                            </div>
                            <div class="flex items-center space-x-2.5">
                                <svg class="w-4 h-4 text-[#ebbf7d] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Check-in: 14:00 PM • Check-out: 12:00 PM</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                            @auth
                                <a href="{{ route('admin.dashboard') }}" @click="mobileMenu = false" class="text-[#ebbf7d] hover:underline font-semibold flex items-center space-x-1.5">
                                    <span>Staff Console Dashboard</span>
                                    <span>&rarr;</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" @click="mobileMenu = false" class="text-stone-400 hover:text-[#ebbf7d] transition flex items-center space-x-1.5">
                                    <span>Staff Portal Login</span>
                                    <span>&rarr;</span>
                                </a>
                            @endauth

                            <span class="text-stone-500 text-[10px]">Serenity Villa © {{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- Footer with Studenterkilden-style Curtain Reveal -->
    <footer data-footer class="bg-[#161513] text-[#cfcfcf] mt-20 border-t border-[#201d1d] will-change-transform overflow-hidden">
        <div data-footer-inner class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 will-change-transform">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-[#ebbf7d] text-[#161513] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-serif text-2xl font-bold text-[#fdfdfd] tracking-tight">Serenity Villa</span>
                    </div>
                    <p class="text-[#cfcfcf]/80 text-sm max-w-md leading-relaxed">
                        A peaceful sanctuary nestled in lush tropical gardens, offering boutique guest rooms, authentic hospitality, modern amenities, and convenient access to local attractions.
                    </p>
                    <div class="text-xs text-[#cfcfcf]/70 space-y-1">
                        <p class="flex items-center space-x-2">
                            <span>📍 128 River Road, Wat Bo Village, Siem Reap, Cambodia</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <span>📞 +855 23 998 877 | ✉️ stay@serenityvilla.com</span>
                        </p>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-[#ebbf7d] mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-[#fdfdfd] transition">Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-[#fdfdfd] transition">Available Rooms</a></li>
                        <li><a href="{{ route('amenities') }}" class="hover:text-[#fdfdfd] transition">Resort Amenities</a></li>
                        <li><a href="{{ route('experience') }}" class="hover:text-[#fdfdfd] transition">The Experience</a></li>
                        <li><a href="{{ route('booking.create') }}" class="hover:text-[#fdfdfd] transition">Direct Reservation</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#fdfdfd] transition">Staff Management Portal</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-[#ebbf7d] mb-4">Payment & Check-in</h4>
                    <p class="text-xs text-[#cfcfcf]/70 leading-relaxed mb-3">
                        Check-in: <strong>14:00 PM</strong> | Check-out: <strong>12:00 PM</strong>
                    </p>
                    <p class="text-xs text-[#cfcfcf]/70 leading-relaxed mb-3">
                        Accepted payments: Cash (USD/KHR), Visa/Mastercard, and instant Bakong KHQR transfers.
                    </p>
                    <div class="inline-flex items-center px-3 py-1.5 rounded-md bg-[#201d1d] border border-[#39393b] text-xs text-[#ebbf7d] font-mono">
                        KHQR Transfer Compatible
                    </div>
                </div>
            </div>

            <div class="border-t border-[#201d1d] mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-[#8c8985]">
                <p>&copy; {{ date('Y') }} Serenity Villa Guest House Management System. All rights reserved.</p>
                <p class="mt-2 sm:mt-0">Powered by Laravel, MySQL & Tailwind CSS.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
