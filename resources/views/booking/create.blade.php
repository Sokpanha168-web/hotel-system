@extends('layouts.public')

@section('title', 'Complete Your Reservation - Serenity Villa')

@section('content')
<!-- Top Banner -->
<div class="bg-[#161513] text-white py-12 border-b border-[#e2ded5]/20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs uppercase tracking-widest text-[#ebbf7d] font-bold block mb-1">Direct Reservation</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#fdfdfd] mb-2">Guest Reservation</h1>
        <p class="text-stone-300 text-sm">Please provide guest details and travel dates to secure your room.</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
     x-data="bookingForm({
        initialRoomTypeId: {{ $selectedRoomType->id ?? 1 }},
        roomTypes: {{ Js::from($allRoomTypes) }},
        services: {{ Js::from($services) }},
        checkIn: '{{ $checkIn }}',
        checkOut: '{{ $checkOut }}',
        calculateUrl: '{{ route('booking.calculate') }}',
        csrfToken: '{{ csrf_token() }}'
     })"
     x-init="calculate()">

    @if ($errors->any())
        <div class="mb-8 p-6 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900">
            <h4 class="font-bold text-sm mb-2 flex items-center space-x-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Please correct the following errors:</span>
            </h4>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        @csrf

        @if($selectedRoom)
            <input type="hidden" name="room_id" value="{{ $selectedRoom->id }}">
        @endif

        <!-- Left Column: Form Fields -->
        <div class="lg:col-span-7 space-y-8">
            <!-- 1. Guest Information Card -->
            <div class="bg-white rounded-2xl border border-[#e2ded5] p-6 sm:p-8 shadow-xs">
                <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-[#e2ded5]/60">
                    <span class="w-7 h-7 rounded-full bg-[#161513] text-[#ebbf7d] text-xs font-bold flex items-center justify-center border border-[#e2ded5]/40">1</span>
                    <h2 class="text-lg font-bold text-[#161513]">Guest Information</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label for="full_name" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">
                            Full Legal Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               value="{{ old('full_name') }}" 
                               required 
                               placeholder="e.g. Johnathan Smith"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">
                            Phone Number <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required 
                               placeholder="e.g. +855 12 345 678"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">
                            Email Address (Optional)
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="john@example.com"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="national_id_or_passport" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">
                            Passport / National ID Number <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="national_id_or_passport" 
                               name="national_id_or_passport" 
                               value="{{ old('national_id_or_passport') }}" 
                               required 
                               placeholder="e.g. N12345678 or ID-998877"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                        <p class="text-[11px] text-stone-500 mt-1">Required for hospitality guest verification and local guest registry.</p>
                    </div>
                </div>
            </div>

            <!-- 2. Stay Dates & Room Selection -->
            <div class="bg-white rounded-2xl border border-[#e2ded5] p-6 sm:p-8 shadow-xs">
                <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-[#e2ded5]/60">
                    <span class="w-7 h-7 rounded-full bg-[#161513] text-[#ebbf7d] text-xs font-bold flex items-center justify-center border border-[#e2ded5]/40">2</span>
                    <h2 class="text-lg font-bold text-[#161513]">Room & Dates</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="check_in_date" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">
                            Check-in Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" 
                               id="check_in_date" 
                               name="check_in_date" 
                               x-model="checkIn"
                               @change="calculate()"
                               min="{{ date('Y-m-d') }}"
                               required 
                               class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm font-medium focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <div>
                        <label for="check_out_date" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">
                            Check-out Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" 
                               id="check_out_date" 
                               name="check_out_date" 
                               x-model="checkOut"
                               @change="calculate()"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               required 
                               class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm font-medium focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="room_type_id" class="block text-xs font-bold uppercase tracking-wider text-[#39393b] mb-1.5">
                            Room Category <span class="text-rose-500">*</span>
                        </label>
                        <select id="room_type_id" 
                                name="room_type_id" 
                                x-model="selectedRoomTypeId"
                                @change="calculate()"
                                required 
                                class="w-full px-4 py-2.5 rounded-xl border border-[#e2ded5] text-sm font-medium focus:ring-2 focus:ring-[#ebbf7d] focus:border-[#ebbf7d]">
                            @foreach($allRoomTypes as $rt)
                                <option value="{{ $rt->id }}" {{ ($selectedRoomType->id ?? 0) == $rt->id ? 'selected' : '' }}>
                                    {{ $rt->name }} (${{ number_format($rt->base_price, 2) }}/night, max {{ $rt->capacity }} guests)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Room Availability Live Feedback -->
                <div x-show="availableCount !== null" class="p-3 rounded-xl text-xs font-medium" 
                     :class="availableCount > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200'">
                    <template x-if="availableCount > 0">
                        <span class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span x-text="availableCount + ' rooms available for these dates.'"></span>
                        </span>
                    </template>
                    <template x-if="availableCount === 0">
                        <span class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Sold out! Please pick alternative dates or room categories.</span>
                        </span>
                    </template>
                </div>
            </div>

            <!-- 3. Add-on Services Selection -->
            <div class="bg-white rounded-2xl border border-[#e2ded5] p-6 sm:p-8 shadow-xs">
                <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-[#e2ded5]/60">
                    <span class="w-7 h-7 rounded-full bg-[#161513] text-[#ebbf7d] text-xs font-bold flex items-center justify-center border border-[#e2ded5]/40">3</span>
                    <h2 class="text-lg font-bold text-[#161513]">Enhance Your Stay (Optional)</h2>
                </div>

                <div class="space-y-4">
                    @foreach($services as $index => $service)
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-[#e2ded5] hover:border-[#ebbf7d] transition bg-[#f7f4ec]/40">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" 
                                       id="service_{{ $service->id }}" 
                                       name="services[{{ $index }}][id]" 
                                       value="{{ $service->id }}"
                                       @change="toggleService({{ $service->id }}, $event.target.checked); calculate()"
                                       class="w-4 h-4 text-[#161513] rounded border-[#e2ded5] focus:ring-[#ebbf7d]">
                                <label for="service_{{ $service->id }}" class="cursor-pointer">
                                    <span class="block text-sm font-semibold text-[#161513]">{{ $service->name }}</span>
                                    <span class="text-xs text-[#39393b]">${{ number_format($service->price, 2) }} / {{ str_replace('_', ' ', $service->unit) }}</span>
                                </label>
                            </div>

                            <div class="flex items-center space-x-2" x-show="selectedServices.includes({{ $service->id }})">
                                <label class="text-xs text-[#39393b] font-medium">Qty:</label>
                                <input type="number" 
                                       name="services[{{ $index }}][quantity]" 
                                       value="1" 
                                       min="1" 
                                       max="20"
                                       @input="updateServiceQty({{ $service->id }}, $event.target.value); calculate()"
                                       class="w-16 px-2.5 py-1 text-center border border-[#e2ded5] rounded-lg text-sm font-medium">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. Payment Method -->
            <div class="bg-white rounded-2xl border border-[#e2ded5] p-6 sm:p-8 shadow-xs">
                <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-[#e2ded5]/60">
                    <span class="w-7 h-7 rounded-full bg-[#161513] text-[#ebbf7d] text-xs font-bold flex items-center justify-center border border-[#e2ded5]/40">4</span>
                    <h2 class="text-lg font-bold text-[#161513]">Payment Preference</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="relative flex flex-col p-4 rounded-xl border border-[#e2ded5] cursor-pointer hover:border-[#ebbf7d] transition has-[:checked]:border-[#ebbf7d] has-[:checked]:bg-[#f7f4ec]">
                        <input type="radio" name="payment_method" value="khqr_transfer" checked class="text-[#161513] focus:ring-[#ebbf7d]">
                        <span class="text-sm font-bold text-[#161513] mt-2 block">Bakong KHQR</span>
                        <span class="text-[11px] text-[#39393b]">Scan & Pay via Mobile Banking</span>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-xl border border-[#e2ded5] cursor-pointer hover:border-[#ebbf7d] transition has-[:checked]:border-[#ebbf7d] has-[:checked]:bg-[#f7f4ec]">
                        <input type="radio" name="payment_method" value="cash" class="text-[#161513] focus:ring-[#ebbf7d]">
                        <span class="text-sm font-bold text-[#161513] mt-2 block">Pay at Check-in</span>
                        <span class="text-[11px] text-[#39393b]">Cash (USD or KHR) upon arrival</span>
                    </label>

                    <label class="relative flex flex-col p-4 rounded-xl border border-[#e2ded5] cursor-pointer hover:border-[#ebbf7d] transition has-[:checked]:border-[#ebbf7d] has-[:checked]:bg-[#f7f4ec]">
                        <input type="radio" name="payment_method" value="card" class="text-[#161513] focus:ring-[#ebbf7d]">
                        <span class="text-sm font-bold text-[#161513] mt-2 block">Credit / Debit Card</span>
                        <span class="text-[11px] text-[#39393b]">Visa / Mastercard at desk</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right Column: Live Summary Card -->
        <div class="lg:col-span-5">
            <div class="sticky top-28 bg-white rounded-2xl border border-[#e2ded5] shadow-lg p-6 sm:p-8 space-y-6">
                <div class="border-b border-[#e2ded5]/60 pb-4">
                    <h3 class="font-serif text-xl font-bold text-[#161513]">Reservation Summary</h3>
                    <p class="text-xs text-[#39393b] mt-1">Live calculation of your planned stay</p>
                </div>

                <div class="space-y-3.5 text-sm">
                    <div class="flex justify-between items-center text-[#39393b]">
                        <span>Duration</span>
                        <span class="font-semibold text-[#161513]" x-text="nights + ' ' + (nights === 1 ? 'Night' : 'Nights')"></span>
                    </div>

                    <div class="flex justify-between items-center text-[#39393b]">
                        <span>Room Rate</span>
                        <span class="font-semibold text-[#161513]" x-text="'$' + basePrice.toFixed(2) + ' / night'"></span>
                    </div>

                    <div class="flex justify-between items-center text-[#39393b]">
                        <span>Room Subtotal</span>
                        <span class="font-semibold text-[#161513]" x-text="'$' + roomTotal.toFixed(2)"></span>
                    </div>

                    <div class="flex justify-between items-center text-[#39393b]" x-show="servicesTotal > 0">
                        <span>Add-on Services</span>
                        <span class="font-semibold text-[#161513]" x-text="'$' + servicesTotal.toFixed(2)"></span>
                    </div>

                    <div class="pt-4 border-t border-[#e2ded5] flex justify-between items-baseline">
                        <div>
                            <span class="text-base font-bold text-[#161513] block">Total Amount</span>
                            <span class="text-[11px] text-stone-500">Taxes & service charge included</span>
                        </div>
                        <span class="text-3xl font-serif font-bold text-[#161513]" x-text="'$' + grandTotal.toFixed(2)"></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        :disabled="availableCount === 0"
                        class="w-full py-4 px-6 rounded-xl font-bold text-sm text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-sm hover:shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Confirm & Place Reservation &rarr;
                </button>

                <p class="text-center text-[11px] text-[#39393b]/70 leading-relaxed">
                    By clicking Confirm, you agree to Serenity Villa Guest House's terms, check-in policies, and privacy guidelines.
                </p>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function bookingForm(config) {
    return {
        selectedRoomTypeId: config.initialRoomTypeId,
        roomTypes: config.roomTypes,
        services: config.services,
        checkIn: config.checkIn,
        checkOut: config.checkOut,
        selectedServices: [],
        serviceQuantities: {},
        nights: 1,
        basePrice: 0.00,
        roomTotal: 0.00,
        servicesTotal: 0.00,
        grandTotal: 0.00,
        availableCount: null,

        toggleService(id, isChecked) {
            if (isChecked) {
                if (!this.selectedServices.includes(id)) {
                    this.selectedServices.push(id);
                    if (!this.serviceQuantities[id]) {
                        this.serviceQuantities[id] = 1;
                    }
                }
            } else {
                this.selectedServices = this.selectedServices.filter(sId => sId !== id);
            }
        },

        updateServiceQty(id, qty) {
            this.serviceQuantities[id] = Math.max(1, parseInt(qty) || 1);
        },

        calculate() {
            const currentType = this.roomTypes.find(t => t.id == this.selectedRoomTypeId);
            if (currentType) {
                this.basePrice = parseFloat(currentType.base_price);
            }

            const inDate = new Date(this.checkIn);
            const outDate = new Date(this.checkOut);
            const diffTime = outDate - inDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            this.nights = diffDays > 0 ? diffDays : 1;

            const servicePayload = this.selectedServices.map(id => ({
                id: id,
                quantity: this.serviceQuantities[id] || 1
            }));

            fetch(config.calculateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': config.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    room_type_id: this.selectedRoomTypeId,
                    check_in: this.checkIn,
                    check_out: this.checkOut,
                    services: servicePayload
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.grand_total !== undefined) {
                    this.nights = data.nights;
                    this.basePrice = data.base_price;
                    this.roomTotal = data.room_total;
                    this.servicesTotal = data.services_total;
                    this.grandTotal = data.grand_total;
                    this.availableCount = data.available_count;
                }
            })
            .catch(err => {
                console.error('Calculation error:', err);
                this.roomTotal = this.nights * this.basePrice;
                this.grandTotal = this.roomTotal;
            });
        }
    }
}
</script>
@endpush
@endsection
