@extends('layouts.public')

@section('title', 'Serenity Villa - Boutique Guest House & Gardens')

@section('content')
@php
    $heroSlides = [
        [
            'badge' => '⭐ Top Rated Boutique Guest House in Siem Reap',
            'title' => 'Discover your private tranquil haven.',
            'desc' => 'Immerse yourself in authentic Khmer elegance, serene tropical gardens, and boutique comfort just minutes away from Angkor Wat.',
            'primary_text' => 'Check Availability',
            'primary_url' => '#search-widget',
            'secondary_text' => 'Explore Suites',
            'secondary_url' => route('rooms.index'),
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=2000&q=80',
            'alt' => 'Serenity Villa boutique resort pool at dusk',
        ],
        [
            'badge' => '🌿 Handcrafted Khmer Heritage & Modern Luxury',
            'title' => 'Designed for serenity, rest & pure comfort.',
            'desc' => 'Spacious private terraces, organic cotton linens, rainfall plunge showers, and bespoke woodwork created by local master artisans.',
            'primary_text' => 'View Rooms & Rates',
            'primary_url' => route('rooms.index'),
            'secondary_text' => 'Our Amenities',
            'secondary_url' => '#amenities',
            'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=2000&q=80',
            'alt' => 'Serenity Villa luxury suites and private garden balconies',
        ],
        [
            'badge' => '🌸 Holistic Spa & Traditional Wellness',
            'title' => 'Revitalize your body, mind and spirit.',
            'desc' => 'Unwind with botanical herbal treatments, open-air pavilion massages, and peaceful evening poolside dining under the palms.',
            'primary_text' => 'Book Your Stay',
            'primary_url' => '#search-widget',
            'secondary_text' => 'Discover Experience',
            'secondary_url' => '#experience',
            'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=2000&q=80',
            'alt' => 'Serenity Villa wellness spa & tranquil pavilion',
        ],
        [
            'badge' => '☀️ Curated Angkor Sunrise Excursions',
            'title' => 'Your gateway to the ancient Khmer kingdom.',
            'desc' => 'Tailored private tuk-tuk journeys, dawn temple tours, and bespoke concierge hospitality designed to craft memories that linger.',
            'primary_text' => 'Plan Your Journey',
            'primary_url' => '#search-widget',
            'secondary_text' => 'Browse All Rooms',
            'secondary_url' => route('rooms.index'),
            'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=2000&q=80',
            'alt' => 'Tropical boutique villa surrounded by lush flora',
        ],
    ];
@endphp

