@extends('layouts.public')

@section('title', 'Reservation Confirmed - ' . $reservation->booking_code)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">
    <!-- Success Banner -->
    <div class="text-center mb-10">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <span class="text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-1">Reservation Received</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#161513] mb-2">Thank you, {{ $reservation->guest->full_name }}!</h1>
        <p class="text-[#39393b] text-sm">
            Your booking reference code is 
            <span class="font-mono font-bold text-[#161513] bg-[#f7f4ec] px-2.5 py-1 rounded-lg border border-[#e2ded5]">
                {{ $reservation->booking_code }}
            </span>
        </p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-[#e2ded5] shadow-xl overflow-hidden mb-10">
        <!-- Top Status Bar -->
        <div class="bg-[#161513] text-white px-8 py-5 flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-xs uppercase tracking-wider text-stone-400 block font-bold">Booking Status</span>
                <div class="flex items-center space-x-2 mt-0.5">
                    @if($reservation->status === 'checked_in')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-500 text-white">Checked In</span>
                    @elseif($reservation->status === 'confirmed')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500 text-white">Confirmed</span>
                    @elseif($reservation->status === 'checked_out')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-500 text-white">Checked Out</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#ebbf7d] text-[#161513]">Pending</span>
                    @endif

                    @if($reservation->is_fully_paid)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-600 text-white">Fully Paid</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#ebbf7d] text-[#161513]">Balance Due: ${{ number_format($reservation->balance_due, 2) }}</span>
                    @endif
                </div>
            </div>

            <div class="text-right">
                <span class="text-xs uppercase tracking-wider text-stone-400 block font-bold">Total Stay Cost</span>
                <span class="text-2xl font-serif font-bold text-[#ebbf7d]">${{ number_format($reservation->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="p-8 space-y-8">
            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8 border-b border-stone-200">
                <!-- Stay Info -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4">Stay Details</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-stone-500">Room Category:</span>
                            <span class="font-semibold text-stone-900">{{ $reservation->room->roomType->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Assigned Room:</span>
                            <span class="font-semibold text-stone-900">Room {{ $reservation->room->room_number }} (Floor {{ $reservation->room->floor }})</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Check-in:</span>
                            <span class="font-semibold text-stone-900">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }} (14:00 PM)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Check-out:</span>
                            <span class="font-semibold text-stone-900">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }} (12:00 PM)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Length of Stay:</span>
                            <span class="font-semibold text-stone-900">{{ $reservation->total_nights }} {{ Str::plural('Night', $reservation->total_nights) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Guest Info -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4">Guest Information</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-stone-500">Primary Guest:</span>
                            <span class="font-semibold text-stone-900">{{ $reservation->guest->full_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Phone:</span>
                            <span class="font-semibold text-stone-900">{{ $reservation->guest->phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Email:</span>
                            <span class="font-semibold text-stone-900">{{ $reservation->guest->email ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-500">Passport / ID:</span>
                            <span class="font-semibold text-stone-900">{{ $reservation->guest->national_id_or_passport }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Breakdown -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-400 mb-4">Charges & Invoicing Breakdown</h3>
                <div class="rounded-2xl border border-stone-200 overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-stone-50 text-xs font-bold text-stone-600 uppercase border-b border-stone-200">
                            <tr>
                                <th class="py-3 px-4">Item / Description</th>
                                <th class="py-3 px-4 text-center">Qty</th>
                                <th class="py-3 px-4 text-right">Rate</th>
                                <th class="py-3 px-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            <tr>
                                <td class="py-3.5 px-4 font-medium text-stone-900">
                                    {{ $reservation->room->roomType->name }} (Room {{ $reservation->room->room_number }})
                                </td>
                                <td class="py-3.5 px-4 text-center text-stone-600">{{ $reservation->total_nights }} nights</td>
                                <td class="py-3.5 px-4 text-right text-stone-600">${{ number_format($reservation->room->roomType->base_price, 2) }}</td>
                                <td class="py-3.5 px-4 text-right font-semibold text-stone-900">
                                    ${{ number_format($reservation->total_nights * $reservation->room->roomType->base_price, 2) }}
                                </td>
                            </tr>

                            @foreach($reservation->reservationServices as $rs)
                                <tr>
                                    <td class="py-3.5 px-4 text-stone-800">
                                        {{ $rs->service->name }} ({{ str_replace('_', ' ', $rs->service->unit) }})
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-stone-600">{{ $rs->quantity }}</td>
                                    <td class="py-3.5 px-4 text-right text-stone-600">${{ number_format($rs->unit_price, 2) }}</td>
                                    <td class="py-3.5 px-4 text-right font-semibold text-stone-900">${{ number_format($rs->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-stone-50 border-t border-stone-200 text-sm">
                            <tr>
                                <td colspan="3" class="py-3 px-4 text-right font-bold text-stone-700">Total Charges:</td>
                                <td class="py-3 px-4 text-right font-bold text-stone-900">${{ number_format($reservation->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="py-2 px-4 text-right text-stone-600">Total Paid:</td>
                                <td class="py-2 px-4 text-right font-semibold text-emerald-700">${{ number_format($reservation->total_paid, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="py-2 px-4 text-right font-bold text-[#161513]">Balance Due:</td>
                                <td class="py-2 px-4 text-right font-bold text-[#161513]">${{ number_format($reservation->balance_due, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Payment Action / KHQR Section -->
            @if(!$reservation->is_fully_paid)
                <div class="pt-6 border-t border-[#e2ded5]">
                    <div class="bg-[#f7f4ec]/40 border border-[#e2ded5] rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-center gap-8">
                        <!-- Visual KHQR Card Placeholder -->
                        <div class="w-64 bg-white rounded-2xl shadow-md border border-[#e2ded5] overflow-hidden flex-shrink-0">
                            <!-- KHQR Header Banner -->
                            <div class="bg-[#161513] text-[#ebbf7d] p-3 text-center border-b border-[#e2ded5]/20">
                                <span class="font-bold tracking-widest text-sm uppercase block font-sans">KHQR</span>
                                <span class="text-[9px] uppercase tracking-wider text-stone-300">National QR Payment</span>
                            </div>

                            <div class="p-4 text-center">
                                <div class="text-[11px] font-bold text-[#161513] uppercase tracking-tight">SERENITY VILLA GUEST HOUSE</div>
                                <div class="text-[10px] text-[#39393b] mb-3">Merchant ID: 00098877</div>

                                <!-- Simulated QR Code Graphic -->
                                <div class="w-44 h-44 mx-auto p-2 bg-white border border-[#e2ded5] rounded-xl shadow-inner flex items-center justify-center relative">
                                    <svg class="w-40 h-40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <!-- QR Corner Squares -->
                                        <rect x="5" y="5" width="26" height="26" rx="3" fill="#161513" />
                                        <rect x="9" y="9" width="18" height="18" rx="2" fill="white" />
                                        <rect x="13" y="13" width="10" height="10" rx="1" fill="#161513" />

                                        <rect x="69" y="5" width="26" height="26" rx="3" fill="#161513" />
                                        <rect x="73" y="9" width="18" height="18" rx="2" fill="white" />
                                        <rect x="77" y="13" width="10" height="10" rx="1" fill="#161513" />

                                        <rect x="5" y="69" width="26" height="26" rx="3" fill="#161513" />
                                        <rect x="9" y="73" width="18" height="18" rx="2" fill="white" />
                                        <rect x="13" y="77" width="10" height="10" rx="1" fill="#161513" />

                                        <!-- Patterns -->
                                        <rect x="36" y="8" width="8" height="8" fill="#161513" />
                                        <rect x="48" y="8" width="8" height="8" fill="#161513" />
                                        <rect x="36" y="20" width="8" height="8" fill="#161513" />
                                        <rect x="48" y="20" width="8" height="8" fill="#161513" />

                                        <rect x="8" y="36" width="8" height="8" fill="#161513" />
                                        <rect x="20" y="36" width="8" height="8" fill="#161513" />
                                        <rect x="36" y="36" width="12" height="12" rx="2" fill="#ebbf7d" />
                                        <rect x="52" y="36" width="8" height="8" fill="#161513" />
                                        <rect x="68" y="36" width="8" height="8" fill="#161513" />
                                        <rect x="84" y="36" width="8" height="8" fill="#161513" />

                                        <rect x="36" y="52" width="8" height="8" fill="#161513" />
                                        <rect x="48" y="52" width="12" height="12" rx="2" fill="#ebbf7d" />
                                        <rect x="68" y="52" width="8" height="8" fill="#161513" />

                                        <rect x="8" y="48" width="8" height="8" fill="#161513" />
                                        <rect x="20" y="48" width="8" height="8" fill="#161513" />
                                        <rect x="36" y="68" width="8" height="8" fill="#161513" />
                                        <rect x="48" y="68" width="8" height="8" fill="#161513" />
                                        <rect x="68" y="68" width="8" height="8" fill="#161513" />
                                        <rect x="80" y="68" width="8" height="8" fill="#161513" />
                                        <rect x="68" y="80" width="8" height="8" fill="#161513" />
                                        <rect x="84" y="80" width="8" height="8" fill="#161513" />
                                    </svg>
                                </div>

                                <div class="mt-3">
                                    <div class="text-lg font-bold font-mono text-[#161513]">${{ number_format($reservation->balance_due, 2) }}</div>
                                    <div class="text-[11px] text-[#39393b] font-mono">≈ {{ number_format($reservation->balance_due * 4100) }} KHR</div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructions & Instant Simulation -->
                        <div class="flex-1 space-y-4">
                            <h4 class="font-serif text-xl font-bold text-[#161513]">Instant Cashless Payment</h4>
                            <p class="text-sm text-[#39393b] leading-relaxed">
                                Open any Cambodian Banking App (ABA, ACLEDA, Wing, Canadia, Sathapana, etc.) and scan the Bakong KHQR code above to settle the remaining balance of <strong>${{ number_format($reservation->balance_due, 2) }}</strong>.
                            </p>

                            <div class="p-4 bg-[#f7f4ec] rounded-xl border border-[#e2ded5] text-xs text-[#161513]">
                                💡 <strong>Testing Mode:</strong> You can simulate an instant mobile bank payment by clicking the button below:
                            </div>

                            <form action="{{ route('booking.simulate_payment', $reservation->booking_code) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 rounded-xl font-bold text-sm text-white bg-emerald-700 hover:bg-emerald-800 shadow-md shadow-emerald-900/15 transition flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Simulate Instant KHQR Payment ($ {{ number_format($reservation->balance_due, 2) }})</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Paid Stamp -->
                <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">
                            ✓
                        </div>
                        <div>
                            <span class="font-bold text-base block">Payment Complete</span>
                            <span class="text-xs text-emerald-700">Thank you! Your booking is confirmed and paid in full.</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.reservations.invoice', $reservation->id) }}" target="_blank" class="px-4 py-2 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition">
                        View Official Invoice &rarr;
                    </a>
                </div>
            @endif

            <!-- Bottom Actions -->
            <div class="pt-6 border-t border-[#e2ded5] flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="text-xs font-bold text-[#39393b] hover:text-[#161513]">
                    &larr; Back to Home Page
                </a>

                <div class="flex items-center space-x-3">
                    <button onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-bold text-[#39393b] bg-[#f7f4ec] hover:bg-[#efeeec] transition">
                        Print Confirmation
                    </button>
                    <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] transition shadow-xs">
                        Book Another Room
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
