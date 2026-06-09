@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black uppercase tracking-widest text-yellow-500">Daftar Pelanggan</h2>
                <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest mt-1">Kelola data & loyalty program pelanggan</p>
            </div>
            <a href="{{ route('customers.create') }}"
                class="bg-yellow-500 hover:bg-yellow-400 text-black font-black py-3 px-6 rounded-none transition-all uppercase tracking-widest text-[10px] active:scale-[0.98]">
                + Pelanggan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-950/20 border-l-2 border-green-600 p-4 mb-6 rounded-none">
                <p class="text-[11px] font-bold text-green-500 uppercase tracking-widest italic">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Stats Bar --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @php
                $total = $customers->count();
                $members = $customers->where('membership_type', 'more_running_club')->count();
                $with10stamps = $customers->where('stamp_count', '>=', 10)->count();
                $totalStamps = $customers->sum('stamp_count');
            @endphp
            <div class="bg-zinc-900 border border-zinc-800/60 p-4 rounded-none">
                <p class="text-[9px] font-black text-zinc-600 uppercase tracking-widest">Total Pelanggan</p>
                <p class="text-2xl font-black text-white mt-1">{{ $total }}</p>
            </div>
            <div class="bg-zinc-900 border border-zinc-800/60 p-4 rounded-none">
                <p class="text-[9px] font-black text-zinc-600 uppercase tracking-widest">Anggota MRC</p>
                <p class="text-2xl font-black text-green-500 mt-1">{{ $members }}</p>
            </div>
            <div class="bg-zinc-900 border border-zinc-800/60 p-4 rounded-none">
                <p class="text-[9px] font-black text-zinc-600 uppercase tracking-widest">Siap Redemption</p>
                <p class="text-2xl font-black text-yellow-500 mt-1">{{ $with10stamps }}</p>
            </div>
            <div class="bg-zinc-900 border border-zinc-800/60 p-4 rounded-none">
                <p class="text-[9px] font-black text-zinc-600 uppercase tracking-widest">Total Stamps Beredar</p>
                <p class="text-2xl font-black text-zinc-300 mt-1">{{ $totalStamps }}</p>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-none border border-zinc-800/60 shadow-lg shadow-black/40 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-400 border-collapse">
                    <thead class="text-[9px] font-black text-zinc-600 uppercase tracking-widest bg-zinc-950/50">
                        <tr class="border-b border-zinc-800/60">
                            <th scope="col" class="py-4 px-4">Nama</th>
                            <th scope="col" class="py-4 px-4">Kontak</th>
                            <th scope="col" class="py-4 px-4">Membership</th>
                            <th scope="col" class="py-4 px-4 text-center">Loyalty Stamp</th>
                            <th scope="col" class="py-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/40">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-zinc-800/20 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="font-bold text-zinc-200 uppercase tracking-wider text-xs">{{ $customer->name }}</div>
                                    <div class="text-[9px] text-zinc-600 font-mono mt-0.5">ID: {{ $customer->id }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="text-zinc-300 text-xs font-mono">{{ $customer->phone ?? '-' }}</div>
                                    <div class="text-zinc-500 text-[10px] lowercase">{{ $customer->email ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    @if($customer->membership_type === 'more_running_club')
                                        <span class="inline-block bg-green-500/15 text-green-400 border border-green-500/30 text-[9px] font-black uppercase tracking-widest px-2 py-1">
                                            MORE RUNNING CLUB
                                        </span>
                                    @else
                                        <span class="inline-block bg-zinc-800/50 text-zinc-500 border border-zinc-700/30 text-[9px] font-black uppercase tracking-widest px-2 py-1">
                                            Regular
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        {{-- Mini stamp display --}}
                                        <div class="flex gap-1 flex-wrap justify-center">
                                            @for($i = 1; $i <= 10; $i++)
                                                @if($i <= $customer->stamp_count)
                                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                                @else
                                                    <div class="w-3 h-3 rounded-full bg-zinc-700"></div>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-[9px] font-black {{ $customer->stamp_count >= 10 ? 'text-yellow-500' : 'text-zinc-500' }}">
                                            {{ $customer->stamp_count }}/10
                                            @if($customer->stamp_count >= 10)
                                                🎉 BISA REDEEM!
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('customers.edit', $customer) }}"
                                            class="text-zinc-500 hover:text-white text-[10px] font-black uppercase tracking-widest transition-colors border border-zinc-700 hover:border-zinc-500 px-3 py-1.5">EDIT</a>

                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Hapus data pelanggan {{ $customer->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500/70 hover:text-red-400 text-[10px] font-black uppercase tracking-widest transition-colors border border-red-500/20 hover:border-red-500/50 px-3 py-1.5">HAPUS</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center">
                                    <p class="text-zinc-600 font-black uppercase tracking-widest text-xs">Belum ada pelanggan terdaftar.</p>
                                    <a href="{{ route('customers.create') }}" class="text-yellow-500 text-[10px] font-black uppercase tracking-widest mt-3 inline-block hover:text-yellow-400">+ Tambah Sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection