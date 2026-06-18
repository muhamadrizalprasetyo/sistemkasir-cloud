@extends('layouts.app')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight mb-1">Daftar Antrean</h2>
            <p class="text-slate-500 text-sm font-medium">Lacak semua pesanan cuci sepatu dan lainnya.</p>
        </div>
        <a href="{{ route('orders.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Order
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-8 flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        @php
                            $isPriority = $order->customer->membership_type === 'more_running_club';
                            $rowClass = $isPriority ? 'bg-orange-50/30' : 'hover:bg-slate-50/80';
                        @endphp
                        <tr class="{{ $rowClass }} transition-colors group">
                            <td class="py-4 px-6">
                                <a href="{{ route('orders.show', $order->id) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition-colors">
                                    #{{ $order->invoice_number }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-700">{{ $order->customer->name }}</span>
                                    @if($isPriority)
                                        <span class="bg-orange-100 text-orange-700 text-[10px] font-bold uppercase px-2 py-0.5 rounded-md flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            Prioritas
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">
                                    {{ $order->customer->phone }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-indigo-900">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
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
                            <td class="py-4 px-6 text-right flex justify-end gap-2">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all">
                                    Detail
                                </a>
                                <a href="{{ url('/orders/' . $order->id . '/receipt') }}" target="_blank"
                                    class="inline-flex items-center justify-center bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-all gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                        </path>
                                    </svg>
                                    Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 mb-4">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada antrean saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection