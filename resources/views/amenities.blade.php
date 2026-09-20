@extends('layouts.public')

@section('title', 'Resort Amenities & Facilities | Serenity Villa')

@section('content')
<!-- Amenities Hero Header -->
<section class="relative pt-32 pb-20 bg-[#fdfdfd] border-b border-[#e2ded5] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-3">
                Resort Amenities & Facilities
            </span>
            <h1 class="section-title font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-[#161513] tracking-tight leading-[1.1] mb-6">
                Curated for Calm, Craft & Well-Being
            </h1>
            <p class="section-desc text-[#39393b] text-base sm:text-lg leading-relaxed mb-8">
                Every space at Serenity Villa has been thoughtfully curated for slow living and mindful travel. From our secluded saltwater pool nestled among tropical fronds to single-origin Mondulkiri espresso and high-speed fiber internet, enjoy an effortless sanctuary in Siem Reap.
            </p>

            <!-- Quick Highlight Pills -->
            <div class="flex flex-wrap gap-2.5 text-xs text-[#161513]">
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-[#f7f4ec] border border-[#e2ded5] font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#ebbf7d] mr-2"></span> Saltwater Garden Pool
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-[#f7f4ec] border border-[#e2ded5] font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#ebbf7d] mr-2"></span> Artisan Mondulkiri Café
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-[#f7f4ec] border border-[#e2ded5] font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#ebbf7d] mr-2"></span> Herbal Spa Pavilion
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-[#f7f4ec] border border-[#e2ded5] font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#ebbf7d] mr-2"></span> Gigabit Fiber Wi-Fi
                </span>
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-[#f7f4ec] border border-[#e2ded5] font-medium">
                    <span class="w-2 h-2 rounded-full bg-[#ebbf7d] mr-2"></span> Instant Bakong KHQR
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Amenities Showcase with Category Filter -->
<section class="py-20 bg-[#fdfdfd]" x-data="{ activeTab: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-8 border-b border-[#e2ded5] mb-12">
            <div class="flex flex-wrap items-center gap-2">
                <button @click="activeTab = 'all'" 
                        type="button" 
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 cursor-pointer"
                        :class="activeTab === 'all' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#e2ded5]/60'">
                    All Amenities
                </button>
                <button @click="activeTab = 'wellness'" 
                        type="button" 
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 cursor-pointer"
                        :class="activeTab === 'wellness' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#e2ded5]/60'">
                    Wellness & Pool
                </button>
                <button @click="activeTab = 'dining'" 
                        type="button" 
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 cursor-pointer"
                        :class="activeTab === 'dining' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#e2ded5]/60'">
                    Culinary & Café
                </button>
                <button @click="activeTab = 'connectivity'" 
                        type="button" 
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 cursor-pointer"
                        :class="activeTab === 'connectivity' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#e2ded5]/60'">
                    Work & Connectivity
                </button>
                <button @click="activeTab = 'services'" 
                        type="button" 
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-200 cursor-pointer"
                        :class="activeTab === 'services' ? 'bg-[#161513] text-[#ebbf7d] shadow-sm' : 'bg-[#f7f4ec] text-[#39393b] hover:bg-[#e2ded5]/60'">
                    Guest Concierge
                </button>
            </div>

            <div class="text-xs text-[#8c6d3b] font-medium hidden sm:block">
                Complimentary for all in-house guests
            </div>
        </div>

        <!-- Amenities Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- 1. Saltwater Pool -->
            <div x-show="activeTab === 'all' || activeTab === 'wellness'" 
                 x-transition.opacity.duration.300ms
                 class="group rounded-2xl bg-white border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-60 overflow-hidden bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?auto=format&fit=crop&w=1000&q=80" 
                             alt="Saltwater Garden Pool" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full bg-[#161513]/85 text-[#ebbf7d] backdrop-blur-xs">
                            Wellness & Pool
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            Saltwater Garden Pool & Cabanas
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            Immerse yourself in our chlorine-free saltwater pool framed by indigenous ferns, bird-of-paradise blooms, and handcrafted teak sun cabanas.
                        </p>
                        <ul class="space-y-2 text-xs text-stone-600 border-t border-[#e2ded5]/60 pt-4">
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Mineral-rich, skin-friendly saltwater filtration</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Complimentary organic cotton plush beach towels</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Poolside iced lemongrass tea & seasonal fruit skewers</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 text-[11px] text-[#8c6d3b] font-medium">
                    Open daily: 06:00 AM – 21:00 PM
                </div>
            </div>

            <!-- 2. Artisan Cafe -->
            <div x-show="activeTab === 'all' || activeTab === 'dining'" 
                 x-transition.opacity.duration.300ms
                 class="group rounded-2xl bg-white border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-60 overflow-hidden bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1000&q=80" 
                             alt="Artisan Café & Espresso Bar" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full bg-[#161513]/85 text-[#ebbf7d] backdrop-blur-xs">
                            Culinary & Café
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            Mondulkiri Espresso Bar & Garden Café
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            Start mornings with freshly brewed single-origin beans cultivated by highland farmers in Mondulkiri, accompanied by tropical breakfast plates.
                        </p>
                        <ul class="space-y-2 text-xs text-stone-600 border-t border-[#e2ded5]/60 pt-4">
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Single-origin espresso, pour-overs & iced Khmer coffee</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Wholesome tropical smoothie bowls & fresh French baguettes</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Vegetarian, vegan & gluten-free options upon request</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 text-[11px] text-[#8c6d3b] font-medium">
                    Breakfast: 06:30 – 10:30 AM | Café: All Day
                </div>
            </div>

            <!-- 3. Herbal Spa Pavilion -->
            <div x-show="activeTab === 'all' || activeTab === 'wellness'" 
                 x-transition.opacity.duration.300ms
                 class="group rounded-2xl bg-white border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-60 overflow-hidden bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=1000&q=80" 
                             alt="Herbal Aromatherapy Spa" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full bg-[#161513]/85 text-[#ebbf7d] backdrop-blur-xs">
                            Wellness & Spa
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            Herbal Aromatherapy & Khmer Massage
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            Restore tired temple-walking legs in our peaceful garden pavilion with steamed herb bundles, sweet orange blossom, and pure virgin coconut oil.
                        </p>
                        <ul class="space-y-2 text-xs text-stone-600 border-t border-[#e2ded5]/60 pt-4">
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Authentic warm herbal compress body therapy</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Aromatherapy with wild lemongrass & kaffir lime</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>In-room private couple massage appointments available</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 text-[11px] text-[#8c6d3b] font-medium">
                    Appointments: 09:00 AM – 21:00 PM
                </div>
            </div>

            <!-- 4. Fiber Wi-Fi & Work Lounge -->
            <div x-show="activeTab === 'all' || activeTab === 'connectivity'" 
                 x-transition.opacity.duration.300ms
                 class="group rounded-2xl bg-white border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-60 overflow-hidden bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1527192491265-7e15c55b1ed2?auto=format&fit=crop&w=1000&q=80" 
                             alt="High-Speed Wi-Fi & Garden Workspace" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full bg-[#161513]/85 text-[#ebbf7d] backdrop-blur-xs">
                            Work & Connectivity
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            Gigabit Fiber Wi-Fi & Garden Co-Working
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            Stay connected effortlessly with uninterrupted gigabit fiber, ergonomic timber workstations, and shaded outdoor garden power outlets.
                        </p>
                        <ul class="space-y-2 text-xs text-stone-600 border-t border-[#e2ded5]/60 pt-4">
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Symmetrical 1,000 Mbps enterprise fiber optic mesh</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Universal international power sockets & USB-C ports</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Quiet shaded patio corners ideal for Zoom conferences</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 text-[11px] text-[#8c6d3b] font-medium">
                    24/7 Access throughout all rooms and public gardens
                </div>
            </div>

            <!-- 5. Bakong KHQR & Front Desk Concierge -->
            <div x-show="activeTab === 'all' || activeTab === 'services'" 
                 x-transition.opacity.duration.300ms
                 class="group rounded-2xl bg-white border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-60 overflow-hidden bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1000&q=80" 
                             alt="Front Desk Concierge" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full bg-[#161513]/85 text-[#ebbf7d] backdrop-blur-xs">
                            Guest Concierge
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            Bakong KHQR & 24/7 Concierge Desk
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            Seamless Cambodian hospitality with instant mobile cashless payments, secure luggage holding, and personalized sightseeing recommendations.
                        </p>
                        <ul class="space-y-2 text-xs text-stone-600 border-t border-[#e2ded5]/60 pt-4">
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Universal Bakong KHQR QR scan from any Cambodian bank</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>24-hour reception, nighttime keycard entry & security</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Temple pass coordination & licensed guide bookings</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 text-[11px] text-[#8c6d3b] font-medium">
                    Reception staffed 24 hours daily
                </div>
            </div>

            <!-- 6. City Cruiser Bicycle Fleet -->
            <div x-show="activeTab === 'all' || activeTab === 'services'" 
                 x-transition.opacity.duration.300ms
                 class="group rounded-2xl bg-white border border-[#e2ded5] overflow-hidden shadow-xs hover:shadow-xl hover:border-[#ebbf7d]/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="relative h-60 overflow-hidden bg-stone-100">
                        <img src="https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=1000&q=80" 
                             alt="City Cruiser Bicycles" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full bg-[#161513]/85 text-[#ebbf7d] backdrop-blur-xs">
                            Exploration
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl font-bold text-[#161513] mb-2 group-hover:text-[#8c6d3b] transition">
                            Classic City Cruiser Bicycle Fleet
                        </h3>
                        <p class="text-[#39393b] text-sm leading-relaxed mb-4">
                            Glide through the bohemian Wat Bo creative quarter, along the tree-lined riverbanks, or to local market stalls on our comfortable bicycles.
                        </p>
                        <ul class="space-y-2 text-xs text-stone-600 border-t border-[#e2ded5]/60 pt-4">
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Vintage cruiser frames with woven rattan baskets</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Complimentary helmet, combination lock, and bike pump</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-[#8c6d3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Curated offline map with local art galleries and coffee spots</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2 text-[11px] text-[#8c6d3b] font-medium">
                    Available at front desk from sunrise to dusk
                </div>
            </div>
        </div>
    </div>
</section>

<!-- On-Demand Additional Services Catalog (Database-Backed) -->
@if(isset($services) && $services->isNotEmpty())
<section class="py-20 bg-[#f7f4ec] border-y border-[#e2ded5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-reveal-header text-center max-w-3xl mx-auto mb-14">
            <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-2">On-Demand Convenience</span>
            <h2 class="section-title font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight mb-4">
                Tailored Services For Your Stay
            </h2>
            <p class="section-desc text-[#39393b] text-sm sm:text-base leading-relaxed">
                Add these bespoke touches anytime during booking or directly through our front desk concierge while in-house.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="p-6 rounded-2xl bg-white border border-[#e2ded5] shadow-xs hover:border-[#ebbf7d] transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <h3 class="font-bold text-base text-[#161513]">{{ $service->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold font-mono bg-[#f7f4ec] border border-[#e2ded5] text-[#161513] flex-shrink-0">
                                ${{ number_format($service->price, 2) }}
                            </span>
                        </div>
                        <p class="text-xs text-[#39393b] leading-relaxed mb-4">
                            @if(str_contains(strtolower($service->name), 'breakfast'))
                                Freshly baked French pastries, seasonal tropical fruits, eggs cooked to order, and local organic coffee.
                            @elseif(str_contains(strtolower($service->name), 'laundry'))
                                Same-day eco-friendly wash, tumble dry, and press service with botanical lavender infusion.
                            @elseif(str_contains(strtolower($service->name), 'airport'))
                                Hassle-free pickup directly at Siem Reap Angkor International Airport (SAI) by private driver.
                            @elseif(str_contains(strtolower($service->name), 'bicycle'))
                                Full-day lightweight cruiser with helmet, lock, basket, and curated local temple route guide.
                            @elseif(str_contains(strtolower($service->name), 'minibar'))
                                Locally produced craft soda, sparkling mineral water, Angkor beer, and roasted cashew nuts.
                            @elseif(str_contains(strtolower($service->name), 'late'))
                                Enjoy your room until 15:00 PM on departure day, with pool access and luggage holding.
                            @else
                                Handled with care by our dedicated guest hospitality team.
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-[#e2ded5]/60 text-xs text-stone-500">
                        <span class="capitalize text-[11px] font-mono">Unit: {{ str_replace('_', ' ', $service->unit) }}</span>
                        <a href="{{ route('booking.create') }}" class="font-bold text-[#8c6d3b] hover:text-[#161513] inline-flex items-center">
                            <span>Add To Booking &rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="rounded-3xl bg-[#161513] text-[#fdfdfd] p-10 sm:p-16 flex flex-col lg:flex-row items-center justify-between shadow-2xl border border-[#201d1d] relative overflow-hidden">
        <div class="relative z-10 max-w-2xl text-center lg:text-left mb-8 lg:mb-0">
            <span class="text-xs uppercase tracking-widest text-[#ebbf7d] font-bold block mb-3">Direct Guest Privileges</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight mb-4 text-white">
                Experience Scandinavian Serenity in Siem Reap
            </h2>
            <p class="text-[#f2e9cf]/85 text-sm sm:text-base leading-relaxed">
                Reserve directly on our official website to enjoy complimentary welcome drinks, flexible cancellation, and inclusive high-speed amenities.
            </p>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row gap-4 flex-shrink-0">
            <a href="{{ route('rooms.index') }}" class="px-6 py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-white border border-[#e2ded5]/30 hover:border-[#ebbf7d] hover:text-[#ebbf7d] transition-all text-center">
                Explore Rooms
            </a>
            <a href="{{ route('booking.create') }}" class="px-7 py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-lg shadow-black/30 hover:scale-[1.02] active:scale-[0.98] transition-all text-center">
                Reserve Your Stay &rarr;
            </a>
        </div>
    </div>
</section>
@endsection
