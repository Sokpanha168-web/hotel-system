<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Financial & Hospitality Reports with interactive Charts.
     */
    public function index(Request $request): View
    {
        // 1. Determine Date Range Filter
        $period = $request->query('period', 'this_month');
        $today = Carbon::today();

        switch ($period) {
            case 'today':
                $startDate = $today->copy()->startOfDay();
                $endDate = $today->copy()->endOfDay();
                break;
            case 'last_7_days':
                $startDate = $today->copy()->subDays(6)->startOfDay();
                $endDate = $today->copy()->endOfDay();
                break;
            case 'last_30_days':
                $startDate = $today->copy()->subDays(29)->startOfDay();
                $endDate = $today->copy()->endOfDay();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->query('start_date') ? Carbon::parse($request->query('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
                $endDate = $request->query('end_date') ? Carbon::parse($request->query('end_date'))->endOfDay() : Carbon::now()->endOfDay();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $period = 'this_month';
        }

        // 2. Core KPI Calculations
        $totalRooms = Room::count();
        $daysInPeriod = max(1, $startDate->diffInDays($endDate) + 1);

        // Payments in period
        $paidPaymentsQuery = Payment::where('payment_status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate]);

        $totalRevenue = (float) (clone $paidPaymentsQuery)->sum('amount');
        $totalTransactions = (clone $paidPaymentsQuery)->count();

        // Reservations in period
        $reservationsInPeriod = Reservation::where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('check_in_date', [$startDate->toDateString(), $endDate->toDateString()])
              ->orWhereBetween('check_out_date', [$startDate->toDateString(), $endDate->toDateString()]);
        })->get();

        $totalBookings = $reservationsInPeriod->count();
        $totalNightsSold = $reservationsInPeriod->whereNotIn('status', ['cancelled'])->sum('total_nights');

        // ADR (Average Daily Rate) & RevPAR
        $adr = $totalNightsSold > 0 ? round($totalRevenue / $totalNightsSold, 2) : 0;
        $totalAvailableRoomNights = $totalRooms * $daysInPeriod;
        $revPar = $totalAvailableRoomNights > 0 ? round($totalRevenue / $totalAvailableRoomNights, 2) : 0;
        $occupancyRate = $totalAvailableRoomNights > 0 ? min(100, round(($totalNightsSold / $totalAvailableRoomNights) * 100, 1)) : 0;

        // 3. Chart 1: Daily Revenue Trend (Last 14 days or in range)
        $chartDays = min(30, (int) $daysInPeriod);
        $revenueTrendLabels = [];
        $revenueTrendData = [];

        $trendCursor = $endDate->copy()->subDays($chartDays - 1)->startOfDay();
        while ($trendCursor->lte($endDate)) {
            $dateStr = $trendCursor->toDateString();
            $label = $trendCursor->format('M d');
            $dayRev = (float) Payment::where('payment_status', 'paid')
                ->whereDate('paid_at', $dateStr)
                ->sum('amount');

            $revenueTrendLabels[] = $label;
            $revenueTrendData[] = $dayRev;
            $trendCursor->addDay();
        }

        // 4. Chart 2: Payment Methods Breakdown
        $paymentMethodsData = [
            'KHQR Transfer' => (float) Payment::where('payment_status', 'paid')
                ->where('payment_method', 'khqr_transfer')
                ->whereBetween('paid_at', [$startDate, $endDate])
                ->sum('amount'),
            'Credit / Debit Card' => (float) Payment::where('payment_status', 'paid')
                ->where('payment_method', 'card')
                ->whereBetween('paid_at', [$startDate, $endDate])
                ->sum('amount'),
            'Cash at Desk' => (float) Payment::where('payment_status', 'paid')
                ->where('payment_method', 'cash')
                ->whereBetween('paid_at', [$startDate, $endDate])
                ->sum('amount'),
        ];

        // 5. Chart 3: Room Fleet Status
        $fleetStatus = [
            'Available' => Room::where('status', 'available')->count(),
            'Occupied' => Room::where('status', 'occupied')->count(),
            'Cleaning' => Room::where('status', 'cleaning')->count(),
            'Maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        // 6. Chart 4: Revenue & Bookings by Room Type
        $roomTypes = RoomType::all();
        $roomTypeLabels = [];
        $roomTypeRevenue = [];
        $roomTypeBookings = [];

        foreach ($roomTypes as $type) {
            $roomTypeLabels[] = $type->name;

            $roomIds = $type->rooms()->pluck('id');
            $typeRes = Reservation::whereIn('room_id', $roomIds)
                ->whereNotIn('status', ['cancelled'])
                ->whereBetween('check_in_date', [$startDate->toDateString(), $endDate->toDateString()]);

            $roomTypeBookings[] = (clone $typeRes)->count();
            $roomTypeRevenue[] = (float) (clone $typeRes)->sum('total_amount');
        }

        // 7. Chart 5: Reservation Status Distribution
        $reservationStatuses = [
            'Confirmed' => Reservation::where('status', 'confirmed')->count(),
            'Checked In' => Reservation::where('status', 'checked_in')->count(),
            'Checked Out' => Reservation::where('status', 'checked_out')->count(),
            'Cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        // 8. Detailed Transactions Report Table
        $recentTransactions = Payment::with(['reservation.guest', 'reservation.room.roomType'])
            ->where('payment_status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->latest('paid_at')
            ->take(50)
            ->get();

        return view('admin.reports.index', compact(
            'period',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalTransactions',
            'totalBookings',
            'totalNightsSold',
            'adr',
            'revPar',
            'occupancyRate',
            'totalRooms',
            'revenueTrendLabels',
            'revenueTrendData',
            'paymentMethodsData',
            'fleetStatus',
            'roomTypeLabels',
            'roomTypeRevenue',
            'roomTypeBookings',
            'reservationStatuses',
            'recentTransactions'
        ));
    }
}
