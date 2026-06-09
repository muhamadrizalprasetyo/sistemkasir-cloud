<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxesole - Workshop</title>

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
        /* Base Reset Brutalism */
        * {
            border-radius: 0 !important;
        }

        /* Fade-in Animation */
        .fade-in-section {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, visibility;
        }

        .fade-in-section.is-visible {
            opacity: 1;
            transform: none;
        }

        /* Input Glow Subtle */
        .input-glow {
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .input-glow:focus {
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.1);
            border-color: #eab308;
        }

        /* Image Grayscale & Hover */
        .raw-img {
            filter: grayscale(100%) contrast(1.1);
            transition: filter 0.6s ease, transform 1s ease;
        }

        .raw-img:hover {
            filter: grayscale(0%) contrast(1);
            transform: scale(1.02);
            z-index: 10;
        }
    </style>
</head>

<body
    class="bg-zinc-950 text-zinc-300 antialiased selection:bg-yellow-500 selection:text-black flex flex-col min-h-screen overflow-x-hidden">

    {{-- 1. HERO SECTION --}}
    <header
        class="bg-cover bg-center min-h-[100dvh] w-full relative flex flex-col items-center justify-center border-b border-zinc-900"
        style="background-image: url('{{ asset('hero/bghero.png') }}');">
        <div class="absolute inset-0 bg-zinc-950/70"></div>

        <!-- Navbar -->
        <nav
            class="absolute top-0 left-0 w-full p-5 md:p-8 flex justify-between items-center z-10 border-b border-zinc-900/80">
            <div class="font-caveat text-3xl md:text-4xl text-yellow-500 font-bold tracking-wider select-none">Luxesole
            </div>
            <a href="#track"
                class="text-[10px] md:text-xs font-black tracking-[0.2em] uppercase text-zinc-400 hover:text-yellow-500 transition-colors border border-transparent hover:border-yellow-500 px-3 py-2">Lacak
                Pesanan</a>
        </nav>

        <!-- Main Quote -->
        <div class="relative z-10 text-center px-4 mt-8 w-full max-w-4xl mx-auto">
            <h1
                class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-black uppercase tracking-tighter mb-4 md:mb-6 text-white leading-[1.1] md:leading-[0.9]">
                Merakit kembali<br>
                langkah yang<br>
                <span class="text-zinc-600 line-through decoration-yellow-500 decoration-4 md:decoration-8">sempat
                    usang.</span>
            </h1>
            <div class="w-12 md:w-16 h-1 flex-shrink-0 bg-yellow-500 mx-auto my-6 md:my-8"></div>
            <p
                class="text-xs md:text-lg font-light tracking-[0.1em] text-zinc-400 max-w-2xl mx-auto leading-relaxed md:leading-loose px-4">
                Di Luxesole, kita bicara tentang ketenangan, bukan sekadar bersih.
            </p>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 flex flex-col items-center opacity-50">
            <span
                class="text-[9px] uppercase tracking-[0.2em] md:tracking-[0.3em] font-black text-zinc-500 mb-3 [writing-mode:vertical-rl]">SCROLL</span>
            <div class="w-[1px] h-8 md:h-12 bg-zinc-600"></div>
        </div>
    </header>


    {{-- 2. BEFORE & AFTER GALLERY SECTION --}}
    <section class="py-20 md:py-32 bg-zinc-950 border-b border-zinc-900 w-full overflow-hidden">
        <div class="max-w-6xl mx-auto px-5 md:px-12">

            <div
                class="mb-12 md:mb-20 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 border-b border-zinc-900 pb-8 md:pb-12 text-center lg:text-left">
                <div class="w-full lg:w-auto">
                    <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter text-white leading-none">
                        Dokumentasi<br>Kediaman</h2>
                </div>
                <div class="w-full lg:text-right max-w-sm mx-auto lg:mx-0 mt-4 lg:mt-0">
                    <p class="italic text-zinc-500 font-serif text-base md:text-xl tracking-wide">"Satu sepatu, seribu
                        cerita."</p>
                </div>
            </div>

            <!-- Grid Gallery (3 Items max) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

                <!-- Foto 1 -->
                <div class="fade-in-section relative group w-full">
                    <div class="w-full overflow-hidden bg-zinc-900 border border-zinc-800">
                        <img src="{{ asset('before&after/foto1.png') }}"
                            onerror="this.onerror=null; this.src='{{ asset('before&after/foto1.jpg') }}';"
                            alt="Dokumentasi 1" class="raw-img w-full h-auto object-contain">
                    </div>
                </div>

                <!-- Foto 2 -->
                <div class="fade-in-section relative group w-full md:mt-8" style="transition-delay: 150ms;">
                    <div class="w-full overflow-hidden bg-zinc-900 border border-zinc-800">
                        <img src="{{ asset('before&after/foto2.png') }}"
                            onerror="this.onerror=null; this.src='{{ asset('before&after/foto2.jpg') }}';"
                            alt="Dokumentasi 2" class="raw-img w-full h-auto object-contain">
                    </div>
                </div>

                <!-- Foto 3 -->
                <div class="fade-in-section relative group w-full md:mt-16" style="transition-delay: 300ms;">
                    <div class="w-full overflow-hidden bg-zinc-900 border border-zinc-800">
                        <img src="{{ asset('before&after/foto3.png') }}"
                            onerror="this.onerror=null; this.src='{{ asset('before&after/foto3.jpg') }}';"
                            alt="Dokumentasi 3" class="raw-img w-full h-auto object-contain">
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- 3. TRACKING SECTION --}}
    <section id="track"
        class="py-24 md:py-32 px-5 md:px-12 max-w-4xl mx-auto w-full flex-grow flex flex-col justify-center relative">
        <!-- Header -->
        <div class="mb-10 md:mb-16 text-center md:text-left">
            <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter text-white mb-4 md:mb-6">
                Penelusuran<br class="hidden md:block">Jejak</h2>
            <div class="w-12 md:w-16 h-1 bg-yellow-500 mb-6 mx-auto md:mx-0"></div>
            <p class="text-[10px] md:text-xs text-zinc-500 tracking-[0.1em] md:tracking-[0.2em] font-black uppercase">
                Masukkan nomor invoice atau kontak Anda.</p>
        </div>

        <!-- Form Tracking -->
        <form action="{{ route('track.search') }}" method="POST" class="flex flex-col md:flex-row gap-0">
            @csrf
            <input type="text" name="keyword" value="{{ old('keyword', $keyword ?? request('keyword') ?? request('query')) }}" placeholder="INV-... / 0812..." required
                class="input-glow w-full bg-zinc-900 border-2 border-zinc-800 px-5 md:px-6 py-5 md:py-6 text-lg md:text-xl font-bold text-white placeholder-zinc-700 outline-none text-center md:text-left">
            <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-[0.2em] text-xs md:text-sm px-6 md:px-10 py-5 md:py-6 transition-colors w-full md:w-auto mt-4 md:mt-0 active:scale-[0.98]">
                Lacak Sepatu
            </button>
        </form>

        <!-- Tracking Results -->
        @if(request('keyword'))
            <div class="mt-16 md:mt-20 fade-in-section is-visible">
                @if(isset($orders) && $orders->count() > 0)
                    <div class="space-y-6 md:space-y-8">
                        @foreach($orders as $order)
                            <div
                                class="bg-zinc-900 border-t-4 border-t-yellow-500 border-x border-b border-zinc-800 p-6 md:p-12 relative overflow-hidden">

                                <div
                                    class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-zinc-800/50 pb-6 md:pb-8 mb-6 md:mb-8">
                                    <div class="w-full text-center md:text-left">
                                        <h3 class="text-xl md:text-3xl font-black text-white tracking-widest">
                                            {{ $order->invoice_number }}
                                        </h3>
                                        <p class="text-[10px] md:text-xs font-bold text-zinc-500 uppercase tracking-widest mt-2">
                                            {{ $order->customer->name }}
                                        </p>
                                    </div>
                                    <div class="mt-6 md:mt-0 w-full md:w-auto text-center md:text-right">
                                        <span
                                            class="inline-block px-4 md:px-5 py-2 md:py-3 border border-yellow-500 text-yellow-500 text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] bg-yellow-500/10 w-full md:w-auto">
                                            {{ $order->order_status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    @foreach($order->orderDetails as $detail)
                                        <div
                                            class="flex flex-col md:flex-row justify-between items-center md:items-center text-sm border-b border-zinc-800/30 pb-4 text-center md:text-left">
                                            <div class="font-bold text-zinc-300 uppercase tracking-wide">
                                                <span class="text-zinc-600 mr-2 md:mr-3">{{ $detail->quantity }}x</span>
                                                {{ $detail->item_variant }}
                                            </div>
                                            <div
                                                class="text-zinc-500 text-[9px] md:text-[10px] font-black tracking-widest uppercase mt-2 md:mt-0">
                                                {{ $detail->service->name ?? 'Layanan' }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div
                                    class="mt-8 md:mt-10 pt-5 md:pt-6 flex flex-col md:flex-row justify-between items-center bg-zinc-950/50 p-4 md:p-6 border border-zinc-800/50">
                                    <span
                                        class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2 md:mb-0">Estimasi
                                        Total</span>
                                    <span
                                        class="font-black text-lg md:text-xl text-yellow-500 tracking-wider">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-zinc-900 border border-zinc-800 p-10 md:p-16 text-center mx-auto">
                        <span class="text-3xl md:text-4xl block mb-4 md:mb-6 opacity-30">Ø</span>
                        <p
                            class="text-zinc-500 tracking-[0.1em] md:tracking-[0.2em] uppercase text-[10px] md:text-xs font-black">
                            Jejak sepatu tidak ditemukan tertinggal di sini.</p>
                    </div>
                @endif
            </div>
        @endif
    </section>


    {{-- 4. FOOTER --}}
    <footer class="bg-zinc-950 border-t border-zinc-900 pt-20 md:pt-32 pb-12 w-full mt-auto">
        <div class="max-w-4xl mx-auto px-5 md:px-6 text-center">

            <div class="mb-12 md:mb-16">
                <p
                    class="text-sm md:text-xl font-light tracking-[0.1em] text-zinc-400 leading-relaxed md:leading-loose max-w-xl mx-auto">
                    Workshop kami terbuka untuk mereka yang lelah berlari.<br class="hidden md:block">
                    Temui kami di <strong class="text-zinc-200 font-black">Tangerang.</strong><br
                        class="hidden md:block">
                    Mari cuci sepatumu, nanti kita cari tahu siapa yang paling lelah.
                </p>
            </div>

            <h2
                class="font-caveat text-5xl md:text-6xl text-yellow-500 mb-10 md:mb-16 select-none opacity-80 hover:opacity-100 transition-opacity cursor-default">
                Luxesole</h2>

            <div class="w-12 h-[1px] bg-zinc-800 mx-auto mb-10 md:mb-16"></div>

            <p class="text-[8px] md:text-[9px] font-black tracking-[0.2em] md:tracking-[0.4em] uppercase text-zinc-700">
                &copy; {{ date('Y') }} Luxesole. The Authentic Care.
            </p>
        </div>
    </footer>

    {{-- SCRIPTS: Vanilla JS Intersection Observer for Fade-In --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Setup Intersection Observer parameters
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            // Observer Callback
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Select all elements to observe
            const fadeElements = document.querySelectorAll('.fade-in-section');

            // Initiate observing
            fadeElements.forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>