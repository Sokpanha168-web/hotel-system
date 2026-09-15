<?php

namespace Tests\Unit;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BookingService $service;
    protected RoomType $roomType;
    protected Room $room101;
    protected Room $room102;
    protected Service $breakfastService;
    protected Service $laundryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new BookingService();

        $this->roomType = RoomType::create([
            'name' => 'Deluxe Suite',
            'slug' => 'deluxe-suite',
            'description' => 'Test suite',
            'base_price' => 50.00,
            'capacity' => 2,
            'amenities' => ['Wi-Fi', 'AC'],
        ]);

        $this->room101 = Room::create([
            'room_number' => '101',
            'room_type_id' => $this->roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);

        $this->room102 = Room::create([
            'room_number' => '102',
            'room_type_id' => $this->roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);

        $this->breakfastService = Service::create([
            'name' => 'Breakfast',
            'price' => 10.00,
            'unit' => 'per_day',
        ]);

        $this->laundryService = Service::create([
            'name' => 'Laundry',
            'price' => 5.00,
            'unit' => 'per_item',
        ]);
    }

    public function test_check_availability_detects_overlaps_correctly(): void
    {
        $guest = Guest::create([
            'full_name' => 'Alice Test',
            'phone' => '123456789',
            'national_id_or_passport' => 'P12345',
        ]);

        // Existing booking on room 101: 2026-10-10 to 2026-10-15
        Reservation::create([
            'booking_code' => 'GH-EXISTING-1',
            'guest_id' => $guest->id,
            'room_id' => $this->room101->id,
            'check_in_date' => '2026-10-10',
            'check_out_date' => '2026-10-15',
            'total_nights' => 5,
            'total_amount' => 250.00,
            'status' => 'confirmed',
        ]);

        // Overlapping request: 2026-10-12 to 2026-10-14 -> Room 101 must be unavailable, Room 102 available
        $available = $this->service->checkAvailability($this->roomType->id, '2026-10-12', '2026-10-14');
        $this->assertCount(1, $available);
        $this->assertEquals('102', $available->first()->room_number);

        // Non-overlapping request before: 2026-10-05 to 2026-10-10 (checkout is existing checkin) -> both available
        $availableBefore = $this->service->checkAvailability($this->roomType->id, '2026-10-05', '2026-10-10');
        $this->assertCount(2, $availableBefore);

        // Non-overlapping request after: 2026-10-15 to 2026-10-20 (checkin is existing checkout) -> both available
        $availableAfter = $this->service->checkAvailability($this->roomType->id, '2026-10-15', '2026-10-20');
        $this->assertCount(2, $availableAfter);
    }

    public function test_cancelled_reservations_do_not_block_availability(): void
    {
        $guest = Guest::create([
            'full_name' => 'Bob Cancel',
            'phone' => '987654321',
            'national_id_or_passport' => 'P98765',
        ]);

        Reservation::create([
            'booking_code' => 'GH-CANCELLED',
            'guest_id' => $guest->id,
            'room_id' => $this->room101->id,
            'check_in_date' => '2026-10-10',
            'check_out_date' => '2026-10-15',
            'total_nights' => 5,
            'total_amount' => 250.00,
            'status' => 'cancelled',
        ]);

        $available = $this->service->checkAvailability($this->roomType->id, '2026-10-10', '2026-10-15');
        $this->assertCount(2, $available);
    }

    public function test_calculate_total_computes_nights_and_services_accurately(): void
    {
        $services = [
            ['id' => $this->breakfastService->id, 'quantity' => 2], // 2 * $10 = $20
            ['id' => $this->laundryService->id, 'quantity' => 3],   // 3 * $5 = $15
        ];

        // 3 nights * $50 = $150 room total + $35 services = $185
        $calculation = $this->service->calculateTotal($this->roomType->id, '2026-11-01', '2026-11-04', $services);

        $this->assertEquals(3, $calculation['nights']);
        $this->assertEquals(50.00, $calculation['base_price']);
        $this->assertEquals(150.00, $calculation['room_total']);
        $this->assertEquals(35.00, $calculation['services_total']);
        $this->assertEquals(185.00, $calculation['grand_total']);
    }

    public function test_create_booking_creates_reservation_and_services(): void
    {
        $data = [
            'full_name' => 'David Warner',
            'phone' => '+855 77 112 233',
            'email' => 'david@example.com',
            'national_id_or_passport' => 'AU-112233',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => '2026-12-01',
            'check_out_date' => '2026-12-03',
            'services' => [
                ['id' => $this->breakfastService->id, 'quantity' => 2],
            ],
            'status' => 'confirmed',
        ];

        $reservation = $this->service->createBooking($data);

        $this->assertNotNull($reservation->id);
        $this->assertStringStartsWith('GH-', $reservation->booking_code);
        $this->assertEquals(2, $reservation->total_nights);
        // 2 nights * $50 = $100 + $20 breakfast = $120
        $this->assertEquals(120.00, (float) $reservation->total_amount);
        $this->assertEquals('David Warner', $reservation->guest->full_name);
        $this->assertCount(1, $reservation->reservationServices);
    }

    public function test_create_booking_throws_exception_when_no_rooms_available(): void
    {
        $guest = Guest::create([
            'full_name' => 'Existing Guest',
            'phone' => '00000000',
            'national_id_or_passport' => 'P00000',
        ]);

        // Occupy both room 101 and 102
        Reservation::create([
            'booking_code' => 'GH-FULL-1',
            'guest_id' => $guest->id,
            'room_id' => $this->room101->id,
            'check_in_date' => '2026-12-10',
            'check_out_date' => '2026-12-15',
            'total_nights' => 5,
            'total_amount' => 250.00,
            'status' => 'confirmed',
        ]);

        Reservation::create([
            'booking_code' => 'GH-FULL-2',
            'guest_id' => $guest->id,
            'room_id' => $this->room102->id,
            'check_in_date' => '2026-12-10',
            'check_out_date' => '2026-12-15',
            'total_nights' => 5,
            'total_amount' => 250.00,
            'status' => 'confirmed',
        ]);

        $this->expectException(ValidationException::class);

        $this->service->createBooking([
            'full_name' => 'Unlucky Guest',
            'phone' => '11111111',
            'national_id_or_passport' => 'P11111',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => '2026-12-12',
            'check_out_date' => '2026-12-14',
        ]);
    }

    public function test_check_in_and_check_out_workflow_with_payment(): void
    {
        $guest = Guest::create([
            'full_name' => 'Sarah Connor',
            'phone' => '5551234',
            'national_id_or_passport' => 'T800',
        ]);

        $reservation = Reservation::create([
            'booking_code' => 'GH-WORKFLOW',
            'guest_id' => $guest->id,
            'room_id' => $this->room101->id,
            'check_in_date' => '2026-10-01',
            'check_out_date' => '2026-10-03',
            'total_nights' => 2,
            'total_amount' => 100.00,
            'status' => 'confirmed',
        ]);

        // Check In
        $this->service->checkInReservation($reservation);
        $reservation->refresh();
        $this->assertEquals('checked_in', $reservation->status);
        $this->assertEquals('occupied', $reservation->room->status);

        // Add service
        $this->service->addServiceToReservation($reservation, $this->laundryService->id, 2); // 2 * $5 = $10
        $reservation->refresh();
        $this->assertEquals(110.00, (float) $reservation->total_amount);
        $this->assertEquals(110.00, $reservation->balance_due);

        // Check Out with cash settlement
        $payment = $this->service->checkOutReservation($reservation, 'cash', 'CASH-SETTLE-001');
        $reservation->refresh();

        $this->assertEquals('checked_out', $reservation->status);
        $this->assertEquals('cleaning', $reservation->room->status);
        $this->assertNotNull($payment);
        $this->assertEquals(110.00, (float) $payment->amount);
        $this->assertTrue($reservation->is_fully_paid);
    }
}
