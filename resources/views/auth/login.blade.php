<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Portal Login - Serenity Villa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
<body class="h-full flex items-center justify-center p-4 selection:bg-amber-500 selection:text-white" x-data="{
    fillCredentials(email, pass) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pass;
    }
}">

    <div class="max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-amber-600 text-white flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-900/50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Staff Management Console</h1>
            <p class="text-xs text-slate-400 mt-1">Serenity Villa Guest House PMS</p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 shadow-2xl shadow-black/50 text-slate-200">
            @if(session('info'))
                <div class="p-3 mb-6 rounded-xl bg-sky-900/50 border border-sky-700 text-sky-200 text-xs font-medium">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-3 mb-6 rounded-xl bg-rose-900/50 border border-rose-700 text-rose-200 text-xs font-medium">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Staff Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', 'admin@guesthouse.com') }}" 
                           required 
                           autofocus
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Password
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           value="password"
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-700 text-amber-500 focus:ring-amber-500">
                        <span class="text-xs text-slate-400">Remember session</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-bold text-sm text-white bg-amber-600 hover:bg-amber-500 shadow-lg shadow-amber-900/40 transition">
                    Sign In to Console &rarr;
                </button>
            </form>

            <!-- Quick Demo Credentials Fill -->
            <div class="mt-8 pt-6 border-t border-slate-700/60">
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-bold block mb-3 text-center">Quick Demo Accounts</span>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" 
                            @click="fillCredentials('admin@guesthouse.com', 'password')" 
                            class="px-3 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-xs font-semibold text-slate-200 transition text-center">
                        Admin User
                    </button>
                    <button type="button" 
                            @click="fillCredentials('reception@guesthouse.com', 'password')" 
                            class="px-3 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-xs font-semibold text-slate-200 transition text-center">
                        Receptionist
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white transition">
                &larr; Return to Public Website
            </a>
        </div>
    </div>

</body>
</html>
