<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice - {{ $reservation->booking_code }} - Serenity Villa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 12pt; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
            @page { margin: 1.5cm; }
        }
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased py-8 selection:bg-amber-200">

    <!-- Top Action Bar (Hidden when Printing) -->
    <div class="no-print max-w-4xl mx-auto px-4 mb-6 flex items-center justify-between">
        <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('admin.reservations.show', $reservation->id) }}" 
           class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-4 py-2.5 rounded-xl border border-slate-300 shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Dashboard</span>
        </a>

        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-amber-700 hover:bg-amber-800 shadow-sm transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Print Invoice / Receipt (A4)</span>
            </button>
        </div>
    </div>

    <!-- Official Invoice Sheet -->
    <div class="max-w-4xl mx-auto bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-slate-200 print-shadow-none">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start justify-between border-b border-slate-200 pb-8 gap-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-xl bg-amber-700 text-amber-50 flex items-center justify-center font-bold">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-serif text-2xl font-bold text-slate-900 tracking-tight">Serenity Villa Guest House</h1>
                    <p class="text-xs text-slate-500 font-medium">Boutique Accommodations & Resort Spa</p>
                    <p class="text-[11px] text-slate-400 mt-1">128 River Road, Wat Bo Village, Siem Reap, Cambodia</p>
                    <p class="text-[11px] text-slate-400">Tel: +855 23 998 877 | VAT ID: K008-9827110</p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-xs uppercase tracking-widest font-bold text-amber-700 block mb-1">Official Guest Folio</span>
                <span class="font-mono text-xl font-bold text-slate-900 block">INV-{{ str_replace('-', '', $reservation->booking_code) }}</span>
                <p class="text-xs text-slate-500 mt-1">Issue Date: {{ date('F d, Y') }}</p>
                <p class="text-xs text-slate-500">Booking Code: <strong class="text-slate-800">{{ $reservation->booking_code }}</strong></p>
            </div>
        </div>

        <!-- Billed To & Stay Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-8 border-b border-slate-200 text-xs">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">Billed To Guest</span>
                <h3 class="text-base font-bold text-slate-900">{{ $reservation->guest->full_name }}</h3>
                <p class="text-slate-600 mt-1">Phone: {{ $reservation->guest->phone }}</p>
                @if($reservation->guest->email)
                    <p class="text-slate-600">Email: {{ $reservation->guest->email }}</p>
                @endif
                <p class="text-slate-600">Passport / ID: <span class="font-mono font-semibold">{{ $reservation->guest->national_id_or_passport }}</span></p>
            </div>

            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">Accommodation Info</span>
                <div class="space-y-1 text-slate-600">
                    <p>Room: <strong class="text-slate-900 font-bold">Room {{ $reservation->room->room_number }}</strong> ({{ $reservation->room->roomType->name }})</p>
                    <p>Check-in: <strong>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }} (14:00 PM)</strong></p>
                    <p>Check-out: <strong>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }} (12:00 PM)</strong></p>
                    <p>Total Length of Stay: <strong>{{ $reservation->total_nights }} {{ Str::plural('night', $reservation->total_nights) }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Itemized Table -->
        <div class="py-8">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Itemized Room & Service Charges</h3>
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 uppercase text-slate-600 font-bold border-y border-slate-200">
                    <tr>
                        <th class="py-3 px-3">Description</th>
                        <th class="py-3 px-3 text-center">Unit / Period</th>
                        <th class="py-3 px-3 text-center">Qty</th>
                        <th class="py-3 px-3 text-right">Unit Rate</th>
                        <th class="py-3 px-3 text-right">Total (USD)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- Room Charge Line -->
                    <tr>
                        <td class="py-3.5 px-3 font-semibold text-slate-900">
                            {{ $reservation->room->roomType->name }} - Room {{ $reservation->room->room_number }}
                            <span class="block text-[11px] text-slate-400 font-normal">
                                Stay from {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d') }} to {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 text-center text-slate-600">Per Night</td>
                        <td class="py-3.5 px-3 text-center text-slate-600">{{ $reservation->total_nights }}</td>
                        <td class="py-3.5 px-3 text-right text-slate-600">${{ number_format($reservation->room->roomType->base_price, 2) }}</td>
                        <td class="py-3.5 px-3 text-right font-bold text-slate-900">
                            ${{ number_format($reservation->total_nights * $reservation->room->roomType->base_price, 2) }}
                        </td>
                    </tr>

                    <!-- Services Charges Lines -->
                    @foreach($reservation->reservationServices as $service)
                        <tr>
                            <td class="py-3 px-3 text-slate-800">
                                {{ $service->service->name }}
                            </td>
                            <td class="py-3 px-3 text-center text-slate-600">{{ str_replace('_', ' ', $service->service->unit) }}</td>
                            <td class="py-3 px-3 text-center text-slate-600">{{ $service->quantity }}</td>
                            <td class="py-3 px-3 text-right text-slate-600">${{ number_format($service->unit_price, 2) }}</td>
                            <td class="py-3 px-3 text-right font-bold text-slate-900">${{ number_format($service->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals & Payment Summary -->
        <div class="border-t border-slate-200 pt-6 flex flex-col sm:flex-row justify-between items-start gap-8">
            <!-- Paid Stamp / Note -->
            <div class="max-w-xs">
                @if($reservation->is_fully_paid)
                    <div class="inline-block border-2 border-emerald-600 text-emerald-700 uppercase font-serif font-bold text-sm tracking-widest px-4 py-2 rounded-xl transform -rotate-3">
                        ✓ PAID IN FULL
                    </div>
                @else
                    <div class="inline-block border-2 border-amber-600 text-amber-700 uppercase font-serif font-bold text-sm tracking-widest px-4 py-2 rounded-xl transform -rotate-3">
                        ! BALANCE DUE
                    </div>
                @endif

                <p class="text-[11px] text-slate-500 mt-4 leading-relaxed">
                    Thank you for choosing Serenity Villa Guest House. We hope you enjoyed your stay in Cambodia! For any inquiries, contact frontdesk@serenityvilla.com.
                </p>
            </div>

            <!-- Numbers Breakdown -->
            <div class="w-full sm:w-72 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span class="font-semibold text-slate-900">${{ number_format($reservation->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>VAT / Service Charge (Included):</span>
                    <span class="font-semibold text-slate-900">$0.00</span>
                </div>
                <div class="border-t border-slate-200 pt-2 flex justify-between text-sm font-bold text-slate-900">
                    <span>Total Folio Amount:</span>
                    <span class="text-base font-mono font-bold text-slate-900">${{ number_format($reservation->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-emerald-700 font-semibold">
                    <span>Amount Paid:</span>
                    <span class="font-mono">-${{ number_format($reservation->total_paid, 2) }}</span>
                </div>
                <div class="border-t-2 border-slate-800 pt-2 flex justify-between text-sm font-bold text-slate-900">
                    <span>Balance Due:</span>
                    <span class="font-mono font-bold {{ $reservation->balance_due > 0 ? 'text-amber-800' : 'text-emerald-700' }}">
                        ${{ number_format($reservation->balance_due, 2) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Signature Block -->
        <div class="border-t border-slate-200 mt-12 pt-12 grid grid-cols-2 gap-8 text-center text-xs text-slate-500">
            <div>
                <div class="w-48 border-b border-slate-400 mx-auto mb-2"></div>
                <span>Guest Signature</span>
            </div>
            <div>
                <div class="w-48 border-b border-slate-400 mx-auto mb-2"></div>
                <span>Authorized Front Desk Cashier</span>
            </div>
        </div>
    </div>

</body>
</html>
