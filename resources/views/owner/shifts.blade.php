@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-black text-white">Monitoring Shift Kasir</h1>
                <p class="text-sm text-zinc-400">Lihat ringkasan shift, pemasukan, pelanggan, dan pengeluaran per kasir.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('owner.shifts.export-csv') }}"
                    class="bg-blue-600 hover:bg-blue-500 text-white font-black uppercase tracking-widest py-2 px-4">Export CSV</a>
                <a href="{{ route('owner.shifts.export-excel') }}"
                    class="bg-green-600 hover:bg-green-500 text-white font-black uppercase tracking-widest py-2 px-4">Export Excel</a>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-zinc-400 text-left">
                        <th class="p-2">#</th>
                        <th class="p-2">Kasir</th>
                        <th class="p-2">Mulai</th>
                        <th class="p-2">Selesai</th>
                        <th class="p-2">Gross</th>
                        <th class="p-2">Tunai</th>
                        <th class="p-2">Non-Tunai</th>
                        <th class="p-2">Pesanan</th>
                        <th class="p-2">Pelanggan</th>
                        <th class="p-2">Pengeluaran</th>
                        <th class="p-2">Pembayaran</th>
                        <th class="p-2">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shifts as $shift)
                        <tr class="border-t border-zinc-800">
                            <td class="p-2 align-top">{{ $shift->id }}</td>
                            <td class="p-2 align-top">{{ $shift->user->name ?? '-' }}</td>
                            <td class="p-2 align-top">{{ $shift->started_at->format('Y-m-d H:i') }}</td>
                            <td class="p-2 align-top">{{ $shift->ended_at ? $shift->ended_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="p-2 align-top">Rp {{ number_format($shift->gross_total ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2 align-top">Rp {{ number_format($shift->cash_total ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2 align-top">Rp {{ number_format($shift->non_cash_total ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2 align-top">{{ $shift->orders_count ?? 0 }}</td>
                            <td class="p-2 align-top">{{ $shift->unique_customers ?? 0 }}</td>
                            <td class="p-2 align-top">Rp {{ number_format($shift->expenses_total ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2 align-top">Rp {{ number_format($shift->payments_total ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2 align-top">{{ $shift->notes ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $shifts->links() }}
            </div>
        </div>
    </div>
@endsection
