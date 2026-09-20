@extends('layouts.public')

@section('title', 'Rooms & Suites - Serenity Villa')

@section('content')
<!-- Header Banner with Filter Form -->
<div class="bg-[#161513] text-white py-16 border-b border-[#e2ded5]/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-10">
            <span class="text-xs uppercase tracking-widest text-[#ebbf7d] font-bold block mb-2">Our Accommodations</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold tracking-tight mb-4">
                Rooms & Private Suites
            </h1>
            <p class="text-stone-300 text-sm sm:text-base leading-relaxed">
                Discover serene retreats designed with indigenous teak wood, natural linens, and private garden terraces.
            </p>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/15">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider text-stone-300 font-semibold mb-1">Check-in</label>
                    <input type="date" name="check_in" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-white/20 border border-white/20 text-white text-sm focus:outline-none focus:bg-white/30 focus:border-[#ebbf7d] transition">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-stone-300 font-semibold mb-1">Check-out</label>
                    <input type="date" name="check_out" value="{{ $checkOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-white/20 border border-white/20 text-white text-sm focus:outline-none focus:bg-white/30 focus:border-[#ebbf7d] transition">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-stone-300 font-semibold mb-1">Guests</label>
                    <select name="guests" class="w-full px-3.5 py-2.5 rounded-xl bg-white/20 border border-white/20 text-white text-sm focus:outline-none focus:bg-white/30 focus:border-[#ebbf7d] transition [&>option]:text-[#161513]">
                        <option value="1" {{ $guests == 1 ? 'selected' : '' }}>1 Guest</option>
                        <option value="2" {{ $guests == 2 ? 'selected' : '' }}>2 Guests</option>
                        <option value="3" {{ $guests == 3 ? 'selected' : '' }}>3 Guests</option>
                        <option value="4" {{ $guests >= 4 ? 'selected' : '' }}>4+ Guests</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-transparent font-semibold mb-1">Search</label>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-sm text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] transition shadow-sm">
                        Update Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ viewMode: 'categories' }">
    <!-- View Switcher Tabs -->
    <div class="flex items-center justify-between pb-6 mb-8 border-b border-[#e2ded5]">
        <div class="flex items-center space-x-3">
            <button @click="viewMode = 'categories'" 
                    :class="viewMode === 'categories' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#efeeec]'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Room Categories ({{ $roomTypes->count() }})</span>
            </button>

            <button @click="viewMode = 'rooms'" 
                    :class="viewMode === 'rooms' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#efeeec]'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>All Individual Rooms ({{ $allRooms->count() }})</span>
            </button>
        </div>

        <span class="text-xs text-[#39393b] hidden sm:block font-medium">
            Showing {{ $roomTypes->count() }} categories • {{ $allRooms->count() }} total rooms
        </span>
    </div>

    <!-- 1. Room Categories View -->
    <div x-show="viewMode === 'categories'" class="space-y-8">
        @forelse($roomTypes as $type)
            <div class="bg-white rounded-2xl border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-md transition grid grid-cols-1 lg:grid-cols-12">
                <!-- Image -->
                <div class="lg:col-span-5 h-64 lg:h-auto relative bg-[#f7f4ec]">
                    <img src="{{ $type->image_url }}" 
                         alt="{{ $type->name }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4">
                        @if($type->available_count > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                {{ $type->available_count }} {{ Str::plural('Room', $type->available_count) }} Available
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-600 text-white shadow-sm">
                                Sold Out for These Dates
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h2 class="font-serif text-2xl font-bold text-[#161513]">
                                    <a href="{{ route('rooms.show', $type->slug) }}" class="hover:text-[#8c6d3b] transition">{{ $type->name }}</a>
                                </h2>
                                <span class="text-xs font-semibold text-[#39393b] flex items-center space-x-2 mt-1">
                                    <span>Max {{ $type->capacity }} Guests</span>
                                    <span>•</span>
                                    <span>Air Conditioned</span>
                                    <span>•</span>
                                    <span>Private Bathroom</span>
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-serif font-bold text-[#161513]">${{ number_format($type->base_price, 2) }}</span>
                                <span class="text-xs text-[#39393b] block">/ night</span>
                            </div>
                        </div>

                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            {{ $type->description }}
                        </p>

                        <!-- Amenities -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @if(!empty($type->amenities))
                                @foreach($type->amenities as $amenity)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-[#f7f4ec] text-[#39393b]">
                                        ✓ {{ $amenity }}
                                    </span>
                                @endforeach
                            @endif
                        </div>

                        <!-- Included Room Numbers Badge List -->
                        @if($type->rooms->isNotEmpty())
                            <div class="mb-4 pt-3 border-t border-[#e2ded5]/60">
                                <span class="text-[11px] uppercase tracking-wider text-[#8c6d3b] font-bold block mb-1.5">Assigned Rooms in Fleet:</span>
                                <div class="flex flex-wrap items-center gap-1.5">
                                    @foreach($type->rooms as $r)
                                        <a href="{{ route('booking.create', ['room' => $r->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                                           title="Book Room {{ $r->room_number }} (Floor {{ $r->floor }})"
                                           class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-xs font-semibold border transition {{ $r->status === 'available' ? 'bg-emerald-50 border-emerald-200 text-emerald-800 hover:bg-emerald-100' : 'bg-[#f7f4ec] border-[#e2ded5] text-stone-500' }}">
                                            <span>Room {{ $r->room_number }}</span>
                                            <span class="text-[10px] text-stone-400">(Fl. {{ $r->floor }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Bottom Bar -->
                    <div class="pt-4 border-t border-[#e2ded5]/60 flex items-center justify-between">
                        <a href="{{ route('rooms.show', $type->slug) }}" class="text-xs font-bold text-[#39393b] hover:text-[#161513] transition">
                            View Category Details &rarr;
                        </a>

                        @if($type->available_count > 0)
                            <a href="{{ route('booking.create', ['room_type_id' => $type->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                               class="px-6 py-2.5 rounded-xl font-bold text-xs text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-sm transition">
                                Reserve Category
                            </a>
                        @else
                            <button disabled class="px-6 py-2.5 rounded-xl font-semibold text-xs text-stone-400 bg-[#f7f4ec] cursor-not-allowed">
                                Not Available
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center bg-white rounded-2xl border border-[#e2ded5]">
                <p class="text-[#39393b]">No rooms match your filter criteria. Try adjusting dates or guest count.</p>
            </div>
        @endforelse
    </div>

    <!-- 2. All Individual Rooms Fleet View -->
    <div x-show="viewMode === 'rooms'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($allRooms as $room)
            <div class="fleet-room-card group relative bg-white rounded-2xl overflow-hidden border border-[#e2ded5] shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/80 hover:-translate-y-2 transition-all duration-300 ease-out flex flex-col justify-between will-change-transform transform-gpu">
                <!-- Shimmer Sheen Reflection Effect on Hover -->
                <div class="absolute inset-0 pointer-events-none z-30 overflow-hidden rounded-2xl">
                    <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                </div>

                <div>
                    <!-- Room Image with Hover Zoom & Vignette -->
                    <div class="relative h-52 bg-[#f7f4ec] overflow-hidden">
                        <img src="{{ $room->image_url }}" 
                             alt="Room {{ $room->room_number }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-[0.5deg] transition-transform duration-700 ease-out will-change-transform">
                        
                        <!-- Subtle Vignette Overlay on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/70 via-stone-950/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 pointer-events-none"></div>

                        <!-- Room Number Badge -->
                        <div class="absolute top-3 left-3 z-20 bg-[#161513]/90 group-hover:bg-[#161513] backdrop-blur-md px-3 py-1 rounded-xl text-[#ebbf7d] text-xs font-bold shadow-md transition-colors duration-300 border border-[#e2ded5]/20">
                            Room {{ $room->room_number }}
                        </div>

                        <!-- Room Status Badge -->
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
                        <div class="absolute bottom-3 left-3 z-20 bg-white/95 group-hover:bg-[#f7f4ec] backdrop-blur-md px-2.5 py-1 rounded-lg text-xs font-semibold text-[#161513] shadow-xs transition-colors duration-200 border border-[#e2ded5]/40">
                            Floor {{ $room->floor }}
                        </div>
                    </div>

                    <!-- Room Details -->
                    <div class="p-5">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#8c6d3b] block mb-1">
                            {{ $room->roomType->name }}
                        </span>
                        <div class="flex items-baseline justify-between mb-2">
                            <span class="text-lg font-serif font-bold text-[#161513] transition-colors">${{ number_format($room->roomType->base_price, 2) }}</span>
                            <span class="text-xs text-[#39393b]">/ night</span>
                        </div>
                        <p class="text-xs text-[#39393b] line-clamp-2 mb-2">{{ $room->roomType->description }}</p>
                        <span class="text-xs text-stone-400 block font-medium">Capacity: Max {{ $room->roomType->capacity }} Guests</span>
                    </div>
                </div>

                <!-- Booking Button -->
                <div class="p-5 pt-0">
                    @if($room->status === 'available')
                        <a href="{{ route('booking.create', ['room' => $room->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                           class="group/btn relative w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl text-xs font-bold text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-xs hover:shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                            <span>Book Room {{ $room->room_number }}</span>
                            <svg class="w-3.5 h-3.5 ml-1.5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <button disabled class="w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl text-xs font-bold text-stone-400 bg-[#f7f4ec] cursor-not-allowed border border-[#e2ded5]">
                            Currently {{ ucfirst($room->status) }}
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 text-center bg-white rounded-2xl border border-[#e2ded5]">
                <p class="text-[#39393b]">No individual rooms found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
