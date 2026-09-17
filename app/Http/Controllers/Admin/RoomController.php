<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Show the form for creating a new room.
     */
    public function create(): View
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number|max:10',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer|min:1|max:100',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', // Allow image upload up to 10MB
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                \Log::error('Image upload failed: ' . $request->file('image')->getErrorMessage());
            }
            // Save the image to storage/app/public/rooms
            $path = $request->file('image')->store('rooms', 'public');
            $data['image'] = $path;
        }

        $room = Room::create($data);

        return redirect()->route('admin.rooms.grid')->with('success', "Room {$room->room_number} has been created successfully.");
    }

    /**
     * Show the form for editing an existing room.
     */
    public function edit(Room $room): View
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer|min:1|max:100',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        $data = $request->except(['image', 'remove_image']);

        // Check if user requested to remove existing image
        if ($request->boolean('remove_image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $data['image'] = null;
        }

        // Check if a new image was uploaded
        if ($request->hasFile('image')) {
            // Remove previous image from storage
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }

            $path = $request->file('image')->store('rooms', 'public');
            $data['image'] = $path;
        }

        $room->update($data);

        return redirect()->route('admin.rooms.grid')->with('success', "Room {$room->room_number} has been updated successfully.");
    }

    /**
     * Delete the specified room from storage.
     */
    public function destroy(Room $room): RedirectResponse
    {
        // Safety check: Cannot delete room if currently occupied or has active future bookings
        $hasActiveReservations = $room->reservations()
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->exists();

        if ($hasActiveReservations) {
            return back()->with('error', "Cannot delete Room {$room->room_number} because it has active or upcoming reservations.");
        }

        // Delete uploaded image file if present
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $roomNumber = $room->room_number;
        $room->delete();

        return redirect()->route('admin.rooms.grid')->with('success', "Room {$roomNumber} has been permanently deleted.");
    }

    /**
     * Visual board showing all rooms color-coded by status with floor filter.
     */
    public function statusGrid(Request $request): View
    {
        $selectedFloor = $request->query('floor');

        $query = Room::with(['roomType', 'reservations' => function ($q) {
            $q->where('status', 'checked_in')->with('guest');
        }]);

        if ($selectedFloor !== null && $selectedFloor !== '') {
            $query->where('floor', (int) $selectedFloor);
        }

        $rooms = $query->orderBy('floor')->orderBy('room_number')->get();

        $floors = Room::distinct()->orderBy('floor')->pluck('floor');

        // Status counts for badge summary
        $statusCounts = [
            'total' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'cleaning' => Room::where('status', 'cleaning')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        return view('admin.rooms.grid', compact('rooms', 'floors', 'selectedFloor', 'statusCounts'));
    }

    /**
     * Quick status toggle endpoint.
     */
    public function updateStatus(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:available,occupied,cleaning,maintenance',
        ]);

        $room = Room::findOrFail($id);
        $this->bookingService->updateRoomStatus($room, $request->status);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Room {$room->room_number} status updated to {$request->status}.",
                'room' => $room,
            ]);
        }

        return back()->with('success', "Room {$room->room_number} marked as " . ucfirst($request->status) . ".");
    }
}
