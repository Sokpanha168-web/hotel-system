@extends('layouts.public')

@section('title', 'The Experience & Excursions | Serenity Villa')

@section('content')
<!-- Experience Hero Header -->
<section class="relative pt-32 pb-20 bg-[#fdfdfd] border-b border-[#e2ded5] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-3">
                The Serenity Experience
            </span>
            <h1 class="section-title font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-[#161513] tracking-tight leading-[1.1] mb-6">
                The Soul of Siem Reap & Slow Luxury Living
            </h1>
            <p class="section-desc text-[#39393b] text-base sm:text-lg leading-relaxed mb-8">
                Beyond a boutique room, Serenity Villa invites you into the authentic rhythm of Cambodia. From privileged pre-dawn temple sunrises with licensed historians to culinary market walks and sunset meditation, discover memories crafted with genuine warmth.
            </p>

            <div class="flex flex-wrap gap-3">
                <a href="#signature-excursions" class="px-6 py-3 rounded-full font-bold text-xs uppercase tracking-wider text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-sm transition">
                    Explore Curated Journeys
                </a>
                <a href="#itinerary" class="px-6 py-3 rounded-full font-bold text-xs uppercase tracking-wider text-[#161513] bg-[#f7f4ec] hover:bg-[#e2ded5] border border-[#e2ded5] transition">
                    A Day at Serenity Villa
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Signature Curated Excursions (Editorial Split Layout) -->
<section id="signature-excursions" class="py-24 bg-[#fdfdfd]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-reveal-header max-w-3xl mb-16">
            <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-2">Bespoke Journeys</span>
            <h2 class="section-title font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight mb-4">
                Signature Private Excursions
            </h2>
            <p class="section-desc text-[#39393b] text-base leading-relaxed">
                Tailored journeys arranged exclusively for our guests with private drivers, licensed temple archaeologists, and thoughtful amenities.
            </p>
        </div>

        <div class="space-y-20">
            <!-- 01. Sacred Dawn at Angkor Wat -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-3xl overflow-hidden shadow-lg border border-[#e2ded5] aspect-[4/3] bg-stone-100 group">
                    <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?auto=format&fit=crop&w=1200&q=80" 
                         alt="Angkor Wat Sunrise" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <span class="absolute top-6 left-6 text-xs uppercase font-bold tracking-widest px-3.5 py-1.5 rounded-full bg-[#161513]/90 text-[#ebbf7d] backdrop-blur-xs">
                        Signature 01
                    </span>
                </div>
                <div class="space-y-6">
                    <span class="text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block">Heritage & Archaeology</span>
                    <h3 class="font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight">
                        Sacred Dawn at Angkor Wat
                    </h3>
                    <p class="text-[#39393b] text-sm sm:text-base leading-relaxed">
                        Depart softly under the starry pre-dawn sky in a private traditional remork. Avoid the standard tour bus crowds as our veteran local archaeologist leads you to private vantage spots as the lotus reflections illuminate in golden dawn splendor.
                    </p>
                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-[#e2ded5] text-xs text-stone-700">
                        <div>
                            <span class="text-[#8c6d3b] font-bold block mb-1">Departure</span>
                            <span>04:45 AM from lobby</span>
                        </div>
                        <div>
                            <span class="text-[#8c6d3b] font-bold block mb-1">Included</span>
                            <span>Chef's breakfast basket & iced coffee</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('booking.create') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#161513] hover:text-[#8c6d3b] group">
                            <span>Reserve With Concierge</span>
                            <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 02. Wat Bo Artisan Culinary Masterclass -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="lg:order-2 relative rounded-3xl overflow-hidden shadow-lg border border-[#e2ded5] aspect-[4/3] bg-stone-100 group">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80" 
                         alt="Khmer Culinary Masterclass" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <span class="absolute top-6 left-6 text-xs uppercase font-bold tracking-widest px-3.5 py-1.5 rounded-full bg-[#161513]/90 text-[#ebbf7d] backdrop-blur-xs">
                        Signature 02
                    </span>
                </div>
                <div class="lg:order-1 space-y-6">
                    <span class="text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block">Culinary Arts</span>
                    <h3 class="font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight">
                        Artisan Khmer Cooking Masterclass
                    </h3>
                    <p class="text-[#39393b] text-sm sm:text-base leading-relaxed">
                        Journey through the lively local morning market with our head chef to hand-select fresh kaffir lime, galangal, organic turmeric, and river fish. Return to our open garden kitchen to craft authentic fish amok and green mango salads.
                    </p>
                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-[#e2ded5] text-xs text-stone-700">
                        <div>
                            <span class="text-[#8c6d3b] font-bold block mb-1">Duration</span>
                            <span>3.5 Hours (Morning or Afternoon)</span>
                        </div>
                        <div>
                            <span class="text-[#8c6d3b] font-bold block mb-1">Includes</span>
                            <span>Market tour, 3-course feast & recipe book</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('booking.create') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#161513] hover:text-[#8c6d3b] group">
                            <span>Inquire During Reservation</span>
                            <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 03. Floating Villages of Tonle Sap -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-3xl overflow-hidden shadow-lg border border-[#e2ded5] aspect-[4/3] bg-stone-100 group">
                    <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=1200&q=80" 
                         alt="Tonle Sap Floating Village" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <span class="absolute top-6 left-6 text-xs uppercase font-bold tracking-widest px-3.5 py-1.5 rounded-full bg-[#161513]/90 text-[#ebbf7d] backdrop-blur-xs">
                        Signature 03
                    </span>
                </div>
                <div class="space-y-6">
                    <span class="text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block">Waterways & Culture</span>
                    <h3 class="font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight">
                        Golden Hour on Tonlé Sap Biosphere
                    </h3>
                    <p class="text-[#39393b] text-sm sm:text-base leading-relaxed">
                        Navigate the flooded mangrove forests and stilted houses of Kampong Phluk by private wooden longtail boat. Witness the traditional aquatic rhythm of fishermen and children paddling wooden canoes under an amber sunset sky.
                    </p>
                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-[#e2ded5] text-xs text-stone-700">
                        <div>
                            <span class="text-[#8c6d3b] font-bold block mb-1">Departure</span>
                            <span>14:30 PM from villa</span>
                        </div>
                        <div>
                            <span class="text-[#8c6d3b] font-bold block mb-1">Experience</span>
                            <span>Private boat, chilled drinks & sunset view</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('booking.create') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#161513] hover:text-[#8c6d3b] group">
                            <span>Book With Front Desk</span>
                            <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline: A Day at Serenity Villa -->
<section id="itinerary" class="py-24 bg-[#f7f4ec] border-y border-[#e2ded5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-reveal-header text-center max-w-3xl mx-auto mb-16">
            <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block mb-2">Slow Luxury Living</span>
            <h2 class="section-title font-serif text-3xl sm:text-4xl font-bold text-[#161513] tracking-tight mb-4">
                A Day in Tranquil Serenity
            </h2>
            <p class="section-desc text-[#39393b] text-base leading-relaxed">
                How our guests unwind from morning birdsong to candlelit tropical nights.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Morning -->
            <div class="p-6 rounded-2xl bg-white border border-[#e2ded5] shadow-xs flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs font-bold text-[#8c6d3b] block mb-2">06:30 – 08:30 AM</span>
                    <h3 class="font-serif text-lg font-bold text-[#161513] mb-2">Sunrise & Artisan Breakfast</h3>
                    <p class="text-xs text-[#39393b] leading-relaxed">
                        Awaken to gentle bird calls, sip hand-dripped Mondulkiri coffee on your private garden terrace, and savor fresh tropical fruit bowls.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-[#e2ded5]/60 text-[11px] text-[#8c6d3b] font-medium">
                    Terrace Dining
                </div>
            </div>

            <!-- Midday -->
            <div class="p-6 rounded-2xl bg-white border border-[#e2ded5] shadow-xs flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs font-bold text-[#8c6d3b] block mb-2">11:00 AM – 02:00 PM</span>
                    <h3 class="font-serif text-lg font-bold text-[#161513] mb-2">Poolside Respite & Books</h3>
                    <p class="text-xs text-[#39393b] leading-relaxed">
                        Dip into the refreshing saltwater pool, read in a shaded teak cabana, or enjoy gigabit fiber Wi-Fi in the garden co-working sala.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-[#e2ded5]/60 text-[11px] text-[#8c6d3b] font-medium">
                    Garden Saltwater Pool
                </div>
            </div>

            <!-- Afternoon -->
            <div class="p-6 rounded-2xl bg-white border border-[#e2ded5] shadow-xs flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs font-bold text-[#8c6d3b] block mb-2">03:30 – 05:30 PM</span>
                    <h3 class="font-serif text-lg font-bold text-[#161513] mb-2">Wat Bo Village Cycling</h3>
                    <p class="text-xs text-[#39393b] leading-relaxed">
                        Take our complimentary vintage cruiser bicycles to explore nearby art studios, ceramic ateliers, and ancient Wat Bo pagoda murals.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-[#e2ded5]/60 text-[11px] text-[#8c6d3b] font-medium">
                    Wat Bo Creative Quarter
                </div>
            </div>

            <!-- Evening -->
            <div class="p-6 rounded-2xl bg-white border border-[#e2ded5] shadow-xs flex flex-col justify-between">
                <div>
                    <span class="font-mono text-xs font-bold text-[#8c6d3b] block mb-2">07:00 – 10:00 PM</span>
                    <h3 class="font-serif text-lg font-bold text-[#161513] mb-2">Herbal Massage & Night Calm</h3>
                    <p class="text-xs text-[#39393b] leading-relaxed">
                        Conclude the day with a steamed lemongrass herbal massage in the spa pavilion, followed by deep sleep in 400-thread-count linens.
                    </p>
                </div>
                <div class="mt-6 pt-3 border-t border-[#e2ded5]/60 text-[11px] text-[#8c6d3b] font-medium">
                    Spa Pavilion & En-Suite
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Neighborhood Location Guide -->
<section class="py-20 bg-[#fdfdfd]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
            <div class="lg:col-span-1 space-y-4">
                <span class="section-eyebrow text-xs uppercase tracking-widest text-[#8c6d3b] font-bold block">Prime Neighborhood</span>
                <h2 class="font-serif text-3xl font-bold text-[#161513] tracking-tight">
                    In the Heart of Wat Bo Village
                </h2>
                <p class="text-[#39393b] text-sm leading-relaxed">
                    Voted Siem Reap's coolest neighborhood, Wat Bo blends centuries-old monastery heritage with chic indie cafés, galleries, and quiet leafy lanes.
                </p>
                <div class="pt-2">
                    <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#8c6d3b] hover:text-[#161513]">
                        <span>Open In Google Maps &rarr;</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-5 rounded-2xl bg-[#f7f4ec] border border-[#e2ded5]">
                    <div class="font-mono text-xl font-bold text-[#161513] mb-1">15 mins</div>
                    <div class="text-xs font-bold text-[#161513]">Angkor Wat Archaeological Park</div>
                    <div class="text-[11px] text-stone-500 mt-1">Convenient remork or taxi ride to all major temple circuits.</div>
                </div>
                <div class="p-5 rounded-2xl bg-[#f7f4ec] border border-[#e2ded5]">
                    <div class="font-mono text-xl font-bold text-[#161513] mb-1">2 mins</div>
                    <div class="text-xs font-bold text-[#161513]">Siem Reap Riverfront Promenade</div>
                    <div class="text-[11px] text-stone-500 mt-1">Peaceful riverside morning strolls and shaded pedestrian pathways.</div>
                </div>
                <div class="p-5 rounded-2xl bg-[#f7f4ec] border border-[#e2ded5]">
                    <div class="font-mono text-xl font-bold text-[#161513] mb-1">5 mins</div>
                    <div class="text-xs font-bold text-[#161513]">Old Market & Night Bazaar</div>
                    <div class="text-[11px] text-stone-500 mt-1">Bustling silk shops, street cuisine, and souvenir boutiques.</div>
                </div>
                <div class="p-5 rounded-2xl bg-[#f7f4ec] border border-[#e2ded5]">
                    <div class="font-mono text-xl font-bold text-[#161513] mb-1">45 mins</div>
                    <div class="text-xs font-bold text-[#161513]">Siem Reap International Airport (SAI)</div>
                    <div class="text-[11px] text-stone-500 mt-1">Direct airport transfer service coordinated by front desk.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="rounded-3xl bg-[#161513] text-[#fdfdfd] p-10 sm:p-16 flex flex-col lg:flex-row items-center justify-between shadow-2xl border border-[#201d1d] relative overflow-hidden">
        <div class="relative z-10 max-w-2xl text-center lg:text-left mb-8 lg:mb-0">
            <span class="text-xs uppercase tracking-widest text-[#ebbf7d] font-bold block mb-3">Begin Your Story</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight mb-4 text-white">
                Reserve Your Boutique Stay in Siem Reap
            </h2>
            <p class="text-[#f2e9cf]/85 text-sm sm:text-base leading-relaxed">
                Immerse yourself in serenity with handcrafted breakfasts, warm hospitality, and unforgettable temple dawns.
            </p>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row gap-4 flex-shrink-0">
            <a href="{{ route('rooms.index') }}" class="px-6 py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-white border border-[#e2ded5]/30 hover:border-[#ebbf7d] hover:text-[#ebbf7d] transition-all text-center">
                Explore Rooms
            </a>
            <a href="{{ route('booking.create') }}" class="px-7 py-3.5 rounded-full font-bold text-xs uppercase tracking-wider text-[#161513] bg-[#ebbf7d] hover:bg-[#deaf6b] shadow-lg shadow-black/30 hover:scale-[1.02] active:scale-[0.98] transition-all text-center">
                Book Your Experience &rarr;
            </a>
        </div>
    </div>
</section>
@endsection
