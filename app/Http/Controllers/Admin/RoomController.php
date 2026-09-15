<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

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
