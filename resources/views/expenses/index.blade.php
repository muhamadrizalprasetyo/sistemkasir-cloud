@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-black text-accent uppercase tracking-wider mb-1">Catat Pengeluaran</h2>
        <p class="text-gray-400 tracking-wide text-sm font-medium">Jurnal pengeluaran operasional harian Luxesole.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 p-4 rounded-lg mb-6 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Input Pengeluaran Baru --}}
    <div class="bg-dark border border-gray-800 rounded-xl p-6 mb-6">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Input Pengeluaran Baru</h3>
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}"
                        class="w-full bg-darker border border-gray-700 rounded-lg px-4 py-3 text-gray-200 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Keterangan</label>
                    <input type="text" name="description" required placeholder="Misal: Beli detergen"
                        class="w-full bg-darker border border-gray-700 rounded-lg px-4 py-3 text-gray-200 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent placeholder-gray-700">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nominal (Rp)</label>
                    <input type="number" name="amount" required min="1" placeholder="50000"
                        class="w-full bg-darker border border-gray-700 rounded-lg px-4 py-3 text-gray-200 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent placeholder-gray-700">
                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-accent hover:bg-yellow-400 text-darker font-black uppercase tracking-widest py-3 rounded-lg transition-colors text-sm">
                        Catat Pengeluaran
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel Histori Pengeluaran --}}
    <div class="bg-dark border border-gray-800 rounded-xl p-6">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Histori Pengeluaran</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="py-3 px-4 text-xs font-bold text-gray-600 uppercase tracking-widest">Tanggal</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-600 uppercase tracking-widest">Dicatat Oleh</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-600 uppercase tracking-widest">Keterangan</th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-600 uppercase tracking-widest text-right">Nominal
                        </th>
                        <th class="py-3 px-4 text-xs font-bold text-gray-600 uppercase tracking-widest text-center">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-4 text-sm text-gray-300">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                            <td class="py-4 px-4 text-sm text-gray-400">{{ $expense->user->name }}</td>
                            <td class="py-4 px-4 text-sm text-gray-200 font-medium">{{ $expense->description }}</td>
                            <td class="py-4 px-4 text-sm text-red-400 font-bold text-right">- Rp
                                {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data pengeluaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs font-bold text-red-500 hover:text-red-400 uppercase tracking-widest transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500 text-sm font-medium">Belum ada data
                                pengeluaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection