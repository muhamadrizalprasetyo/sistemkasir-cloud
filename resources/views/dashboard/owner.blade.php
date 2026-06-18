@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight mb-1">Dashboard</h2>
        <p class="text-slate-500 text-sm font-medium">Laporan Operasional &middot; {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    </div>

    {{-- Statistik Kartu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Omzet Kotor --}}
        <div class="bg-[#3b2c70] rounded-2xl shadow-lg shadow-indigo-900/20 p-6 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
            <div class="flex flex-col h-full relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">Total Earning</span>
                </div>
                <div class="mt-auto">
                    <p class="text-white/80 text-lg font-bold mt-1 tracking-tight">Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="bg-[#3b2c70] rounded-2xl shadow-lg shadow-indigo-900/20 p-6 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
            <div class="flex flex-col h-full relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                    <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">Total Withdrawal</span>
                </div>
                <div class="mt-auto">
                    <p class="text-3xl font-bold text-white tracking-tight">Rp {{ number_format($totalExpenses ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Laba Bersih --}}
        <div class="bg-[#3b2c70] rounded-2xl shadow-lg shadow-indigo-900/20 p-6 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
            <div class="flex flex-col h-full relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">Net Profit</span>
                </div>
                <div class="mt-auto">
                    <p class="text-3xl font-bold text-white tracking-tight">Rp {{ number_format($labaBersih ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Pesanan Aktif --}}
        <div class="bg-[#3b2c70] rounded-2xl shadow-lg shadow-indigo-900/20 p-6 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
            <div class="flex flex-col h-full relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">Active Deals</span>
                </div>
                <div class="mt-auto">
                    <p class="text-3xl font-bold text-white tracking-tight">{{ $pesananAktif ?? 0 }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Transaksi Terakhir --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-slate-800">Recent Deals</h3>
            <div class="p-2 hover:bg-slate-50 rounded-lg cursor-pointer">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders ?? [] as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="py-4 px-2">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-[#3b2c70] rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <a href="{{ route('orders.show', $order->id) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition-colors">
                                            Invoice #{{ $order->invoice_number }}
                                        </a>
                                        <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $order->customer->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 hidden sm:table-cell">
                                @php
                                    $statusColors = [
                                        'Antrian' => 'bg-slate-100 text-slate-600',
                                        'Dicuci' => 'bg-indigo-50 text-indigo-600',
                                        'Dikeringkan' => 'bg-orange-50 text-orange-600',
                                        'Siap Diambil' => 'bg-emerald-50 text-emerald-600',
                                        'Selesai' => 'bg-purple-50 text-purple-600',
                                    ];
                                    $colorClass = $statusColors[$order->order_status] ?? 'bg-slate-100 text-slate-600';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="py-4 px-2 text-right">
                                <span class="font-bold text-[#3b2c70]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 mb-4">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada transaksi bulan ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($recentOrders ?? []) > 0)
        <div class="mt-4 pt-4 border-t border-slate-100 text-center">
            <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View All Transactions</a>
        </div>
        @endif
    </div>
@endsection