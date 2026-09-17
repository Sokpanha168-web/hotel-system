@extends('layouts.admin')

@section('title', 'Room Status Grid')
@section('header_title', 'Visual Room Fleet Grid')
@section('header_subtitle', 'Real-time room occupancy, housekeeping, and maintenance status')

@section('content')
<div class="space-y-8" x-data="{
    activeModal: false,
    selectedRoom: null,
    openStatusModal(room) {
        this.selectedRoom = room;
        this.activeModal = true;
    }
}">

    <!-- Filter & Legend Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <!-- Floor Filter Tabs and Actions -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.rooms.create') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs transition flex items-center mr-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Room
            </a>
            
            <a href="{{ route('admin.rooms.grid') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ empty($selectedFloor) ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Floors ({{ $statusCounts['total'] }})
            </a>
            @foreach($floors as $floor)
                <a href="{{ route('admin.rooms.grid', ['floor' => $floor]) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ (string)$selectedFloor === (string)$floor ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Floor {{ $floor }}
                </a>
            @endforeach
        </div>

        <!-- High-contrast Color Code Legend -->
        <div class="flex flex-wrap items-center gap-4 text-xs font-bold">
            <span class="flex items-center space-x-1.5 text-emerald-700">
                <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-xs"></span>
                <span>Available ({{ $statusCounts['available'] }})</span>
            </span>
            <span class="flex items-center space-x-1.5 text-rose-700">
                <span class="w-3 h-3 rounded-full bg-rose-500 shadow-xs"></span>
                <span>Occupied ({{ $statusCounts['occupied'] }})</span>
            </span>
            <span class="flex items-center space-x-1.5 text-amber-700">
                <span class="w-3 h-3 rounded-full bg-amber-500 shadow-xs"></span>
                <span>Cleaning ({{ $statusCounts['cleaning'] }})</span>
            </span>
            <span class="flex items-center space-x-1.5 text-slate-600">
                <span class="w-3 h-3 rounded-full bg-slate-400 shadow-xs"></span>
                <span>Maintenance ({{ $statusCounts['maintenance'] }})</span>
            </span>
        </div>
    </div>

    <!-- Visual Grid of Room Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
        @forelse($rooms as $room)
            @php
                $activeRes = $room->reservations->first();
                $cardClasses = match($room->status) {
                    'available' => 'bg-emerald-50/70 border-emerald-300 text-emerald-950 shadow-emerald-900/5',
                    'occupied' => 'bg-rose-50/70 border-rose-300 text-rose-950 shadow-rose-900/5',
                    'cleaning' => 'bg-amber-50/70 border-amber-300 text-amber-950 shadow-amber-900/5',
                    'maintenance' => 'bg-slate-100 border-slate-300 text-slate-800 shadow-slate-900/5',
                    default => 'bg-white border-slate-200 text-slate-900',
                };
                $badgeClasses = match($room->status) {
                    'available' => 'bg-emerald-600 text-white',
                    'occupied' => 'bg-rose-600 text-white',
                    'cleaning' => 'bg-amber-600 text-white',
                    'maintenance' => 'bg-slate-500 text-white',
                    default => 'bg-slate-400 text-white',
                };
            @endphp

            <div class="rounded-2xl border-2 p-5 flex flex-col justify-between transition duration-200 hover:shadow-lg relative group {{ $cardClasses }}">
                <div>
                    <!-- Header: Room Number & Status Badge -->
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-slate-500 font-bold block">Floor {{ $room->floor }}</span>
                            <span class="text-2xl font-mono font-bold">Room {{ $room->room_number }}</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider shadow-xs {{ $badgeClasses }}">
                            {{ $room->status }}
                        </span>
                    </div>

                    <!-- Room Image if exists -->
                    @if($room->image)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}" class="w-full h-32 object-cover rounded-xl border border-slate-200 shadow-sm">
                        </div>
                    @endif

                    <!-- Room Type & Rate -->
                    <div class="text-xs font-medium text-slate-600 mb-3">
                        <span class="font-bold text-slate-900">{{ $room->roomType->name }}</span>
                        <span class="block text-[11px] text-slate-500">${{ number_format($room->roomType->base_price, 2) }}/night • Max {{ $room->roomType->capacity }} guests</span>
                    </div>

                    <!-- Occupant Details if Occupied -->
                    @if($room->status === 'occupied' && $activeRes)
                        <div class="mt-3 p-2.5 rounded-xl bg-white/80 border border-rose-200 text-xs">
                            <span class="text-[10px] uppercase tracking-wider text-rose-700 font-bold block">Current Guest</span>
                            <span class="font-bold text-slate-900 block truncate">{{ $activeRes->guest->full_name }}</span>
                            <span class="text-[11px] text-slate-500 block">Out: {{ \Carbon\Carbon::parse($activeRes->check_out_date)->format('M d') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Footer Action Buttons -->
                <div class="mt-4 pt-3 border-t border-black/5 space-y-2">
                    <!-- Management Actions Grid -->
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" 
                                @click="openStatusModal({{ Js::from($room) }})"
                                class="w-full text-xs font-bold text-slate-700 hover:text-slate-900 py-1.5 px-2 rounded-lg bg-white/90 border border-slate-300 hover:bg-white shadow-2xs transition flex items-center justify-center space-x-1">
                            <svg class="w-3.5 h-3.5 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Status</span>
                        </button>

                        <a href="{{ route('admin.rooms.edit', $room->id) }}" 
                           class="w-full text-xs font-bold text-slate-700 hover:text-amber-800 py-1.5 px-2 rounded-lg bg-white/90 border border-slate-300 hover:bg-white shadow-2xs transition flex items-center justify-center space-x-1">
                            <svg class="w-3.5 h-3.5 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                        </a>
                    </div>

                    <!-- Contextual Booking / Dossier Link -->
                    @if($room->status === 'available')
                        <a href="{{ route('booking.create', ['room_id' => $room->id, 'room_type_id' => $room->room_type_id]) }}" 
                           class="block w-full text-center py-1.5 px-2 rounded-lg text-xs font-bold text-emerald-800 bg-emerald-100/60 hover:bg-emerald-100 border border-emerald-300/80 transition">
                            Book Room &rarr;
                        </a>
                    @elseif($room->status === 'occupied' && $activeRes)
                        <a href="{{ route('admin.reservations.show', $activeRes->id) }}" 
                           class="block w-full text-center py-1.5 px-2 rounded-lg text-xs font-bold text-rose-800 bg-rose-100/60 hover:bg-rose-100 border border-rose-300/80 transition">
                            View Dossier &rarr;
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                <p class="text-slate-500 text-sm">No rooms found for the selected filter.</p>
            </div>
        @endforelse
    </div>

    <!-- Quick Status Change Modal -->
    <div x-show="activeModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="activeModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Update Room Status</h3>
                    <p class="text-xs text-slate-500" x-text="'Room ' + (selectedRoom ? selectedRoom.room_number : '') + ' (Floor ' + (selectedRoom ? selectedRoom.floor : '') + ')'"></p>
                </div>
                <button @click="activeModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="'/admin/rooms/' + (selectedRoom ? selectedRoom.id : '') + '/status'" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Select New Status</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 cursor-pointer hover:bg-emerald-100/50 transition flex items-center space-x-2.5">
                            <input type="radio" name="status" value="available" :checked="selectedRoom && selectedRoom.status === 'available'" class="text-emerald-600">
                            <span class="text-xs font-bold text-emerald-900">Available</span>
                        </label>

                        <label class="p-3 rounded-xl border border-rose-200 bg-rose-50/50 cursor-pointer hover:bg-rose-100/50 transition flex items-center space-x-2.5">
                            <input type="radio" name="status" value="occupied" :checked="selectedRoom && selectedRoom.status === 'occupied'" class="text-rose-600">
                            <span class="text-xs font-bold text-rose-900">Occupied</span>
                        </label>

                        <label class="p-3 rounded-xl border border-amber-200 bg-amber-50/50 cursor-pointer hover:bg-amber-100/50 transition flex items-center space-x-2.5">
                            <input type="radio" name="status" value="cleaning" :checked="selectedRoom && selectedRoom.status === 'cleaning'" class="text-amber-600">
                            <span class="text-xs font-bold text-amber-900">Cleaning</span>
                        </label>

                        <label class="p-3 rounded-xl border border-slate-300 bg-slate-100 cursor-pointer hover:bg-slate-200 transition flex items-center space-x-2.5">
                            <input type="radio" name="status" value="maintenance" :checked="selectedRoom && selectedRoom.status === 'maintenance'" class="text-slate-700">
                            <span class="text-xs font-bold text-slate-800">Maintenance</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <button type="button" @click="activeModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition">
                        Save Status
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
