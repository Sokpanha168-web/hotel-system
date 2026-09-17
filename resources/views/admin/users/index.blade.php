@extends('layouts.admin')

@section('title', 'User Management')
@section('header_title', 'Staff User Management')
@section('header_subtitle', 'Manage administrator and frontdesk receptionist accounts')

@section('content')
<div class="space-y-6">
    <!-- Top Stats & Add User Action -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Staff</span>
            <span class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</span>
            <p class="text-[11px] text-slate-500 mt-1">Active system logins</p>
        </div>

        <!-- Administrators -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-purple-700 block mb-1">Administrators</span>
            <span class="text-2xl font-bold text-purple-900">{{ $adminCount }}</span>
            <p class="text-[11px] text-slate-500 mt-1">Full system control</p>
        </div>

        <!-- Receptionists -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-700 block mb-1">Frontdesk</span>
            <span class="text-2xl font-bold text-blue-900">{{ $receptionistCount }}</span>
            <p class="text-[11px] text-slate-500 mt-1">Check-in, guests & rooms</p>
        </div>
    </div>

    <!-- User Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">All System Users</h3>
                <p class="text-xs text-slate-500">Only administrators have access to create and manage user credentials</p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-xs transition inline-flex items-center space-x-1.5 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New Staff</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">Staff Member</th>
                        <th class="py-3.5 px-6">Email Address</th>
                        <th class="py-3.5 px-6">System Role</th>
                        <th class="py-3.5 px-6">Created On</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs uppercase flex-shrink-0">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block text-sm">{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                            <span class="text-[10px] text-amber-700 font-bold uppercase tracking-wider">(You - Current Account)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="py-4 px-6">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-purple-100 text-purple-800 border border-purple-200">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800 border border-blue-200">
                                        Receptionist
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="px-3 py-1.5 rounded-lg border border-slate-300 hover:bg-slate-100 text-slate-700 font-bold text-xs transition">
                                        Edit
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete user \'{{ $user->name }}\'?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-xs transition">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500 text-sm">
                                No staff users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
