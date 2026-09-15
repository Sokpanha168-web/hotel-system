@extends('layouts.public')

@section('title', $roomType->name . ' - Serenity Villa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-stone-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-stone-900">Home</a>
        <span>/</span>
        <a href="{{ route('rooms.index') }}" class="hover:text-stone-900">Rooms</a>
        <span>/</span>
        <span class="text-stone-900 font-semibold">{{ $roomType->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Details -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Hero Image -->
            <div class="rounded-2xl overflow-hidden bg-stone-100 h-96 relative border border-stone-200">
                <img src="{{ $roomType->image ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80' }}" 
                     alt="{{ $roomType->name }}" 
                     class="w-full h-full object-cover">
                <div class="absolute bottom-4 left-4 bg-stone-900/80 backdrop-blur-md px-4 py-2 rounded-xl text-white">
                    <span class="text-xs uppercase tracking-wider text-amber-400 font-bold block">Capacity</span>
                    <span class="text-sm font-semibold">Accommodates up to {{ $roomType->capacity }} Guests</span>
                </div>
            </div>

            <!-- Title & Description -->
            <div class="bg-white rounded-2xl border border-stone-200 p-8">
                <div class="flex items-start justify-between border-b border-stone-100 pb-6 mb-6">
                    <div>
                        <h1 class="font-serif text-3xl font-bold text-stone-900 mb-1">{{ $roomType->name }}</h1>
                        <p class="text-xs uppercase tracking-wider text-amber-700 font-bold">Boutique Garden View Suite</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-serif font-bold text-stone-900">${{ number_format($roomType->base_price, 2) }}</span>
                        <span class="text-xs text-stone-500 block">per night</span>
                    </div>
                </div>

                <div class="prose prose-stone max-w-none text-stone-600 text-sm leading-relaxed mb-8">
                    <p>{{ $roomType->description }}</p>
                    <p class="mt-4">
                        Designed with authentic natural woods, local artisan textiles, and soothing earth tones, this room offers an idyllic retreat. Enjoy high-speed wireless connectivity, plush mattresses, and dedicated workspaces suited for both leisure and remote work.
                    </p>
                </div>

                <!-- Amenities Checklist -->
                <div>
                    <h3 class="text-base font-bold text-stone-900 mb-4">Included Amenities & Services</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm text-stone-700">
                        @if(!empty($roomType->amenities))
                            @foreach($roomType->amenities as $amenity)
                                <div class="flex items-center space-x-2 bg-stone-50 p-2.5 rounded-lg border border-stone-200/60">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-xs font-medium">{{ $amenity }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Guest House Policies -->
            <div class="bg-white rounded-2xl border border-stone-200 p-8 text-sm text-stone-600">
                <h3 class="text-base font-bold text-stone-900 mb-4">Guest House Policies</h3>
                <ul class="space-y-2 text-xs list-disc list-inside text-stone-500">
                    <li>Check-in begins at <strong>14:00 PM</strong>. Early check-in subject to room availability.</li>
                    <li>Check-out is strictly at <strong>12:00 PM</strong>. Late check-out may incur add-on charges.</li>
                    <li>Valid passport or national identification is required upon arrival.</li>
                    <li>Non-smoking inside all guest rooms; designated outdoor garden smoking areas available.</li>
                </ul>
            </div>
        </div>

        <!-- Sticky Booking Widget -->
        <div class="lg:col-span-4">
            <div class="sticky top-28 bg-white rounded-2xl border border-stone-200 shadow-md p-6 sm:p-8 space-y-6">
                <div class="border-b border-stone-100 pb-4">
                    <span class="text-xs text-stone-500 uppercase tracking-wider block font-bold">Standard Rate</span>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-3xl font-serif font-bold text-stone-900">${{ number_format($roomType->base_price, 2) }}</span>
                        <span class="text-xs text-stone-500">/ night</span>
                    </div>
                </div>

                <form action="{{ route('booking.create') }}" method="GET" class="space-y-4">
                    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">Check-in</label>
                        <input type="date" name="check_in" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">Check-out</label>
                        <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-sm font-medium">
                    </div>

                    <button type="submit" class="w-full py-3 px-6 rounded-xl font-bold text-sm text-white bg-amber-700 hover:bg-amber-800 shadow-sm transition">
                        Proceed to Reservation
                    </button>
                </form>

                <div class="pt-4 border-t border-stone-100 text-xs text-stone-500 space-y-2">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Free cancellation up to 24 hours prior</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Instant confirmation & Bakong KHQR accepted</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
