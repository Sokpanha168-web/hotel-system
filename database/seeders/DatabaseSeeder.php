<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Staff & Admin Users
        User::updateOrCreate(
            ['email' => 'admin@guesthouse.com'],
            [
                'name' => 'Sok Panha (General Manager)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'reception@guesthouse.com'],
            [
                'name' => 'Bopha Chann (Frontdesk Receptionist)',
                'password' => Hash::make('password'),
                'role' => 'receptionist',
                'email_verified_at' => now(),
            ]
        );

        // 2. Room Types
        $roomTypesData = [
            [
                'name' => 'Deluxe Double Room',
                'slug' => 'deluxe-double-room',
                'description' => 'Elegantly appointed room with custom teak wood furniture, plush King-size bed, private terrace overlooking serene gardens, and modern en-suite bathroom.',
                'base_price' => 45.00,
                'capacity' => 2,
                'amenities' => ['King Bed', 'Air Conditioning', 'Private Balcony', 'Hot Rain Shower', 'High-Speed Wi-Fi', 'Mini Fridge', 'Coffee & Tea Kettle', 'Room Safe'],
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Superior Twin Suite',
                'slug' => 'superior-twin-suite',
                'description' => 'Spacious room featuring two comfortable single beds, dedicated work desk, pool view patio, and premium bathroom amenities tailored for friends or colleagues.',
                'base_price' => 55.00,
                'capacity' => 2,
                'amenities' => ['2 Twin Beds', 'Air Conditioning', 'Pool View Patio', 'Smart TV with Netflix', 'Free Wi-Fi', 'Work Desk', 'En-suite Bathroom', 'Hairdryer'],
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Executive Garden Suite',
                'slug' => 'executive-garden-suite',
                'description' => 'A luxurious sanctuary featuring a private garden courtyard, deep-soaking terrazzo bathtub, espresso coffee machine, and spacious lounging sofa bed.',
                'base_price' => 85.00,
                'capacity' => 3,
                'amenities' => ['King Bed + Daybed', 'Terrazzo Soaking Tub', 'Private Garden Courtyard', 'Nespresso Machine', 'Fast Fiber Wi-Fi', 'Bluetooth Speaker', 'Bathrobes & Slippers'],
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Family Garden Bungalow',
                'slug' => 'family-garden-bungalow',
                'description' => 'Freestanding tropical bungalow offering two queen beds, separate living area, kitchenette with dining table, and large shaded veranda ideal for families.',
                'base_price' => 120.00,
                'capacity' => 4,
                'amenities' => ['2 Queen Beds', 'Living Room & Sofa', 'Kitchenette & Microwave', 'Private Veranda', 'Smart TV', 'Dining Table', 'Child-friendly setup', 'High-Speed Wi-Fi'],
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        $createdTypes = [];
        foreach ($roomTypesData as $data) {
            $createdTypes[$data['slug']] = RoomType::updateOrCreate(['slug' => $data['slug']], $data);
        }

        // 3. Rooms (15 Rooms across 3 Floors)
        $roomsData = [
            // Floor 1 (Garden level)
            ['room_number' => '101', 'room_type_id' => $createdTypes['deluxe-double-room']->id, 'floor' => 1, 'status' => 'available'],
            ['room_number' => '102', 'room_type_id' => $createdTypes['deluxe-double-room']->id, 'floor' => 1, 'status' => 'occupied'],
            ['room_number' => '103', 'room_type_id' => $createdTypes['superior-twin-suite']->id, 'floor' => 1, 'status' => 'available'],
            ['room_number' => '104', 'room_type_id' => $createdTypes['executive-garden-suite']->id, 'floor' => 1, 'status' => 'cleaning'],
            ['room_number' => '105', 'room_type_id' => $createdTypes['family-garden-bungalow']->id, 'floor' => 1, 'status' => 'occupied'],

            // Floor 2 (Pool & Balcony level)
            ['room_number' => '201', 'room_type_id' => $createdTypes['deluxe-double-room']->id, 'floor' => 2, 'status' => 'available'],
            ['room_number' => '202', 'room_type_id' => $createdTypes['deluxe-double-room']->id, 'floor' => 2, 'status' => 'occupied'],
            ['room_number' => '203', 'room_type_id' => $createdTypes['superior-twin-suite']->id, 'floor' => 2, 'status' => 'available'],
            ['room_number' => '204', 'room_type_id' => $createdTypes['superior-twin-suite']->id, 'floor' => 2, 'status' => 'maintenance'],
            ['room_number' => '205', 'room_type_id' => $createdTypes['executive-garden-suite']->id, 'floor' => 2, 'status' => 'available'],

            // Floor 3 (Rooftop & Sunset view)
            ['room_number' => '301', 'room_type_id' => $createdTypes['deluxe-double-room']->id, 'floor' => 3, 'status' => 'available'],
            ['room_number' => '302', 'room_type_id' => $createdTypes['superior-twin-suite']->id, 'floor' => 3, 'status' => 'cleaning'],
            ['room_number' => '303', 'room_type_id' => $createdTypes['executive-garden-suite']->id, 'floor' => 3, 'status' => 'available'],
            ['room_number' => '304', 'room_type_id' => $createdTypes['executive-garden-suite']->id, 'floor' => 3, 'status' => 'occupied'],
            ['room_number' => '305', 'room_type_id' => $createdTypes['family-garden-bungalow']->id, 'floor' => 3, 'status' => 'available'],
        ];

        $createdRooms = [];
        foreach ($roomsData as $rData) {
            $createdRooms[$rData['room_number']] = Room::updateOrCreate(['room_number' => $rData['room_number']], $rData);
        }

        // 4. Extra Services
        $servicesData = [
            ['name' => 'Laundry Service (Wash & Fold)', 'price' => 3.50, 'unit' => 'per_item'],
            ['name' => 'Artisan Khmer Breakfast Set', 'price' => 8.00, 'unit' => 'per_day'],
            ['name' => 'Airport Tuk-Tuk Transfer', 'price' => 12.00, 'unit' => 'per_trip'],
            ['name' => 'City Cruiser Bicycle Rental', 'price' => 5.00, 'unit' => 'per_day'],
            ['name' => 'Minibar Cold Drinks & Snacks', 'price' => 2.50, 'unit' => 'per_item'],
            ['name' => 'Late Check-out Privilege (Until 15:00)', 'price' => 15.00, 'unit' => 'per_booking'],
        ];

        $createdServices = [];
        foreach ($servicesData as $sData) {
            $createdServices[] = Service::updateOrCreate(['name' => $sData['name']], $sData);
        }

        // 5. Sample Guests
        $guestsData = [
            ['full_name' => 'Jonathan Miller', 'phone' => '+855 12 778 899', 'email' => 'jmiller@example.com', 'national_id_or_passport' => 'PA-9988214'],
            ['full_name' => 'Claire Dupont', 'phone' => '+33 6 12 34 56 78', 'email' => 'claire.dupont@example.fr', 'national_id_or_passport' => 'FR-8877112'],
            ['full_name' => 'Sokha Meng', 'phone' => '+855 98 443 322', 'email' => 'sokha.meng@example.com', 'national_id_or_passport' => 'ID-010293847'],
            ['full_name' => 'Alexander Schmidt', 'phone' => '+49 151 2345678', 'email' => 'alex.schmidt@example.de', 'national_id_or_passport' => 'DE-7766554'],
            ['full_name' => 'Mei-Ling Chen', 'phone' => '+886 912 345 678', 'email' => 'meiling@example.tw', 'national_id_or_passport' => 'TW-4433221'],
        ];

        $createdGuests = [];
        foreach ($guestsData as $gData) {
            $createdGuests[] = Guest::updateOrCreate(['national_id_or_passport' => $gData['national_id_or_passport']], $gData);
        }

        // 6. Sample Active & Recent Reservations
        $today = Carbon::today();

        // Res 1: Checked In Guest in Room 102 (Arrived yesterday, checks out tomorrow)
        $res1 = Reservation::updateOrCreate(
            ['booking_code' => 'GH-102A-8841'],
            [
                'guest_id' => $createdGuests[0]->id,
                'room_id' => $createdRooms['102']->id,
                'check_in_date' => $today->copy()->subDay()->toDateString(),
                'check_out_date' => $today->copy()->addDays(2)->toDateString(),
                'total_nights' => 3,
                'total_amount' => 135.00,
                'status' => 'checked_in',
            ]
        );
        Payment::updateOrCreate(
            ['transaction_ref' => 'KHQR-TX-8841'],
            [
                'reservation_id' => $res1->id,
                'amount' => 135.00,
                'payment_method' => 'khqr_transfer',
                'payment_status' => 'paid',
                'paid_at' => $today->copy()->subDay(),
            ]
        );

        // Res 2: Today's Arrival in Room 101 (Check in today, confirmed status)
        $res2 = Reservation::updateOrCreate(
            ['booking_code' => 'GH-101A-9922'],
            [
                'guest_id' => $createdGuests[1]->id,
                'room_id' => $createdRooms['101']->id,
                'check_in_date' => $today->toDateString(),
                'check_out_date' => $today->copy()->addDays(3)->toDateString(),
                'total_nights' => 3,
                'total_amount' => 143.00,
                'status' => 'confirmed',
            ]
        );
        // Add a breakfast service
        ReservationService::updateOrCreate(
            ['reservation_id' => $res2->id, 'service_id' => $createdServices[1]->id],
            [
                'quantity' => 1,
                'unit_price' => 8.00,
                'total_price' => 8.00,
            ]
        );
        Payment::updateOrCreate(
            ['transaction_ref' => 'KHQR-TX-9922'],
            [
                'reservation_id' => $res2->id,
                'amount' => 143.00,
                'payment_method' => 'khqr_transfer',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]
        );

        // Res 3: Today's Departure in Room 105 (Checked in, departing today)
        $res3 = Reservation::updateOrCreate(
            ['booking_code' => 'GH-105A-7733'],
            [
                'guest_id' => $createdGuests[2]->id,
                'room_id' => $createdRooms['105']->id,
                'check_in_date' => $today->copy()->subDays(2)->toDateString(),
                'check_out_date' => $today->toDateString(),
                'total_nights' => 2,
                'total_amount' => 252.00,
                'status' => 'checked_in',
            ]
        );
        ReservationService::updateOrCreate(
            ['reservation_id' => $res3->id, 'service_id' => $createdServices[2]->id],
            [
                'quantity' => 1,
                'unit_price' => 12.00,
                'total_price' => 12.00,
            ]
        );
        Payment::updateOrCreate(
            ['transaction_ref' => 'CASH-ADV-7733'],
            [
                'reservation_id' => $res3->id,
                'amount' => 150.00,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
                'paid_at' => $today->copy()->subDays(2),
            ]
        );

        // Res 4: Checked In in Room 202
        $res4 = Reservation::updateOrCreate(
            ['booking_code' => 'GH-202A-4455'],
            [
                'guest_id' => $createdGuests[3]->id,
                'room_id' => $createdRooms['202']->id,
                'check_in_date' => $today->copy()->subDay()->toDateString(),
                'check_out_date' => $today->copy()->addDay()->toDateString(),
                'total_nights' => 2,
                'total_amount' => 90.00,
                'status' => 'checked_in',
            ]
        );
        Payment::updateOrCreate(
            ['transaction_ref' => 'CARD-VISA-4455'],
            [
                'reservation_id' => $res4->id,
                'amount' => 90.00,
                'payment_method' => 'card',
                'payment_status' => 'paid',
                'paid_at' => $today->copy()->subDay(),
            ]
        );

        // Res 5: Checked In in Room 304 (Executive Suite)
        $res5 = Reservation::updateOrCreate(
            ['booking_code' => 'GH-304A-6611'],
            [
                'guest_id' => $createdGuests[4]->id,
                'room_id' => $createdRooms['304']->id,
                'check_in_date' => $today->toDateString(),
                'check_out_date' => $today->copy()->addDays(4)->toDateString(),
                'total_nights' => 4,
                'total_amount' => 340.00,
                'status' => 'checked_in',
            ]
        );
        Payment::updateOrCreate(
            ['transaction_ref' => 'KHQR-TX-6611'],
            [
                'reservation_id' => $res5->id,
                'amount' => 340.00,
                'payment_method' => 'khqr_transfer',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]
        );
    }
}
