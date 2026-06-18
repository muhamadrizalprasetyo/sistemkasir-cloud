@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight mb-1">POS KASIR</h2>
        <p class="text-slate-500 text-sm font-medium">Buat pesanan baru dengan teliti.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 p-4 mb-8 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-semibold text-red-700">
                Error: {{ session('error') }}
            </p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 p-4 mb-8 rounded-xl">
            @foreach($errors->all() as $error)
                <p class="text-sm font-medium text-red-600 flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ $error }}
                </p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Data Pelanggan -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Informasi Pelanggan & Pembayaran -->
                <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6 relative">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-3 mb-5">
                        Data Pesanan
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih
                                Pelanggan</label>
                            <input type="text" id="customer_search" placeholder="Cari pelanggan: nama / WA"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-400 text-sm mb-3">
                            <select name="customer_id" id="customer_id"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium">
                                <option value="new" data-membership="regular">+ PELANGGAN BARU</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" data-membership="{{ $customer->membership_type }}"
                                        data-stamps="{{ $customer->stamp_count }}">
                                        {{ $customer->name }} ({{ $customer->phone ?? 'Tanpa No' }})
                                    </option>
                                @endforeach
                            </select>

                            <div id="new_customer_fields" class="mt-4 space-y-4 bg-slate-50/50 p-4 border border-slate-100 rounded-xl">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider pb-1">
                                    Input Pelanggan Baru</p>
                                <div>
                                    <input type="text" name="new_customer_phone" placeholder="No. WA (0812...)"
                                        class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-400 text-sm">
                                </div>
                                <div>
                                    <input type="text" name="new_customer_name" placeholder="Nama Lengkap"
                                        class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-400 text-sm">
                                </div>
                            </div>
                            <div id="membership_badge" class="mt-3 hidden">
                                <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold px-3 py-2 rounded-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Member Club Terdeteksi! Diskon 10%
                                </span>
                            </div>
                            <div id="loyalty_badge" class="mt-3 hidden">
                                <span class="bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold px-3 py-2 rounded-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    10 Stamps! Diskon Rp35.000 Otomatis
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tipe
                                Pesanan</label>
                            <select name="order_type" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium">
                                <option value="drop">Drop di Toko</option>
                                <option value="pickup">Pick-up</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Metode
                                    Bayar</label>
                                <select name="payment_method" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium">
                                    <option value="cash">Tunai</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nominal
                                    Uang DP</label>
                                <input type="number" name="dp_amount" id="dp_amount" value="0" min="0" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-400 text-sm font-semibold"
                                    placeholder="0">
                                <p id="dp_warning" class="mt-2 text-xs text-red-500 font-semibold hidden">DP melebihi tagihan.</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">Isi 0 jika belum bayar DP.</p>

                        <div class="pt-4 border-t border-slate-100 mt-4">
                            <label
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Catatan
                                Kasir</label>
                            <textarea name="notes" rows="2"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-400 text-sm"
                                placeholder="Kondisi barang, keluhan, dll">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6 mb-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-3 mb-4">Ringkasan Order</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-slate-600 font-medium">
                            <span>Total Tagihan</span>
                            <span id="grand_total_display" class="font-bold text-slate-800 text-lg">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center font-bold">
                            <span class="text-slate-600">Sisa Pelunasan</span>
                            <span id="sisa_tagihan_display" class="text-red-600 text-lg">Rp 0</span>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-[0.98] text-lg">
                    Proses Nota
                </button>
            </div>

            <!-- Kolom Kanan: Pemilihan Layanan -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                
                <!-- Section Pemilihan -->
                <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6 relative">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-3 mb-5">
                        Menu Layanan
                    </h3>

                    @php
                        $servicesByCategory = $services->groupBy(fn($service) => $service->category?->name ?? 'Lainnya');
                    @endphp
                    
                    <!-- Kategori -->
                    <div class="mb-6">
                        <h4 class="text-slate-700 text-sm font-bold mb-4">Pilih Kategori</h4>
                        <div class="flex flex-wrap gap-3">
                            @foreach($servicesByCategory as $categoryName => $group)
                                <button type="button"
                                    class="category-btn rounded-xl border border-slate-200 px-6 py-3 bg-white hover:border-indigo-600 hover:text-indigo-600 transition-all text-slate-600 font-semibold text-sm shadow-sm"
                                    data-category-name="{{ $categoryName }}"
                                    data-category-services='{{ json_encode($group->map(fn($s) => ["id" => $s->id, "name" => $s->name, "price" => $s->price, "estimation" => $s->estimation_days])->values()) }}'>
                                    {{ $categoryName }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Layanan -->
                    <div id="services-container" class="hidden">
                        <div class="flex items-center justify-between mb-4 border-t border-slate-100 pt-6">
                            <h4 class="text-slate-700 text-sm font-bold">
                                Layanan <span id="selected-category-label" class="text-indigo-600 ml-1"></span>
                            </h4>
                        </div>
                        <div id="services-grid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <!-- Populated via JS -->
                        </div>
                    </div>
                </div>

                <!-- Section Item Pesanan -->
                <div class="bg-white border border-slate-100 shadow-sm rounded-2xl p-6 relative">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3 mb-5">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                            Item Pesanan
                        </h3>
                    </div>

                    <div id="order-items-list" class="space-y-3">
                        <!-- Items populated here -->
                    </div>
                    
                    <!-- Empty State -->
                    <div id="empty-order-state" class="text-slate-400 text-sm font-medium text-center p-10 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 mt-2 flex flex-col items-center justify-center gap-3">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        Belum ada layanan yang ditambahkan. Silakan pilih kategori dan layanan di atas.
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- Item Modal -->
    <div id="item-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-end md:items-center justify-center p-4">
        <div class="bg-white border border-slate-200 rounded-2xl w-full md:w-3/4 lg:w-1/3 max-h-[90vh] overflow-y-auto p-6 shadow-xl">
            
            <div class="flex justify-between items-center mb-6">
                <h3 id="item-modal-title" class="text-slate-800 font-bold text-lg">Detail Item</h3>
                <button type="button" class="item-modal-close text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-full p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="mb-6 p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <div id="modal-service-name" class="text-indigo-700 font-bold text-sm mb-1"></div>
                <div class="flex justify-between items-center">
                    <div id="modal-service-meta" class="text-slate-500 text-xs font-medium"></div>
                    <div id="modal-service-price-display" class="text-slate-800 font-bold text-sm"></div>
                </div>
            </div>

            <div id="item-modal-form" class="space-y-5">
                <input type="hidden" id="modal-service-id">
                <input type="hidden" id="modal-service-price">
                <input type="hidden" id="modal-service-category">
                <input type="hidden" id="modal-service-estimation">
                <input type="hidden" id="modal-item-index" value="-1">

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Merek / Varian <span class="text-red-500">*</span></label>
                    <input type="text" id="modal-merek" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm text-slate-800 transition-colors shadow-sm" placeholder="Contoh: Nike AF1 White">
                    <p class="text-xs text-red-500 font-medium mt-2 hidden" id="modal-merek-error">Merek/Varian wajib diisi.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" id="modal-qty" value="1" min="1" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm text-slate-800 transition-colors shadow-sm">
                </div>

                <div class="mt-8 flex gap-3 pt-4">
                    <button type="button" class="item-modal-close flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl transition-colors text-sm">
                        Batal
                    </button>
                    <button type="button" id="modal-save-btn" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-colors text-sm shadow-sm">
                        Simpan Item
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const servicesAll = {!! $services->map(function($s){ return ['id' => $s->id, 'name' => $s->name, 'price' => $s->price, 'category' => $s->category?->name, 'estimation' => $s->estimation_days]; })->toJson() !!};

        document.addEventListener('DOMContentLoaded', function () {
            let orderItems = [];
            let nextItemIndex = 0;

            const categoryBtns = document.querySelectorAll('.category-btn');
            const servicesContainer = document.getElementById('services-container');
            const selectedCategoryLabel = document.getElementById('selected-category-label');
            const servicesGrid = document.getElementById('services-grid');

            const orderItemsList = document.getElementById('order-items-list');
            const emptyOrderState = document.getElementById('empty-order-state');

            const itemModal = document.getElementById('item-modal');
            const modalCloseBtns = document.querySelectorAll('.item-modal-close');
            const modalSaveBtn = document.getElementById('modal-save-btn');
            
            const mServiceId = document.getElementById('modal-service-id');
            const mServicePrice = document.getElementById('modal-service-price');
            const mServiceCategory = document.getElementById('modal-service-category');
            const mServiceEstimation = document.getElementById('modal-service-estimation');
            const mItemIndex = document.getElementById('modal-item-index');
            
            const mServiceNameDisplay = document.getElementById('modal-service-name');
            const mServiceMetaDisplay = document.getElementById('modal-service-meta');
            const mServicePriceDisplay = document.getElementById('modal-service-price-display');
            
            const mMerek = document.getElementById('modal-merek');
            const mQty = document.getElementById('modal-qty');
            const mMerekError = document.getElementById('modal-merek-error');

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

            const mainForm = document.querySelector('form');
            if (mainForm) {
                mainForm.addEventListener('submit', function(e) {
                    if (orderItems.length === 0) {
                        e.preventDefault();
                        alert('Harap tambahkan minimal 1 item pesanan.');
                    }
                });
            }

            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    categoryBtns.forEach(b => {
                        b.classList.remove('bg-indigo-50', 'text-indigo-700', 'border-indigo-600');
                        b.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
                    });
                    this.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
                    this.classList.add('bg-indigo-50', 'text-indigo-700', 'border-indigo-600');

                    const categoryName = this.getAttribute('data-category-name');
                    const services = JSON.parse(this.getAttribute('data-category-services'));

                    selectedCategoryLabel.textContent = "- " + categoryName;
                    servicesGrid.innerHTML = '';

                    services.forEach(service => {
                        const card = document.createElement('button');
                        card.type = 'button';
                        card.className = 'text-left rounded-xl border border-slate-200 p-5 bg-white hover:border-indigo-300 hover:shadow-md transition-all flex flex-col justify-between group h-full';
                        card.innerHTML = `
                            <div>
                                <div class="text-slate-800 font-bold text-sm group-hover:text-indigo-600 transition-colors">${service.name}</div>
                                <div class="text-slate-400 text-xs mt-1 font-medium">${service.estimation} hari</div>
                            </div>
                            <div class="text-slate-700 font-bold text-sm mt-4">
                                Rp ${Number(service.price).toLocaleString('id-ID')}
                            </div>
                        `;
                        card.addEventListener('click', () => openItemModal(service, categoryName));
                        servicesGrid.appendChild(card);
                    });

                    servicesContainer.classList.remove('hidden');
                });
            });

            function openItemModal(service, categoryName, existingItem = null) {
                mServiceId.value = service.id || service.service_id; 
                mServicePrice.value = service.price;
                mServiceCategory.value = categoryName || service.category;
                mServiceEstimation.value = service.estimation;
                
                mServiceNameDisplay.textContent = service.name;
                mServiceMetaDisplay.textContent = (categoryName || service.category) + ' • ' + service.estimation + ' Hari';
                mServicePriceDisplay.textContent = 'Rp ' + Number(service.price).toLocaleString('id-ID');

                mMerekError.classList.add('hidden');

                if (existingItem) {
                    mItemIndex.value = existingItem.index;
                    mMerek.value = existingItem.merek;
                    mQty.value = existingItem.qty;
                    document.getElementById('item-modal-title').textContent = 'Edit Item Pesanan';
                } else {
                    mItemIndex.value = '-1';
                    mMerek.value = '';
                    mQty.value = '1';
                    document.getElementById('item-modal-title').textContent = 'Tambah Item Pesanan';
                }

                itemModal.classList.remove('hidden');
                setTimeout(() => mMerek.focus(), 100);
            }

            function closeItemModal() {
                itemModal.classList.add('hidden');
            }

            modalCloseBtns.forEach(btn => btn.addEventListener('click', closeItemModal));
            itemModal.addEventListener('click', (e) => {
                if (e.target === itemModal) closeItemModal();
            });

            mMerek.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    modalSaveBtn.click();
                }
            });
            mQty.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    modalSaveBtn.click();
                }
            });

            modalSaveBtn.addEventListener('click', function() {
                const merekVal = mMerek.value.trim();
                if (!merekVal) {
                    mMerekError.classList.remove('hidden');
                    return;
                }
                
                const qtyVal = parseInt(mQty.value) || 1;
                const idx = parseInt(mItemIndex.value);

                const itemData = {
                    id: mServiceId.value,
                    name: mServiceNameDisplay.textContent,
                    price: parseFloat(mServicePrice.value),
                    category: mServiceCategory.value,
                    estimation: mServiceEstimation.value,
                    merek: merekVal,
                    qty: qtyVal
                };

                if (idx === -1) {
                    itemData.index = nextItemIndex++;
                    orderItems.push(itemData);
                } else {
                    itemData.index = idx;
                    const arrIdx = orderItems.findIndex(i => i.index === idx);
                    if (arrIdx !== -1) orderItems[arrIdx] = itemData;
                }

                closeItemModal();
                renderOrderItems();
            });

            function renderOrderItems() {
                orderItemsList.innerHTML = '';
                
                if (orderItems.length === 0) {
                    emptyOrderState.classList.remove('hidden');
                } else {
                    emptyOrderState.classList.add('hidden');
                    
                    orderItems.forEach((item, i) => {
                        const subtotal = item.price * item.qty;
                        
                        const el = document.createElement('div');
                        el.className = 'bg-white border border-slate-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all hover:border-indigo-300 shadow-sm';
                        
                        el.innerHTML = `
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-slate-800 font-bold text-sm">${item.merek}</span>
                                    <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-[10px] font-semibold uppercase">${item.category}</span>
                                </div>
                                <div class="text-slate-500 text-xs font-medium">${item.name}</div>
                            </div>
                            
                            <div class="flex items-center justify-between md:justify-end gap-6 md:w-1/2">
                                <div class="text-right">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Qty</div>
                                    <div class="text-slate-800 font-semibold text-sm">${item.qty}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Subtotal</div>
                                    <div class="text-slate-800 font-bold text-sm">Rp ${subtotal.toLocaleString('id-ID')}</div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="btn-edit text-slate-400 hover:text-indigo-600 bg-slate-50 hover:bg-indigo-50 p-2 rounded-lg transition-colors" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-delete text-slate-400 hover:text-red-600 bg-slate-50 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <input type="hidden" name="items[${i}][service_id]" value="${item.id}">
                            <input type="hidden" name="items[${i}][item_variant]" value="${item.merek}">
                            <input type="hidden" name="items[${i}][quantity]" value="${item.qty}">
                        `;

                        el.querySelector('.btn-edit').addEventListener('click', () => {
                            openItemModal(item, item.category, item);
                        });

                        el.querySelector('.btn-delete').addEventListener('click', () => {
                            orderItems = orderItems.filter(x => x.index !== item.index);
                            renderOrderItems();
                        });

                        orderItemsList.appendChild(el);
                    });
                }
                
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
                orderItems.forEach(item => {
                    total += item.price * item.qty;
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
                    sisaTagihanDisplay.classList.remove('text-red-600');
                    sisaTagihanDisplay.classList.add('text-emerald-600');
                    sisaTagihanDisplay.textContent = 'Rp 0 — LUNAS ✓';
                } else {
                    sisaTagihanDisplay.classList.add('text-red-600');
                    sisaTagihanDisplay.classList.remove('text-emerald-600');
                    sisaTagihanDisplay.textContent = 'Rp ' + sisa.toLocaleString('id-ID');
                }
            }

            dpInput.addEventListener('input', function () {
                updateSisaPelunasan();
                validateDpInput();
            });

            toggleCustomerFields();
            calculateTotal();
        });
    </script>
@endsection