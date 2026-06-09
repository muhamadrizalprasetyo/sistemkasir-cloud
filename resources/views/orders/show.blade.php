@extends('layouts.app')

@section('content')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-950/20 border-l-2 border-green-600 p-4 mb-8 rounded-none">
            <p class="text-[11px] font-bold text-green-500 uppercase tracking-widest italic">
                {{ session('success') }}
            </p>
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('orders.index') }}"
            class="text-[10px] text-zinc-500 hover:text-yellow-500 uppercase tracking-widest font-black transition-colors">
            &larr; KEMBALI KE DAFTAR ORDER
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== KOLOM KIRI: Info Pelanggan & Status ===== --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Kartu Info Pelanggan --}}
            <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 relative">
                <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-zinc-700 m-2"></div>
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-5 border-b border-zinc-800/60 pb-3">Informasi Pesanan</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">No. Invoice</p>
                        <p class="font-black text-lg text-yellow-500 tracking-wider">#{{ $order->invoice_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">Pelanggan</p>
                        <p class="font-bold text-zinc-200 uppercase tracking-wider text-sm">{{ $order->customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">No. WhatsApp</p>
                        <p class="font-medium text-zinc-300 font-mono text-xs">{{ $order->customer->phone }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">Metode Pengiriman</p>
                        <p class="font-medium text-zinc-300 text-xs">{{ $order->delivery_method }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">Waktu</p>
                        <p class="font-medium text-zinc-300 text-xs">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">PIC</p>
                        <p class="font-medium text-zinc-300 text-xs">{{ $order->user->name }}</p>
                    </div>
                    @if($order->notes)
                        <div class="pt-3 border-t border-zinc-800/60">
                            <p class="text-[10px] text-zinc-500 uppercase tracking-widest font-black mb-1">Catatan</p>
                            <p class="text-xs text-zinc-400 italic">"{{ $order->notes }}"</p>
                        </div>
                    @endif
                </div>

                {{-- Tombol WA --}}
                @php
                    $waPhone = preg_replace('/^0/', '62', preg_replace('/\D/', '', $order->customer->phone));
                    $waMessage = urlencode("Halo kak *{$order->customer->name}*, pesanan Anda di Luxesole dengan nomor invoice *{$order->invoice_number}* saat ini berstatus: *{$order->order_status}*. Terima kasih sudah mempercayakan kebersihan koleksi Anda kepada kami! 👟✨");
                @endphp
                <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" target="_blank"
                    class="mt-8 flex items-center justify-center gap-3 w-full bg-zinc-800 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500/10 rounded-none uppercase tracking-widest text-xs font-bold py-4 transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Kirim WA
                </a>
            </div>

            {{-- Kartu Update Status --}}
            <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 relative">
                <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-zinc-700 m-2"></div>
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-5 border-b border-zinc-800/60 pb-3 pl-6">Update Status</h3>

                <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">POSISI AKTUAL</label>
                        <select name="order_status"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all appearance-none text-sm">
                            @php
                                $statuses = ['Antrian', 'Dicuci', 'Dikeringkan', 'Siap Diambil', 'Selesai'];
                            @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" @selected($order->order_status === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-zinc-800 hover:bg-zinc-700 text-white font-black uppercase tracking-widest py-4 rounded-none border border-zinc-700/50 transition-all text-xs">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

        </div>

        {{-- ===== KOLOM KANAN: Rincian Item ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 h-full flex flex-col relative">
                <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>
                <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-6 border-b border-zinc-800/60 pb-3">Rincian Barang</h3>

                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-800/60">
                                <th class="pb-4 text-[10px] font-black text-zinc-600 uppercase tracking-widest">Layanan</th>
                                <th class="pb-4 text-[10px] font-black text-zinc-600 uppercase tracking-widest">Varian</th>
                                <th class="pb-4 text-[10px] font-black text-center text-zinc-600 uppercase tracking-widest">Qty</th>
                                <th class="pb-4 text-[10px] font-black text-right text-zinc-600 uppercase tracking-widest">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60">
                            @foreach($order->orderDetails as $detail)
                                <tr class="hover:bg-zinc-800/30 transition-colors">
                                    <td class="py-5">
                                        <p class="font-bold text-zinc-200 text-xs uppercase tracking-wider">{{ $detail->service->name }}</p>
                                        <p class="text-[10px] text-zinc-500 font-bold tracking-widest mt-1">EST. {{ $detail->service->estimated_days ?? 0 }} HARI</p>
                                    </td>
                                    <td class="py-5 text-xs text-zinc-300 font-medium uppercase tracking-wider">{{ $detail->item_variant }}</td>
                                    <td class="py-5 text-sm text-zinc-300 text-center font-bold">{{ $detail->quantity }}</td>
                                    <td class="py-5 text-sm text-zinc-200 font-black text-right tracking-wider">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Rincian Pembayaran --}}
                <div class="border-t border-zinc-800/60 mt-8 pt-6 space-y-4">

                    {{-- Status Badge --}}
                    @php
                        $paymentColors = [
                            'Unpaid' => 'text-red-500',
                            'DP'     => 'text-yellow-500',
                            'Paid'   => 'text-green-500',
                        ];
                        $sisaPelunasan = $order->total_amount - ($order->dp_amount ?? 0);
                    @endphp

                    {{-- Total Tagihan --}}
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">Total Tagihan</span>
                        <span class="text-2xl font-black text-yellow-500 font-mono">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    {{-- DP Dibayar --}}
                    @if(($order->dp_amount ?? 0) > 0)
                    <div class="flex justify-between items-center py-3 border-t border-zinc-800/60">
                        <div>
                            <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">DP Dibayar</span>
                            <span class="ml-2 text-[9px] font-black uppercase tracking-widest {{ $paymentColors[$order->payment_status] ?? 'text-zinc-500' }}">[ {{ $order->payment_status }} ]</span>
                        </div>
                        <span class="text-lg font-black text-zinc-300 font-mono">- Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    {{-- Sisa Pelunasan --}}
                    @if($order->payment_status !== 'Paid')
                    <div class="flex justify-between items-center py-3 bg-zinc-950 px-4 border border-zinc-800">
                        <span class="text-[10px] font-black text-red-400 uppercase tracking-widest">Sisa Pelunasan</span>
                        <span class="text-2xl font-black text-red-400 font-mono">Rp {{ number_format(max(0, $sisaPelunasan), 0, ',', '.') }}</span>
                    </div>
                    @else
                    <div class="flex justify-between items-center py-3 bg-green-950/30 px-4 border border-green-700/50">
                        <span class="text-[10px] font-black text-green-400 uppercase tracking-widest">Status Pembayaran</span>
                        <span class="text-lg font-black text-green-400">LUNAS ✓</span>
                    </div>
                    @endif

                    {{-- Tombol Pelunasan --}}
                    @if($order->payment_status === 'Unpaid' || $order->payment_status === 'DP')
                    <button type="button" id="openPelunasanModal" class="w-full bg-green-900/40 hover:bg-green-800/60 text-green-400 border border-green-700/50 font-black uppercase tracking-widest py-4 rounded-none transition-all text-xs flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tandai Sudah Lunas (Rp {{ number_format(max(0, $sisaPelunasan), 0, ',', '.') }})
                    </button>

                    <div id="pelunasanModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4 py-6">
                        <div class="w-full max-w-md bg-zinc-950 border border-zinc-800 rounded-none p-6 shadow-2xl shadow-black/80">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h2 class="text-lg font-black text-white uppercase tracking-[0.2em]">Konfirmasi Pelunasan</h2>
                                    <p class="text-[10px] text-zinc-500 uppercase tracking-[0.2em] mt-1">Total sisa Rp {{ number_format(max(0, $sisaPelunasan), 0, ',', '.') }}</p>
                                </div>
                                <button type="button" id="closePelunasanModal" class="text-zinc-400 hover:text-white">✕</button>
                            </div>

                            <form action="{{ route('orders.update-payment', $order->id) }}" method="POST" id="pelunasanForm">
                                @csrf
                                @method('PATCH')

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Metode Pembayaran Pelunasan</label>
                                        <select name="payment_method" required class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all appearance-none text-sm">
                                            <option value="cash">Cash / Tunai</option>
                                            <option value="transfer">Bank Transfer</option>
                                            <option value="qris">QRIS</option>
                                        </select>
                                    </div>

                                    <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
                                        <p class="text-[10px] text-zinc-500 uppercase tracking-[0.2em] mb-2">Jumlah Pelunasan</p>
                                        <p class="text-xl font-black text-yellow-500">Rp {{ number_format(max(0, $sisaPelunasan), 0, ',', '.') }}</p>
                                    </div>

                                    <div class="flex gap-3">
                                        <button type="submit" class="flex-1 bg-green-500 hover:bg-green-400 text-black font-black uppercase tracking-widest py-3 rounded-none transition-colors">Simpan Pelunasan</button>
                                        <button type="button" id="cancelPelunasan" class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-black uppercase tracking-widest py-3 rounded-none transition-colors">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openModal = document.getElementById('openPelunasanModal');
            const closeModal = document.getElementById('closePelunasanModal');
            const cancelButton = document.getElementById('cancelPelunasan');
            const modal = document.getElementById('pelunasanModal');

            if (!modal) {
                return;
            }

            function showModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function hideModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            if (openModal) {
                openModal.addEventListener('click', showModal);
            }
            if (closeModal) {
                closeModal.addEventListener('click', hideModal);
            }
            if (cancelButton) {
                cancelButton.addEventListener('click', hideModal);
            }

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    hideModal();
                }
            });
        });
    </script>
@endsection