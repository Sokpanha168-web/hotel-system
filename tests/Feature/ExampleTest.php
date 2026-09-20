<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $roomType = \App\Models\RoomType::create([
            'name' => 'Deluxe Garden Room',
            'slug' => 'deluxe-garden-room',
            'description' => 'A wonderful garden view room.',
            'base_price' => 60.00,
            'capacity' => 2,
            'amenities' => ['Wi-Fi', 'Air Conditioning'],
        ]);

        \App\Models\Room::create([
            'room_number' => '101',
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('data-nav', false);
        $response->assertSee('data-footer', false);
        $response->assertSee('scroll-progress-bar', false);
        $response->assertSee('parallax-img-wrapper', false);
        $response->assertSee('section-reveal-header', false);
        $response->assertSee('aria-label="Toggle navigation menu"', false);
        $response->assertSee('Hotel Directory & Suites', false);
    }
}
