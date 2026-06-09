@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black uppercase tracking-widest text-yellow-500">Manajemen Layanan</h2>
                <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest mt-1">Kelola pricelist dan estimasi
                    pengerjaan</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-950/20 border-l-2 border-green-600 p-4 mb-8 rounded-none">
                <p class="text-[11px] font-bold text-green-500 uppercase tracking-widest italic">
                    {{ session('success') }}
                </p>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-950/20 border-l-2 border-red-600 p-4 mb-8 rounded-none">
                <ul class="list-disc pl-5 text-[11px] font-bold text-red-500 uppercase tracking-widest italic">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah -->
            <div class="lg:col-span-1">
                <div
                    class="bg-zinc-900 rounded-none border border-zinc-800/60 shadow-lg shadow-black/40 p-6 lg:p-8 sticky top-24 relative">
                    <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-zinc-700 m-2"></div>
                    <h3
                        class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-6 border-b border-zinc-800/60 pb-3 pl-4 border-l-2 border-yellow-500">
                        Tambah Layanan</h3>

                    <form action="{{ route('services.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Pilih
                                Kategori</label>
                            <select name="category_id" required
                                class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 text-sm rounded-none focus:outline-none focus:border-zinc-500 p-4 transition-all appearance-none cursor-pointer">
                                <option value="">-- KATEGORI --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Nama
                                Layanan</label>
                            <input type="text" name="name" placeholder="Misal: Sneakers Deep Clean" required
                                class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 text-sm rounded-none focus:outline-none focus:border-zinc-500 p-4 transition-all placeholder-zinc-600">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Harga
                                (Rp)</label>
                            <input type="number" name="price" placeholder="Misal: 50000" required min="0"
                                class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 text-sm rounded-none focus:outline-none focus:border-zinc-500 p-4 transition-all placeholder-zinc-600 font-mono">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Estimasi
                                (Hari)</label>
                            <input type="number" name="estimated_days" placeholder="Misal: 3" required min="1"
                                class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 text-sm rounded-none focus:outline-none focus:border-zinc-500 p-4 transition-all placeholder-zinc-600 font-mono">
                        </div>
                        <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-400 border border-yellow-500 text-black shadow-[4px_4px_0_rgba(255,255,255,0.1)] font-black py-4 mt-4 rounded-none transition-all uppercase tracking-[0.2em] text-[10px] active:scale-[0.98]">
                            Simpan Data
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Layanan -->
            <div class="lg:col-span-2">
                <div
                    class="bg-zinc-900 rounded-none border border-zinc-800/60 shadow-lg shadow-black/40 overflow-hidden relative p-4 sm:p-6">
                    <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>

                    <div class="overflow-x-auto mt-4">
                        <table class="w-full text-left text-sm text-zinc-400 border-collapse">
                            <thead class="text-[10px] font-black text-zinc-600 uppercase tracking-widest">
                                <tr class="border-b border-zinc-800/60">
                                    <th scope="col" class="pb-4 px-4">Layanan</th>
                                    <th scope="col" class="pb-4 px-4">Kategori</th>
                                    <th scope="col" class="pb-4 px-4">Harga</th>
                                    <th scope="col" class="pb-4 px-4 text-center">Estimasi</th>
                                    <th scope="col" class="pb-4 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800/60">
                                @forelse($services as $service)
                                    <tr class="hover:bg-zinc-800/30 transition-colors">
                                        <td class="py-5 px-4">
                                            <div class="font-bold text-zinc-200 uppercase tracking-wider text-xs">
                                                {{ $service->name }}</div>
                                        </td>
                                        <td class="py-5 px-4">
                                            <span
                                                class="bg-zinc-800 text-zinc-400 text-[9px] px-2 py-1 uppercase tracking-widest font-black border border-zinc-700/50">
                                                {{ $service->category->name }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-4 font-black text-yellow-500 tracking-wider">
                                            Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-5 px-4 text-center font-bold text-zinc-300">
                                            {{ $service->estimated_days }} Hari
                                        </td>
                                        <td class="py-5 px-4 text-right">
                                            <form action="{{ route('services.destroy', $service) }}" method="POST"
                                                onsubmit="return confirm('Hapus layanan ini beserta data yang terhubung?');"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500/10 text-red-500 hover:bg-red-600 hover:text-white rounded-none border border-red-500/20 transition-colors px-3 py-1.5 text-[9px] font-black uppercase tracking-widest">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-16">
                                            <p class="text-zinc-600 italic text-sm text-center tracking-wide">"Katalog kosong.
                                                Tambahkan layanan baru agar mesin ini terus berjalan."</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection