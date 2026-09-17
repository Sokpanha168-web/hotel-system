@extends('layouts.admin')

@section('title', 'Add New Room')
@section('header_title', 'Add New Room')
@section('header_subtitle', 'Create a new room in the system')

@section('content')
<div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs max-w-2xl mx-auto">
    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="room_number" class="block text-sm font-bold text-slate-700 mb-2">Room Number</label>
            <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('room_number') border-rose-500 ring-rose-200 @enderror">
            @error('room_number')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="room_type_id" class="block text-sm font-bold text-slate-700 mb-2">Room Type</label>
            <select name="room_type_id" id="room_type_id" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white @error('room_type_id') border-rose-500 ring-rose-200 @enderror">
                <option value="" disabled selected>Select a room type...</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }} (${{ number_format($type->base_price, 2) }}/night)
                    </option>
                @endforeach
            </select>
            @error('room_type_id')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="floor" class="block text-sm font-bold text-slate-700 mb-2">Floor</label>
            <input type="number" name="floor" id="floor" value="{{ old('floor') }}" required min="1" max="100"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('floor') border-rose-500 ring-rose-200 @enderror">
            @error('floor')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Initial Status</label>
            <select name="status" id="status" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white @error('status') border-rose-500 ring-rose-200 @enderror">
                <option value="available" {{ old('status', 'available') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="cleaning" {{ old('status') === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            @error('status')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="image" class="block text-sm font-bold text-slate-700 mb-2">Room Image (Optional)</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 @error('image') border-rose-500 ring-rose-200 @enderror">
            @error('image')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.rooms.grid') }}" class="px-5 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition">
                Create Room
            </button>
        </div>
    </form>
</div>
@endsection
