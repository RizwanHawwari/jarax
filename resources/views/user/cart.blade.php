<x-user-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Keranjang Belanja</h1>
                <p class="text-gray-500">{{ $cartItems->count() }} produk di keranjang Anda</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items (2/3 width) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Table Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <div class="grid grid-cols-12 gap-4 text-xs font-medium text-gray-500 uppercase">
                                <div class="col-span-1">SELECT</div>
                                <div class="col-span-5">PRODUK</div>
                                <div class="col-span-3">HARGA</div>
                                <div class="col-span-3">JUMLAH</div>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="divide-y divide-gray-100">
                            @forelse($cartItems as $item)
                                <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <div class="grid grid-cols-12 gap-4 items-center">
                                        <!-- Checkbox -->
                                        <div class="col-span-1">
                                            <form action="{{ route('user.cart.toggle', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-5 h-5 rounded {{ $item->is_selected ? 'bg-[#F95738]' : 'bg-gray-200' }} flex items-center justify-center transition-colors">
                                                    @if($item->is_selected)
                                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="col-span-5">
                                            <div class="flex items-center">
                                                @if($item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-lg mr-4">
                                                @else
                                                    <div class="w-20 h-20 bg-gray-100 rounded-lg mr-4 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                                    <p class="text-sm text-gray-500">{{ $item->variant ?? 'Variant: Default' }}</p>
                                                    <form action="{{ route('user.cart.remove', $item->id) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 hover:underline">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-span-3">
                                            <span class="font-semibold text-gray-800">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-span-3">
                                            <form action="{{ route('user.cart.update', $item->id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                       onchange="this.form.submit()"
                                                       class="w-16 px-2 py-1 border border-gray-300 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-[#F95738] text-sm">
                                            </form>
                                            <p class="text-xs text-gray-400 mt-1">Stok: {{ $item->product->stock }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-12 text-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Keranjang Kosong</h3>
                                    <p class="text-gray-500 mb-4">Mulai belanja untuk menambahkan produk</p>
                                    <a href="{{ route('user.products.index') }}" class="inline-block bg-[#F95738] hover:bg-orange-600 text-white px-6 py-2 rounded-full font-medium transition-colors">
                                        Belanja Sekarang
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Order Summary (1/3 width) -->
<div class="lg:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Ringkasan Pesanan</h2>

        <div class="space-y-4 mb-6">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Total Harga ({{ $selectedCount }} Barang)</span>
                <span class="font-medium text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Ongkos Kirim</span>
                <span class="font-medium text-gray-800">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
            </div>
            <div class="border-t border-gray-100 pt-4">
                <div class="flex justify-between">
                    <span class="text-base font-semibold text-gray-800">Total Tagihan</span>
                    <span class="text-xl font-bold text-[#F95738]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</h3>
            <div class="space-y-2">
                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-[#F95738] transition-colors">
                    <input type="radio" name="payment_method" value="transfer_bank" checked class="w-4 h-4 text-[#F95738]">
                    <span class="ml-3 text-sm text-gray-700">Transfer Bank (BCA)</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-[#F95738] transition-colors">
                    <input type="radio" name="payment_method" value="ewallet" class="w-4 h-4 text-[#F95738]">
                    <span class="ml-3 text-sm text-gray-700">E-Wallet (GoPay/OVO)</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-[#F95738] transition-colors">
                    <input type="radio" name="payment_method" value="cod" class="w-4 h-4 text-[#F95738]">
                    <span class="ml-3 text-sm text-gray-700">Bayar di Tempat (COD)</span>
                </label>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Alamat Pengiriman</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-medium text-gray-800">{{ auth()->user()->full_name }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ auth()->user()->phone_number ?? 'Belum ada nomor telepon' }}</p>
                <p class="text-sm text-gray-500 mt-2 text-xs">Alamat akan dikonfirmasi saat checkout</p>
            </div>
        </div>

        <!-- Checkout Button -->
        @if($selectedCount > 0)
            <a href="{{ route('user.checkout.index') }}" class="block w-full bg-[#F95738] hover:bg-orange-600 text-white text-center py-3 rounded-xl font-semibold transition-all hover:shadow-lg">
                BUAT PESANAN
            </a>
        @else
            <button disabled class="block w-full bg-gray-300 text-gray-500 text-center py-3 rounded-xl font-semibold cursor-not-allowed">
                Pilih Produk Terlebih Dahulu
            </button>
        @endif

        <!-- Continue Shopping -->
        <a href="{{ route('user.products.index') }}" class="block text-center text-sm text-[#F95738] hover:underline mt-4">
            Lanjut Belanja →
        </a>
    </div>
</div>

                        <!-- Continue Shopping -->
                        <a href="{{ route('user.products.index') }}" class="block text-center text-sm text-[#F95738] hover:underline mt-4">
                            Lanjut Belanja →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Auto update ringkasan saat checkbox diklik
    document.querySelectorAll('form[action*="cart/toggle"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const summary = document.querySelector('.sticky');
            if (summary) {
                summary.style.opacity = '0.5';
            }
        });
    });

    // Auto update saat quantity berubah
    document.querySelectorAll('input[name="quantity"]').forEach(input => {
        input.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
</x-user-layout>
