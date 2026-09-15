@extends('layouts.public')

@section('title', 'Serenity Villa - Boutique Guest House & Gardens')

@section('content')
<!-- Hero Section -->
<section class="relative bg-stone-900 text-white overflow-hidden">
    <!-- Ambient Background Image overlay -->
    <div class="absolute inset-0 z-0 opacity-40 bg-[radial-gradient(#d97706_1px,transparent_1px)] [background-size:16px_16px]">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=2000&q=80" 
             alt="Serenity Villa Resort" 
             class="w-full h-full object-cover mix-blend-overlay">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-900/70 to-stone-900/40 z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-36 text-center lg:text-left">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-semibold tracking-wider uppercase mb-6 backdrop-blur-sm">
                <span>⭐ Top Rated Guest House in Siem Reap</span>
            </div>
            <h1 class="font-serif text-4xl sm:text-6xl font-bold tracking-tight text-white leading-tight mb-6">
                Discover your private tranquil haven.
            </h1>
            <p class="text-lg sm:text-xl text-stone-300 leading-relaxed mb-10 font-light">
                Immerse yourself in authentic Khmer elegance, serene tropical gardens, and boutique comfort just minutes away from Angkor Wat.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                <a href="#search-widget" class="w-full sm:w-auto px-8 py-4 rounded-xl text-base font-semibold text-stone-900 bg-amber-400 hover:bg-amber-300 shadow-lg shadow-amber-900/30 transition text-center">
                    Check Availability
                </a>
                <a href="{{ route('rooms.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl text-base font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-sm transition text-center">
                    Explore Suites
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Search & Booking Filter Widget -->
<div id="search-widget" class="max-w-6xl mx-auto px-4 sm:px-6 -mt-16 relative z-20">
    <div class="bg-white rounded-2xl shadow-xl shadow-stone-900/10 border border-stone-200 p-6 lg:p-8">
        <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <!-- Check-in Date -->
            <div>
                <label for="check_in" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">
                    Check-in Date
                </label>
                <div class="relative">
                    <input type="date" 
                           id="check_in" 
                           name="check_in" 
                           value="{{ request('check_in', date('Y-m-d')) }}" 
                           min="{{ date('Y-m-d') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-900 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                </div>
            </div>

            <!-- Check-out Date -->
            <div>
                <label for="check_out" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">
                    Check-out Date
                </label>
                <div class="relative">
                    <input type="date" 
                           id="check_out" 
                           name="check_out" 
                           value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-900 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                </div>
            </div>

            <!-- Guests -->
            <div>
                <label for="guests" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">
                    Guests / Capacity
                </label>
                <select id="guests" 
                        name="guests" 
                        class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-900 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                    <option value="1" {{ request('guests') == 1 ? 'selected' : '' }}>1 Adult</option>
                    <option value="2" {{ request('guests', 2) == 2 ? 'selected' : '' }}>2 Adults</option>
                    <option value="3" {{ request('guests') == 3 ? 'selected' : '' }}>3 Guests</option>
                    <option value="4" {{ request('guests') == 4 ? 'selected' : '' }}>4+ Family Group</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white bg-amber-700 hover:bg-amber-800 shadow-md shadow-amber-900/15 transition flex items-center justify-center space-x-2">
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
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-xs uppercase tracking-widest text-amber-700 font-bold block mb-3">Accommodations</span>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 tracking-tight mb-4">
            Curated Rooms for Every Journey
        </h2>
        <p class="text-stone-600 text-base leading-relaxed">
            From intimate deluxe suites overlooking serene lotus ponds to expansive family villas, each space is crafted with natural wood, plush linens, and modern amenities.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($roomTypes as $type)
            <div class="bg-white rounded-2xl overflow-hidden border border-stone-200 shadow-sm hover:shadow-xl transition duration-300 flex flex-col group">
                <!-- Image with Price Badge -->
                <div class="relative h-64 overflow-hidden bg-stone-100">
                    <img src="{{ $type->image ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80' }}" 
                         alt="{{ $type->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 right-4 bg-stone-950/80 backdrop-blur-md px-3.5 py-1.5 rounded-full text-white text-xs font-semibold">
                        <span class="text-amber-400 font-bold">${{ number_format($type->base_price, 2) }}</span> / night
                    </div>
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-md text-stone-800 text-xs font-semibold flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Up to {{ $type->capacity }} Guests</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-stone-900 mb-2 group-hover:text-amber-700 transition">
                            <a href="{{ route('rooms.show', $type->slug) }}">{{ $type->name }}</a>
                        </h3>
                        <p class="text-stone-500 text-sm leading-relaxed mb-4 line-clamp-2">
                            {{ $type->description }}
                        </p>

                        <!-- Amenities Pills -->
                        <div class="flex flex-wrap gap-1.5 mb-6">
                            @if(!empty($type->amenities))
                                @foreach(array_slice($type->amenities, 0, 4) as $amenity)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-stone-100 text-stone-700">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                        <a href="{{ route('rooms.show', $type->slug) }}" class="text-xs font-bold text-stone-700 hover:text-stone-900 transition">
                            Details & Amenities &rarr;
                        </a>
                        <a href="{{ route('booking.create', ['room_type_id' => $type->id]) }}" class="px-4 py-2 rounded-lg text-xs font-bold text-white bg-amber-700 hover:bg-amber-800 transition shadow-xs">
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
</section>

