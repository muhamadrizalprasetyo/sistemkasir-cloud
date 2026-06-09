<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxesole - Lacak Pesanan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Inter:wght@300;400;600;900&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        caveat: ['Caveat', 'cursive'],
                    },
                    colors: {
                        zinc: {
                            900: '#18181b',
                            950: '#09090b',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * { border-radius: 0 !important; }
        .input-glow:focus {
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.1);
            border-color: #eab308;
        }
    </style>
</head>

<body class="bg-zinc-950 text-zinc-300 antialiased selection:bg-yellow-500 selection:text-black flex flex-col min-h-screen overflow-x-hidden">

    <!-- Navbar -->
    <nav class="w-full p-5 md:p-8 flex justify-between items-center z-10 border-b border-zinc-900/80 bg-zinc-900 absolute top-0">
        <a href="{{ route('home') }}" class="font-caveat text-3xl md:text-4xl text-yellow-500 font-bold tracking-wider select-none">
            Luxesole
        </a>
        <a href="{{ route('home') }}"
            class="text-[10px] md:text-xs font-black tracking-[0.2em] uppercase text-zinc-400 hover:text-yellow-500 transition-colors border border-transparent hover:border-yellow-500 px-3 py-2">
            Kembali
        </a>
    </nav>

    {{-- TRACKING SECTION --}}
    <section class="pt-32 pb-24 md:pb-32 px-5 md:px-12 max-w-4xl mx-auto w-full flex-grow flex flex-col justify-start relative">
        <!-- Header -->
        <div class="mb-10 mt-10 md:mb-16 text-center md:text-left">
            <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter text-white mb-4 md:mb-6">
                Penelusuran<br class="hidden md:block">Jejak
            </h2>
            <div class="w-12 md:w-16 h-1 bg-yellow-500 mb-6 mx-auto md:mx-0"></div>
            <p class="text-[10px] md:text-xs text-zinc-500 tracking-[0.1em] md:tracking-[0.2em] font-black uppercase">
                Masukkan nomor invoice atau kontak WA Anda.
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-950/20 border-l-2 border-red-600 p-4 mb-6 rounded-none">
                <p class="text-[11px] font-bold text-red-500 uppercase tracking-widest italic">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        @if(isset($error))
            <div class="bg-red-950/20 border-l-2 border-red-600 p-4 mb-6 rounded-none">
                <p class="text-[11px] font-bold text-red-500 uppercase tracking-widest italic">
                    {{ $error }}
                </p>
            </div>
        @endif

        <!-- Form Tracking -->
        <form action="{{ route('track.search') }}" method="POST" class="flex flex-col md:flex-row gap-0">
            @csrf
            <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="INV-... / 0812..." required
                class="input-glow w-full bg-zinc-900 border-2 border-zinc-800 px-5 md:px-6 py-5 md:py-6 text-lg md:text-xl font-bold text-white placeholder-zinc-700 outline-none text-center md:text-left">
            <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-[0.2em] text-xs md:text-sm px-6 md:px-10 py-5 md:py-6 transition-colors w-full md:w-auto mt-4 md:mt-0 active:scale-[0.98]">
                Lacak Sepatu
            </button>
        </form>

        <!-- Tracking Results -->
        @if(isset($orders))
            <div class="mt-12 md:mt-16">
                @if($orders->count() > 0)
                    <div class="mb-6 border-b border-zinc-900 pb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                        <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                            Menemukan {{ $orders->count() }} jejak untuk: <span class="text-white">{{ $keyword }}</span>
                        </p>
                        
                        @php
                            // Extract customer if they searched by WA (orders > 0 and all belong to one customer)
                            $firstOrder = $orders->first();
                            $trackCustomer = $firstOrder ? $firstOrder->customer : null;
                        @endphp
                        
                        @if($trackCustomer && !str_starts_with(strtoupper($keyword), 'INV-'))
                        <div class="bg-zinc-900 border border-zinc-700/50 p-4 shrink-0">
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2">My Loyalty Card</p>
                            <div class="flex flex-wrap gap-2 items-center">
                                @for($i = 1; $i <= 10; $i++)
                                    @if($i <= $trackCustomer->stamp_count)
                                        <div class="w-6 h-6 rounded-full bg-yellow-500 border-2 border-yellow-400 flex items-center justify-center shadow-[0_0_10px_rgba(234,179,8,0.3)]">
                                            <svg class="w-3 h-3 text-black" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-zinc-950 border border-zinc-700 flex items-center justify-center">
                                            <span class="text-[8px] text-zinc-700 font-black">{{ $i }}</span>
                                        </div>
                                    @endif
                                @endfor
                                <span class="ml-2 text-[10px] font-black text-yellow-500">{{ $trackCustomer->stamp_count }} / 10</span>
                            </div>
                            <p class="text-[8px] text-zinc-500 mt-2 italic">* 1 Stamp diberikan saat cucian selesai.</p>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-6 md:space-y-8">
                        @foreach($orders as $order)
                            <div class="bg-zinc-900 border-t-4 border-t-yellow-500 border-x border-b border-zinc-800 p-6 md:p-8 relative overflow-hidden flex flex-col md:flex-row gap-8">
                                
                                <div class="flex-grow">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-zinc-800/50 pb-4 mb-4">
                                        <div class="w-full text-left">
                                            <h3 class="text-xl md:text-2xl font-black text-white tracking-widest">
                                                {{ $order->invoice_number }}
                                            </h3>
                                            <p class="text-[9px] md:text-[10px] font-bold text-zinc-500 uppercase tracking-widest mt-1 hidden md:block">
                                                Tgl Masuk: {{ $order->created_at->format('d M Y') }}
                                            </p>
                                        </div>

                                        <div class="mt-4 md:mt-0 w-full md:w-auto text-left md:text-right flex flex-col md:items-end gap-2">
                                            {{-- Status Aktual Badge --}}
                                            @php
                                                $statusColors = [
                                                    'Antrian' => 'bg-zinc-800 text-zinc-300 border-zinc-600',
                                                    'Dicuci' => 'bg-blue-900/40 text-blue-400 border-blue-500/50',
                                                    'Dikeringkan' => 'bg-orange-900/40 text-orange-400 border-orange-500/50',
                                                    'Siap Diambil' => 'bg-green-900/40 text-green-400 border-green-500/50',
                                                    'Selesai' => 'bg-yellow-900/40 text-yellow-500 border-yellow-500/50',
                                                ];
                                                $sClass = $statusColors[$order->order_status] ?? 'bg-zinc-800 text-zinc-300';
                                            @endphp
                                            <span class="inline-block px-3 py-2 border text-[9px] font-black uppercase tracking-[0.2em] {{ $sClass }}">
                                                {{ $order->order_status }}
                                            </span>

                                            {{-- Status Bayar --}}
                                            @if(strtolower($order->payment_status) == 'paid')
                                                <span class="inline-block px-3 py-1 bg-green-500/10 text-green-500 text-[8px] font-black uppercase tracking-widest">
                                                    LUNAS
                                                </span>
                                            @elseif(strtolower($order->payment_status) == 'dp')
                                                <span class="inline-block px-3 py-1 bg-orange-500/10 text-orange-500 text-[8px] font-black uppercase tracking-widest">
                                                    DP: Rp{{ number_format($order->dp_amount,0,',','.') }}
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-red-500/10 text-red-500 text-[8px] font-black uppercase tracking-widest">
                                                    BELUM LUNAS
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach($order->orderDetails as $detail)
                                            <div class="flex justify-between items-center text-sm border-b border-zinc-800/30 pb-3 text-left">
                                                <div class="font-bold text-zinc-300 uppercase tracking-wide text-xs">
                                                    <span class="text-zinc-600 mr-2">{{ $detail->quantity }}x</span>
                                                    {{ $detail->item_variant }}
                                                </div>
                                                <div class="text-zinc-500 text-[9px] font-black tracking-widest uppercase">
                                                    {{ $detail->service?->name ?? 'Layanan' }} (Rp{{ number_format($detail->subtotal,0,',','.') }})
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-4 pt-4 flex justify-between items-center text-left">
                                        <div>
                                            <span class="text-[9px] font-black uppercase tracking-widest text-zinc-500 block">Pelanggan</span>
                                            {{ $order->customer?->name ?? 'Pelanggan' }}
                                        </div>
                                        <div>
                                            <span class="text-[9px] font-black uppercase tracking-widest text-zinc-500 block text-right">Tipe Antar</span>
                                            <span class="text-[11px] font-bold text-zinc-300 uppercase text-right block">{{ rtrim($order->order_type, " \n\r\t\v\0") ?? 'Drop' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Kotak Grand Total Kanan --}}
                                <div class="bg-zinc-950/50 p-4 border-l border-zinc-900 md:w-48 flex flex-col justify-center items-center md:items-end text-center md:text-right shrink-0">
                                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2">Grand Total</span>
                                    <span class="font-black text-xl text-yellow-500 tracking-wider block">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    @if($order->discount_amount > 0)
                                        <span class="text-green-500 text-[8px] font-black mt-2 bg-green-500/10 px-2 py-1 max-w-full truncate">- Diskon Rp{{ number_format($order->discount_amount,0,',','.') }}</span>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-zinc-900 border border-zinc-800 p-10 md:p-16 text-center mx-auto">
                        <span class="text-3xl md:text-4xl block mb-4 md:mb-6 opacity-30">Ø</span>
                        <p class="text-zinc-500 tracking-[0.1em] md:tracking-[0.2em] uppercase text-[10px] md:text-xs font-black">
                            Pesanan tidak ditemukan.<br>Pastikan nomor Invoice atau WA benar.
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </section>

    {{-- FOOTER --}}
    <footer class="bg-zinc-950 border-t border-zinc-900 pt-10 pb-10 w-full mt-auto">
        <div class="max-w-4xl mx-auto px-5 text-center">
            <p class="text-[8px] md:text-[9px] font-black tracking-[0.2em] md:tracking-[0.4em] uppercase text-zinc-700">
                &copy; {{ date('Y') }} Luxesole. The Authentic Care.
            </p>
        </div>
    </footer>

</body>
</html>
