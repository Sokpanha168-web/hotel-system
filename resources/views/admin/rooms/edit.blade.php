@extends('layouts.admin')

@section('title', 'Edit Room ' . $room->room_number)
@section('header_title', 'Edit Room ' . $room->room_number)
@section('header_subtitle', 'Update details, pricing category, or room photo')

@section('content')
<div class="space-y-8 max-w-2xl mx-auto">
    <!-- Main Edit Card -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs">
        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Room Number -->
            <div>
                <label for="room_number" class="block text-sm font-bold text-slate-700 mb-2">Room Number</label>
                <input type="text" name="room_number" id="room_number" value="{{ old('room_number', $room->room_number) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('room_number') border-rose-500 ring-rose-200 @enderror">
                @error('room_number')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Room Type -->
            <div>
                <label for="room_type_id" class="block text-sm font-bold text-slate-700 mb-2">Room Type</label>
                <select name="room_type_id" id="room_type_id" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white @error('room_type_id') border-rose-500 ring-rose-200 @enderror">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} (${{ number_format($type->base_price, 2) }}/night • Max {{ $type->capacity }} Guests)
                        </option>
                    @endforeach
                </select>
                @error('room_type_id')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Floor -->
            <div>
                <label for="floor" class="block text-sm font-bold text-slate-700 mb-2">Floor</label>
                <input type="number" name="floor" id="floor" value="{{ old('floor', $room->floor) }}" required min="1" max="100"
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('floor') border-rose-500 ring-rose-200 @enderror">
                @error('floor')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                <select name="status" id="status" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white @error('status') border-rose-500 ring-rose-200 @enderror">
                    <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="cleaning" {{ old('status', $room->status) === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                    <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image & Upload -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-4">
                <label class="block text-sm font-bold text-slate-700">Room Photo</label>

                @if($room->image)
                    <div class="flex items-center space-x-4">
                        <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 border border-slate-300 flex-shrink-0">
                            <img src="{{ $room->image_url }}" alt="Room {{ $room->room_number }}" class="w-full h-full object-cover">
                        </div>
                        <div class="space-y-2 text-xs">
                            <p class="text-slate-600 font-medium">Current image attached to this room.</p>
                            <label class="inline-flex items-center space-x-2 text-rose-600 cursor-pointer font-bold">
                                <input type="checkbox" name="remove_image" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                <span>Remove current image</span>
                            </label>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-slate-500">No custom photo attached yet. The room currently uses the category default image.</p>
                @endif

                <div>
                    <label for="image" class="block text-xs font-semibold text-slate-600 mb-1.5">
                        {{ $room->image ? 'Replace photo with new file:' : 'Upload a room photo:' }}
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white file:mr-4 file:py-1.5 file:px-3.5 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 @error('image') border-rose-500 ring-rose-200 @enderror">
                    @error('image')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <a href="{{ route('admin.rooms.grid') }}" class="px-5 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone Card: Delete Room -->
    <div class="bg-rose-50/60 rounded-2xl p-6 border border-rose-200">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-base font-bold text-rose-900 mb-1">Delete Room</h3>
                <p class="text-xs text-rose-700 max-w-md">
                    Permanently remove Room {{ $room->room_number }} from your fleet and database. This action cannot be undone. Rooms with active guests or upcoming reservations cannot be deleted.
                </p>
            </div>
            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST"
                  onsubmit="return confirm('Are you completely sure you want to permanently delete Room {{ $room->room_number }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Delete Room</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