<!-- Amenities & Guest Experience -->
<section id="amenities" class="bg-stone-100 py-24 border-y border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-widest text-amber-700 font-bold block mb-3">Resort Amenities</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 tracking-tight mb-4">
                Thoughtful Touches for a Restful Stay
            </h2>
            <p class="text-stone-600 text-base leading-relaxed">
                Everything you need to unwind, revitalize, and experience seamless Cambodian hospitality.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="p-8 rounded-2xl bg-white border border-stone-200 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Saltwater Tropical Pool</h3>
                <p class="text-stone-600 text-sm leading-relaxed">
                    Surrounded by lush frangipani trees and comfortable sun loungers, perfect for relaxing after temple excursions.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-stone-200 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">High-Speed Fiber Wi-Fi</h3>
                <p class="text-stone-600 text-sm leading-relaxed">
                    Reliable gigabit internet coverage across all private rooms, garden patios, and co-working lounge spaces.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-stone-200 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Instant KHQR Payments</h3>
                <p class="text-stone-600 text-sm leading-relaxed">
                    Convenient cashless checkout supporting any Cambodian bank via the national Bakong KHQR QR standard.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-stone-200 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Artisan Breakfast & Café</h3>
                <p class="text-stone-600 text-sm leading-relaxed">
                    Freshly brewed local Mondulkiri coffee, tropical seasonal fruit platters, and wholesome made-to-order breakfasts.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-stone-200 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Concierge & Excursion Booking</h3>
                <p class="text-stone-600 text-sm leading-relaxed">
                    Private remork (tuk-tuk) temple circuits, licensed tour guides, bicycle rentals, and airport transfers arranged on-site.
                </p>
            </div>

            <div class="p-8 rounded-2xl bg-white border border-stone-200 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">24/7 Front Desk & Security</h3>
                <p class="text-stone-600 text-sm leading-relaxed">
                    Always available assistance for late check-ins, luggage storage, and nighttime peace of mind.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="rounded-3xl bg-amber-700 text-white p-10 sm:p-16 flex flex-col lg:flex-row items-center justify-between shadow-xl shadow-amber-900/20 relative overflow-hidden">
        <div class="relative z-10 max-w-2xl text-center lg:text-left mb-8 lg:mb-0">
            <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight mb-4">
                Plan Your Unforgettable Escape Today
            </h2>
            <p class="text-amber-100 text-base leading-relaxed">
                Book directly on our official site to enjoy complimentary welcome drinks, flexible cancellation, and guaranteed best rates.
            </p>
        </div>
        <div class="relative z-10 flex-shrink-0">
            <a href="{{ route('booking.create') }}" class="px-8 py-4 rounded-xl font-bold text-base text-amber-900 bg-white hover:bg-amber-50 shadow-lg transition">
                Reserve Your Stay &rarr;
            </a>
        </div>
    </div>
</section>
@endsection
