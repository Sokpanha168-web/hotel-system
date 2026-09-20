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
            <div class="rounded-2xl overflow-hidden bg-stone-100 h-96 relative border border-[#e2ded5]">
                <img src="{{ $roomType->image_url }}" 
                     alt="{{ $roomType->name }}" 
                     class="w-full h-full object-cover">
                <div class="absolute bottom-4 left-4 bg-[#161513]/85 backdrop-blur-md px-4 py-2 rounded-xl text-white">
                    <span class="text-xs uppercase tracking-wider text-[#ebbf7d] font-bold block">Capacity</span>
                    <span class="text-sm font-semibold">Accommodates up to {{ $roomType->capacity }} Guests</span>
                </div>
            </div>

            <!-- Title & Description -->
            <div class="bg-white rounded-2xl border border-[#e2ded5] p-8">
                <div class="flex items-start justify-between border-b border-[#e2ded5]/60 pb-6 mb-6">
                    <div>
                        <h1 class="font-serif text-3xl font-bold text-[#161513] mb-1">{{ $roomType->name }}</h1>
                        <p class="text-xs uppercase tracking-wider text-[#8c6d3b] font-bold">Boutique Garden View Suite</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-serif font-bold text-[#161513]">${{ number_format($roomType->base_price, 2) }}</span>
                        <span class="text-xs text-[#39393b] block">per night</span>
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

            <!-- Specific Rooms Available in this Category -->
            @if($roomType->rooms->isNotEmpty())
                <div class="bg-white rounded-2xl border border-stone-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-serif font-bold text-stone-900">Rooms in this Category</h3>
                            <p class="text-xs text-stone-500 mt-0.5">Select and reserve a specific room number or floor</p>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-stone-100 text-stone-700">
                            {{ $roomType->rooms->count() }} Total Rooms
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($roomType->rooms as $room)
                            <div class="p-4 rounded-xl border border-[#e2ded5] hover:border-[#ebbf7d] bg-[#f7f4ec]/40 hover:bg-white transition flex items-center justify-between gap-4">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-stone-200 flex-shrink-0 border border-[#e2ded5]">
                                        <img src="{{ $room->image_url }}" alt="Room {{ $room->room_number }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-bold text-[#161513] text-sm">Room {{ $room->room_number }}</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $room->status === 'available' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-700' }}">
                                                {{ $room->status }}
                                            </span>
                                        </div>
                                        <span class="text-xs text-[#39393b] block">Floor {{ $room->floor }}</span>
                                    </div>
                                </div>

                                @if($room->status === 'available')
                                    <a href="{{ route('booking.create', ['room' => $room->id]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] transition shadow-xs flex-shrink-0">
                                        Book This
                                    </a>
                                @else
                                    <span class="text-xs text-stone-400 font-medium px-2 py-1 flex-shrink-0">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Guest House Policies -->
            <div class="bg-white rounded-2xl border border-[#e2ded5] p-8 text-sm text-[#39393b]">
                <h3 class="text-base font-bold text-[#161513] mb-4">Guest House Policies</h3>
                <ul class="space-y-2 text-xs list-disc list-inside text-[#39393b]/80">
                    <li>Check-in begins at <strong>14:00 PM</strong>. Early check-in subject to room availability.</li>
                    <li>Check-out is strictly at <strong>12:00 PM</strong>. Late check-out may incur add-on charges.</li>
                    <li>Valid passport or national identification is required upon arrival.</li>
                    <li>Non-smoking inside all guest rooms; designated outdoor garden smoking areas available.</li>
                </ul>
            </div>
        </div>

        <!-- Sticky Booking Widget -->
        <div class="lg:col-span-4">
            <div class="sticky top-28 bg-white rounded-2xl border border-[#e2ded5] shadow-md p-6 sm:p-8 space-y-6">
                <div class="border-b border-[#e2ded5]/60 pb-4">
                    <span class="text-xs text-[#8c6d3b] uppercase tracking-wider block font-bold">Standard Rate</span>
                    <div class="flex items-baseline space-x-1">
                        <span class="text-3xl font-serif font-bold text-[#161513]">${{ number_format($roomType->base_price, 2) }}</span>
                        <span class="text-xs text-[#39393b]">/ night</span>
                    </div>
                </div>

                <form action="{{ route('booking.create') }}" method="GET" class="space-y-4">
                    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">Check-in</label>
                        <input type="date" name="check_in" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-[#e2ded5] text-[#161513] text-sm font-medium focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">Check-out</label>
                        <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-[#e2ded5] text-[#161513] text-sm font-medium focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-sm hover:shadow-md transition">
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
