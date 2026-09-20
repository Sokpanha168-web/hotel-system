<!DOCTYPE html>
<html lang="en" class="h-full bg-[#09090b] text-zinc-100 scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexusAI — Next-Generation Autonomous AI Engine & Platform</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jet-brains-mono:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #09090b;
        }
        pre, code, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-[#09090b] text-zinc-100 antialiased selection:bg-indigo-500/30 selection:text-indigo-200" x-data="{ mobileMenu: false }">

    <!-- Top Floating Navbar -->
    <header class="sticky top-0 z-40 bg-[#09090b]/80 backdrop-blur-xl border-b border-white/5 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('hero.showcase') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-violet-600 to-purple-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/25 group-hover:shadow-indigo-500/40 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-lg tracking-tight text-white group-hover:text-zinc-200 transition">NexusAI</span>
                            <span class="text-[10px] uppercase font-mono px-2 py-0.5 rounded-full bg-indigo-500/15 text-indigo-400 border border-indigo-500/30">v2.4</span>
                        </div>
                        <span class="text-[11px] text-zinc-500 block leading-tight">Autonomous Neural Engine</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-zinc-400">
                    <a href="#features" class="hover:text-white transition">Features</a>
                    <a href="#benchmarks" class="hover:text-white transition">Benchmarks</a>
                    <a href="#architecture" class="hover:text-white transition">Architecture</a>
                    <a href="{{ route('home') }}" class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-zinc-900 border border-zinc-800 text-zinc-300 hover:text-amber-300 hover:border-amber-500/40 transition">
                        <span>🏨 Hotel System Guest Portal</span>
                    </a>
                </nav>

                <!-- Actions -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="https://github.com" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-zinc-400 hover:text-white bg-zinc-900/60 hover:bg-zinc-900 border border-zinc-800 rounded-lg transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                        <span>Star 14.8k</span>
                    </a>

                    <a href="#demo" class="px-4 py-2 text-xs font-semibold text-zinc-950 bg-white hover:bg-zinc-200 rounded-lg shadow-sm hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all">
                        Launch Engine
                    </a>
                </div>

                <!-- Mobile Menu Hamburger -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" type="button" class="p-2 rounded-lg text-zinc-400 hover:text-white hover:bg-zinc-800">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-cloak class="md:hidden border-b border-zinc-800 bg-[#09090b] px-4 py-5 space-y-3">
            <a href="#features" class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800">Features</a>
            <a href="#benchmarks" class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800">Benchmarks</a>
            <a href="#architecture" class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800">Architecture</a>
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-amber-400 bg-amber-500/10 border border-amber-500/20">Go to Hotel System</a>
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section Component -->
        <x-hero-section 
            badgeText="New Feature v2.0 Released ->"
            badgeUrl="#features"
            headlinePrimary="The Autonomous AI Engine"
            headlineSecondary="for Modern Infrastructure."
            subheadline="Deploy intelligent agents, automate real-time hospitality workflows, and scale high-throughput neural APIs with microsecond latency and zero cold starts."
            primaryCtaText="Get Started Free"
            primaryCtaUrl="#pricing"
            secondaryCtaText="Read Architecture Doc"
            secondaryCtaUrl="#docs"
            cliCommand="npm i @nexus/ai-engine"
        />

        <!-- Secondary Showcase Section (Highlights Motion.dev Scroll Unfolding) -->
        <section id="features" class="relative py-28 bg-[#09090b] border-t border-white/5 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-mono text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 mb-4">
                        <span>ARCHITECTURE SPECS</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-bold tracking-tight text-white mb-5">
                        Engineered for High Throughput & Zero Cold Starts
                    </h2>
                    <p class="text-zinc-400 text-base sm:text-lg">
                        Everything you need to orchestrate autonomous AI workloads, real-time event streams, and edge data synchronization in production.
                    </p>
                </div>

                <!-- Feature Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Card 1 -->
                    <div class="p-8 rounded-2xl bg-zinc-900/40 border border-white/5 hover:border-indigo-500/40 hover:shadow-[0_0_30px_rgba(99,102,241,0.15)] transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-600/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 group-hover:bg-indigo-600/20 transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Microsecond Edge Routing</h3>
                            <p class="text-sm text-zinc-400 leading-relaxed">
                                Distributed Raft consensus and state hydration across 32 worldwide edge nodes, cutting P99 latency below 10 milliseconds.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-800/60 flex items-center text-xs text-indigo-400 font-mono">
                            <span>p99 &lt; 9.8ms guaranteed</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="p-8 rounded-2xl bg-zinc-900/40 border border-white/5 hover:border-violet-500/40 hover:shadow-[0_0_30px_rgba(139,92,246,0.15)] transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-violet-600/10 border border-violet-500/20 flex items-center justify-center text-violet-400 mb-6 group-hover:scale-110 group-hover:bg-violet-600/20 transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Enterprise Zero-Trust Security</h3>
                            <p class="text-sm text-zinc-400 leading-relaxed">
                                Cryptographic attestation, automated mTLS key rotation, and isolated memory micro-enclaves for mission-critical enterprise workloads.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-800/60 flex items-center text-xs text-violet-400 font-mono">
                            <span>SOC2 Type II & HIPAA certified</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="p-8 rounded-2xl bg-zinc-900/40 border border-white/5 hover:border-fuchsia-500/40 hover:shadow-[0_0_30px_rgba(217,70,239,0.15)] transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-fuchsia-600/10 border border-fuchsia-500/20 flex items-center justify-center text-fuchsia-400 mb-6 group-hover:scale-110 group-hover:bg-fuchsia-600/20 transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Autonomous Multi-Agent Mesh</h3>
                            <p class="text-sm text-zinc-400 leading-relaxed">
                                Self-coordinating agents handle reservation booking pipelines, dynamic pricing yield calculations, and instant guest concierge inquiries in real-time.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-800/60 flex items-center text-xs text-fuchsia-400 font-mono">
                            <span>24,000 concurrent agents / node</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 bg-[#070709] py-12 text-zinc-500 text-xs font-mono">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-6 h-6 rounded-md bg-indigo-600 flex items-center justify-center text-white font-bold text-[10px]">N</div>
                <span class="text-zinc-400">© 2026 NexusAI Technologies. All systems operational.</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="#privacy" class="hover:text-zinc-300 transition">Privacy</a>
                <a href="#terms" class="hover:text-zinc-300 transition">Terms</a>
                <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300 transition">Hotel Portal</a>
                <a href="https://motion.dev" target="_blank" class="text-indigo-400 hover:text-indigo-300 transition">Powered by motion.dev</a>
            </div>
        </div>
    </footer>

</body>
</html>
