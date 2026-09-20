@props([
    'badgeText' => 'New Feature v2.0 Released ->',
    'badgeUrl' => '#features',
    'headlinePrimary' => 'The Autonomous AI Engine',
    'headlineSecondary' => 'for Modern Infrastructure.',
    'subheadline' => 'Deploy intelligent agents, automate real-time hospitality operations, and scale high-throughput neural APIs with microsecond latency and zero cold starts.',
    'primaryCtaText' => 'Get Started Free',
    'primaryCtaUrl' => '#pricing',
    'secondaryCtaText' => 'Read Architecture Doc',
    'secondaryCtaUrl' => '#docs',
    'cliCommand' => 'npm i @nexus/ai-engine',
])

<section id="hero-section" class="relative min-h-screen bg-[#09090b] text-zinc-100 overflow-hidden pt-28 pb-36 selection:bg-indigo-500/30 selection:text-indigo-200">
    <!-- Top Scroll Progress Bar (Driven by Motion.dev) -->
    <div class="fixed top-0 left-0 right-0 h-[2px] bg-zinc-800/60 z-50 pointer-events-none">
        <div id="scroll-progress-bar" class="h-full w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-400 origin-left scale-x-0 transition-transform duration-75"></div>
    </div>

    <!-- Fine Tech Dot Grid Matrix Overlay -->
    <div class="absolute inset-0 z-0 opacity-25 bg-[radial-gradient(#3f3f46_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

    <!-- Top Soft Radial Lighting Sheen -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[420px] bg-radial from-indigo-500/10 via-transparent to-transparent pointer-events-none z-0"></div>

    <!-- Subtle Ambient Glow Mesh (Dynamic Motion.dev Parallax & Scale) -->
    <div id="ambient-glow-mesh" class="absolute top-44 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[720px] sm:w-[920px] h-[480px] sm:h-[580px] bg-gradient-to-tr from-indigo-600/30 via-violet-600/25 to-fuchsia-600/15 blur-[120px] rounded-full pointer-events-none z-0 transition-opacity duration-300"></div>

    <!-- Secondary Under-Card Soft Ambient Glow -->
    <div class="absolute top-[680px] left-1/2 -translate-x-1/2 w-[620px] h-[340px] bg-violet-600/15 blur-[140px] rounded-full pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Content Container -->
        <div class="text-center max-w-4xl mx-auto flex flex-col items-center">
            
            <!-- 1. Pill Badge -->
            <div id="hero-badge" class="mb-8 opacity-0">
                <a href="{{ $badgeUrl }}" class="group relative inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full text-xs font-medium text-zinc-300 bg-zinc-900/80 border border-indigo-500/30 hover:border-indigo-400/60 shadow-[0_0_20px_rgba(99,102,241,0.15)] hover:shadow-[0_0_25px_rgba(99,102,241,0.3)] backdrop-blur-md transition-all duration-300">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="tracking-wide">{{ $badgeText }}</span>
                    <svg class="w-3.5 h-3.5 text-zinc-400 group-hover:text-white group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- 2. Hero Headline with Gradient Text Effect -->
            <h1 id="hero-headline" class="opacity-0 text-5xl sm:text-7xl lg:text-8xl font-extrabold tracking-tight leading-[1.08] mb-6">
                <span class="bg-gradient-to-r from-white via-zinc-200 to-zinc-500 bg-clip-text text-transparent block">
                    {{ $headlinePrimary }}
                </span>
                <span class="bg-gradient-to-r from-indigo-200 via-zinc-100 to-zinc-400 bg-clip-text text-transparent block mt-1 sm:mt-2">
                    {{ $headlineSecondary }}
                </span>
            </h1>

            <!-- 3. Subheadline with Max-Width for Readability -->
            <p id="hero-subheadline" class="opacity-0 max-w-2xl mx-auto text-base sm:text-lg md:text-xl text-zinc-400 font-normal leading-relaxed text-balance mb-10">
                {{ $subheadline }}
            </p>

            <!-- 4. CTA Action Area -->
            <div id="hero-ctas" class="opacity-0 flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                <!-- Primary High-Contrast CTA Button -->
                <a href="{{ $primaryCtaUrl }}" class="w-full sm:w-auto px-7 py-3.5 rounded-xl text-sm font-semibold text-zinc-950 bg-white hover:bg-zinc-100 shadow-[0_0_30px_rgba(255,255,255,0.22)] hover:shadow-[0_0_40px_rgba(255,255,255,0.38)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 group">
                    <span>{{ $primaryCtaText }}</span>
                    <svg class="w-4 h-4 text-zinc-700 group-hover:translate-x-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>

                <!-- Secondary Ghost Button with Hover Border Glow -->
                <a href="{{ $secondaryCtaUrl }}" class="w-full sm:w-auto px-7 py-3.5 rounded-xl text-sm font-medium text-zinc-300 hover:text-white bg-zinc-900/50 hover:bg-zinc-900/80 border border-zinc-800 hover:border-violet-500/60 hover:shadow-[0_0_25px_rgba(139,92,246,0.3)] backdrop-blur-md transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>{{ $secondaryCtaText }}</span>
                </a>
            </div>

            <!-- Terminal Quick-Install Pill with Copy Feedback -->
            <div class="mt-7 inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-zinc-900/40 border border-zinc-800/80 backdrop-blur-md text-xs font-mono text-zinc-400 group"
                 x-data="{ copied: false }">
                <span class="text-indigo-400 select-none">$</span>
                <span class="text-zinc-200">{{ $cliCommand }}</span>
                <button @click="navigator.clipboard.writeText('{{ $cliCommand }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                        type="button" 
                        class="p-1 rounded hover:bg-zinc-800 text-zinc-400 hover:text-zinc-200 transition" 
                        title="Copy to clipboard">
                    <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <svg x-show="copied" x-cloak class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <span x-show="copied" x-cloak class="text-[11px] text-emerald-400 font-sans font-medium">Copied!</span>
            </div>

        </div>

        <!-- 5. Preview Mockup Card Underneath with Glassmorphism -->
        <div class="mt-16 sm:mt-24 relative max-w-6xl mx-auto" x-data="{ activeTab: 'developer' }">
            
            <!-- Floating Parallax Micro-Badges (Driven by Motion.dev scroll) -->
            <div data-parallax-depth="22" class="floating-badge opacity-0 hidden lg:flex absolute -top-8 -left-6 z-20 items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-zinc-900/80 border border-white/10 backdrop-blur-xl shadow-xl shadow-black/40 text-xs font-medium text-zinc-200">
                <div class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.8)]"></div>
                <span>⚡ Latency: <strong>8.4ms</strong> edge</span>
            </div>

            <div data-parallax-depth="30" class="floating-badge opacity-0 hidden lg:flex absolute -top-4 -right-6 z-20 items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-zinc-900/80 border border-white/10 backdrop-blur-xl shadow-xl shadow-black/40 text-xs font-medium text-zinc-200">
                <span class="text-indigo-400">🤖</span>
                <span>Active Agents: <strong>1,482 mesh</strong></span>
            </div>

            <div data-parallax-depth="18" class="floating-badge opacity-0 hidden lg:flex absolute -bottom-6 right-12 z-20 items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-zinc-900/80 border border-white/10 backdrop-blur-xl shadow-xl shadow-black/40 text-xs font-medium text-zinc-200">
                <span class="text-violet-400">🛡️</span>
                <span>Zero-Trust Micro-Enclave</span>
            </div>

            <!-- The Main Glassmorphism Card (Motion.dev 3D Perspective Tilt on Scroll) -->
            <div id="hero-mockup-card" class="opacity-0 relative rounded-2xl sm:rounded-3xl bg-zinc-900/60 backdrop-blur-xl border border-white/10 shadow-[0_20px_70px_rgba(0,0,0,0.7)] shadow-indigo-950/40 overflow-hidden transform-gpu will-change-transform">
                
                <!-- Window Chrome Title Bar -->
                <div class="px-5 py-3.5 bg-zinc-950/70 border-b border-white/10 flex flex-wrap items-center justify-between gap-3">
                    
                    <!-- macOS Traffic Lights & Title -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-rose-500/80 hover:opacity-100 transition cursor-pointer"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/80 hover:opacity-100 transition cursor-pointer"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/80 hover:opacity-100 transition cursor-pointer"></div>
                        </div>

                        <div class="h-4 w-[1px] bg-zinc-800"></div>

                        <div class="flex items-center gap-2 text-xs font-mono text-zinc-400">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            <span class="text-zinc-300 font-semibold">nexus-cluster-v2</span>
                            <span class="text-zinc-600">/</span>
                            <span class="text-zinc-400" x-text="activeTab === 'developer' ? 'mesh-runtime.ts' : 'hotel-yield-agent.py'"></span>
                        </div>
                    </div>

                    <!-- Interactive Mode Switcher Tabs -->
                    <div class="flex items-center p-1 rounded-xl bg-zinc-900 border border-zinc-800 text-xs font-medium">
                        <button @click="activeTab = 'developer'" 
                                :class="activeTab === 'developer' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/30' : 'text-zinc-400 hover:text-zinc-200'"
                                class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Developer Tool / AI SDK</span>
                        </button>
                        <button @click="activeTab = 'hospitality'" 
                                :class="activeTab === 'hospitality' ? 'bg-violet-600 text-white shadow-sm shadow-violet-500/30' : 'text-zinc-400 hover:text-zinc-200'"
                                class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Hotel System AI Engine</span>
                        </button>
                    </div>

                    <!-- Telemetry Health Badges -->
                    <div class="hidden sm:flex items-center gap-3 text-xs">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-mono text-[11px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Live Engine
                        </span>
                        <span class="text-zinc-500 font-mono text-[11px]">tok/s: 184.2</span>
                    </div>

                </div>

                <!-- Window Body / Interactive Code & Telemetry Canvas -->
                <div class="p-6 sm:p-8 bg-zinc-950/40">
                    
                    <!-- TAB 1: DEVELOPER TOOL / AI PRODUCT VIEW -->
                    <div x-show="activeTab === 'developer'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            
                            <!-- Code Editor Section -->
                            <div class="lg:col-span-7 bg-zinc-950/90 rounded-xl border border-zinc-800/80 p-5 font-mono text-xs text-zinc-300 overflow-x-auto shadow-inner leading-relaxed">
                                <div class="flex items-center justify-between pb-3 mb-3 border-b border-zinc-800/60 text-zinc-500 text-[11px]">
                                    <span class="text-zinc-400">typescript // quickstart.ts</span>
                                    <span class="text-indigo-400">nexus v2.4.0</span>
                                </div>
                                <pre class="text-zinc-300"><code><span class="text-purple-400">import</span> { <span class="text-indigo-300">createNexusMesh</span>, <span class="text-indigo-300">AgentOrchestrator</span> } <span class="text-purple-400">from</span> <span class="text-emerald-300">'@nexus/ai-engine'</span>;

<span class="text-zinc-500">// 1. Initialize ultra-low latency neural runtime</span>
<span class="text-purple-400">const</span> mesh = <span class="text-blue-400">await</span> <span class="text-indigo-300">createNexusMesh</span>({
  apiKey: process.env.<span class="text-amber-300">NEXUS_KEY</span>,
  edgeRegion: <span class="text-emerald-300">'auto-optimal'</span>,
  streaming: <span class="text-amber-400">true</span>,
});

<span class="text-zinc-500">// 2. Spin up autonomous multi-agent cluster</span>
<span class="text-purple-400">const</span> cluster = mesh.<span class="text-blue-400">spawnCluster</span>({
  model: <span class="text-emerald-300">'neural-flash-high-v2'</span>,
  consensus: <span class="text-emerald-300">'raft-distributed'</span>,
  maxConcurrency: <span class="text-amber-400">2048</span>,
});

<span class="text-zinc-500">// 3. Stream pipeline events with microsecond precision</span>
mesh.<span class="text-blue-400">onStream</span>((event) => {
  console.<span class="text-blue-400">log</span>(<span class="text-emerald-300">`[Mesh Event] ${event.type}: ${event.latencyMs}ms`</span>);
});</code></pre>
                            </div>

                            <!-- Live Telemetry / Neural Stream Output -->
                            <div class="lg:col-span-5 flex flex-col justify-between space-y-4">
                                
                                <!-- Metric Cards -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-4 rounded-xl bg-zinc-900/50 border border-white/5 backdrop-blur-md">
                                        <div class="text-[11px] text-zinc-400 uppercase tracking-wider mb-1">Time to First Token</div>
                                        <div class="text-2xl font-bold text-white tracking-tight flex items-baseline gap-1.5">
                                            <span>8.4</span>
                                            <span class="text-xs font-normal text-emerald-400">ms</span>
                                        </div>
                                        <div class="text-[11px] text-zinc-500 mt-1">99.8th percentile</div>
                                    </div>

                                    <div class="p-4 rounded-xl bg-zinc-900/50 border border-white/5 backdrop-blur-md">
                                        <div class="text-[11px] text-zinc-400 uppercase tracking-wider mb-1">Throughput</div>
                                        <div class="text-2xl font-bold text-white tracking-tight flex items-baseline gap-1.5">
                                            <span>184.2</span>
                                            <span class="text-xs font-normal text-indigo-400">k req/s</span>
                                        </div>
                                        <div class="text-[11px] text-zinc-500 mt-1">across 32 edge clusters</div>
                                    </div>
                                </div>

                                <!-- Live Stream Event Terminal -->
                                <div class="flex-1 p-4 rounded-xl bg-zinc-950/80 border border-zinc-800/80 font-mono text-[11px] space-y-2">
                                    <div class="flex items-center justify-between text-zinc-500 pb-2 border-b border-zinc-800/50">
                                        <span>LIVE TELEMETRY STREAM</span>
                                        <span class="flex items-center gap-1 text-emerald-400 text-[10px]">
                                            <span class="w-1 h-1 rounded-full bg-emerald-400 animate-ping"></span>
                                            SYNCED
                                        </span>
                                    </div>
                                    <div class="text-zinc-400 flex items-center justify-between">
                                        <span>[17:34:02.102] Agent #1842 spawned</span>
                                        <span class="text-indigo-400">us-east</span>
                                    </div>
                                    <div class="text-zinc-400 flex items-center justify-between">
                                        <span>[17:34:02.115] Raft Consensus verified</span>
                                        <span class="text-emerald-400">0.8ms</span>
                                    </div>
                                    <div class="text-zinc-400 flex items-center justify-between">
                                        <span>[17:34:02.148] Neural Pipeline warm</span>
                                        <span class="text-violet-400">0 cold starts</span>
                                    </div>
                                    <div class="text-zinc-400 flex items-center justify-between">
                                        <span>[17:34:02.190] Vector Embeddings indexed</span>
                                        <span class="text-zinc-300">512k/512k</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- TAB 2: HOTEL SYSTEM AI ENGINE VIEW -->
                    <div x-show="activeTab === 'hospitality'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            
                            <!-- Live Hotel Automation Board -->
                            <div class="lg:col-span-7 bg-zinc-950/90 rounded-xl border border-zinc-800/80 p-5 font-mono text-xs text-zinc-300 space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-zinc-800/60">
                                    <div class="flex items-center gap-2">
                                        <span class="text-amber-400">🏨 Hotel Intelligence Node:</span>
                                        <span class="text-zinc-200 font-semibold">Serenity Villa Siem Reap</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-300 border border-amber-500/20 text-[10px]">AI COPILOT</span>
                                </div>

                                <div class="space-y-3 font-sans">
                                    <div class="p-3 rounded-lg bg-zinc-900/70 border border-zinc-800 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-xs">R104</div>
                                            <div>
                                                <div class="text-zinc-200 font-semibold text-xs">Deluxe Pool Villa #104</div>
                                                <div class="text-zinc-400 text-[11px]">Guest: Jean Dupont (Check-in 14:00)</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Auto Room Ready</span>
                                            <div class="text-[10px] text-zinc-500 mt-0.5">AC pre-cooled to 23°C</div>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-lg bg-zinc-900/70 border border-zinc-800 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-violet-500/20 text-violet-400 flex items-center justify-center font-bold text-xs">KHQR</div>
                                            <div>
                                                <div class="text-zinc-200 font-semibold text-xs">Instant Settlement Engine</div>
                                                <div class="text-zinc-400 text-[11px]">Bakong QR verification webhook</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Auto Reconciled</span>
                                            <div class="text-[10px] text-zinc-500 mt-0.5">Tx: KHQR-7E9381 • $140.00</div>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-lg bg-zinc-900/70 border border-zinc-800 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-xs">YIELD</div>
                                            <div>
                                                <div class="text-zinc-200 font-semibold text-xs">Predictive Yield Optimization</div>
                                                <div class="text-zinc-400 text-[11px]">Angkor Wat high-season demand spike detected</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">+18% RevPAR</span>
                                            <div class="text-[10px] text-zinc-500 mt-0.5">Auto-adjusted 12 room prices</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Realtime Hotel Analytics -->
                            <div class="lg:col-span-5 flex flex-col justify-between space-y-4 font-mono text-xs">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-4 rounded-xl bg-zinc-900/50 border border-white/5">
                                        <div class="text-[11px] text-zinc-400 uppercase">Live Occupancy</div>
                                        <div class="text-2xl font-bold text-emerald-400 font-sans tracking-tight">94.8%</div>
                                        <div class="text-[11px] text-zinc-500 mt-1">28/30 suites occupied</div>
                                    </div>
                                    <div class="p-4 rounded-xl bg-zinc-900/50 border border-white/5">
                                        <div class="text-[11px] text-zinc-400 uppercase">Guest Satisfaction</div>
                                        <div class="text-2xl font-bold text-amber-400 font-sans tracking-tight">4.96 <span class="text-xs text-zinc-400 font-normal">/5</span></div>
                                        <div class="text-[11px] text-zinc-500 mt-1">Autonomous concierge</div>
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl bg-zinc-950/80 border border-zinc-800/80 text-[11px] space-y-2">
                                    <div class="flex items-center justify-between text-zinc-400 border-b border-zinc-800/50 pb-2">
                                        <span>AUTONOMOUS DISPATCH LOG</span>
                                        <span class="text-violet-400 font-sans font-bold">24/7 ACTIVE</span>
                                    </div>
                                    <div class="text-zinc-400">→ Guest asked: "Airport tuk-tuk pickup at 08:30"</div>
                                    <div class="text-emerald-400">✓ AI dispatched Driver Sokha (Plate: 2A-9812)</div>
                                    <div class="text-zinc-400">→ Automated WhatsApp confirmation sent to guest</div>
                                    <div class="text-indigo-300">✓ Folio updated: +$15.00 Transportation service</div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Subtle Bottom Sheen Inside Card -->
                <div class="h-1 w-full bg-gradient-to-r from-transparent via-indigo-500/40 to-transparent"></div>

            </div>

        </div>

    </div>
</section>
