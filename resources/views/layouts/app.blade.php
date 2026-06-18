<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Luxesole System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Space+Grotesk:wght@300;400;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#121212',
                        darker: '#0a0a0a',
                        accent: '#eab308'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
        }

        .logo-font {
            font-family: 'Caveat', cursive;
        }
    </style>
</head>

<body class="bg-zinc-950 text-gray-200 antialiased min-h-screen">
    {{-- Mobile Topbar --}}
    <div
        class="lg:hidden bg-zinc-900 border-b border-zinc-800/60 px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="text-yellow-500 font-bold logo-font text-3xl tracking-wider">Luxesole</div>
        <button id="mobile-menu-btn" class="text-zinc-500 hover:text-yellow-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-zinc-900 border-r border-zinc-800/60 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-300 ease-in-out flex flex-col">
            {{-- Logo --}}
            <div class="p-6 border-b border-zinc-800/60">
                <h1 class="text-yellow-500 font-bold logo-font text-4xl tracking-wider select-none">Luxesole</h1>
                <p class="text-zinc-500 text-[10px] tracking-[0.3em] font-black uppercase mt-1">Point of Sale</p>
            </div>

            {{-- User Info --}}
            <div class="px-6 py-4 border-b border-zinc-800/60">
                <p class="text-sm font-black text-zinc-300 truncate">{{ auth()->user()->name }}</p>
                <span
                    class="text-[10px] font-black tracking-widest uppercase mt-1 inline-block px-2 py-1 rounded-none border {{ auth()->user()->role === 'owner' ? 'border-yellow-500 text-yellow-500' : 'border-blue-500 text-blue-500' }}">
                    {{ auth()->user()->role }}
                </span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow py-6 space-y-1 overflow-y-auto">
                @if(auth()->user()->role === 'owner')
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                @endif
                <a href="{{ route('orders.create') }}"
                    class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('orders.create') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    POS Kasir
                </a>
                <a href="{{ route('orders.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('orders.index') || request()->routeIs('orders.show') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    Antrean
                </a>
                <a href="{{ route('customers.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('customers.*') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Pelanggan
                </a>
                <a href="{{ route('expenses.index') }}"
                    class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('expenses.*') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Pengeluaran
                </a>

                @if(auth()->user()->role === 'owner')
                    <div class="px-6 pt-6 pb-2">
                        <span
                            class="text-[10px] font-black tracking-widest text-zinc-600 uppercase border-b border-zinc-800/60 pb-1 flex w-full">Master
                            Data</span>
                    </div>
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('categories.*') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h10v10H7zM7 11h10M11 7v10"></path>
                        </svg>
                        Kategori
                    </a>
                    <a href="{{ route('services.index') }}"
                        class="flex items-center gap-3 px-6 py-3 text-sm font-bold transition-all uppercase tracking-widest {{ request()->routeIs('services.*') ? 'bg-zinc-800 border-l-4 border-yellow-500 text-white' : 'text-zinc-500 border-l-4 border-transparent hover:text-zinc-300' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Layanan
                    </a>
                @endif
            </nav>

            <div class="border-t border-zinc-800/60 p-4 space-y-3">
                <button id="openEndShiftModal" type="button"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-none text-sm font-black text-zinc-500 hover:bg-zinc-800 hover:text-yellow-500 transition-colors uppercase tracking-widest border border-transparent hover:border-zinc-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    End Shift
                </button>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-none text-sm font-black text-zinc-500 hover:bg-zinc-800 hover:text-red-500 transition-colors uppercase tracking-widest border border-transparent hover:border-zinc-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay (Mobile) --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/80 z-30 hidden lg:hidden backdrop-blur-sm"></div>

        {{-- End Shift Modal --}}
        <div id="endShiftModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 px-4 py-6">
            <div class="w-full max-w-xl bg-zinc-950 border border-zinc-800 rounded-none p-6 shadow-2xl shadow-black/90">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-black text-white uppercase tracking-[0.2em]">Konfirmasi End Shift</h2>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-[0.2em] mt-1">Pastikan semua transaksi sudah ditutup sebelum mengakhiri shift.</p>
                    </div>
                    <button type="button" id="closeEndShiftModal" class="text-zinc-400 hover:text-white">✕</button>
                </div>

                <div id="endShiftSummary" class="space-y-4 text-sm text-zinc-300">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500">Cash Pending</p>
                            <p id="endShiftCashTotal" class="text-xl font-black text-yellow-500">Rp 0</p>
                        </div>
                        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500">Non-Cash Pending</p>
                            <p id="endShiftNonCashTotal" class="text-xl font-black text-yellow-500">Rp 0</p>
                        </div>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500">Gross Pending</p>
                        <p id="endShiftGrossTotal" class="text-2xl font-black text-emerald-400">Rp 0</p>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500">Pembayaran Belum Dipindahkan</p>
                        <p id="endShiftPaymentCount" class="font-black text-zinc-200">0 transaksi</p>
                    </div>
                    <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-none">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500">Mulai Shift</p>
                        <p id="endShiftStartedAt" class="font-black text-zinc-200">-</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <button id="confirmEndShift" type="button" class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-widest py-3 rounded-none transition-colors">Tutup Shift</button>
                    <button id="cancelEndShift" type="button" class="w-full sm:w-auto bg-zinc-800 hover:bg-zinc-700 text-white font-black uppercase tracking-widest py-3 rounded-none transition-colors">Batal</button>
                </div>
                <p id="endShiftMessage" class="mt-3 text-[10px] text-red-500 hidden"></p>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-grow w-full lg:w-auto p-4 sm:p-6 lg:p-8 min-h-screen">
            @yield('content')
        </main>
    </div>

    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        menuBtn.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);

        const endShiftButton = document.getElementById('openEndShiftModal');
        const endShiftModal = document.getElementById('endShiftModal');
        const closeEndShiftModal = document.getElementById('closeEndShiftModal');
        const cancelEndShift = document.getElementById('cancelEndShift');
        const confirmEndShift = document.getElementById('confirmEndShift');
        const endShiftCashTotal = document.getElementById('endShiftCashTotal');
        const endShiftNonCashTotal = document.getElementById('endShiftNonCashTotal');
        const endShiftGrossTotal = document.getElementById('endShiftGrossTotal');
        const endShiftPaymentCount = document.getElementById('endShiftPaymentCount');
        const endShiftStartedAt = document.getElementById('endShiftStartedAt');
        const endShiftMessage = document.getElementById('endShiftMessage');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function openEndShift() {
            endShiftMessage.classList.add('hidden');
            endShiftMessage.textContent = '';
            fetch("{{ route('shift.summary') }}")
                .then(response => response.json())
                .then(data => {
                    endShiftCashTotal.textContent = 'Rp ' + Number(data.cash_total).toLocaleString('id-ID');
                    endShiftNonCashTotal.textContent = 'Rp ' + Number(data.non_cash_total).toLocaleString('id-ID');
                    endShiftGrossTotal.textContent = 'Rp ' + Number(data.gross_total).toLocaleString('id-ID');
                    endShiftPaymentCount.textContent = data.payment_count + ' transaksi';
                    endShiftStartedAt.textContent = data.started_at;
                    endShiftModal.classList.remove('hidden');
                    endShiftModal.classList.add('flex');
                })
                .catch(() => {
                    endShiftMessage.textContent = 'Gagal memuat data shift. Coba lagi.';
                    endShiftMessage.classList.remove('hidden');
                    endShiftModal.classList.remove('hidden');
                    endShiftModal.classList.add('flex');
                });
        }

        function closeEndShift() {
            endShiftModal.classList.add('hidden');
            endShiftModal.classList.remove('flex');
        }

        if (endShiftButton) {
            endShiftButton.addEventListener('click', openEndShift);
        }
        if (closeEndShiftModal) {
            closeEndShiftModal.addEventListener('click', closeEndShift);
        }
        if (cancelEndShift) {
            cancelEndShift.addEventListener('click', closeEndShift);
        }
        if (endShiftModal) {
            endShiftModal.addEventListener('click', function (event) {
                if (event.target === endShiftModal) {
                    closeEndShift();
                }
            });
        }
        if (confirmEndShift) {
            confirmEndShift.addEventListener('click', function () {
                confirmEndShift.disabled = true;
                confirmEndShift.textContent = 'Menyimpan...';
                fetch("{{ route('shift.end') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({}),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            throw new Error('Shift gagal ditutup');
                        }
                    })
                    .catch(() => {
                        endShiftMessage.textContent = 'Terjadi kesalahan saat menutup shift. Coba lagi.';
                        endShiftMessage.classList.remove('hidden');
                    })
                    .finally(() => {
                        confirmEndShift.disabled = false;
                        confirmEndShift.textContent = 'Tutup Shift';
                    });
            });
        }
    </script>
</body>

</html>