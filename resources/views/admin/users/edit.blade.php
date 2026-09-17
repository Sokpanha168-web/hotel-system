@extends('layouts.admin')

@section('title', 'Edit Staff User: ' . $user->name)
@section('header_title', 'Edit Staff Account: ' . $user->name)
@section('header_subtitle', 'Update staff member profile, assigned role, or reset password')

@section('content')
<div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs max-w-xl mx-auto">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition @error('name') border-rose-500 ring-rose-200 @enderror">
            @error('name')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email Address (Login)</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
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
                <option value="receptionist" {{ old('role', $user->role) === 'receptionist' ? 'selected' : '' }}>
                    Frontdesk Receptionist (Check-in, guest booking, room status)
                </option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                    Administrator (Full unrestricted access including Reports & User Management)
                </option>
            </select>
            @error('role')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Reset Password Section (Optional) -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Reset Password (Optional)</span>
                <p class="text-xs text-slate-500">Leave both fields blank if you wish to keep the current password.</p>
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-600 mb-1">New Password</label>
                <input type="password" name="password" id="password" minlength="6" placeholder="Leave blank to keep unchanged"
                       autocomplete="new-password"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white @error('password') border-rose-500 ring-rose-200 @enderror">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" minlength="6" placeholder="Repeat new password"
                       autocomplete="new-password"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-white">
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
