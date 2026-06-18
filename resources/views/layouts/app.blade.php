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
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b2c70', // Deep purple from reference
                        secondary: '#4f3c9e',
                        accent: '#6366f1' // Indigo
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* slate-50 */
        }
        .logo-font {
            font-family: 'Caveat', cursive;
        }
    </style>
</head>

<body class="text-slate-800 antialiased min-h-screen">
    {{-- Mobile Topbar --}}
    <div
        class="lg:hidden bg-primary shadow-md px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="text-white font-bold logo-font text-3xl tracking-wider">Luxesole</div>
        <button id="mobile-menu-btn" class="text-white/70 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-primary text-white shadow-xl transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-300 ease-in-out flex flex-col">
            {{-- Logo --}}
            <div class="p-6">
                <h1 class="text-white font-bold logo-font text-4xl tracking-wider select-none">Luxesole</h1>
                <p class="text-white/50 text-[10px] tracking-[0.3em] font-bold uppercase mt-1">Point of Sale</p>
            </div>

            {{-- User Info --}}
            <div class="px-6 pb-4">
                <div class="bg-secondary rounded-xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center font-bold text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white truncate max-w-[120px]">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-semibold text-white/70 uppercase tracking-widest mt-0.5">
                            {{ auth()->user()->role }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow py-4 space-y-1 overflow-y-auto px-3">
                @if(auth()->user()->role === 'owner')
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                @endif
                <a href="{{ route('orders.create') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('orders.create') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    POS Kasir
                </a>
                <a href="{{ route('orders.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('orders.index') || request()->routeIs('orders.show') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    Antrean
                </a>
                <a href="{{ route('customers.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('customers.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Pelanggan
                </a>
                <a href="{{ route('expenses.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('expenses.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Pengeluaran
                </a>

                @if(auth()->user()->role === 'owner')
                    <div class="px-4 pt-6 pb-2">
                        <span class="text-[10px] font-bold tracking-widest text-white/40 uppercase">Master Data</span>
                    </div>
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('categories.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h10v10H7zM7 11h10M11 7v10"></path>
                        </svg>
                        Kategori
                    </a>
                    <a href="{{ route('services.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('services.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Layanan
                    </a>
                @endif
            </nav>

            <div class="p-4 mt-auto">
                <button id="openEndShiftModal" type="button"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-white/70 hover:bg-white/10 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    End Shift
                </button>

                <form action="{{ route('logout') }}" method="POST" class="mt-1">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-white/70 hover:bg-red-500/20 hover:text-red-400 transition-colors">
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
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden lg:hidden backdrop-blur-sm"></div>

        {{-- End Shift Modal (Light Theme) --}}
        <div id="endShiftModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4 py-6 backdrop-blur-sm">
            <div class="w-full max-w-xl bg-white border border-slate-200 rounded-2xl p-6 shadow-xl">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Konfirmasi End Shift</h2>
                        <p class="text-sm text-slate-500 mt-1">Pastikan semua transaksi sudah ditutup sebelum mengakhiri shift.</p>
                    </div>
                    <button type="button" id="closeEndShiftModal" class="text-slate-400 hover:text-slate-600 bg-slate-100 p-2 rounded-full">✕</button>
                </div>

                <div id="endShiftSummary" class="space-y-4 text-sm text-slate-600">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Cash Pending</p>
                            <p id="endShiftCashTotal" class="text-xl font-bold text-slate-800">Rp 0</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Non-Cash Pending</p>
                            <p id="endShiftNonCashTotal" class="text-xl font-bold text-slate-800">Rp 0</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Gross Pending</p>
                            <p id="endShiftGrossTotal" class="text-2xl font-black text-indigo-600">Rp 0</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl flex justify-between items-center">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembayaran Belum Dipindahkan</p>
                        <p id="endShiftPaymentCount" class="font-bold text-slate-800">0 transaksi</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl flex justify-between items-center">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mulai Shift</p>
                        <p id="endShiftStartedAt" class="font-bold text-slate-800">-</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <button id="confirmEndShift" type="button" class="w-full sm:w-auto flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">Tutup Shift</button>
                    <button id="cancelEndShift" type="button" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-colors">Batal</button>
                </div>
                <p id="endShiftMessage" class="mt-3 text-sm font-medium text-red-500 hidden text-center"></p>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-grow w-full lg:w-auto p-4 sm:p-6 lg:p-8 min-h-screen max-w-7xl mx-auto">
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