<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Admin dashboard with KPI metrics, room status summary, and daily operations.
     */
    public function index(): View
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Total and occupied rooms
        $totalRooms = Room::count();
        $occupiedRoomsCount = Room::where('status', 'occupied')->count();
        $availableRoomsCount = Room::where('status', 'available')->count();
        $cleaningRoomsCount = Room::where('status', 'cleaning')->count();
        $maintenanceRoomsCount = Room::where('status', 'maintenance')->count();

        // Occupancy rate
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRoomsCount / $totalRooms) * 100, 1) : 0;

        // Daily operations
        $todayArrivals = Reservation::with(['guest', 'room.roomType'])
            ->whereDate('check_in_date', $today)
            ->whereNotIn('status', ['cancelled', 'checked_out'])
            ->get();

        $todayDepartures = Reservation::with(['guest', 'room.roomType'])
            ->whereDate('check_out_date', $today)
            ->where('status', 'checked_in')
            ->get();

        // Revenue metrics
        $monthlyRevenue = (float) Payment::where('payment_status', 'paid')
            ->whereBetween('paid_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $todayRevenue = (float) Payment::where('payment_status', 'paid')
            ->whereDate('paid_at', $today)
            ->sum('amount');

        // Recent bookings
        $recentBookings = Reservation::with(['guest', 'room.roomType', 'payments'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'occupiedRoomsCount',
            'availableRoomsCount',
            'cleaningRoomsCount',
            'maintenanceRoomsCount',
            'occupancyRate',
            'todayArrivals',
            'todayDepartures',
            'monthlyRevenue',
            'todayRevenue',
            'recentBookings'
        ));
    }
}