<!-- Hero Banner Slider with Ken Burns Effect, Controls & Motion Parallax -->
<section id="hotel-hero" 
         x-data="heroSlider()"
         @touchstart.passive="handleTouchStart($event)"
         @touchend.passive="handleTouchEnd($event)"
         @keydown.arrow-left.window="prev()"
         @keydown.arrow-right.window="next()"
         class="relative bg-stone-950 text-white overflow-hidden min-h-[620px] sm:min-h-[680px] lg:min-h-[720px] flex items-center select-none">
    
    <!-- Background Slide Images Container (Parallax Driven by Motion.dev) -->
    <div id="hero-parallax-bg" class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        @foreach($heroSlides as $index => $slide)
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out will-change-transform"
                 :class="active === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img src="{{ $slide['image'] }}" 
                     alt="{{ $slide['alt'] }}" 
                     class="w-full h-full object-cover opacity-50 mix-blend-overlay transition-transform duration-[7000ms] ease-out will-change-transform"
                     :class="active === {{ $index }} ? 'scale-110' : 'scale-100'">
            </div>
        @endforeach
    </div>

    <!-- Gradient Vignette Overlays for High Contrast Readability -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#161513] via-[#161513]/70 to-[#201d1d]/40 z-10 pointer-events-none"></div>
    <div class="absolute inset-0 bg-radial-at-c from-[#ebbf7d]/10 via-transparent to-black/70 z-10 pointer-events-none"></div>

    <!-- Slide Content Container -->
    <div id="hero-content-wrapper" class="relative z-20 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-28 sm:pt-24 sm:pb-36 will-change-transform transform-gpu">
        <div class="relative min-h-[300px] sm:min-h-[320px] max-w-3xl">
            @foreach($heroSlides as $index => $slide)
                <div x-show="active === {{ $index }}"
                     x-cloak
                     x-transition:enter="transition-all duration-700 ease-out"
                     x-transition:enter-start="opacity-0 translate-y-6"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition-all duration-300 ease-in absolute top-0 left-0 right-0"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="{{ $index === 0 ? '' : 'hidden' }} text-center lg:text-left">
                    
                    <!-- Pill Badge -->
                    <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-[#ebbf7d]/20 border border-[#ebbf7d]/40 text-[#ebbf7d] text-xs font-semibold tracking-wider uppercase mb-6 backdrop-blur-md shadow-sm">
                        <span>{{ $slide['badge'] }}</span>
                    </div>

                    <!-- Slide Title -->
                    <h1 class="font-serif text-4xl sm:text-6xl font-bold tracking-tight text-white leading-tight mb-6 drop-shadow-sm">
                        {{ $slide['title'] }}
                    </h1>

                    <!-- Slide Description -->
                    <p class="text-lg sm:text-xl text-[#f2e9cf]/90 leading-relaxed mb-10 font-light max-w-2xl drop-shadow">
                        {{ $slide['desc'] }}
                    </p>

                    <!-- Slide Action CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ $slide['primary_url'] }}" 
                           class="w-full sm:w-auto px-8 py-4 rounded-xl text-base font-semibold text-[#161513] bg-gradient-to-r from-[#ebbf7d] to-[#f2cca0] hover:from-[#deaf6b] hover:to-[#ebbf7d] shadow-xl shadow-black/30 hover:scale-[1.02] active:scale-[0.98] transition-all text-center">
                            {{ $slide['primary_text'] }}
                        </a>
                        <a href="{{ $slide['secondary_url'] }}" 
                           class="w-full sm:w-auto px-8 py-4 rounded-xl text-base font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md hover:scale-[1.02] active:scale-[0.98] transition-all text-center">
                            {{ $slide['secondary_text'] }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Side Navigation Arrow: Previous -->
    <button @click="prev()" 
            type="button"
            aria-label="Previous Slide"
            class="hidden sm:flex absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full items-center justify-center bg-[#161513]/60 hover:bg-[#161513] hover:text-[#ebbf7d] text-white/80 border border-white/20 backdrop-blur-md shadow-xl transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none group">
        <svg class="w-5 h-5 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Side Navigation Arrow: Next -->
    <button @click="next()" 
            type="button"
            aria-label="Next Slide"
            class="hidden sm:flex absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full items-center justify-center bg-[#161513]/60 hover:bg-[#161513] hover:text-[#ebbf7d] text-white/80 border border-white/20 backdrop-blur-md shadow-xl transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none group">
        <svg class="w-5 h-5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Bottom Timeline Indicators -->
    <div class="absolute bottom-20 sm:bottom-24 left-0 right-0 z-30 pointer-events-none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between pointer-events-auto">
            <!-- Slide Indicators with Real-time Progress Countdown -->
            <div class="flex items-center space-x-3 bg-[#161513]/75 backdrop-blur-md border border-white/15 rounded-full px-4 py-2 shadow-lg">
                @foreach($heroSlides as $index => $slide)
                    <button @click="goTo({{ $index }})" 
                            type="button" 
                            aria-label="Go to slide {{ $index + 1 }}"
                            class="relative h-2 rounded-full transition-all duration-300 focus:outline-none overflow-hidden"
                            :class="active === {{ $index }} ? 'w-10 sm:w-12 bg-stone-800 border border-white/30' : 'w-2.5 bg-white/40 hover:bg-white/70'">
                        <div x-show="active === {{ $index }}" 
                             x-cloak
                             class="h-full bg-gradient-to-r from-[#ebbf7d] to-[#f2e9cf] transition-all duration-75 ease-linear rounded-full"
                             :style="'width: ' + progress + '%'"></div>
                    </button>
                @endforeach

                <!-- Slide Counter (e.g., 01 / 04) -->
                <div class="ml-2 pl-3 border-l border-white/20 text-xs font-medium tracking-wider text-stone-300 font-mono">
                    <span class="text-[#ebbf7d] font-bold" x-text="'0' + (active + 1)">01</span>
                    <span class="text-stone-500">/</span>
                    <span>0{{ count($heroSlides) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search & Booking Filter Widget (Motion.dev In-View Reveal) -->
<div id="search-widget" class="max-w-6xl mx-auto px-4 sm:px-6 -mt-16 relative z-20 will-change-transform transform-gpu">
    <div class="bg-white rounded-2xl shadow-xl shadow-[#161513]/5 border border-[#e2ded5] p-6 lg:p-8">
        <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <!-- Check-in Date -->
            <div>
                <label for="check_in" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-2">
                    Check-in Date
                </label>
                <div class="relative">
                    <input type="date" 
                           id="check_in" 
                           name="check_in" 
                           value="{{ request('check_in', date('Y-m-d')) }}" 
                           min="{{ date('Y-m-d') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-[#e2ded5] text-[#161513] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d] transition">
                </div>
            </div>

            <!-- Check-out Date -->
            <div>
                <label for="check_out" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-2">
                    Check-out Date
                </label>
                <div class="relative">
                    <input type="date" 
                           id="check_out" 
                           name="check_out" 
                           value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-[#e2ded5] text-[#161513] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d] transition">
                </div>
            </div>

            <!-- Guests -->
            <div>
                <label for="guests" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-2">
                    Guests / Capacity
                </label>
                <select id="guests" 
                        name="guests" 
                        class="w-full px-4 py-3 rounded-xl border border-[#e2ded5] text-[#161513] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d] transition">
                    <option value="1" {{ request('guests') == 1 ? 'selected' : '' }}>1 Adult</option>
                    <option value="2" {{ request('guests', 2) == 2 ? 'selected' : '' }}>2 Adults</option>
                    <option value="3" {{ request('guests') == 3 ? 'selected' : '' }}>3 Guests</option>
                    <option value="4" {{ request('guests') == 4 ? 'selected' : '' }}>4+ Family Group</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-[#ebbf7d] bg-[#161513] hover:bg-[#2c2a27] shadow-md shadow-[#161513]/15 transition flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Find Rooms</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Featured Room Types Showcase -->
<section id="accommodations-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="section-reveal-header text-center max-w-3xl mx-auto mb-16">
        <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-3">Accommodations</span>
        <h2 class="section-title font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight mb-4">
            Curated Rooms for Every Journey
        </h2>
        <p class="section-desc text-[#39393b] text-base leading-relaxed">
            From intimate deluxe suites overlooking serene lotus ponds to expansive family villas, each space is crafted with natural wood, plush linens, and modern amenities.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($roomTypes as $type)
            <div class="room-type-card bg-white rounded-2xl overflow-hidden border border-[#e2ded5] shadow-sm hover:shadow-xl hover:border-[#ebbf7d]/60 transition duration-300 flex flex-col group will-change-transform transform-gpu">
                <!-- Image with Price Badge -->
                <div class="relative h-64 overflow-hidden bg-stone-100">
                    <div class="parallax-img-wrapper w-full h-[120%] -top-[10%] absolute inset-x-0 will-change-transform pointer-events-none">
                        <img src="{{ $type->image_url }}" 
                             alt="{{ $type->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500 pointer-events-auto">
                    </div>
                    <div class="absolute top-4 right-4 bg-[#161513]/85 backdrop-blur-md px-3.5 py-1.5 rounded-full text-white text-xs font-semibold z-20">
                        <span class="text-[#ebbf7d] font-bold">${{ number_format($type->base_price, 2) }}</span> / night
                    </div>
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-md px-3 py-1 rounded-md text-[#161513] text-xs font-semibold flex items-center space-x-1.5 z-20">
                        <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Up to {{ $type->capacity }} Guests</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            <a href="{{ route('rooms.show', $type->slug) }}">{{ $type->name }}</a>
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4 line-clamp-2">
                            {{ $type->description }}
                        </p>

                        <!-- Amenities Pills -->
                        <div class="flex flex-wrap gap-1.5 mb-6">
                            @if(!empty($type->amenities))
                                @foreach(array_slice($type->amenities, 0, 4) as $amenity)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-[#f7f4ec] text-[#39393b] border border-[#e2ded5]/60">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-4 border-t border-[#e2ded5]/60 flex items-center justify-between">
                        <a href="{{ route('rooms.show', $type->slug) }}" class="text-xs font-bold text-[#161513] hover:text-[#8c6d3b] transition">
                            Details & Amenities &rarr;
                        </a>
                        <a href="{{ route('booking.create', ['room_type_id' => $type->id]) }}" class="px-4 py-2 rounded-lg text-xs font-bold text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] transition shadow-xs">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-stone-500">
                No room accommodations listed at this time.
            </div>
        @endforelse
    </div>

    <!-- Individual Rooms Fleet Rotating Carousel / Slider -->
    @if(isset($allRooms) && $allRooms->isNotEmpty())
        <div id="fleet-section" 
             x-data="rotatingFleetCarousel({{ $allRooms->count() }})" 
             @mouseenter="pause()" 
             @mouseleave="resume()" 
             class="mt-20 pt-16 border-t border-[#e2ded5] select-none">
            
            <!-- Section Header -->
            <div class="section-reveal-header max-w-3xl mb-8">
                <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-2">Guest Room Fleet</span>
                <h3 class="section-title font-serif text-2xl sm:text-3xl font-bold text-[#161513]">Explore Individual Guest Rooms</h3>
                <p class="section-desc text-[#39393b] text-sm mt-1">Directly select and book specific room numbers across all floors</p>
            </div>

            <!-- Carousel Slider Track with Floating Controls -->
            <div class="relative py-4 -my-4">
                <!-- Floating Left Arrow on Large Screens -->
                <button @click="prev()" 
                        type="button" 
                        aria-label="Previous room"
                        class="hidden xl:flex absolute -left-5 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full items-center justify-center bg-white/95 hover:bg-[#161513] hover:text-[#ebbf7d] text-[#161513] shadow-xl border border-[#e2ded5] backdrop-blur-sm transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Floating Right Arrow on Large Screens -->
                <button @click="next()" 
                        type="button" 
                        aria-label="Next room"
                        class="hidden xl:flex absolute -right-5 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full items-center justify-center bg-white/95 hover:bg-[#161513] hover:text-[#ebbf7d] text-[#161513] shadow-xl border border-[#e2ded5] backdrop-blur-sm transition-all duration-200 hover:scale-110 active:scale-95 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Slider Track (Smooth Scrolling, No Scrollbar, Snap Alignment) -->
                <div x-ref="sliderTrack" 
                     class="flex gap-6 overflow-x-auto scroll-smooth no-scrollbar snap-x snap-mandatory py-4 px-1"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    @foreach($allRooms as $room)
                        <div class="fleet-room-card group relative bg-white rounded-2xl overflow-hidden border border-[#e2ded5] shadow-sm hover:shadow-2xl hover:border-[#ebbf7d]/60 hover:-translate-y-2.5 transition-all duration-300 ease-out flex flex-col justify-between will-change-transform transform-gpu w-[285px] sm:w-[320px] md:w-[340px] flex-shrink-0 snap-start">
                            <!-- Shimmer Sheen Reflection Effect on Hover -->
                            <div class="absolute inset-0 pointer-events-none z-30 overflow-hidden rounded-2xl">
                                <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                            </div>

                            <div>
                                <!-- Room Image with Hover Zoom & Vignette -->
                                <div class="relative h-52 bg-stone-100 overflow-hidden">
                                    <div class="parallax-img-wrapper w-full h-[120%] -top-[10%] absolute inset-x-0 will-change-transform pointer-events-none">
                                        <img src="{{ $room->image_url }}" 
                                             alt="Room {{ $room->room_number }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-[0.5deg] transition-transform duration-700 ease-out will-change-transform pointer-events-auto">
                                    </div>
                                    
                                    <!-- Subtle Vignette Overlay on Hover -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#161513]/70 via-[#161513]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 pointer-events-none"></div>

                                    <!-- Room Number Badge -->
                                    <div class="absolute top-3 left-3 z-20 bg-[#161513]/85 group-hover:bg-[#161513] backdrop-blur-md px-3 py-1 rounded-xl text-white text-xs font-bold shadow-md transition-colors duration-300">
                                        Room {{ $room->room_number }}
                                    </div>

                                    <!-- Room Status Badge with Live Pulsing Radar -->
                                    <div class="absolute top-3 right-3 z-20">
                                        @if($room->status === 'available')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider bg-emerald-600/95 text-white backdrop-blur-md shadow-md">
                                                <span class="relative flex h-2 w-2 mr-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                                </span>
                                                Available
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider bg-stone-600/90 text-white backdrop-blur-md shadow-sm">
                                                <svg class="w-2.5 h-2.5 mr-1 text-stone-300 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Floor Badge -->
                                    <div class="absolute bottom-3 left-3 z-20 bg-white/95 group-hover:bg-[#f2e9cf] backdrop-blur-md px-2.5 py-1 rounded-lg text-xs font-semibold text-[#39393b] group-hover:text-[#161513] shadow-sm transition-colors duration-200">
                                        Floor {{ $room->floor }}
                                    </div>
                                </div>

                                <!-- Room Details -->
                                <div class="p-5">
                                    <h4 class="font-serif font-bold text-[#161513] text-base mb-1.5 group-hover:text-[#8c6d3b] transition-colors duration-200 line-clamp-1">
                                        {{ $room->roomType->name }}
                                    </h4>
                                    <div class="flex items-baseline justify-between text-xs mb-1">
                                        <div>
                                            <span class="text-base font-serif font-bold text-[#161513]">
                                                ${{ number_format($room->roomType->base_price, 2) }}
                                            </span>
                                            <span class="text-stone-400 font-normal"> / night</span>
                                        </div>
                                        <span class="inline-flex items-center text-[#39393b] font-medium text-[11px] bg-[#f7f4ec] px-2 py-0.5 rounded-md border border-[#e2ded5]/60">
                                            <svg class="w-3 h-3 mr-1 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Max {{ $room->roomType->capacity }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button with Hover Interaction -->
                            <div class="p-5 pt-0">
                                @if($room->status === 'available')
                                    <a href="{{ route('booking.create', ['room' => $room->id]) }}" 
                                       class="group/btn relative w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl text-xs font-bold text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-sm hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                        <span>Book Room {{ $room->room_number }}</span>
                                        <svg class="w-3.5 h-3.5 ml-1.5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <button disabled class="w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl text-xs font-bold text-stone-400 bg-stone-100/90 cursor-not-allowed border border-stone-200/50">
                                        Currently {{ ucfirst($room->status) }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</section>

<!-- Amenities & Guest Experience -->
<section id="amenities" class="bg-[#f7f4ec] py-24 border-y border-[#e2ded5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-reveal-header text-center max-w-3xl mx-auto mb-16">
            <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-3">Resort Amenities</span>
            <h2 class="section-title font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight mb-4">
                Thoughtful Touches for a Restful Stay
            </h2>
            <p class="section-desc text-[#39393b] text-base leading-relaxed">
                Everything you need to unwind, revitalize, and experience seamless Cambodian hospitality.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="amenity-card p-8 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:shadow-md transition will-change-transform transform-gpu">
                <div class="w-12 h-12 rounded-xl bg-[#f2e9cf] text-[#161513] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#161513] mb-2">Saltwater Tropical Pool</h3>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Surrounded by lush frangipani trees and comfortable sun loungers, perfect for relaxing after temple excursions.
                </p>
            </div>

            <div class="amenity-card p-8 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:shadow-md transition will-change-transform transform-gpu">
                <div class="w-12 h-12 rounded-xl bg-[#f2e9cf] text-[#161513] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#161513] mb-2">High-Speed Fiber Wi-Fi</h3>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Reliable gigabit internet coverage across all private rooms, garden patios, and co-working lounge spaces.
                </p>
            </div>

            <div class="amenity-card p-8 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:shadow-md transition will-change-transform transform-gpu">
                <div class="w-12 h-12 rounded-xl bg-[#f2e9cf] text-[#161513] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#161513] mb-2">Instant KHQR Payments</h3>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Convenient cashless checkout supporting any Cambodian bank via the national Bakong KHQR QR standard.
                </p>
            </div>

            <div class="amenity-card p-8 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:shadow-md transition will-change-transform transform-gpu">
                <div class="w-12 h-12 rounded-xl bg-[#f2e9cf] text-[#161513] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#161513] mb-2">Artisan Breakfast & Café</h3>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Freshly brewed local Mondulkiri coffee, tropical seasonal fruit platters, and wholesome made-to-order breakfasts.
                </p>
            </div>

            <div class="amenity-card p-8 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:shadow-md transition will-change-transform transform-gpu">
                <div class="w-12 h-12 rounded-xl bg-[#f2e9cf] text-[#161513] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#161513] mb-2">Concierge & Excursion Booking</h3>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Private remork (tuk-tuk) temple circuits, licensed tour guides, bicycle rentals, and airport transfers arranged on-site.
                </p>
            </div>

            <div class="amenity-card p-8 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:shadow-md transition will-change-transform transform-gpu">
                <div class="w-12 h-12 rounded-xl bg-[#f2e9cf] text-[#161513] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#161513] mb-2">24/7 Front Desk & Security</h3>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Always available assistance for late check-ins, luggage storage, and nighttime peace of mind.
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('amenities') }}" class="inline-flex items-center space-x-2 px-6 py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-[#161513] bg-white hover:bg-[#ebbf7d] border border-[#e2ded5] shadow-xs hover:shadow-md transition-all duration-200">
                <span>Explore All Facilities & Services</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div id="cta-banner" class="rounded-3xl bg-[#161513] text-[#fdfdfd] p-10 sm:p-16 flex flex-col lg:flex-row items-center justify-between shadow-2xl shadow-black/25 border border-[#201d1d] relative overflow-hidden will-change-transform transform-gpu">
        <div class="relative z-10 max-w-2xl text-center lg:text-left mb-8 lg:mb-0">
            <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight mb-4 text-white">
                Plan Your Unforgettable Escape Today
            </h2>
            <p class="text-[#f2e9cf]/85 text-base leading-relaxed">
                Book directly on our official site to enjoy complimentary welcome drinks, flexible cancellation, and guaranteed best rates.
            </p>
        </div>
        <div class="relative z-10 flex-shrink-0">
            <a href="{{ route('booking.create') }}" class="px-8 py-4 rounded-xl font-bold text-base text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-lg shadow-black/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                Reserve Your Stay &rarr;
            </a>
        </div>
    </div>
</section>
@endsection

