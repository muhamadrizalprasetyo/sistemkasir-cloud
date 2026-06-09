@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-black text-yellow-500 uppercase tracking-widest mb-1">Registrasi Pelanggan</h2>
            <p class="text-zinc-500 tracking-widest text-[10px] font-bold uppercase">Tambah identitas baru ke dalam sistem.</p>
        </div>

        <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 p-8 relative">
            <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-zinc-700 m-2"></div>
            
            <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-700 text-sm"
                           placeholder="Masukkan nama pelanggan">
                    @error('name')
                        <p class="text-red-500 text-[10px] font-bold mt-1 uppercase italic tracking-widest">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">No. WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-700 text-sm font-mono"
                               placeholder="08xxxxxxxx">
                        @error('phone')
                            <p class="text-red-500 text-[10px] font-bold mt-1 uppercase italic tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-700 text-sm"
                               placeholder="user@example.com">
                        @error('email')
                            <p class="text-red-500 text-[10px] font-bold mt-1 uppercase italic tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Alamat (Opsional)</label>
                    <textarea name="address" rows="3"
                          class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-700 text-sm">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-[10px] font-bold mt-1 uppercase italic tracking-widest">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-[0.2em] py-4 rounded-none transition-all border border-yellow-500 shadow-[4px_4px_0_rgba(255,255,255,0.1)] active:scale-[0.98] text-[11px]">
                        SIMPAN DATA
                    </button>
                    <a href="{{ route('customers.index') }}" 
                       class="flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-black uppercase tracking-[0.2em] py-4 rounded-none transition-all border border-zinc-700 text-center text-[11px]">
                        BATAL
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
