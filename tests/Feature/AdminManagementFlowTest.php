<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminManagementFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected RoomType $roomType;
    protected Room $room;
    protected Guest $guest;
    protected Service $service;
    protected Reservation $reservation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Manager Admin',
            'email' => 'admin@guesthouse.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->roomType = RoomType::create([
            'name' => 'Standard Deluxe',
            'slug' => 'standard-deluxe',
            'base_price' => 50.00,
            'capacity' => 2,
        ]);

        $this->room = Room::create([
            'room_number' => '101',
            'room_type_id' => $this->roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);

        $this->guest = Guest::create([
            'full_name' => 'John Doe',
            'phone' => '+855 12 345 678',
            'email' => 'john@example.com',
            'national_id_or_passport' => 'US-998822',
        ]);

        $this->service = Service::create([
            'name' => 'Fresh Laundry',
            'price' => 5.00,
            'unit' => 'per_item',
        ]);

        $this->reservation = Reservation::create([
            'booking_code' => 'GH-TEST-001',
            'guest_id' => $this->guest->id,
            'room_id' => $this->room->id,
            'check_in_date' => Carbon::today()->toDateString(),
            'check_out_date' => Carbon::tomorrow()->toDateString(),
            'total_nights' => 1,
            'total_amount' => 50.00,
            'status' => 'confirmed',
        ]);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_staff_can_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@guesthouse.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_authenticated_admin_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Daily Occupancy');
        $response->assertSee('John Doe');
        $response->assertSee('GH-TEST-001');
    }

    public function test_admin_can_view_room_status_grid(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.rooms.grid'));

        $response->assertStatus(200);
        $response->assertSee('Room 101');
        $response->assertSee('available');
    }

    public function test_admin_can_update_room_status(): void
    {
        $response = $this->actingAs($this->admin)->patch(route('admin.rooms.status', $this->room->id), [
            'status' => 'cleaning',
        ]);

        $response->assertRedirect();
        $this->room->refresh();
        $this->assertEquals('cleaning', $this->room->status);
    }

    public function test_admin_can_check_in_reservation(): void
    {
        $response = $this->actingAs($this->admin)->patch(route('admin.reservations.check-in', $this->reservation->id));

        $response->assertRedirect();
        $this->reservation->refresh();
        $this->room->refresh();

        $this->assertEquals('checked_in', $this->reservation->status);
        $this->assertEquals('occupied', $this->room->status);
    }

    public function test_admin_can_add_extra_service_to_reservation(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.reservations.services', $this->reservation->id), [
            'service_id' => $this->service->id,
            'quantity' => 2, // 2 * $5 = $10
        ]);

        $response->assertRedirect();
        $this->reservation->refresh();

        $this->assertEquals(60.00, (float) $this->reservation->total_amount);
        $this->assertDatabaseHas('reservation_services', [
            'reservation_id' => $this->reservation->id,
            'service_id' => $this->service->id,
            'quantity' => 2,
            'total_price' => 10.00,
        ]);
    }

    public function test_admin_can_check_out_and_view_invoice(): void
    {
        // First check in
        $this->actingAs($this->admin)->patch(route('admin.reservations.check-in', $this->reservation->id));

        // Check out with cash
        $response = $this->actingAs($this->admin)->patch(route('admin.reservations.check-out', $this->reservation->id), [
            'payment_method' => 'cash',
            'transaction_ref' => 'CASH-CHECKOUT-99',
        ]);

        $response->assertRedirect(route('admin.reservations.invoice', $this->reservation->id));

        $this->reservation->refresh();
        $this->room->refresh();

        $this->assertEquals('checked_out', $this->reservation->status);
        $this->assertEquals('cleaning', $this->room->status);
        $this->assertTrue($this->reservation->is_fully_paid);

        // View printable invoice
        $invoiceResponse = $this->actingAs($this->admin)->get(route('admin.reservations.invoice', $this->reservation->id));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('PAID IN FULL');
        $invoiceResponse->assertSee($this->reservation->booking_code);
    }
}
