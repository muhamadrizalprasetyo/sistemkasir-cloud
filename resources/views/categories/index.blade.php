@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black uppercase tracking-widest text-yellow-500">Manajemen Kategori</h2>
                <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest mt-1">Kelola jenis layanan cuci Anda
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-950/20 border-l-2 border-green-600 p-4 mb-8 rounded-none">
                <p class="text-[11px] font-bold text-green-500 uppercase tracking-widest italic">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        <div
            class="bg-zinc-900 rounded-none border border-zinc-800/60 shadow-lg shadow-black/40 overflow-hidden mb-8 relative">
            <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-zinc-700 m-2"></div>

            <div class="p-6 sm:p-8 border-b border-zinc-800/60">
                <h3
                    class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-4 pl-4 border-l-2 border-yellow-500">
                    TAMBAH KATEGORI BARU</h3>
                <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <input type="text" name="name" placeholder="Misal: Deep Clean, Fast Clean..." required
                            class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 text-sm rounded-none focus:outline-none focus:border-zinc-500 p-4 placeholder-zinc-600 transition-all">
                        @error('name')
                            <p class="text-[10px] font-bold text-red-500 mt-2 uppercase tracking-widest italic">{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="bg-zinc-800 hover:bg-zinc-700 border border-zinc-700/50 text-white shadow-[2px_2px_0_rgba(234,179,8,0.3)] font-black py-4 px-8 rounded-none transition-all uppercase tracking-widest text-[10px] whitespace-nowrap active:scale-[0.98]">
                        Tambah
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto p-4 sm:p-6">
                <table class="w-full text-left text-sm text-zinc-400 border-collapse">
                    <thead class="text-[10px] font-black text-zinc-600 uppercase tracking-widest">
                        <tr class="border-b border-zinc-800/60">
                            <th scope="col" class="pb-4 px-4">Nama Kategori</th>
                            <th scope="col" class="pb-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60">
                        @forelse($categories as $category)
                            <tr class="hover:bg-zinc-800/30 transition-colors">
                                <td class="py-5 px-4 font-bold text-zinc-200 uppercase tracking-wider text-xs">
                                    {{ $category->name }}
                                </td>
                                <td class="py-5 px-4 text-right">
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500/10 text-red-500 hover:bg-red-600 hover:text-white rounded-none border border-red-500/20 transition-colors px-4 py-2 text-[10px] font-black uppercase tracking-widest">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-16">
                                    <p class="text-zinc-600 italic text-sm text-center tracking-wide">"Belum ada kategori.
                                        Definisikan identitas pertamamu."</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection