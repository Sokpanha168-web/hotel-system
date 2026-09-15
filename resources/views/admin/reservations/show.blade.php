@extends('layouts.admin')

@section('title', 'Reservation Details - ' . $reservation->booking_code)
@section('header_title', 'Reservation Details')
@section('header_subtitle', 'Booking Code: ' . $reservation->booking_code)

@section('content')
<div class="space-y-8" x-data="{ addServiceModal: false, checkOutModal: false }">

    <!-- Header Actions Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.reservations.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-2">
                    <span class="font-mono text-xl font-bold text-slate-900">{{ $reservation->booking_code }}</span>
                    @if($reservation->status === 'checked_in')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Checked In</span>
                    @elseif($reservation->status === 'confirmed')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Confirmed</span>
                    @elseif($reservation->status === 'checked_out')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Checked Out</span>
                    @elseif($reservation->status === 'cancelled')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">Cancelled</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Pending</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Placed on {{ $reservation->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-3">
            @if($reservation->status === 'confirmed' || $reservation->status === 'pending')
                <form method="POST" action="{{ route('admin.reservations.check-in', $reservation->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-xs transition">
                        ✓ Check In Guest
                    </button>
                </form>
            @endif

            @if($reservation->status === 'checked_in')
                <button type="button" @click="addServiceModal = true" class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 transition">
                    + Add Service (Laundry / Drinks)
                </button>

                <button type="button" @click="checkOutModal = true" class="px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition">
                    Settle & Check Out &rarr;
                </button>
            @endif

            <a href="{{ route('admin.reservations.invoice', $reservation->id) }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs text-amber-900 bg-amber-100 hover:bg-amber-200 border border-amber-300 transition">
                Print Invoice
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Guest & Stay Details -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Guest Dossier -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Guest Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-500 text-xs block">Full Name</span>
                        <span class="font-bold text-slate-900">{{ $reservation->guest->full_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Phone Number</span>
                        <span class="font-bold text-slate-900">{{ $reservation->guest->phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Email Address</span>
                        <span class="font-bold text-slate-900">{{ $reservation->guest->email ?? 'Not provided' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Passport / National ID</span>
                        <span class="font-mono font-bold text-slate-900">{{ $reservation->guest->national_id_or_passport }}</span>
                    </div>
                </div>
            </div>

            <!-- Stay Dossier -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Accommodation Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <span class="text-slate-500 text-xs block">Assigned Room</span>
                        <span class="font-bold text-slate-900 text-base">Room {{ $reservation->room->room_number }}</span>
                        <span class="text-xs text-slate-500 block">Floor {{ $reservation->room->floor }} • Status: {{ ucfirst($reservation->room->status) }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Room Category</span>
                        <span class="font-bold text-slate-900">{{ $reservation->room->roomType->name }}</span>
                        <span class="text-xs text-slate-500 block">${{ number_format($reservation->room->roomType->base_price, 2) }} / night</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Check-in Date</span>
                        <span class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Check-out Date</span>
                        <span class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Duration: <strong class="text-slate-800">{{ $reservation->total_nights }} {{ Str::plural('night', $reservation->total_nights) }}</strong></span>
                    <span>Max Capacity: <strong class="text-slate-800">{{ $reservation->room->roomType->capacity }} guests</strong></span>
                </div>
            </div>

            <!-- Attached Services Table -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Add-on Services</h3>
                        <p class="text-xs text-slate-500">Extra amenities, laundry, beverages, and tours charged to room</p>
                    </div>
                    @if($reservation->status === 'checked_in')
                        <button type="button" @click="addServiceModal = true" class="px-3 py-1.5 rounded-lg text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition">
                            + Add Service
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 uppercase text-slate-500 font-bold border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">Service</th>
                                <th class="py-2.5 px-3 text-center">Qty</th>
                                <th class="py-2.5 px-3 text-right">Unit Price</th>
                                <th class="py-2.5 px-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($reservation->reservationServices as $rs)
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">{{ $rs->service->name }}</td>
                                    <td class="py-2.5 px-3 text-center text-slate-600">{{ $rs->quantity }}</td>
                                    <td class="py-2.5 px-3 text-right text-slate-600">${{ number_format($rs->unit_price, 2) }}</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-slate-900">${{ number_format($rs->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-400">No extra services billed to this reservation.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Billing & Payment History -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Financial Breakdown Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Billing Summary</h3>

                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Room Charges ({{ $reservation->total_nights }} nights)</span>
                        <span class="font-semibold text-slate-900">${{ number_format($reservation->total_nights * $reservation->room->roomType->base_price, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-slate-600">
                        <span>Services Subtotal</span>
                        <span class="font-semibold text-slate-900">${{ number_format($reservation->reservationServices->sum('total_price'), 2) }}</span>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex justify-between font-bold text-base text-slate-900">
                        <span>Total Stay Cost</span>
                        <span>${{ number_format($reservation->total_amount, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-emerald-700 font-medium">
                        <span>Total Paid</span>
                        <span>${{ number_format($reservation->total_paid, 2) }}</span>
                    </div>

                    <div class="pt-3 border-t-2 border-slate-200 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-slate-900">Balance Due</span>
                        <span class="text-2xl font-bold font-mono {{ $reservation->balance_due > 0 ? 'text-amber-800' : 'text-emerald-700' }}">
                            ${{ number_format($reservation->balance_due, 2) }}
                        </span>
                    </div>
                </div>

                @if($reservation->status === 'checked_in')
                    <button type="button" @click="checkOutModal = true" class="w-full mt-4 py-3 px-4 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition">
                        Check Out & Settle Balance &rarr;
                    </button>
                @endif
            </div>

            <!-- Payment Records -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Payment Transactions</h3>

                <div class="space-y-3">
                    @forelse($reservation->payments as $payment)
                        <div class="p-3 rounded-xl border border-slate-200 bg-slate-50/50 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block">${{ number_format($payment->amount, 2) }}</span>
                                <span class="text-[11px] text-slate-500 uppercase tracking-wider">
                                    Method: {{ str_replace('_', ' ', $payment->payment_method) }}
                                </span>
                                @if($payment->transaction_ref)
                                    <span class="text-[10px] text-slate-400 font-mono block">Ref: {{ $payment->transaction_ref }}</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded-md font-semibold text-[10px] uppercase bg-emerald-100 text-emerald-800">
                                    {{ $payment->payment_status }}
                                </span>
                                <span class="text-[10px] text-slate-400 block mt-1">
                                    {{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, H:i') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center">No payment transactions recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Add Extra Service -->
    <div x-show="addServiceModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addServiceModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Add Service to Reservation</h3>
                    <p class="text-xs text-slate-500">Bill extra amenities directly to guest folio</p>
                </div>
                <button @click="addServiceModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.reservations.services', $reservation->id) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="service_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Select Service</label>
                    <select name="service_id" id="service_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium">
                        @foreach($availableServices as $svc)
                            <option value="{{ $svc->id }}">
                                {{ $svc->name }} (${{ number_format($svc->price, 2) }} / {{ str_replace('_', ' ', $svc->unit) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="100" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <button type="button" @click="addServiceModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition">
                        Add to Folio
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Settle & Check Out -->
    <div x-show="checkOutModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="checkOutModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Check Out & Settlement</h3>
                    <p class="text-xs text-slate-500">Room {{ $reservation->room->room_number }} • {{ $reservation->guest->full_name }}</p>
                </div>
                <button @click="checkOutModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.reservations.check-out', $reservation->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs flex justify-between items-center">
                    <span class="text-slate-600">Final Balance to Settle:</span>
                    <span class="text-xl font-mono font-bold text-amber-800">${{ number_format($reservation->balance_due, 2) }}</span>
                </div>

                @if($reservation->balance_due > 0)
                    <div>
                        <label for="payment_method" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Settlement Method</label>
                        <select name="payment_method" id="payment_method" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium">
                            <option value="cash">Cash (USD / KHR)</option>
                            <option value="khqr_transfer">Bakong KHQR Transfer</option>
                            <option value="card">Credit / Debit Card</option>
                        </select>
                    </div>

                    <div>
                        <label for="transaction_ref" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Receipt / Transaction Ref (Optional)</label>
                        <input type="text" name="transaction_ref" id="transaction_ref" placeholder="e.g. CASH-POS or KHQR-TX-9988" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium">
                    </div>
                @else
                    <input type="hidden" name="payment_method" value="cash">
                    <p class="text-xs text-emerald-700 bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                        ✓ Folio is already fully paid. Proceeding will close the booking and set room to cleaning.
                    </p>
                @endif

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <button type="button" @click="checkOutModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs transition">
                        Confirm Check-Out & Settle
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
