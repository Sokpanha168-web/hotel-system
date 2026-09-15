<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestBookingFlowTest extends TestCase
{
    use RefreshDatabase;

    protected RoomType $roomType;
    protected Room $room;
    protected Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->roomType = RoomType::create([
            'name' => 'Deluxe Garden Room',
            'slug' => 'deluxe-garden-room',
            'description' => 'A wonderful garden view room.',
            'base_price' => 60.00,
            'capacity' => 2,
            'amenities' => ['Wi-Fi', 'Air Conditioning'],
        ]);

        $this->room = Room::create([
            'room_number' => '101',
            'room_type_id' => $this->roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);

        $this->service = Service::create([
            'name' => 'Airport Transfer',
            'price' => 15.00,
            'unit' => 'per_trip',
        ]);
    }

    public function test_guest_can_view_landing_page(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Serenity Villa');
        $response->assertSee('Deluxe Garden Room');
    }

    public function test_guest_can_view_rooms_list(): void
    {
        $response = $this->get(route('rooms.index', [
            'check_in' => Carbon::today()->toDateString(),
            'check_out' => Carbon::tomorrow()->toDateString(),
        ]));

        $response->assertStatus(200);
        $response->assertSee('Deluxe Garden Room');
        $response->assertSee('1 Room Available');
    }

    public function test_guest_can_view_room_type_details(): void
    {
        $response = $this->get(route('rooms.show', $this->roomType->slug));

        $response->assertStatus(200);
        $response->assertSee('Deluxe Garden Room');
        $response->assertSee('$60.00');
    }

    public function test_guest_can_place_a_booking(): void
    {
        $response = $this->post(route('booking.store'), [
            'full_name' => 'Emily Watson',
            'phone' => '+855 12 998 877',
            'email' => 'emily@example.com',
            'national_id_or_passport' => 'GB-9988776',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => Carbon::today()->toDateString(),
            'check_out_date' => Carbon::tomorrow()->toDateString(),
            'payment_method' => 'khqr_transfer',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('guests', [
            'full_name' => 'Emily Watson',
            'phone' => '+855 12 998 877',
        ]);

        $this->assertDatabaseHas('reservations', [
            'room_id' => $this->room->id,
            'total_nights' => 1,
            'total_amount' => 60.00,
        ]);
    }

    public function test_guest_can_view_confirmation_and_simulate_khqr_payment(): void
    {
        // First book
        $this->post(route('booking.store'), [
            'full_name' => 'Marcus Aurelius',
            'phone' => '+855 11 223 344',
            'email' => 'marcus@example.com',
            'national_id_or_passport' => 'RO-112233',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => Carbon::today()->toDateString(),
            'check_out_date' => Carbon::tomorrow()->toDateString(),
            'payment_method' => 'khqr_transfer',
        ]);

        $reservation = \App\Models\Reservation::first();
        $this->assertNotNull($reservation);

        // View confirmation page
        $response = $this->get(route('booking.confirmation', $reservation->booking_code));
        $response->assertStatus(200);
        $response->assertSee($reservation->booking_code);
        $response->assertSee('KHQR');

        // Simulate KHQR payment
        $payResponse = $this->post(route('booking.simulate_payment', $reservation->booking_code));
        $payResponse->assertRedirect(route('booking.confirmation', $reservation->booking_code));

        $reservation->refresh();
        $this->assertTrue($reservation->is_fully_paid);
        $this->assertEquals('confirmed', $reservation->status);
    }
}
