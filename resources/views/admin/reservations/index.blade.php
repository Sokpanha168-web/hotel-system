@extends('layouts.admin')

@section('title', 'Reservations Master List')
@section('header_title', 'Reservations & Bookings')
@section('header_subtitle', 'Manage bookings, check-in arrivals, and settle guest departures')

@section('content')
<div class="space-y-6">

    <!-- Search & Status Filter Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-4">
            <a href="{{ route('admin.reservations.index', array_merge(request()->except('status', 'page'), [])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ empty($status) ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('admin.reservations.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'pending' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Pending ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('admin.reservations.index', array_merge(request()->except('page'), ['status' => 'confirmed'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'confirmed' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Confirmed ({{ $statusCounts['confirmed'] }})
            </a>
            <a href="{{ route('admin.reservations.index', array_merge(request()->except('page'), ['status' => 'checked_in'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'checked_in' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Checked In ({{ $statusCounts['checked_in'] }})
            </a>
            <a href="{{ route('admin.reservations.index', array_merge(request()->except('page'), ['status' => 'checked_out'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'checked_out' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Checked Out ({{ $statusCounts['checked_out'] }})
            </a>
            <a href="{{ route('admin.reservations.index', array_merge(request()->except('page'), ['status' => 'cancelled'])) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $status === 'cancelled' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Cancelled ({{ $statusCounts['cancelled'] }})
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.reservations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            @if(!empty($status))
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Search by guest name, phone, booking code (e.g. GH-...), or room number..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
            </div>

            <button type="submit" class="px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-slate-800 hover:bg-slate-900 transition">
                Search
            </button>

            @if($search)
                <a href="{{ route('admin.reservations.index', !empty($status) ? ['status' => $status] : []) }}" 
                   class="px-4 py-2.5 rounded-xl font-semibold text-xs text-slate-600 bg-slate-100 hover:bg-slate-200 transition text-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">Booking Code</th>
                        <th class="py-3.5 px-6">Guest</th>
                        <th class="py-3.5 px-6">Room</th>
                        <th class="py-3.5 px-6">Dates</th>
                        <th class="py-3.5 px-6 text-right">Amount</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-xs text-slate-900">
                                <a href="{{ route('admin.reservations.show', $res->id) }}" class="text-amber-700 hover:underline">
                                    {{ $res->booking_code }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-slate-900 block">{{ $res->guest->full_name }}</span>
                                <span class="text-xs text-slate-400">{{ $res->guest->phone }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-900">Room {{ $res->room->room_number }}</span>
                                <span class="text-xs text-slate-400 block">{{ $res->room->roomType->name }}</span>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <div>{{ \Carbon\Carbon::parse($res->check_in_date)->format('M d') }} &rarr; {{ \Carbon\Carbon::parse($res->check_out_date)->format('M d, Y') }}</div>
                                <div class="text-slate-400">{{ $res->total_nights }} {{ Str::plural('night', $res->total_nights) }}</div>
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-slate-900">
                                ${{ number_format($res->total_amount, 2) }}
                                @if($res->is_fully_paid)
                                    <span class="block text-[10px] text-emerald-600 font-semibold">Paid</span>
                                @else
                                    <span class="block text-[10px] text-amber-600 font-semibold">Due: ${{ number_format($res->balance_due, 2) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($res->status === 'checked_in')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Checked In</span>
                                @elseif($res->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Confirmed</span>
                                @elseif($res->status === 'checked_out')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Checked Out</span>
                                @elseif($res->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Cancelled</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Pending</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                @if($res->status === 'confirmed' || $res->status === 'pending')
                                    <form method="POST" action="{{ route('admin.reservations.check-in', $res->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                                            Check In
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.reservations.show', $res->id) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                    Details
                                </a>

                                <a href="{{ route('admin.reservations.invoice', $res->id) }}" target="_blank" class="px-2.5 py-1 rounded-lg text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 transition">
                                    Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-xs text-slate-400">
                                No reservations matching the current criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reservations->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
