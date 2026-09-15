<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Display a listing of reservations with search and status filters.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Reservation::with(['guest', 'room.roomType', 'payments']);

        if ($status && in_array($status, ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'], true)) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('guest', function ($g) use ($search) {
                        $g->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('national_id_or_passport', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($r) use ($search) {
                        $r->where('room_number', 'like', "%{$search}%");
                    });
            });
        }

        $reservations = $query->latest()->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'checked_in' => Reservation::where('status', 'checked_in')->count(),
            'checked_out' => Reservation::where('status', 'checked_out')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        return view('admin.reservations.index', compact('reservations', 'status', 'search', 'statusCounts'));
    }

    /**
     * Show reservation details.
     */
    public function show(int $id): View
    {
        $reservation = Reservation::with([
            'guest',
            'room.roomType',
            'reservationServices.service',
            'payments',
        ])->findOrFail($id);

        $availableServices = Service::all();

        return view('admin.reservations.show', compact('reservation', 'availableServices'));
    }

    /**
     * Switch reservation status to checked_in and room to occupied.
     */
    public function checkIn(int $id): RedirectResponse
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        if ($reservation->status === 'checked_in') {
            return back()->with('info', 'This reservation is already checked in.');
        }

        if ($reservation->status === 'checked_out' || $reservation->status === 'cancelled') {
            return back()->with('error', "Cannot check in a {$reservation->status} reservation.");
        }

        $this->bookingService->checkInReservation($reservation);

        return back()->with('success', "Guest {$reservation->guest->full_name} successfully checked into Room {$reservation->room->room_number}.");
    }

    /**
     * Add extra services (laundry, drinks, breakfast) to the active booking.
     */
    public function addService(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'cancelled' || $reservation->status === 'checked_out') {
            return back()->with('error', 'Cannot add services to a completed or cancelled reservation.');
        }

        $this->bookingService->addServiceToReservation(
            $reservation,
            (int) $request->service_id,
            (int) $request->quantity
        );

        return back()->with('success', 'Extra service added and reservation total updated successfully.');
    }

    /**
     * Calculate final balance, record payment in payments table, set room to cleaning, and redirect to invoice.
     */
    public function checkOut(Request $request, int $id): RedirectResponse
    {
        $reservation = Reservation::with(['room', 'payments'])->findOrFail($id);

        if ($reservation->status === 'checked_out') {
            return redirect()->route('admin.reservations.invoice', $reservation->id)
                ->with('info', 'This reservation is already checked out.');
        }

        $request->validate([
            'payment_method' => ['required', 'string', 'in:cash,card,khqr_transfer'],
            'transaction_ref' => ['nullable', 'string', 'max:100'],
        ]);

        $this->bookingService->checkOutReservation(
            $reservation,
            $request->payment_method,
            $request->transaction_ref
        );

        return redirect()->route('admin.reservations.invoice', $reservation->id)
            ->with('success', "Check-out completed for Room {$reservation->room->room_number}. Room marked for cleaning and payment recorded.");
    }

    /**
     * Generate printable invoice Blade view formatted cleanly for POS receipt or A4 printing.
     */
    public function invoice(int $id): View
    {
        $reservation = Reservation::with([
            'guest',
            'room.roomType',
            'reservationServices.service',
            'payments',
        ])->findOrFail($id);

        return view('invoices.print', compact('reservation'));
    }
}
