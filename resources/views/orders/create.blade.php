@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-black text-yellow-500 uppercase tracking-widest mb-1">POS KASIR</h2>
        <p class="text-zinc-500 text-sm uppercase tracking-[0.2em]">Awas jangan salah input</p>
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
                                <option value="new" data-membership="regular">PELANGGAN BARU</option>
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
                                    <option value="cash">Tunai</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Nominal
                                    Uang DP</label>
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
            <div class="lg:col-span-2 flex flex-col gap-6">
                
                <!-- Section Pemilihan -->
                <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 relative">
                    <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-zinc-700 m-2"></div>
                    <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-800/60 pb-3 mb-4 pl-8">
                        Menu Layanan
                    </h3>

                    @php
                        $servicesByCategory = $services->groupBy(fn($service) => $service->category?->name ?? 'Lainnya');
                    @endphp
                    
                    <!-- Kategori -->
                    <div class="mb-6">
                        <h4 class="text-white text-sm font-black uppercase tracking-[0.2em] mb-4">Pilih Kategori</h4>
                        <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            @foreach($servicesByCategory as $categoryName => $group)
                                <button type="button"
                                    class="category-btn rounded-none border-2 border-zinc-800 p-4 bg-zinc-950 hover:bg-yellow-500 hover:border-yellow-500 hover:text-black transition-all text-zinc-400 font-bold uppercase tracking-[0.2em] text-xs text-left"
                                    data-category-name="{{ $categoryName }}"
                                    data-category-services='{{ json_encode($group->map(fn($s) => ["id" => $s->id, "name" => $s->name, "price" => $s->price, "estimation" => $s->estimation_days])->values()) }}'>
                                    {{ $categoryName }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Layanan -->
                    <div id="services-container" class="hidden">
                        <div class="flex items-center justify-between mb-4 border-t border-zinc-800/60 pt-6">
                            <h4 class="text-white text-sm font-black uppercase tracking-[0.2em]">
                                Layanan <span id="selected-category-label" class="text-yellow-500 ml-1"></span>
                            </h4>
                        </div>
                        <div id="services-grid" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            <!-- Populated via JS -->
                        </div>
                    </div>
                </div>

                <!-- Section Item Pesanan -->
                <div class="bg-zinc-900 border border-zinc-800/60 shadow-lg shadow-black/40 rounded-none p-6 relative">
                    <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-zinc-700 m-2"></div>
                    <h3 class="text-[10px] font-black text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-800/60 pb-3 mb-4 pr-8 text-right">
                        Item Pesanan
                    </h3>

                    <div id="order-items-list" class="space-y-3">
                        <!-- Items populated here -->
                    </div>
                    
                    <!-- Empty State -->
                    <div id="empty-order-state" class="text-zinc-500 text-sm italic text-center p-8 border border-dashed border-zinc-700 bg-zinc-950/50 mt-2">
                        Belum ada layanan yang ditambahkan. Silakan pilih kategori dan layanan di atas.
                    </div>
                </div>

            </div>
        </div>
    </form>

    <!-- Item Modal -->
    <div id="item-modal" class="fixed inset-0 bg-black/80 z-50 hidden flex items-end md:items-center justify-center">
        <div class="bg-zinc-900 border border-yellow-500 rounded-none w-full md:w-3/4 lg:w-1/3 max-h-[90vh] overflow-y-auto p-6 relative shadow-[8px_8px_0_rgba(0,0,0,1)]">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
            
            <div class="flex justify-between items-center mb-6 mt-2">
                <h3 id="item-modal-title" class="text-white font-black uppercase tracking-[0.2em] text-lg">Detail Item</h3>
                <button type="button" class="item-modal-close text-zinc-400 hover:text-white text-2xl transition-colors">✕</button>
            </div>
            
            <div class="mb-6 p-4 bg-zinc-950 border border-zinc-800">
                <div id="modal-service-name" class="text-yellow-500 font-black text-sm uppercase tracking-widest mb-1"></div>
                <div class="flex justify-between items-center">
                    <div id="modal-service-meta" class="text-zinc-400 text-[10px] tracking-widest uppercase"></div>
                    <div id="modal-service-price-display" class="text-white font-bold text-sm tracking-widest"></div>
                </div>
            </div>

            <div id="item-modal-form" class="space-y-4">
                <input type="hidden" id="modal-service-id">
                <input type="hidden" id="modal-service-price">
                <input type="hidden" id="modal-service-category">
                <input type="hidden" id="modal-service-estimation">
                <input type="hidden" id="modal-item-index" value="-1">

                <div>
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Merek / Varian <span class="text-red-500">*</span></label>
                    <input type="text" id="modal-merek" class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 focus:outline-none focus:border-zinc-500 text-sm text-zinc-200 placeholder-zinc-600 transition-colors" placeholder="Contoh: Nike AF1 White">
                    <p class="text-[9px] text-red-500 font-bold mt-1 hidden" id="modal-merek-error">Merek/Varian wajib diisi.</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] mb-2">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" id="modal-qty" value="1" min="1" class="w-full bg-zinc-950 border border-zinc-800 rounded-none px-4 py-3 focus:outline-none focus:border-zinc-500 text-sm text-zinc-200 transition-colors">
                </div>

                <div class="mt-8 pt-4 border-t border-zinc-800/60 flex gap-3">
                    <button type="button" class="item-modal-close flex-1 bg-zinc-800 hover:bg-zinc-700 text-white font-black uppercase tracking-widest py-3 rounded-none transition-colors text-xs border border-zinc-700">
                        Batal
                    </button>
                    <button type="button" id="modal-save-btn" class="flex-1 bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-widest py-3 rounded-none transition-colors text-xs border border-yellow-500 shadow-[4px_4px_0_rgba(255,255,255,0.1)] active:scale-[0.98]">
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

            // Prevent form submit if no items
            const mainForm = document.querySelector('form');
            if (mainForm) {
                mainForm.addEventListener('submit', function(e) {
                    if (orderItems.length === 0) {
                        e.preventDefault();
                        alert('Harap tambahkan minimal 1 item pesanan.');
                    }
                });
            }

            // --- CATEGORY & SERVICES ---
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Update active state of buttons
                    categoryBtns.forEach(b => {
                        b.classList.remove('bg-yellow-500', 'text-black', 'border-yellow-500');
                        b.classList.add('bg-zinc-950', 'text-zinc-400', 'border-zinc-800');
                    });
                    this.classList.remove('bg-zinc-950', 'text-zinc-400', 'border-zinc-800');
                    this.classList.add('bg-yellow-500', 'text-black', 'border-yellow-500');

                    const categoryName = this.getAttribute('data-category-name');
                    const services = JSON.parse(this.getAttribute('data-category-services'));

                    selectedCategoryLabel.textContent = "- " + categoryName;
                    servicesGrid.innerHTML = '';

                    services.forEach(service => {
                        const card = document.createElement('button');
                        card.type = 'button';
                        card.className = 'text-left rounded-none border border-zinc-700 p-4 bg-zinc-900 hover:bg-zinc-800 hover:border-zinc-500 transition-all flex flex-col justify-between group h-full';
                        card.innerHTML = `
                            <div>
                                <div class="text-white font-bold text-xs uppercase tracking-widest group-hover:text-yellow-500 transition-colors">${service.name}</div>
                                <div class="text-zinc-500 text-[10px] uppercase tracking-[0.2em] mt-2">${service.estimation} hari</div>
                            </div>
                            <div class="text-zinc-300 text-sm font-mono mt-3 border-t border-zinc-800 pt-2">
                                Rp ${Number(service.price).toLocaleString('id-ID')}
                            </div>
                        `;
                        card.addEventListener('click', () => openItemModal(service, categoryName));
                        servicesGrid.appendChild(card);
                    });

                    servicesContainer.classList.remove('hidden');
                });
            });

            // --- MODAL LOGIC ---
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

            // enter key in input fields triggers save
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
                    // Add new
                    itemData.index = nextItemIndex++;
                    orderItems.push(itemData);
                } else {
                    // Edit existing
                    itemData.index = idx;
                    const arrIdx = orderItems.findIndex(i => i.index === idx);
                    if (arrIdx !== -1) orderItems[arrIdx] = itemData;
                }

                closeItemModal();
                renderOrderItems();
            });

            // --- RENDER ITEMS ---
            function renderOrderItems() {
                orderItemsList.innerHTML = '';
                
                if (orderItems.length === 0) {
                    emptyOrderState.classList.remove('hidden');
                } else {
                    emptyOrderState.classList.add('hidden');
                    
                    orderItems.forEach((item, i) => {
                        const subtotal = item.price * item.qty;
                        
                        const el = document.createElement('div');
                        el.className = 'bg-zinc-950 border border-zinc-800 p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 group transition-all hover:border-zinc-600';
                        
                        el.innerHTML = `
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-white font-black text-sm uppercase tracking-widest">${item.merek}</span>
                                    <span class="text-[9px] bg-zinc-800 text-zinc-400 px-2 py-0.5 uppercase tracking-widest">${item.category}</span>
                                </div>
                                <div class="text-zinc-400 text-xs">${item.name}</div>
                            </div>
                            
                            <div class="flex items-center justify-between md:justify-end gap-6 md:w-1/2">
                                <div class="text-right">
                                    <div class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Qty</div>
                                    <div class="text-white font-mono text-sm">${item.qty}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Subtotal</div>
                                    <div class="text-yellow-500 font-mono text-sm font-bold">Rp ${subtotal.toLocaleString('id-ID')}</div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="btn-edit text-zinc-400 hover:text-white hover:bg-zinc-800 p-2 border border-transparent hover:border-zinc-700 transition-colors" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-delete text-red-500 hover:text-red-400 hover:bg-red-950/30 p-2 border border-transparent hover:border-red-900/50 transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" name="items[${i}][service_id]" value="${item.id}">
                            <input type="hidden" name="items[${i}][item_variant]" value="${item.merek}">
                            <input type="hidden" name="items[${i}][quantity]" value="${item.qty}">
                        `;

                        // Edit handler
                        el.querySelector('.btn-edit').addEventListener('click', () => {
                            openItemModal(item, item.category, item);
                        });

                        // Delete handler
                        el.querySelector('.btn-delete').addEventListener('click', () => {
                            orderItems = orderItems.filter(x => x.index !== item.index);
                            renderOrderItems();
                        });

                        orderItemsList.appendChild(el);
                    });
                }
                
                calculateTotal();
            }

            // --- CUSTOMER & TOTALS ---
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

            // Initialize
            toggleCustomerFields();
            calculateTotal();
        });
    </script>
@endsection