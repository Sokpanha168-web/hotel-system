@extends('layouts.admin')

@section('title', 'Add New Staff User')
@section('header_title', 'Create Staff Account')
@section('header_subtitle', 'Provision a new system account with designated role and access permissions')

@section('content')
<style>
    /* Prevent browser autofill from styling inputs with yellow or blue backgrounds */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 1000px white inset !important;
        -webkit-text-fill-color: #1e293b !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>

<div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs max-w-xl mx-auto">
    <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-6" autocomplete="off">
        @csrf

        <!-- Decoy hidden fields to catch browser credential autofill -->
        <input type="text" name="fake_username_decoy" class="hidden" tabindex="-1" aria-hidden="true" autocomplete="off" style="display:none !important;">
        <input type="password" name="fake_password_decoy" class="hidden" tabindex="-1" aria-hidden="true" autocomplete="new-password" style="display:none !important;">

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Sok Sovan"
                   autocomplete="off"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('name') border-rose-500 ring-rose-200 @enderror">
            @error('name')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email Address (Login)</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="staff@guesthouse.com"
                   autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('email') border-rose-500 ring-rose-200 @enderror">
            @error('email')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- System Role Selection -->
        <div>
            <label for="role" class="block text-sm font-bold text-slate-700 mb-2">System Role & Permissions</label>
            <select name="role" id="role" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white @error('role') border-rose-500 ring-rose-200 @enderror">
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Select System Role --</option>
                <option value="receptionist" {{ old('role') === 'receptionist' ? 'selected' : '' }}>
                    Frontdesk Receptionist (Check-in, guest booking, room status)
                </option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                    Administrator (Full unrestricted access including Reports & User Management)
                </option>
            </select>
            <p class="text-xs text-slate-500 mt-1.5">
                Note: Receptionists can manage rooms and reservations. Only Administrators have access to Reports, Analytics, and User Management.
            </p>
            @error('role')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
            <input type="password" name="password" id="password" required minlength="6" placeholder="Minimum 6 characters"
                   autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('password') border-rose-500 ring-rose-200 @enderror">
            @error('password')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="6" placeholder="Repeat password"
                   autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition">
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition">
                Create Account
            </button>
        </div>
    </form>
</div>

@if(!$errors->any())
<script>
    // Ensure form fields are completely clear and blank on initial load
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createUserForm');
        if (form) {
            form.reset();
            const fields = ['name', 'email', 'password', 'password_confirmation'];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            const roleSelect = document.getElementById('role');
            if (roleSelect && !roleSelect.value) {
                roleSelect.selectedIndex = 0;
            }
        }
    });
</script>
@endif
@endsection
