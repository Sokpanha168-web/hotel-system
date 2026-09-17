<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingService
{

    /**
     * Check room availability for a given room type and date range.
     * Non-overlapping condition: check_in_date < $requestedCheckOut AND check_out_date > $requestedCheckIn
     *
     * @param int $roomTypeId
     * @param string $checkIn
     * @param string $checkOut
     * @param int|null $excludeReservationId
     * @return Collection
     */
    public function checkAvailability(int $roomTypeId, string $checkIn, string $checkOut, ?int $excludeReservationId = null): Collection
    {
        return Room::where('room_type_id', $roomTypeId)
            ->where('status', '!=', 'maintenance')
            ->whereDoesntHave('reservations', function ($query) use ($checkIn, $checkOut, $excludeReservationId) {
                $query->where('status', '!=', 'cancelled')
                    ->whereDate('check_in_date', '<', $checkOut)
                    ->whereDate('check_out_date', '>', $checkIn);

                if ($excludeReservationId) {
                    $query->where('id', '!=', $excludeReservationId);
                }
            })
            ->get();
    }

    /**
     * Find an available room and lock candidate records to prevent race conditions.
     *
     * @param int $roomTypeId
     * @param string $checkIn
     * @param string $checkOut
     * @param int|null $excludeReservationId
     * @return Room|null
     */
    public function findAvailableRoomWithLock(int $roomTypeId, string $checkIn, string $checkOut, ?int $excludeReservationId = null): ?Room
    {
        return Room::where('room_type_id', $roomTypeId)
            ->where('status', '!=', 'maintenance')
            ->whereDoesntHave('reservations', function ($query) use ($checkIn, $checkOut, $excludeReservationId) {
                $query->where('status', '!=', 'cancelled')
                    ->whereDate('check_in_date', '<', $checkOut)
                    ->whereDate('check_out_date', '>', $checkIn);

                if ($excludeReservationId) {
                    $query->where('id', '!=', $excludeReservationId);
                }
            })
            ->lockForUpdate()
            ->first();
    }

    /**
     * Compute stay nights, room total, and add-on services.
     *
     * @param int $roomTypeId
     * @param string $checkIn
     * @param string $checkOut
     * @param array $serviceItems Array of ['id' => int, 'quantity' => int] or key-value [service_id => qty]
     * @return array
     */
    public function calculateTotal(int $roomTypeId, string $checkIn, string $checkOut, array $serviceItems = []): array
    {
        $roomType = RoomType::findOrFail($roomTypeId);
        $startDate = Carbon::parse($checkIn)->startOfDay();
        $endDate = Carbon::parse($checkOut)->startOfDay();

        $nights = $startDate->diffInDays($endDate);
        if ($nights <= 0) {
            $nights = 1;
        }

        $basePrice = (float) $roomType->base_price;
        $roomTotal = round($basePrice * $nights, 2);

        $servicesTotal = 0.00;
        $servicesBreakdown = [];

        foreach ($serviceItems as $key => $item) {
            $serviceId = is_array($item) ? ($item['id'] ?? $item['service_id'] ?? null) : $key;
            $quantity = is_array($item) ? (int) ($item['quantity'] ?? 1) : (int) $item;

            if ($serviceId && $quantity > 0) {
                $service = Service::find($serviceId);
                if ($service) {
                    $unitPrice = (float) $service->price;
                    $lineTotal = round($unitPrice * $quantity, 2);
                    $servicesTotal += $lineTotal;

                    $servicesBreakdown[] = [
                        'service_id' => $service->id,
                        'name' => $service->name,
                        'unit' => $service->unit,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $lineTotal,
                    ];
                }
            }
        }

        $grandTotal = round($roomTotal + $servicesTotal, 2);

        return [
            'nights' => $nights,
            'base_price' => $basePrice,
            'room_total' => $roomTotal,
            'services_total' => round($servicesTotal, 2),
            'services' => $servicesBreakdown,
            'grand_total' => $grandTotal,
        ];
    }

    /**
     * Create a new reservation with double-booking prevention and row-level locking.
     *
     * @param array $data
     * @return Reservation
     * @throws ValidationException
     */
    public function createBooking(array $data): Reservation
    {
        return DB::transaction(function () use ($data) {
            $roomTypeId = (int) $data['room_type_id'];
            $checkIn = Carbon::parse($data['check_in_date'])->toDateString();
            $checkOut = Carbon::parse($data['check_out_date'])->toDateString();

            // Lock candidate rooms to prevent concurrency conflict
            $room = null;
            if (!empty($data['room_id'])) {
                // If a specific room was requested, verify its availability and lock it
                $room = Room::where('id', $data['room_id'])
                    ->where('status', '!=', 'maintenance')
                    ->whereDoesntHave('reservations', function ($query) use ($checkIn, $checkOut) {
                        $query->where('status', '!=', 'cancelled')
                            ->whereDate('check_in_date', '<', $checkOut)
                            ->whereDate('check_out_date', '>', $checkIn);
                    })
                    ->lockForUpdate()
                    ->first();
            }

            if (!$room) {
                $room = $this->findAvailableRoomWithLock($roomTypeId, $checkIn, $checkOut);
            }

            if (!$room) {
                throw ValidationException::withMessages([
                    'room_type_id' => 'No rooms are available for the selected room type and dates. Please select other dates or room types.',
                ]);
            }

            // Find or create Guest
            $guest = Guest::firstOrNew(['phone' => $data['phone']]);
            $guest->full_name = $data['full_name'];
            if (!empty($data['email'])) {
                $guest->email = $data['email'];
            }
            $guest->national_id_or_passport = $data['national_id_or_passport'];
            $guest->save();

            // Calculate stay totals
            $serviceItems = $data['services'] ?? [];
            $calculation = $this->calculateTotal($roomTypeId, $checkIn, $checkOut, $serviceItems);

            // Generate unique booking code
            do {
                $code = 'GH-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
            } while (Reservation::where('booking_code', $code)->exists());

            // Create Reservation
            $reservation = Reservation::create([
                'booking_code' => $code,
                'guest_id' => $guest->id,
                'room_id' => $room->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'total_nights' => $calculation['nights'],
                'total_amount' => $calculation['grand_total'],
                'status' => $data['status'] ?? 'confirmed',
            ]);

            // Save reservation services
            foreach ($calculation['services'] as $svc) {
                ReservationService::create([
                    'reservation_id' => $reservation->id,
                    'service_id' => $svc['service_id'],
                    'quantity' => $svc['quantity'],
                    'unit_price' => $svc['unit_price'],
                    'total_price' => $svc['total_price'],
                ]);
            }

            // If initial payment was made
            if (!empty($data['payment_amount']) && (float) $data['payment_amount'] > 0) {
                Payment::create([
                    'reservation_id' => $reservation->id,
                    'amount' => (float) $data['payment_amount'],
                    'payment_method' => $data['payment_method'] ?? 'cash',
                    'payment_status' => 'paid',
                    'transaction_ref' => $data['transaction_ref'] ?? null,
                    'paid_at' => now(),
                ]);
            }

            return $reservation->load(['guest', 'room.roomType', 'reservationServices.service', 'payments']);
        });
    }

    /**
     * Add extra service to an existing reservation and recalculate total.
     *
     * @param Reservation $reservation
     * @param int $serviceId
     * @param int $quantity
     * @return ReservationService
     */
    public function addServiceToReservation(Reservation $reservation, int $serviceId, int $quantity = 1): ReservationService
    {
        return DB::transaction(function () use ($reservation, $serviceId, $quantity) {
            $service = Service::findOrFail($serviceId);
            $unitPrice = (float) $service->price;
            $lineTotal = round($unitPrice * $quantity, 2);

            $resService = ReservationService::create([
                'reservation_id' => $reservation->id,
                'service_id' => $service->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $lineTotal,
            ]);

            $reservation->increment('total_amount', $lineTotal);

            return $resService;
        });
    }

    /**
     * Check in reservation and mark room occupied.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function checkInReservation(Reservation $reservation): void
    {
        DB::transaction(function () use ($reservation) {
            $reservation->update(['status' => 'checked_in']);
            $reservation->room->update(['status' => 'occupied']);
        });
    }

    /**
     * Check out reservation, settle remaining balance into payments, set room to cleaning.
     *
     * @param Reservation $reservation
     * @param string $paymentMethod
     * @param string|null $txRef
     * @return Payment|null
     */
    public function checkOutReservation(Reservation $reservation, string $paymentMethod = 'cash', ?string $txRef = null): ?Payment
    {
        return DB::transaction(function () use ($reservation, $paymentMethod, $txRef) {
            $balanceDue = $reservation->balance_due;
            $payment = null;

            if ($balanceDue > 0) {
                $payment = Payment::create([
                    'reservation_id' => $reservation->id,
                    'amount' => $balanceDue,
                    'payment_method' => $paymentMethod,
                    'payment_status' => 'paid',
                    'transaction_ref' => $txRef,
                    'paid_at' => now(),
                ]);
            }

            $reservation->update(['status' => 'checked_out']);
            $reservation->room->update(['status' => 'cleaning']);

            return $payment;
        });
    }

    /**
     * Update room status directly (e.g. from status grid).
     *
     * @param Room $room
     * @param string $status
     * @return void
     */
    public function updateRoomStatus(Room $room, string $status): void
    {
        if (!in_array($status, ['available', 'occupied', 'cleaning', 'maintenance'], true)) {
            throw new Exception("Invalid room status: {$status}");
        }

        $room->update(['status' => $status]);
    }
}
