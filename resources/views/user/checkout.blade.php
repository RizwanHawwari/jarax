<x-user-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Checkout</h1>
                <p class="text-gray-500">Lengkapi informasi untuk menyelesaikan pesanan</p>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
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

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                                    <input type="text" name="shipping_city" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Metode Pembayaran</h2>

                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors">
                                    <input type="radio" name="payment_method" value="transfer_bank" checked class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">Transfer Bank</p>
                                        <p class="text-sm text-gray-500">BCA, Mandiri, BNI</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=Bank" alt="Bank" class="h-8">
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors">
                                    <input type="radio" name="payment_method" value="ewallet" class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">E-Wallet</p>
                                        <p class="text-sm text-gray-500">GoPay, OVO, DANA</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=E-Wallet" alt="E-Wallet" class="h-8">
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#F95738] transition-colors">
                                    <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-[#F95738]">
                                    <div class="ml-3 flex-1">
                                        <p class="font-medium text-gray-800">Bayar di Tempat (COD)</p>
                                        <p class="text-sm text-gray-500">Bayar saat barang diterima</p>
                                    </div>
                                    <img src="https://via.placeholder.com/60x30?text=COD" alt="COD" class="h-8">
                                </label>
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
                                    <span class="font-medium text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Ongkos Kirim</span>
                                    <span class="font-medium text-gray-800">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-gray-100 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-semibold text-gray-800">Total</span>
                                        <span class="text-xl font-bold text-[#F95738]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full mt-6 bg-[#F95738] hover:bg-orange-600 text-white py-3 rounded-xl font-semibold transition-all hover:shadow-lg">
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
</x-user-layout>
