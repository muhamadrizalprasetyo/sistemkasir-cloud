@extends('layouts.app')

@section('content')
    <div class="bg-zinc-900 border border-zinc-800/60 rounded-none p-6 sm:p-8 shadow-lg shadow-black/40 relative">
        <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>

        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-zinc-800/60 pb-5">
            <div>
                <h2 class="text-3xl font-black text-yellow-500 uppercase tracking-widest mb-1">Daftar Antrean</h2>
                <p class="text-zinc-500 tracking-widest text-[10px] font-bold uppercase">Lacak semua pesanan cuci sepatu dan
                    lainnya.</p>
            </div>
            <a href="{{ route('orders.create') }}"
                class="mt-4 sm:mt-0 bg-zinc-800 hover:bg-zinc-700 text-white font-bold uppercase tracking-widest text-[10px] px-6 py-3 rounded-none border border-zinc-700/50 transition-colors">
                + Tambah Order
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-950/20 border-l-2 border-green-600 p-4 mb-8 rounded-none">
                <p class="text-[11px] font-bold text-green-500 uppercase tracking-widest italic">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800">
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Invoice</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Pelanggan</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Total</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Status</th>
                        <th class="pb-4 px-4 text-[10px] font-black text-zinc-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60">
                    @forelse($orders as $order)
                        @php
                            $isPriority = $order->customer->membership_type === 'more_running_club';
                            $rowClass = $isPriority ? 'bg-yellow-950/10 border-l-4 border-yellow-500' : 'hover:bg-zinc-800/30';
                        @endphp
                        <tr class="{{ $rowClass }} transition-colors">
                            <td class="py-5 px-4 font-black tracking-wider text-xs text-zinc-400">
                                #{{ $order->invoice_number }}
                            </td>
                            <td class="py-5 px-4">
                                <div class="font-bold text-zinc-200 uppercase tracking-wider text-xs flex items-center gap-2">
                                    {{ $order->customer->name }}
                                    @if($isPriority)
                                        <span
                                            class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/50 text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-none">⭐
                                            PRIORITAS MEMBER</span>
                                    @endif
                                </div>
                                <div class="text-[10px] text-zinc-500 font-bold tracking-widest mt-1">
                                    {{ $order->customer->phone }}</div>
                            </td>
                            <td class="py-5 px-4 font-black text-yellow-500 tracking-wider">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
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
                            <td class="py-5 px-4 flex gap-3">
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="text-[10px] font-bold text-zinc-500 hover:text-yellow-500 uppercase tracking-widest transition-colors border border-zinc-700 hover:border-yellow-500 px-3 py-1">Detail</a>
                                <a href="{{ url('/orders/' . $order->id . '/receipt') }}" target="_blank"
                                    class="text-[10px] font-bold text-blue-500 hover:text-blue-400 uppercase tracking-widest transition-colors border border-blue-500/50 hover:border-blue-400 px-3 py-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <td colspan="5" class="py-16">
                                <p class="text-zinc-600 italic text-sm text-center tracking-wide">"Belum ada sepatu di antrean.
                                    Istirahatlah sejenak sebelum langkah berikutnya datang."</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection