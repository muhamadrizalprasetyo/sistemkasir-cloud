@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-black text-yellow-500 uppercase tracking-widest mb-1">Point of Sale</h2>
        <p class="text-zinc-500 text-sm uppercase tracking-[0.2em]">Pelanggan → Pesanan → Pembayaran → Layanan → Nota</p>
    </div>

    @if(session('error'))
        <div class="bg-red-950/20 border-l-2 border-red-600 p-4 mb-8 rounded-none">
            <p class="text-[11px] font-bold text-red-500 uppercase tracking-widest italic">
                Error: {{ session('error') }}
            </p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-950/20 border-l-2 border-red-600 p-4 mb-8 rounded-none">
            @foreach($errors->all() as $error)
                <p class="text-[11px] font-bold text-red-500 uppercase tracking-widest italic">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Data Pelanggan -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Informasi Pelanggan & Pembayaran -->
                <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 relative mb-6">
                    <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-zinc-700 m-2"></div>
                    <h3
                        class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-800/60 pb-3 mb-4">
                        Data Pesanan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Pilih
                                Pelanggan</label>
                            <input type="text" id="customer_search" placeholder="Cari pelanggan: nama / WA"
                                class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-600 text-sm mb-3">
                            <select name="customer_id" id="customer_id"
                                class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all appearance-none text-sm">
                                <option value="new" data-membership="regular">-- + PELANGGAN BARU (Input Manual) --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" data-membership="{{ $customer->membership_type }}"
                                        data-stamps="{{ $customer->stamp_count }}">
                                        {{ $customer->name }} ({{ $customer->phone ?? 'Tanpa No' }})
                                    </option>
                                @endforeach
                            </select>

                            <div id="new_customer_fields" class="mt-4 space-y-4 bg-zinc-950 p-4 border border-zinc-800">
                                <p
                                    class="text-[9px] text-zinc-500 uppercase tracking-widest border-b border-zinc-800 pb-2">
                                    Pelanggan Baru</p>
                                <div>
                                    <input type="text" name="new_customer_phone" placeholder="No. WA (0812...)"
                                        class="w-full bg-zinc-900 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-600 text-sm">
                                </div>
                                <div>
                                    <input type="text" name="new_customer_name" placeholder="Nama Lengkap"
                                        class="w-full bg-zinc-900 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-600 text-sm">
                                </div>
                            </div>
                            <div id="membership_badge" class="mt-2 hidden">
                                <span
                                    class="bg-green-500/20 text-green-500 border border-green-500/50 text-[9px] font-black uppercase tracking-widest px-3 py-1 inline-block">
                                    MEMBER MORE RUNNING CLUB TERDETEKSI! DISKON 10% AKAN AKTIF
                                </span>
                            </div>
                            <div id="loyalty_badge" class="mt-2 hidden">
                                <span
                                    class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/50 text-[9px] font-black uppercase tracking-widest px-3 py-1 inline-block">
                                    MEMILIKI 10 STAMPS! DISKON RP35.000 AKAN AKTIF OTOMATIS
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Tipe
                                Pesanan</label>
                            <select name="order_type" required
                                class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all appearance-none text-sm">
                                <option value="drop">Drop di Toko</option>
                                <option value="pickup">Pick-up</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Metode
                                    Bayar</label>
                                <select name="payment_method" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all appearance-none text-sm">
                                    <option value="cash">Cash / Tunai</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Nominal
                                    DP Awal</label>
                                <input type="number" name="dp_amount" id="dp_amount" value="0" min="0" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-600 text-sm font-mono"
                                    placeholder="0">
                                <p id="dp_warning" class="mt-2 text-[9px] text-red-500 font-bold italic hidden">Nominal DP tidak boleh melebihi Total Tagihan.</p>
                            </div>
                        </div>
                        <p class="text-[9px] text-zinc-500 italic w-full">Isi 0 jika belum bayar DP.</p>

                        <div class="pt-3 border-t border-zinc-800/60 mt-3">
                            <label
                                class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Catatan
                                Kasir</label>
                            <textarea name="notes" rows="2"
                                class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 text-zinc-200 focus:outline-none focus:border-zinc-500 transition-all placeholder-zinc-600 text-sm"
                                placeholder="Kondisi barang, keluhan, dll">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 mb-4">
                    <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-800/60 pb-3 mb-4">Ringkasan Order</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-zinc-400 uppercase tracking-[0.2em]"><span>Total Tagihan</span><span id="grand_total_display" class="font-black text-yellow-500">Rp 0</span></div>
                        <div class="flex justify-between text-zinc-400 uppercase tracking-[0.2em]"><span>Sisa Pelunasan</span><span id="sisa_tagihan_display" class="font-black text-red-500">Rp 0</span></div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-widest py-4 rounded-none transition-colors border border-yellow-500 shadow-[4px_4px_0_rgba(255,255,255,0.1)] active:scale-[0.98]">
                    Proses Nota
                </button>
            </div>

            <!-- Kolom Kanan: Pemilihan Layanan -->
            <div class="lg:col-span-2">
                <div
                    class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 h-full relative">
                    <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-zinc-700 m-2"></div>
                    <h3
                        class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-800/60 pb-3 mb-4 pl-8">
                        Daftar Layanan
                    </h3>

                    @php
                        $servicesByCategory = $services->groupBy(fn($service) => $service->category?->name ?? 'Lainnya');
                    @endphp
                    <div class="mb-6">
                        <h4 class="text-white text-sm font-black uppercase tracking-[0.2em] mb-4">Pilih Kategori</h4>
                        <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            @foreach($servicesByCategory as $categoryName => $group)
                                <button type="button"
                                    class="category-btn rounded-none border-2 border-zinc-700 p-4 bg-zinc-900 hover:bg-yellow-500 hover:border-yellow-500 transition-all text-white font-bold uppercase tracking-[0.2em] text-sm"
                                    data-category-name="{{ $categoryName }}"
                                    data-category-services='{{ json_encode($group->map(fn($s) => ["id" => $s->id, "name" => $s->name, "price" => $s->price, "estimation" => $s->estimation_days])->values()) }}'>
                                    {{ $categoryName }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div id="service-items" class="space-y-4">
                        <!-- Item 1 (Utama) -->
                        <div
                            class="service-item bg-zinc-950/50 p-5 border border-zinc-800/60 rounded-none flex flex-col md:flex-row gap-4 items-end transition-all">
                            <div class="flex-1 w-full text-zinc-200">
                                <label
                                    class="block text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] mb-2">Layanan</label>
                                <div class="service-card-field border border-zinc-800 rounded-none p-4 bg-zinc-950 flex flex-col gap-2">
                                    <div class="selected-service-text text-sm text-zinc-300">Pilih layanan dari kartu di atas</div>
                                    <button type="button" class="choose-service-btn self-start bg-zinc-800 hover:bg-zinc-700 text-white text-xs uppercase tracking-[0.2em] px-4 py-2 rounded-none transition-all">Pilih Layanan</button>
                                </div>
                                <select name="items[0][service_id]" required class="hidden service-select">
                                    <option value="">-- Pilih Layanan --</option>
                                </select>
                            </div>
                            <div class="flex-1 w-full text-zinc-200">
                                <label
                                    class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Merek/Varian</label>
                                <input type="text" name="items[0][item_variant]" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-3 py-3 focus:outline-none focus:border-zinc-500 text-sm placeholder-zinc-600"
                                    placeholder="Contoh: Nike AF1">
                            </div>
                            <div class="w-full md:w-24 text-zinc-200">
                                <label
                                    class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Qty</label>
                                <input type="number" name="items[0][quantity]" value="1" min="1" required
                                    class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-3 py-3 focus:outline-none focus:border-zinc-500 text-center text-sm qty-input">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-zinc-800/60">
                        <button type="button" id="add-item"
                            class="bg-zinc-800 hover:bg-zinc-700 text-white font-bold uppercase tracking-widest text-[10px] px-6 py-4 rounded-none border border-zinc-700/50 transition-all w-full md:w-auto">
                            + Tambah Layanan Lainnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Service Selection Modal -->
    <div id="service-modal" class="fixed inset-0 bg-black/80 z-50 hidden flex items-end md:items-center justify-center">
        <div class="bg-zinc-900 border border-yellow-500 rounded-none w-full md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modal-category-title" class="text-white font-black uppercase tracking-[0.2em] text-lg">Pilih Layanan</h3>
                <button type="button" class="modal-close text-zinc-400 hover:text-white text-2xl">✕</button>
            </div>
            <div id="modal-services" class="grid gap-3 sm:grid-cols-2"></div>
        </div>
    </div>

    <script>
        const servicesAll = {!! $services->map(function($s){ return ['id' => $s->id, 'name' => $s->name, 'price' => $s->price, 'category' => $s->category?->name, 'estimation' => $s->estimation_days]; })->toJson() !!};

        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = 1;
            const addBtn = document.getElementById('add-item');
            const container = document.getElementById('service-items');
            const customerSelect = document.getElementById('customer_id');
            const customerSearch = document.getElementById('customer_search');
            const membershipBadge = document.getElementById('membership_badge');
            const loyaltyBadge = document.getElementById('loyalty_badge');
            const newCustomerFields = document.getElementById('new_customer_fields');
            const phoneInput = document.querySelector('input[name="new_customer_phone"]');
            const nameInput = document.querySelector('input[name="new_customer_name"]');
            const dpInput = document.getElementById('dp_amount');
            const dpWarning = document.getElementById('dp_warning');
            const grandTotalDisplay = document.getElementById('grand_total_display');
            const sisaTagihanDisplay = document.getElementById('sisa_tagihan_display');
            let currentGrandTotal = 0;

            addBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'service-item bg-zinc-950/50 p-5 border border-zinc-800/60 rounded-none flex flex-col md:flex-row gap-4 items-end mt-4 transition-all opacity-0';
                row.innerHTML = `
                    <div class="flex-1 w-full text-zinc-200">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Jenis Layanan</label>
                        <div class="service-card-field border border-zinc-800 rounded-none p-4 bg-zinc-950 flex flex-col gap-2">
                            <div class="selected-service-text text-sm text-zinc-300">Pilih layanan dari kartu di atas</div>
                            <div class="selected-service-meta text-[11px] text-zinc-500">Kategori & harga akan tampil setelah memilih layanan.</div>
                            <button type="button" class="choose-service-btn self-start bg-zinc-800 hover:bg-zinc-700 text-white text-xs uppercase tracking-[0.2em] px-4 py-2 rounded-none transition-all">Pilih Layanan</button>
                        </div>
                        <select name="items[${itemIndex}][service_id]" required class="hidden service-select">
                            <option value="">-- Pilih Layanan --</option>
                        </select>
                    </div>
                    <div class="flex-1 w-full text-zinc-200">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Merek/Varian</label>
                        <input type="text" name="items[${itemIndex}][item_variant]" required class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-3 py-3 focus:outline-none focus:border-zinc-500 text-sm placeholder-zinc-600" placeholder="Contoh: Vans Old Skool">
                    </div>
                    <div class="w-full md:w-24 text-zinc-200">
                        <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Qty</label>
                        <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" required class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-3 py-3 focus:outline-none focus:border-zinc-500 text-center text-sm qty-input">
                    </div>
                    <div class="md:pb-1 w-full md:w-auto text-right md:text-left mt-2 md:mt-0 lg:mb-1">
                        <button type="button" class="remove-btn text-red-500 hover:text-white hover:bg-red-900/50 text-[10px] font-black uppercase tracking-[0.2em] border border-red-500/30 p-2 lg:px-4 lg:py-2.5 rounded-none transition-colors border-dashed">
                            X
                        </button>
                    </div>
                `;
                // assign index for this row so modal can target it
                row.dataset.index = itemIndex;
                container.appendChild(row);

                setTimeout(() => {
                    row.classList.remove('opacity-0');
                }, 10);

                const removeBtn = row.querySelector('.remove-btn');
                removeBtn.addEventListener('click', function () {
                    row.classList.add('opacity-0');
                    setTimeout(() => {
                        row.remove();
                        calculateTotal();
                    }, 300);
                });

                const newServiceSelect = row.querySelector('.service-select');
                const newQtyInput = row.querySelector('.qty-input');
                const chooseServiceBtn = row.querySelector('.choose-service-btn');
                const selectedServiceText = row.querySelector('.selected-service-text');
                const selectedServiceMeta = row.querySelector('.selected-service-meta');

                newServiceSelect.addEventListener('change', calculateTotal);
                newQtyInput.addEventListener('input', calculateTotal);
                row.addEventListener('click', function (event) {
                    if (!event.target.closest('.remove-btn')) {
                        selectRow(row);
                    }
                });
                chooseServiceBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    // open modal in edit mode for this row
                    openModalForEdit(row.dataset.index);
                });

                    itemIndex++;
            });

                // ensure existing rows have stable indexes
                Array.from(document.querySelectorAll('.service-item')).forEach((r, i) => r.dataset.index = i);

            function initRow(row) {
                const removeBtn = row.querySelector('.remove-btn');
                const newServiceSelect = row.querySelector('.service-select');
                const newQtyInput = row.querySelector('.qty-input');
                const chooseServiceBtn = row.querySelector('.choose-service-btn');

                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        row.classList.add('opacity-0');
                        setTimeout(() => {
                            row.remove();
                            calculateTotal();
                        }, 300);
                    });
                }

                if (newServiceSelect) {
                    newServiceSelect.addEventListener('change', calculateTotal);
                }
                if (newQtyInput) {
                    newQtyInput.addEventListener('input', calculateTotal);
                }
                row.addEventListener('click', function (event) {
                    if (!event.target.closest('.remove-btn')) {
                        selectRow(row);
                    }
                });
                if (chooseServiceBtn) {
                    chooseServiceBtn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        openModalForEdit(row.dataset.index);
                    });
                }
            }

            const initialRow = container.querySelector('.service-item');
            if (initialRow) {
                initRow(initialRow);
                selectRow(initialRow);
            }

            // Modal handling
            const modal = document.getElementById('service-modal');
            const modalClose = document.querySelector('.modal-close');
            const modalTitle = document.getElementById('modal-category-title');
            const modalServices = document.getElementById('modal-services');
            const categoryBtns = document.querySelectorAll('.category-btn');

            modalClose.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });

            // open modal for category selection — mode 'add'
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const categoryName = this.getAttribute('data-category-name');
                    const servicesJson = this.getAttribute('data-category-services');
                    const services = JSON.parse(servicesJson);

                    modal.dataset.mode = 'add';
                    modal.dataset.category = categoryName;

                    modalTitle.textContent = categoryName;
                    modalServices.innerHTML = '';

                    services.forEach(service => {
                        const card = document.createElement('button');
                        card.type = 'button';
                        card.className = 'service-modal-card text-left rounded-none border border-zinc-700 p-4 bg-zinc-900 hover:bg-yellow-500 hover:border-yellow-500 transition-all';
                        card.innerHTML = `
                            <div class="text-white font-bold">${service.name}</div>
                            <div class="text-zinc-400 text-[11px] mt-1">Rp${Number(service.price).toLocaleString('id-ID')}</div>
                            <div class="text-zinc-400 text-[10px] uppercase tracking-[0.2em] mt-2">${service.estimation} hari</div>
                        `;
                        card.addEventListener('click', () => handleModalSelection(service, categoryName));
                        modalServices.appendChild(card);
                    });

                    modal.classList.remove('hidden');
                });
            });

            // open modal for editing a specific row
            function openModalForEdit(targetRowIndex) {
                modal.dataset.mode = 'edit';
                modal.dataset.targetRow = String(targetRowIndex);
                modalTitle.textContent = 'Pilih Layanan';
                modalServices.innerHTML = '';

                // show all services
                servicesAll.forEach(service => {
                    const card = document.createElement('button');
                    card.type = 'button';
                    card.className = 'service-modal-card text-left rounded-none border border-zinc-700 p-4 bg-zinc-900 hover:bg-yellow-500 hover:border-yellow-500 transition-all';
                    card.innerHTML = `
                        <div class="text-white font-bold">${service.name}</div>
                        <div class="text-zinc-400 text-[11px] mt-1">Rp${Number(service.price).toLocaleString('id-ID')}</div>
                        <div class="text-zinc-400 text-[10px] uppercase tracking-[0.2em] mt-2">${service.estimation} hari</div>
                    `;
                    card.addEventListener('click', () => handleModalSelection(service, service.category));
                    modalServices.appendChild(card);
                });

                modal.classList.remove('hidden');
            }

            function handleModalSelection(service, categoryName) {
                const mode = modal.dataset.mode || 'add';

                if (mode === 'edit' && modal.dataset.targetRow !== undefined) {
                    const idx = modal.dataset.targetRow;
                    const targetRow = Array.from(document.querySelectorAll('.service-item')).find(r => r.dataset.index === String(idx));
                    if (targetRow) {
                        populateServiceRow(targetRow, { id: service.id, name: service.name, price: service.price, category: categoryName, estimation: service.estimation });
                        initRow(targetRow);
                        selectRow(targetRow);
                    }
                } else {
                    // if there is an empty row, fill it instead of adding a new one
                    const emptyRow = Array.from(document.querySelectorAll('.service-item')).find(r => {
                        const select = r.querySelector('.service-select');
                        return select && !select.value;
                    });

                    if (emptyRow) {
                        populateServiceRow(emptyRow, { id: service.id, name: service.name, price: service.price, category: categoryName, estimation: service.estimation });
                        initRow(emptyRow);
                        selectRow(emptyRow);
                    } else {
                        addBtn.click();
                        setTimeout(() => {
                            const newRow = container.querySelector('.service-item:last-child');
                            populateServiceRow(newRow, { id: service.id, name: service.name, price: service.price, category: categoryName, estimation: service.estimation });
                            initRow(newRow);
                            selectRow(newRow);
                        }, 120);
                    }
                }

                modal.classList.add('hidden');
            }

            function selectRow(row) {
                document.querySelectorAll('.service-item').forEach(item => item.classList.remove('active-row', 'border-yellow-500', 'border-zinc-800'));
                row.classList.add('active-row');
                row.classList.add('border-yellow-500');
            }

            function addServiceRow(selectedService = null) {
                addBtn.click();
                const addedRows = document.querySelectorAll('.service-item');
                const newRow = addedRows[addedRows.length - 1];
                if (selectedService) {
                    populateServiceRow(newRow, selectedService);
                }
                return newRow;
            }

            function populateServiceRow(row, serviceData) {
                const select = row.querySelector('.service-select');
                const selectedText = row.querySelector('.selected-service-text');
                const selectedMeta = row.querySelector('.selected-service-meta');
                // ensure the hidden select has an option with price metadata so totals calculate correctly
                let opt = select.querySelector(`option[value="${serviceData.id}"]`);
                if (!opt) {
                    select.innerHTML = ` <option value="${serviceData.id}" data-price="${serviceData.price}" data-service-name="${serviceData.name}" data-service-category="${serviceData.category}" data-service-estimation="${serviceData.estimation}">${serviceData.name}</option>`;
                    opt = select.querySelector(`option[value="${serviceData.id}"]`);
                } else {
                    opt.setAttribute('data-price', serviceData.price);
                    opt.setAttribute('data-service-name', serviceData.name);
                    opt.setAttribute('data-service-category', serviceData.category);
                    opt.setAttribute('data-service-estimation', serviceData.estimation);
                }
                select.value = serviceData.id;
                selectedText.textContent = serviceData.name;
                selectedMeta.textContent = serviceData.category + ' • Rp ' + Number(serviceData.price).toLocaleString('id-ID') + ' • ' + serviceData.estimation + ' hari';
                // trigger calculation after updating select
                select.dispatchEvent(new Event('change'));
                calculateTotal();
            }

            function toggleCustomerFields() {
                const selectedOption = customerSelect.options[customerSelect.selectedIndex];
                const membershipType = selectedOption.getAttribute('data-membership');
                const stamps = parseInt(selectedOption.getAttribute('data-stamps')) || 0;

                if (customerSelect.value === 'new') {
                    newCustomerFields.classList.remove('hidden');
                    membershipBadge.classList.add('hidden');
                    loyaltyBadge.classList.add('hidden');
                    phoneInput.setAttribute('required', 'required');
                    nameInput.setAttribute('required', 'required');
                } else {
                    newCustomerFields.classList.add('hidden');
                    phoneInput.removeAttribute('required');
                    nameInput.removeAttribute('required');

                    if (membershipType === 'more_running_club') {
                        membershipBadge.classList.remove('hidden');
                    } else {
                        membershipBadge.classList.add('hidden');
                    }

                    if (stamps >= 10) {
                        loyaltyBadge.classList.remove('hidden');
                    } else {
                        loyaltyBadge.classList.add('hidden');
                    }
                }
            }

            customerSelect.addEventListener('change', () => {
                toggleCustomerFields();
                calculateTotal();
            });

            customerSearch.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                Array.from(customerSelect.options).forEach(option => {
                    if (option.value === 'new') {
                        return;
                    }
                    const text = option.textContent.toLowerCase();
                    option.hidden = query.length > 0 && !text.includes(query);
                });
            });

            function validateDpInput() {
                const dpValue = parseInt(dpInput.value) || 0;
                if (dpValue > currentGrandTotal) {
                    dpWarning.classList.remove('hidden');
                    dpInput.value = currentGrandTotal;
                } else {
                    dpWarning.classList.add('hidden');
                }
            }

            function calculateTotal() {
                let total = 0;
                const rows = document.querySelectorAll('.service-item');
                rows.forEach(row => {
                    const select = row.querySelector('.service-select');
                    const qtyInput = row.querySelector('.qty-input');
                    if (select && qtyInput) {
                        const selectedOption = select.options[select.selectedIndex];
                        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                        const qty = parseInt(qtyInput.value) || 0;
                        total += price * qty;
                    }
                });

                const selectedCustomer = customerSelect.options[customerSelect.selectedIndex];
                const membershipType = selectedCustomer.getAttribute('data-membership');
                const stampCount = parseInt(selectedCustomer.getAttribute('data-stamps')) || 0;

                let discountAmount = 0;
                if (membershipType === 'more_running_club') {
                    discountAmount = total * 0.10;
                } else if (stampCount >= 10) {
                    discountAmount = 35000;
                }

                currentGrandTotal = Math.max(0, total - discountAmount);
                grandTotalDisplay.textContent = 'Rp ' + currentGrandTotal.toLocaleString('id-ID');
                dpInput.max = currentGrandTotal;
                if (parseInt(dpInput.value) > currentGrandTotal) {
                    dpInput.value = currentGrandTotal;
                }
                updateSisaPelunasan();
                validateDpInput();
            }

            function updateSisaPelunasan() {
                const dp = parseInt(dpInput.value) || 0;
                const sisa = Math.max(0, currentGrandTotal - dp);

                if (sisa <= 0 && currentGrandTotal > 0) {
                    sisaTagihanDisplay.classList.remove('text-red-500');
                    sisaTagihanDisplay.classList.add('text-green-500');
                    sisaTagihanDisplay.textContent = 'Rp 0 — LUNAS ✓';
                } else {
                    sisaTagihanDisplay.classList.add('text-red-500');
                    sisaTagihanDisplay.classList.remove('text-green-500');
                    sisaTagihanDisplay.textContent = 'Rp ' + sisa.toLocaleString('id-ID');
                }
            }

            dpInput.addEventListener('input', function () {
                updateSisaPelunasan();
                validateDpInput();
            });

            document.querySelector('.service-select').addEventListener('change', calculateTotal);
            document.querySelector('.qty-input').addEventListener('input', calculateTotal);

            toggleCustomerFields();
            calculateTotal();
        });
    </script>
@endsection