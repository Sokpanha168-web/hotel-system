@extends('layouts.public')

@section('title', 'Rooms & Suites - Serenity Villa')

@section('content')
<!-- Header Banner with Filter Form -->
<div class="bg-stone-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-10">
            <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-2">Our Accommodations</span>
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
                           class="w-full px-3.5 py-2.5 rounded-xl bg-white/20 border border-white/20 text-white text-sm focus:outline-none focus:bg-white/30 focus:border-amber-400 transition">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-stone-300 font-semibold mb-1">Check-out</label>
                    <input type="date" name="check_out" value="{{ $checkOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-white/20 border border-white/20 text-white text-sm focus:outline-none focus:bg-white/30 focus:border-amber-400 transition">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-stone-300 font-semibold mb-1">Guests</label>
                    <select name="guests" class="w-full px-3.5 py-2.5 rounded-xl bg-white/20 border border-white/20 text-white text-sm focus:outline-none focus:bg-white/30 focus:border-amber-400 transition [&>option]:text-stone-900">
                        <option value="1" {{ $guests == 1 ? 'selected' : '' }}>1 Guest</option>
                        <option value="2" {{ $guests == 2 ? 'selected' : '' }}>2 Guests</option>
                        <option value="3" {{ $guests == 3 ? 'selected' : '' }}>3 Guests</option>
                        <option value="4" {{ $guests >= 4 ? 'selected' : '' }}>4+ Guests</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-transparent font-semibold mb-1">Search</label>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-sm text-white bg-amber-700 hover:bg-amber-800 transition shadow-sm">
                        Update Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ viewMode: 'categories' }">
    <!-- View Switcher Tabs -->
    <div class="flex items-center justify-between pb-6 mb-8 border-b border-stone-200">
        <div class="flex items-center space-x-3">
            <button @click="viewMode = 'categories'" 
                    :class="viewMode === 'categories' ? 'bg-amber-700 text-white shadow-xs' : 'bg-stone-100 text-stone-600 hover:bg-stone-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Room Categories ({{ $roomTypes->count() }})</span>
            </button>

            <button @click="viewMode = 'rooms'" 
                    :class="viewMode === 'rooms' ? 'bg-amber-700 text-white shadow-xs' : 'bg-stone-100 text-stone-600 hover:bg-stone-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>All Individual Rooms ({{ $allRooms->count() }})</span>
            </button>
        </div>

        <span class="text-xs text-stone-500 hidden sm:block">
            Showing {{ $roomTypes->count() }} categories • {{ $allRooms->count() }} total rooms
        </span>
    </div>

    <!-- 1. Room Categories View -->
    <div x-show="viewMode === 'categories'" class="space-y-8">
        @forelse($roomTypes as $type)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-md transition grid grid-cols-1 lg:grid-cols-12">
                <!-- Image -->
                <div class="lg:col-span-5 h-64 lg:h-auto relative bg-stone-100">
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
                                <h2 class="font-serif text-2xl font-bold text-stone-900">
                                    <a href="{{ route('rooms.show', $type->slug) }}" class="hover:text-amber-700 transition">{{ $type->name }}</a>
                                </h2>
                                <span class="text-xs font-semibold text-stone-500 flex items-center space-x-2 mt-1">
                                    <span>Max {{ $type->capacity }} Guests</span>
                                    <span>•</span>
                                    <span>Air Conditioned</span>
                                    <span>•</span>
                                    <span>Private Bathroom</span>
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-serif font-bold text-stone-900">${{ number_format($type->base_price, 2) }}</span>
                                <span class="text-xs text-stone-500 block">/ night</span>
                            </div>
                        </div>

                        <p class="text-stone-600 text-sm leading-relaxed mb-4">
                            {{ $type->description }}
                        </p>

                        <!-- Amenities -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @if(!empty($type->amenities))
                                @foreach($type->amenities as $amenity)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-stone-100 text-stone-700">
                                        ✓ {{ $amenity }}
                                    </span>
                                @endforeach
                            @endif
                        </div>

                        <!-- Included Room Numbers Badge List -->
                        @if($type->rooms->isNotEmpty())
                            <div class="mb-4 pt-3 border-t border-stone-100">
                                <span class="text-[11px] uppercase tracking-wider text-stone-400 font-bold block mb-1.5">Assigned Rooms in Fleet:</span>
                                <div class="flex flex-wrap items-center gap-1.5">
                                    @foreach($type->rooms as $r)
                                        <a href="{{ route('booking.create', ['room' => $r->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                                           title="Book Room {{ $r->room_number }} (Floor {{ $r->floor }})"
                                           class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-xs font-semibold border transition {{ $r->status === 'available' ? 'bg-emerald-50 border-emerald-200 text-emerald-800 hover:bg-emerald-100' : 'bg-stone-50 border-stone-200 text-stone-500' }}">
                                            <span>Room {{ $r->room_number }}</span>
                                            <span class="text-[10px] text-stone-400">(Fl. {{ $r->floor }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Bottom Bar -->
                    <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                        <a href="{{ route('rooms.show', $type->slug) }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition">
                            View Category Details &rarr;
                        </a>

                        @if($type->available_count > 0)
                            <a href="{{ route('booking.create', ['room_type_id' => $type->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                               class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-amber-700 hover:bg-amber-800 shadow-sm transition">
                                Reserve Category
                            </a>
                        @else
                            <button disabled class="px-6 py-2.5 rounded-xl font-semibold text-xs text-stone-400 bg-stone-100 cursor-not-allowed">
                                Not Available
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center bg-white rounded-2xl border border-stone-200">
                <p class="text-stone-500">No rooms match your filter criteria. Try adjusting dates or guest count.</p>
            </div>
        @endforelse
    </div>

    <!-- 2. All Individual Rooms Fleet View -->
    <div x-show="viewMode === 'rooms'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($allRooms as $room)
            <div class="bg-white rounded-2xl overflow-hidden border border-stone-200 shadow-xs hover:shadow-lg transition duration-200 flex flex-col justify-between group">
                <div>
                    <!-- Room Image -->
                    <div class="relative h-48 bg-stone-100 overflow-hidden">
                        <img src="{{ $room->image_url }}" alt="Room {{ $room->room_number }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3 bg-stone-900/80 backdrop-blur-md px-2.5 py-1 rounded-lg text-white text-xs font-bold">
                            Room {{ $room->room_number }}
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider {{ $room->status === 'available' ? 'bg-emerald-600 text-white' : 'bg-stone-500 text-white' }}">
                                {{ $room->status }}
                            </span>
                        </div>
                        <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-0.5 rounded text-xs font-semibold text-stone-700">
                            Floor {{ $room->floor }}
                        </div>
                    </div>

                    <!-- Room Details -->
                    <div class="p-4">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 block mb-1">
                            {{ $room->roomType->name }}
                        </span>
                        <div class="flex items-baseline justify-between mb-2">
                            <span class="text-lg font-serif font-bold text-stone-900">${{ number_format($room->roomType->base_price, 2) }}</span>
                            <span class="text-xs text-stone-400">/ night</span>
                        </div>
                        <p class="text-xs text-stone-500 line-clamp-2 mb-2">{{ $room->roomType->description }}</p>
                        <span class="text-xs text-stone-400 block font-medium">Capacity: Max {{ $room->roomType->capacity }} Guests</span>
                    </div>
                </div>

                <!-- Booking Button -->
                <div class="p-4 pt-0">
                    @if($room->status === 'available')
                        <a href="{{ route('booking.create', ['room' => $room->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                           class="block w-full text-center py-2.5 px-3 rounded-xl text-xs font-bold text-white bg-amber-700 hover:bg-amber-800 transition shadow-xs">
                            Book Room {{ $room->room_number }}
                        </a>
                    @else
                        <button disabled class="block w-full text-center py-2.5 px-3 rounded-xl text-xs font-bold text-stone-400 bg-stone-100 cursor-not-allowed">
                            Currently {{ ucfirst($room->status) }}
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 text-center bg-white rounded-2xl border border-stone-200">
                <p class="text-stone-500">No individual rooms found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
