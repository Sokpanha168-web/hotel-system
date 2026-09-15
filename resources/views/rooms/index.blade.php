@extends('layouts.public')

@section('title', 'Available Rooms & Suites - Serenity Villa')

@section('content')
<div class="bg-stone-100 py-10 border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 mb-2">Accommodations & Rates</h1>
        <p class="text-stone-600 text-sm">Select your travel dates to verify real-time room availability and best direct rates.</p>

        <!-- Search Bar -->
        <div class="mt-8 bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">Check-in</label>
                    <input type="date" name="check_in" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-sm font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">Check-out</label>
                    <input type="date" name="check_out" value="{{ $checkOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-sm font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">Guests</label>
                    <select name="guests" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-sm font-medium">
                        <option value="1" {{ $guests == 1 ? 'selected' : '' }}>1 Adult</option>
                        <option value="2" {{ $guests == 2 ? 'selected' : '' }}>2 Adults</option>
                        <option value="3" {{ $guests == 3 ? 'selected' : '' }}>3 Guests</option>
                        <option value="4" {{ $guests == 4 ? 'selected' : '' }}>4+ Guests</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-sm text-white bg-amber-700 hover:bg-amber-800 transition">
                        Update Dates
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-8">
        @forelse($roomTypes as $type)
            <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-md transition grid grid-cols-1 lg:grid-cols-12">
                <!-- Image -->
                <div class="lg:col-span-5 h-64 lg:h-auto relative bg-stone-100">
                    <img src="{{ $type->image ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80' }}" 
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
                        <div class="flex flex-wrap gap-1.5 mb-6">
                            @if(!empty($type->amenities))
                                @foreach($type->amenities as $amenity)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-stone-100 text-stone-700">
                                        ✓ {{ $amenity }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Bottom Bar -->
                    <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                        <a href="{{ route('rooms.show', $type->slug) }}" class="text-xs font-bold text-stone-600 hover:text-stone-900 transition">
                            View Room Details &rarr;
                        </a>

                        @if($type->available_count > 0)
                            <a href="{{ route('booking.create', ['room_type_id' => $type->id, 'check_in' => $checkIn, 'check_out' => $checkOut]) }}" 
                               class="px-6 py-2.5 rounded-xl font-bold text-xs text-white bg-amber-700 hover:bg-amber-800 shadow-sm transition">
                                Reserve This Room
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
</div>
@endsection
