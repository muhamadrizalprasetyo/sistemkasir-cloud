@extends('layouts.app')

@section('content')
    <div class="mb-10">
        <h2 class="text-3xl font-black text-yellow-500 uppercase tracking-widest mb-1">Terminal Owner</h2>
        <p class="text-zinc-500 tracking-widest text-[10px] font-bold uppercase">Laporan Operasional /
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
    </div>

    {{-- Statistik Kartu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        {{-- Omzet Kotor --}}
        <div
            class="bg-zinc-900 border border-zinc-800/60 rounded-none shadow-lg shadow-black/40 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em]">Omzet Kotor</h3>
                <div class="w-8 h-8 bg-zinc-800 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black text-zinc-100 tracking-tighter">Rp
                {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}</p>
            <p class="text-[9px] text-zinc-600 mt-2 tracking-widest font-bold uppercase border-t border-zinc-800/60 pt-2">
                (PAID)</p>
        </div>

        {{-- Pengeluaran --}}
        <div
            class="bg-zinc-900 border border-zinc-800/60 rounded-none shadow-lg shadow-black/40 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em]">Pengeluaran</h3>
                <div class="w-8 h-8 bg-zinc-800 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black text-zinc-100 tracking-tighter">Rp
                {{ number_format($totalExpenses ?? 0, 0, ',', '.') }}</p>
            <p class="text-[9px] text-zinc-600 mt-2 tracking-widest font-bold uppercase border-t border-zinc-800/60 pt-2">
                (TOTAL EXPENSES)</p>
        </div>

        {{-- Laba Bersih --}}
        <div
            class="bg-zinc-900 border border-zinc-800/60 rounded-none shadow-lg shadow-black/40 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em]">Laba Bersih</h3>
                <div class="w-8 h-8 bg-zinc-800 flex items-center justify-center">
                    <svg class="w-4 h-4 {{ ($labaBersih ?? 0) >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
            </div>
            <p
                class="text-3xl font-black tracking-tighter {{ ($labaBersih ?? 0) >= 0 ? 'text-zinc-100' : 'text-zinc-100' }}">
                Rp {{ number_format($labaBersih ?? 0, 0, ',', '.') }}</p>
            <p class="text-[9px] text-zinc-600 mt-2 tracking-widest font-bold uppercase border-t border-zinc-800/60 pt-2">
                OMZET - EXPENSES</p>
        </div>

        {{-- Pesanan Aktif --}}
        <div
            class="bg-zinc-900 border border-zinc-800/60 rounded-none shadow-lg shadow-black/40 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em]">Pesanan Aktif</h3>
                <div class="w-8 h-8 bg-zinc-800 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black text-zinc-100 tracking-tighter">{{ $pesananAktif ?? 0 }}</p>
            <p class="text-[9px] text-zinc-600 mt-2 tracking-widest font-bold uppercase border-t border-zinc-800/60 pt-2">
                PENDING PROCESS</p>
        </div>

    </div>

    {{-- Tabel Transaksi Terakhir --}}
    <div class="bg-zinc-900 border border-zinc-800/60 rounded-none shadow-lg shadow-black/40 p-6">
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-zinc-800/60">
            <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em]">5 Transaksi Terakhir</h3>
            <a href="{{ route('orders.index') }}"
                class="text-[10px] text-zinc-500 hover:text-yellow-500 uppercase tracking-[0.2em] font-black transition-colors">
                View All &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-600 uppercase tracking-widest">Identify</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-600 uppercase tracking-widest">Customer</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-600 uppercase tracking-widest">Status</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-600 uppercase tracking-widest text-right">
                            Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60">
                    @forelse($recentOrders ?? [] as $order)
                        <tr class="hover:bg-zinc-800/30 transition-colors">
                            <td class="py-5 px-4 font-black tracking-wider text-xs">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="text-zinc-400 hover:text-yellow-500 transition-colors">#{{ $order->invoice_number }}</a>
                            </td>
                            <td class="py-5 px-4 text-xs font-bold text-zinc-300 uppercase tracking-wider">
                                {{ $order->customer->name }}</td>
                            <td class="py-5 px-4">
                                @php
                                    $statusColors = [
                                        'Antrian' => 'border-zinc-500 text-zinc-500',
                                        'Dicuci' => 'border-blue-500 text-blue-500',
                                        'Dikeringkan' => 'border-orange-500 text-orange-500',
                                        'Siap Diambil' => 'border-green-500 text-green-500',
                                        'Selesai' => 'border-yellow-500 text-yellow-500',
                                    ];
                                    $colorClass = $statusColors[$order->order_status] ?? 'border-zinc-500 text-zinc-500';
                                @endphp
                                <span
                                    class="px-2 py-1 rounded-none text-[9px] font-black uppercase tracking-[0.1em] border {{ $colorClass }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="py-5 px-4 font-black text-zinc-200 text-right tracking-wider text-sm">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <p class="text-zinc-600 italic text-sm font-medium tracking-wide">"Mesin kasir masih terdiam.
                                    Mari doakan hari ini lebih ramai dari biasanya."</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection