@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header_title', 'Executive Operations Dashboard')
@section('header_subtitle', 'Daily room occupancy, arrivals, departures, and hospitality metrics')

@section('content')
<div class="space-y-8">
    <!-- Top 4 KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- 1. Occupancy Rate -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Daily Occupancy</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900">{{ $occupancyRate }}%</span>
                <span class="text-xs text-slate-500 font-medium">{{ $occupiedRoomsCount }} of {{ $totalRooms }} rooms</span>
            </div>
            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 h-2 rounded-full mt-4 overflow-hidden">
                <div class="bg-amber-600 h-full rounded-full transition-all duration-500" style="width: {{ min(100, $occupancyRate) }}%"></div>
            </div>
        </div>

        <!-- 2. Today's Arrivals -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Today's Arrivals</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900">{{ $todayArrivals->count() }}</span>
                <span class="text-xs text-slate-500 font-medium">Guests arriving today</span>
            </div>
            <p class="text-xs text-emerald-600 mt-4 font-semibold flex items-center">
                <span>Check-in starts 14:00 PM</span>
            </p>
        </div>

        <!-- 3. Today's Departures -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Today's Departures</span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900">{{ $todayDepartures->count() }}</span>
                <span class="text-xs text-slate-500 font-medium">Scheduled check-outs</span>
            </div>
            <p class="text-xs text-blue-600 mt-4 font-semibold flex items-center">
                <span>Standard check-out 12:00 PM</span>
            </p>
        </div>

        <!-- 4. Monthly Revenue -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Monthly Revenue</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-bold text-slate-900">${{ number_format($monthlyRevenue, 2) }}</span>
                <span class="text-xs text-slate-500 font-medium">This month</span>
            </div>
            <p class="text-xs text-slate-500 mt-4 font-medium">
                Today's receipts: <strong class="text-slate-900">${{ number_format($todayRevenue, 2) }}</strong>
            </p>
        </div>
    </div>

    <!-- Room Status Quick Overview Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
            <div>
                <h3 class="text-base font-bold text-slate-900">Room Fleet Distribution</h3>
                <p class="text-xs text-slate-500">Live operational status across all {{ $totalRooms }} rooms</p>
            </div>
            <a href="{{ route('admin.rooms.grid') }}" class="text-xs font-bold text-amber-700 hover:text-amber-800 transition">
                Open Full Visual Grid &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-5">
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200/80">
                <div class="flex items-center space-x-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                    <span class="text-xs font-bold text-emerald-900 uppercase tracking-wider">Available</span>
                </div>
                <div class="text-2xl font-bold text-emerald-900">{{ $availableRoomsCount }}</div>
            </div>

            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200/80">
                <div class="flex items-center space-x-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600"></span>
                    <span class="text-xs font-bold text-rose-900 uppercase tracking-wider">Occupied</span>
                </div>
                <div class="text-2xl font-bold text-rose-900">{{ $occupiedRoomsCount }}</div>
            </div>

            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200/80">
                <div class="flex items-center space-x-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-600"></span>
                    <span class="text-xs font-bold text-amber-900 uppercase tracking-wider">Cleaning</span>
                </div>
                <div class="text-2xl font-bold text-amber-900">{{ $cleaningRoomsCount }}</div>
            </div>

            <div class="p-4 rounded-xl bg-slate-100 border border-slate-300">
                <div class="flex items-center space-x-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span>
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Maintenance</span>
                </div>
                <div class="text-2xl font-bold text-slate-900">{{ $maintenanceRoomsCount }}</div>
            </div>
        </div>
    </div>

    <!-- Two-column Section: Today's Operations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Today's Expected Arrivals -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <h3 class="text-base font-bold text-slate-900">Today's Arrivals ({{ $todayArrivals->count() }})</h3>
                </div>
                <span class="text-xs text-slate-400">{{ date('M d, Y') }}</span>
            </div>

            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto pr-1">
                @forelse($todayArrivals as $arrival)
                    <div class="py-3.5 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $arrival->guest->full_name }}</p>
                            <p class="text-xs text-slate-500">
                                Room <strong class="text-slate-800">{{ $arrival->room->room_number }}</strong> • {{ $arrival->total_nights }} nights • Code: {{ $arrival->booking_code }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($arrival->status === 'checked_in')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Checked In</span>
                            @else
                                <form method="POST" action="{{ route('admin.reservations.check-in', $arrival->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                                        Check In
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-400">
                        No check-ins scheduled for today.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Today's Departures -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h3 class="text-base font-bold text-slate-900">Today's Departures ({{ $todayDepartures->count() }})</h3>
                </div>
                <span class="text-xs text-slate-400">{{ date('M d, Y') }}</span>
            </div>

            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto pr-1">
                @forelse($todayDepartures as $dep)
                    <div class="py-3.5 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $dep->guest->full_name }}</p>
                            <p class="text-xs text-slate-500">
                                Room <strong class="text-slate-800">{{ $dep->room->room_number }}</strong> • Balance: <span class="{{ $dep->balance_due > 0 ? 'text-amber-700 font-bold' : 'text-emerald-600' }}">${{ number_format($dep->balance_due, 2) }}</span>
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.reservations.show', $dep->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                Settle & Check Out
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-400">
                        No checked-in guests departing today.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Recent Guest Reservations</h3>
                <p class="text-xs text-slate-500">Latest reservations placed via public portal and walk-in counter</p>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="text-xs font-bold text-amber-700 hover:text-amber-800 transition">
                View All Reservations &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">Booking Code</th>
                        <th class="py-3.5 px-6">Guest</th>
                        <th class="py-3.5 px-6">Room</th>
                        <th class="py-3.5 px-6">Dates</th>
                        <th class="py-3.5 px-6 text-right">Total</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-6 font-mono font-bold text-xs text-slate-900">
                                <a href="{{ route('admin.reservations.show', $booking->id) }}" class="text-amber-700 hover:underline">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-900">{{ $booking->guest->full_name }}</div>
                                <div class="text-xs text-slate-400">{{ $booking->guest->phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-900">Room {{ $booking->room->room_number }}</span>
                                <span class="text-xs text-slate-400 block">{{ $booking->room->roomType->name }}</span>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <div>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</div>
                                <div class="text-slate-400">{{ $booking->total_nights }} nights</div>
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-slate-900">
                                ${{ number_format($booking->total_amount, 2) }}
                                @if($booking->is_fully_paid)
                                    <span class="block text-[10px] text-emerald-600 font-normal">Paid in full</span>
                                @else
                                    <span class="block text-[10px] text-amber-600 font-normal">Due: ${{ number_format($booking->balance_due, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($booking->status === 'checked_in')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Checked In</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Confirmed</span>
                                @elseif($booking->status === 'checked_out')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Checked Out</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Cancelled</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Pending</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.reservations.show', $booking->id) }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 transition">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-xs text-slate-400">
                                No reservations registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
