<x-user-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Checkout</h1>
                <p class="text-gray-500">Lengkapi informasi untuk menyelesaikan pesanan</p>
            </div>

            <form action="{{ route('user.checkout.process') }}" method="POST" id="checkoutForm">
                @csrf
                
                <!-- Hidden inputs yang akan di-update otomatis oleh JS -->
                <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="{{ $shippingCost }}">
                <input type="hidden" name="shipping_courier" id="shipping_courier_input" value="gojek">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Checkout Form (2/3 width) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Shipping Information -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengiriman</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="shipping_name" value="{{ auth()->user()->full_name }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                    <input type="text" name="shipping_phone" value="{{ auth()->user()->phone_number }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                    <textarea name="shipping_address" rows="3" required
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">{{ old('shipping_address') }}</textarea>
                                </div>

                                <!-- Kota Tujuan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kota / Kabupaten Tujuan</label>
                                    <select name="shipping_city" id="shipping_city" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                                        <option value="">-- Pilih Kota / Kabupaten --</option>
                                        <option value="jakarta" {{ old('shipping_city') == 'jakarta' ? 'selected' : '' }}>Jakarta</option>
                                        <option value="bandung" {{ old('shipping_city') == 'bandung' ? 'selected' : '' }}>Bandung</option>
                                        <option value="surabaya" {{ old('shipping_city') == 'surabaya' ? 'selected' : '' }}>Surabaya</option>
                                        <option value="yogyakarta" {{ old('shipping_city') == 'yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                                        <option value="semarang" {{ old('shipping_city') == 'semarang' ? 'selected' : '' }}>Semarang</option>
                                        <option value="medan" {{ old('shipping_city') == 'medan' ? 'selected' : '' }}>Medan</option>
                                        <option value="makassar" {{ old('shipping_city') == 'makassar' ? 'selected' : '' }}>Makassar</option>
                                        <option value="lainnya" {{ old('shipping_city') == 'lainnya' ? 'selected' : '' }}>Kota Lainnya</option>
                                    </select>
                                </div>

                                <!-- Kecamatan / Area (hanya muncul jika Jakarta) -->
                                <div id="district_container" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kecamatan / Area di Jakarta</label>
                                    <select name="shipping_district" id="shipping_district"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                                        <option value="">-- Pilih Area --</option>
                                        <option value="selatan" {{ old('shipping_district') == 'selatan' ? 'selected' : '' }}>Jakarta Selatan (lebih dekat)</option>
                                        <option value="pusat" {{ old('shipping_district') == 'pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                        <option value="barat" {{ old('shipping_district') == 'barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                        <option value="utara" {{ old('shipping_district') == 'utara' ? 'selected' : '' }}>Jakarta Utara</option>
                                        <option value="timur" {{ old('shipping_district') == 'timur' ? 'selected' : '' }}>Jakarta Timur (lebih jauh)</option>
                                        <option value="lainnya_jakarta" {{ old('shipping_district') == 'lainnya_jakarta' ? 'selected' : '' }}>Lainnya di Jakarta</option>
                                    </select>
                                </div>

                                <!-- Pilih Kurir -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kurir</label>
                                    <select name="shipping_courier" id="shipping_courier"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                                        <option value="gojek" {{ old('shipping_courier') == 'gojek' ? 'selected' : '' }}>🚀 Gojek (Instant - paling cepat)</option>
                                        <option value="ninja" {{ old('shipping_courier') == 'ninja' ? 'selected' : '' }}>📦 Ninja Express (Standar - paling murah)</option>
                                        <option value="jne" {{ old('shipping_courier') == 'jne' ? 'selected' : '' }}>📬 JNE Reguler</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">*Tarif ongkir otomatis disesuaikan dengan jarak + kurir (realistis seperti e-commerce biasa)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method (sama seperti sebelumnya) -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Metode Pembayaran</h2>

                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors payment-option" data-value="transfer_bank">
                                    <input type="radio" name="payment_method" value="transfer_bank" checked class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">Transfer Bank (Virtual Account)</p>
                                        <p class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=Bank" alt="Bank" class="h-8">
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors payment-option" data-value="ewallet">
                                    <input type="radio" name="payment_method" value="ewallet" class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">E-Wallet</p>
                                        <p class="text-sm text-gray-500">GoPay, OVO, DANA, ShopeePay</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=E-Wallet" alt="E-Wallet" class="h-8">
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors payment-option" data-value="qris">
                                    <input type="radio" name="payment_method" value="qris" class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">QRIS (Dummy)</p>
                                        <p class="text-sm text-gray-500">Scan QR Code untuk bayar</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=QRIS" alt="QRIS" class="h-8">
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors payment-option" data-value="cod">
                                    <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">Bayar di Tempat (COD)</p>
                                        <p class="text-sm text-gray-500">Bayar saat barang diterima</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=COD" alt="COD" class="h-8">
                                </label>
                            </div>

                            <div id="payment_details" class="hidden mt-6 p-5 bg-orange-50 border border-orange-200 rounded-2xl">
                                <div id="payment_content"></div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan Pesanan (Opsional)</h2>
                            <textarea name="notes" rows="3" placeholder="Contoh: Tolong dikemas dengan bubble wrap tambahan"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]"></textarea>
                        </div>
                    </div>

                    <!-- Order Summary (1/3 width) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-semibold text-gray-800 mb-6">Ringkasan Pesanan</h2>

                            <!-- Products -->
                            <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-3">
                                        @if($item->product->image)
                                            <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Totals -->
                            <div class="space-y-3 pt-4 border-t border-gray-100">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Subtotal</span>
                                    <span class="font-medium text-gray-800">Rp <span id="subtotal_display">{{ number_format($subtotal, 0, ',', '.') }}</span></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Ongkos Kirim</span>
                                    <span class="font-medium text-gray-800">Rp <span id="shipping_display">{{ number_format($shippingCost, 0, ',', '.') }}</span></span>
                                </div>
                                <div class="border-t border-gray-100 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-semibold text-gray-800">Total</span>
                                        <span class="text-xl font-bold text-[#F95738]">Rp <span id="total_display">{{ number_format($total, 0, ',', '.') }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitButton" class="w-full mt-6 bg-[#F95738] hover:bg-orange-600 text-white py-3 rounded-xl font-semibold transition-all hover:shadow-lg">
                                BUAT PESANAN
                            </button>

                            <!-- Back to Cart -->
                            <a href="{{ route('user.cart.index') }}" class="block text-center text-sm text-gray-500 hover:text-[#F95738] mt-4">
                                ← Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== JAVASCRIPT ==================== -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari Controller
        const subtotal = {{ $subtotal ?? 0 }};
        let shippingCost = {{ $shippingCost ?? 20000 }};

        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID').format(number);
        };

        // ==================== DATA ONGKIR REALISTIS ====================
        // Asumsi toko di Depok → ongkir disesuaikan jarak + kurir
        const shippingRates = {
            'jakarta': {
                'selatan':      { gojek: 8000,  ninja: 5000,  jne: 6000 },
                'pusat':        { gojek: 12000, ninja: 9000,  jne: 10000 },
                'barat':        { gojek: 15000, ninja: 11000, jne: 13000 },
                'utara':        { gojek: 18000, ninja: 14000, jne: 16000 },
                'timur':        { gojek: 35000, ninja: 25000, jne: 28000 },
                'lainnya_jakarta': { gojek: 20000, ninja: 15000, jne: 17000 }
            },
            'bandung':     { gojek: 17000, ninja: 13000, jne: 15000 },
            'surabaya':    { gojek: 25000, ninja: 18000, jne: 20000 },
            'yogyakarta':  { gojek: 22000, ninja: 16000, jne: 18000 },
            'semarang':    { gojek: 21000, ninja: 15000, jne: 17000 },
            'medan':       { gojek: 30000, ninja: 22000, jne: 25000 },
            'makassar':    { gojek: 40000, ninja: 30000, jne: 35000 },
            'lainnya':     { gojek: 40000, ninja: 30000, jne: 35000 }
        };

        // Fungsi utama hitung ongkir (realistis)
        const calculateShipping = () => {
            const city = document.getElementById('shipping_city').value;
            const district = document.getElementById('shipping_district').value;
            const courier = document.getElementById('shipping_courier').value;

            if (!city) return 20000;

            // Jakarta → pakai kecamatan
            if (city === 'jakarta') {
                const area = district || 'lainnya_jakarta';
                return shippingRates['jakarta'][area][courier] || 15000;
            }

            // Kota lain
            return shippingRates[city] ? shippingRates[city][courier] : 20000;
        };

        // Update tampilan ongkir + total
        const updateTotal = () => {
            shippingCost = calculateShipping();

            document.getElementById('shipping_display').textContent = formatRupiah(shippingCost);
            document.getElementById('total_display').textContent = formatRupiah(subtotal + shippingCost);
            document.getElementById('shipping_cost_input').value = shippingCost;
            document.getElementById('shipping_courier_input').value = document.getElementById('shipping_courier').value;
        };

        // Generate QR Code Dummy (sama seperti sebelumnya)
        const generateDynamicQR = (total) => {
            const qrData = `QRIS|DUMMY-${Date.now()}|${total}|TOKO-DEMO`;
            return `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrData)}`;
        };

        // Render Payment Details (sama)
        const renderPaymentDetails = (method, total) => {
            const container = document.getElementById('payment_details');
            const content = document.getElementById('payment_content');
            let html = '';

            if (method === 'transfer_bank') {
                html = `
                    <div class="text-center">
                        <p class="font-semibold text-gray-800 mb-3">Transfer ke Virtual Account</p>
                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                            <p class="text-sm text-gray-600 mb-1">Bank BCA Virtual Account</p>
                            <p class="text-3xl font-mono font-bold text-[#F95738] tracking-widest mb-2">81234567890</p>
                            <p class="text-xs text-gray-500">Atas Nama: Toko Demo Store</p>
                            <hr class="my-3">
                            <p class="text-sm"><strong>Total yang harus dibayar:</strong> Rp ${formatRupiah(total)}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-4">Bayar sebelum 24 jam atau pesanan otomatis dibatalkan.</p>
                    </div>`;
            } 
            else if (method === 'ewallet') {
                html = `
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl text-center border border-gray-200">
                            <p class="font-medium text-sm">GoPay / OVO</p>
                            <p class="text-2xl font-bold text-[#F95738]">081234567890</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl text-center border border-gray-200">
                            <p class="font-medium text-sm">DANA / ShopeePay</p>
                            <p class="text-2xl font-bold text-[#F95738]">081234567890</p>
                        </div>
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-4">Kirim nominal <strong>tepat</strong>: Rp ${formatRupiah(total)}</p>`;
            } 
            else if (method === 'qris') {
                const qrUrl = generateDynamicQR(total);
                html = `
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-3">📱 Scan QR Code ini (Dummy)</p>
                        <div class="inline-block p-3 bg-white rounded-2xl shadow">
                            <img src="${qrUrl}" alt="QRIS Dummy" class="w-48 h-48">
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Nominal: Rp ${formatRupiah(total)}</p>
                    </div>`;
            } 
            else if (method === 'cod') {
                html = `
                    <div class="text-center py-4">
                        <p class="text-green-600 font-semibold text-lg">💵 Bayar di Tempat (COD)</p>
                        <p class="text-sm text-gray-600 mt-2">Anda dapat membayar secara tunai saat barang diterima.</p>
                    </div>`;
            }

            content.innerHTML = html;
            container.classList.remove('hidden');
        };

        // ==================== EVENT LISTENERS ONGKIR ====================
        const citySelect = document.getElementById('shipping_city');
        const districtContainer = document.getElementById('district_container');
        const districtSelect = document.getElementById('shipping_district');
        const courierSelect = document.getElementById('shipping_courier');

        // Saat kota berubah
        citySelect.addEventListener('change', function() {
            if (this.value === 'jakarta') {
                districtContainer.classList.remove('hidden');
                districtContainer.style.display = 'block';
            } else {
                districtContainer.classList.add('hidden');
                districtSelect.value = ''; // reset kecamatan
            }
            updateTotal();
        });

        // Saat kecamatan berubah (hanya Jakarta)
        districtSelect.addEventListener('change', updateTotal);

        // Saat kurir berubah
        courierSelect.addEventListener('change', updateTotal);

        // Handle Payment Method Change (sama)
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const total = subtotal + shippingCost;
                renderPaymentDetails(this.value, total);
            });
        });

        // Restore nilai lama (setelah validasi gagal)
        @if(old('shipping_city'))
            const savedCity = "{{ old('shipping_city') }}";
            if (savedCity) {
                citySelect.value = savedCity;
                if (savedCity === 'jakarta') {
                    districtContainer.classList.remove('hidden');
                    districtContainer.style.display = 'block';
                }
            }
        @endif

        @if(old('shipping_district'))
            const savedDistrict = "{{ old('shipping_district') }}";
            if (savedDistrict) districtSelect.value = savedDistrict;
        @endif

        @if(old('shipping_courier'))
            const savedCourier = "{{ old('shipping_courier') }}";
            if (savedCourier) courierSelect.value = savedCourier;
        @endif

        @if(old('payment_method'))
            const oldMethod = "{{ old('payment_method') }}";
            if (oldMethod) {
                const radio = document.querySelector(`input[name="payment_method"][value="${oldMethod}"]`);
                if (radio) radio.checked = true;
            }
        @endif

        // Initialize
        updateTotal();
        
        // Tampilkan payment detail default
        const defaultMethod = document.querySelector('input[name="payment_method"]:checked').value;
        renderPaymentDetails(defaultMethod, subtotal + shippingCost);

        // Hindari double submit (jika tadi loading terus)
        let isSubmitting = false;
        document.getElementById('checkoutForm').addEventListener('submit', function() {
            if (isSubmitting) {
                event.preventDefault();
                return;
            }
            isSubmitting = true;
            document.getElementById('submitButton').innerHTML = `
                <span class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    MEMPROSES...
                </span>
            `;
        });
    });
    </script>
</x-user-layout>