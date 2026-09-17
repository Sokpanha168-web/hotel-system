@extends('layouts.admin')

@section('title', 'Reports & Analytics')
@section('header_title', 'Business Reports & Operational Analytics')
@section('header_subtitle', 'Financial performance, room yield, occupancy analytics, and revenue trends')

@section('content')
<div class="space-y-8">
    <!-- Top Filter & Print Toolbar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 print:hidden">
        <!-- Quick Period Presets -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.reports.index', ['period' => 'today']) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $period === 'today' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Today
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'last_7_days']) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $period === 'last_7_days' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Last 7 Days
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'this_month']) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $period === 'this_month' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                This Month
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'last_month']) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $period === 'last_month' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Last Month
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'this_year']) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $period === 'this_year' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                This Year
            </a>
        </div>

        <!-- Custom Date Range Form & Print -->
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center space-x-2 text-xs">
                <input type="hidden" name="period" value="custom">
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                <span class="text-slate-400 font-bold">to</span>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-bold transition">
                    Filter
                </button>
            </form>

            <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition flex items-center space-x-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Print Report</span>
            </button>
        </div>
    </div>

    <!-- Active Period Indicator -->
    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
        <span>Report Period: <strong class="text-slate-900">{{ $startDate->format('M d, Y') }} — {{ $endDate->format('M d, Y') }}</strong></span>
        <span>Total Fleet: <strong class="text-slate-900">{{ $totalRooms }} rooms</strong></span>
    </div>

    <!-- 5 High-Impact Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        <!-- 1. Total Revenue -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Gross Revenue</span>
                <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <span class="text-2xl font-bold text-slate-900">${{ number_format($totalRevenue, 2) }}</span>
            <p class="text-[11px] text-slate-500 mt-2 font-medium">{{ $totalTransactions }} completed payments</p>
        </div>

        <!-- 2. Occupancy Rate -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Occupancy</span>
                <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </span>
            </div>
            <span class="text-2xl font-bold text-slate-900">{{ $occupancyRate }}%</span>
            <p class="text-[11px] text-slate-500 mt-2 font-medium">{{ $totalNightsSold }} room nights sold</p>
        </div>

        <!-- 3. ADR (Average Daily Rate) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">ADR (Avg Rate)</span>
                <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </span>
            </div>
            <span class="text-2xl font-bold text-slate-900">${{ number_format($adr, 2) }}</span>
            <p class="text-[11px] text-slate-500 mt-2 font-medium">Per occupied room night</p>
        </div>

        <!-- 4. RevPAR -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">RevPAR</span>
                <span class="p-1.5 rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </span>
            </div>
            <span class="text-2xl font-bold text-slate-900">${{ number_format($revPar, 2) }}</span>
            <p class="text-[11px] text-slate-500 mt-2 font-medium">Yield across all rooms</p>
        </div>

        <!-- 5. Total Bookings -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Bookings</span>
                <span class="p-1.5 rounded-lg bg-purple-50 text-purple-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <span class="text-2xl font-bold text-slate-900">{{ $totalBookings }}</span>
            <p class="text-[11px] text-slate-500 mt-2 font-medium">In selected date range</p>
        </div>
    </div>

    <!-- Charts Row 1: Revenue Timeline (Line/Bar) & Payment Methods (Doughnut) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Revenue Trend Chart -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Revenue Timeline & Trend</h3>
                    <p class="text-xs text-slate-500">Daily collections over time in selected period</p>
                </div>
                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-50 text-amber-800">
                    Total: ${{ number_format($totalRevenue, 2) }}
                </span>
            </div>
            <div class="h-72">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <!-- Payment Methods Breakdown -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Payment Channels</h3>
                        <p class="text-xs text-slate-500">Breakdown by method</p>
                    </div>
                </div>
                <div class="h-56 relative flex items-center justify-center">
                    <canvas id="paymentMethodsChart"></canvas>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs">
                @foreach($paymentMethodsData as $methodName => $amt)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 font-medium">{{ $methodName }}:</span>
                        <span class="font-bold text-slate-900">${{ number_format($amt, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Room Type Yield (Bar) & Fleet Status (Doughnut) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Room Type Revenue Yield -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Yield by Room Category</h3>
                    <p class="text-xs text-slate-500">Revenue generation compared across suite categories</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="roomTypeChart"></canvas>
            </div>
        </div>

        <!-- Fleet Operational Status -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Current Fleet Operations</h3>
                        <p class="text-xs text-slate-500">Status distribution of {{ $totalRooms }} rooms</p>
                    </div>
                </div>
                <div class="h-48 relative flex items-center justify-center">
                    <canvas id="fleetStatusChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 pt-3 border-t border-slate-100 text-xs">
                <div class="p-2 rounded-lg bg-emerald-50 text-emerald-900 flex items-center justify-between">
                    <span>Available</span>
                    <strong class="font-bold">{{ $fleetStatus['Available'] }}</strong>
                </div>
                <div class="p-2 rounded-lg bg-rose-50 text-rose-900 flex items-center justify-between">
                    <span>Occupied</span>
                    <strong class="font-bold">{{ $fleetStatus['Occupied'] }}</strong>
                </div>
                <div class="p-2 rounded-lg bg-amber-50 text-amber-900 flex items-center justify-between">
                    <span>Cleaning</span>
                    <strong class="font-bold">{{ $fleetStatus['Cleaning'] }}</strong>
                </div>
                <div class="p-2 rounded-lg bg-slate-100 text-slate-800 flex items-center justify-between">
                    <span>Maintenance</span>
                    <strong class="font-bold">{{ $fleetStatus['Maintenance'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Transactions Report Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Financial Transactions Journal</h3>
                <p class="text-xs text-slate-500">Itemized paid charges and settlements for selected period</p>
            </div>
            <span class="text-xs text-slate-400">Showing up to 50 records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-6">Transaction Ref</th>
                        <th class="py-3.5 px-6">Guest</th>
                        <th class="py-3.5 px-6">Room</th>
                        <th class="py-3.5 px-6">Category</th>
                        <th class="py-3.5 px-6">Method</th>
                        <th class="py-3.5 px-6">Date Paid</th>
                        <th class="py-3.5 px-6 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($recentTransactions as $tx)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-6 font-mono font-bold text-slate-900">
                                {{ $tx->transaction_ref ?? 'TX-' . str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-3.5 px-6 font-semibold text-slate-900">
                                {{ $tx->reservation?->guest?->full_name ?? 'Walk-in Guest' }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-amber-800">
                                Room {{ $tx->reservation?->room?->room_number ?? 'N/A' }}
                            </td>
                            <td class="py-3.5 px-6 text-slate-600">
                                {{ $tx->reservation?->room?->roomType?->name ?? 'Standard' }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                                    {{ str_replace('_', ' ', $tx->payment_method) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-500">
                                {{ $tx->paid_at ? $tx->paid_at->format('M d, Y H:i') : $tx->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-6 text-right font-bold text-slate-900 text-sm">
                                ${{ number_format($tx->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 text-sm">
                                No transactions recorded for the selected period.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($recentTransactions->isNotEmpty())
                    <tfoot>
                        <tr class="bg-slate-50 font-bold text-slate-900 border-t-2 border-slate-200">
                            <td colspan="6" class="py-4 px-6 text-right uppercase tracking-wider text-xs">Total Period Revenue:</td>
                            <td class="py-4 px-6 text-right text-base text-emerald-700 font-mono">${{ number_format($totalRevenue, 2) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Revenue Timeline Chart
    const revCtx = document.getElementById('revenueTrendChart')?.getContext('2d');
    if (revCtx) {
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: {!! Js::from($revenueTrendLabels) !!},
                datasets: [{
                    label: 'Daily Revenue ($)',
                    data: {!! Js::from($revenueTrendData) !!},
                    borderColor: '#d97706',
                    backgroundColor: 'rgba(217, 119, 6, 0.12)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#d97706',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Revenue: $' + context.raw.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return '$' + value; }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // 2. Payment Methods Chart
    const payCtx = document.getElementById('paymentMethodsChart')?.getContext('2d');
    if (payCtx) {
        new Chart(payCtx, {
            type: 'doughnut',
            data: {
                labels: {!! Js::from(array_keys($paymentMethodsData)) !!},
                datasets: [{
                    data: {!! Js::from(array_values($paymentMethodsData)) !!},
                    backgroundColor: ['#d97706', '#2563eb', '#10b981'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                },
                cutout: '70%'
            }
        });
    }

    // 3. Room Type Revenue Yield Chart
    const roomTypeCtx = document.getElementById('roomTypeChart')?.getContext('2d');
    if (roomTypeCtx) {
        new Chart(roomTypeCtx, {
            type: 'bar',
            data: {
                labels: {!! Js::from($roomTypeLabels) !!},
                datasets: [{
                    label: 'Revenue ($)',
                    data: {!! Js::from($roomTypeRevenue) !!},
                    backgroundColor: '#059669',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return ' $' + ctx.raw.toFixed(2); }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: function(v) { return '$' + v; } },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 4. Fleet Status Chart
    const fleetCtx = document.getElementById('fleetStatusChart')?.getContext('2d');
    if (fleetCtx) {
        new Chart(fleetCtx, {
            type: 'doughnut',
            data: {
                labels: {!! Js::from(array_keys($fleetStatus)) !!},
                datasets: [{
                    data: {!! Js::from(array_values($fleetStatus)) !!},
                    backgroundColor: ['#10b981', '#f43f5e', '#f59e0b', '#64748b'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                },
                cutout: '68%'
            }
        });
    }
});
</script>
@endpush
