<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Public landing page with room showcase and search form.
     */
    public function index(): View
    {
        $roomTypes = RoomType::withCount('rooms')->get();
        $services = Service::all();
        $totalRooms = Room::count();

        return view('welcome', compact('roomTypes', 'services', 'totalRooms'));
    }

    /**
     * List filtered available rooms.
     */
    public function rooms(Request $request): View
    {
        $checkIn = $request->query('check_in', Carbon::today()->toDateString());
        $checkOut = $request->query('check_out', Carbon::tomorrow()->toDateString());
        $guests = (int) $request->query('guests', 1);

        $roomTypesQuery = RoomType::query();

        if ($guests > 1) {
            $roomTypesQuery->where('capacity', '>=', $guests);
        }

        $roomTypes = $roomTypesQuery->get()->map(function ($type) use ($checkIn, $checkOut) {
            $availableRooms = $this->bookingService->checkAvailability($type->id, $checkIn, $checkOut);
            $type->available_count = $availableRooms->count();
            $type->first_available_room = $availableRooms->first();
            return $type;
        });

        return view('rooms.index', compact('roomTypes', 'checkIn', 'checkOut', 'guests'));
    }

    /**
     * Room details and amenities.
     */
    public function showRoomType(RoomType $roomType): View
    {
        $roomType->load('rooms');
        $services = Service::all();

        return view('rooms.show', compact('roomType', 'services'));
    }

    /**
     * Booking form for a specific room or room type.
     */
    public function book(Request $request, ?Room $room = null): View
    {
        $selectedRoom = $room;
        $roomTypeId = $request->query('room_type_id', $room?->room_type_id);

        $selectedRoomType = $roomTypeId ? RoomType::find($roomTypeId) : null;
        if (!$selectedRoomType && $room) {
            $selectedRoomType = $room->roomType;
        }
        if (!$selectedRoomType) {
            $selectedRoomType = RoomType::first();
        }

        $allRoomTypes = RoomType::all();
        $services = Service::all();

        $checkIn = $request->query('check_in', Carbon::today()->toDateString());
        $checkOut = $request->query('check_out', Carbon::tomorrow()->toDateString());

        return view('booking.create', compact(
            'selectedRoom',
            'selectedRoomType',
            'allRoomTypes',
            'services',
            'checkIn',
            'checkOut'
        ));
    }

    /**
     * Calculate price breakdown dynamically for Alpine.js AJAX.
     */
    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'services' => 'nullable|array',
        ]);

        $calculation = $this->bookingService->calculateTotal(
            (int) $request->room_type_id,
            $request->check_in,
            $request->check_out,
            $request->services ?? []
        );

        $availableRooms = $this->bookingService->checkAvailability(
            (int) $request->room_type_id,
            $request->check_in,
            $request->check_out
        );

        $calculation['available_count'] = $availableRooms->count();

        return response()->json($calculation);
    }

    /**
     * Process booking form submission.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $reservation = $this->bookingService->createBooking($request->validated());

        return redirect()->route('booking.confirmation', ['code' => $reservation->booking_code])
            ->with('success', 'Your reservation was placed successfully! Please review the details and complete payment.');
    }

    /**
     * Confirmation page with QR payment placeholder and invoice preview.
     */
    public function confirmation(string $code): View
    {
        $reservation = Reservation::with(['guest', 'room.roomType', 'reservationServices.service', 'payments'])
            ->where('booking_code', $code)
            ->firstOrFail();

        return view('booking.confirmation', compact('reservation'));
    }

    /**
     * Simulate instant QR payment confirmation.
     */
    public function simulatePayment(Request $request, string $code): RedirectResponse
    {
        $reservation = Reservation::where('booking_code', $code)->firstOrFail();

        $balanceDue = $reservation->balance_due;
        if ($balanceDue > 0) {
            Payment::create([
                'reservation_id' => $reservation->id,
                'amount' => $balanceDue,
                'payment_method' => 'khqr_transfer',
                'payment_status' => 'paid',
                'transaction_ref' => 'KHQR-' . strtoupper(bin2hex(random_bytes(4))),
                'paid_at' => now(),
            ]);

            $reservation->update(['status' => 'confirmed']);
        }

        return redirect()->route('booking.confirmation', ['code' => $reservation->booking_code])
            ->with('success', 'Payment of $' . number_format($balanceDue, 2) . ' via KHQR confirmed successfully!');
    }
}
