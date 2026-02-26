<x-user-layout>
    <!-- Product Detail Section -->
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li>
                        <a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-[#F95738]">Home</a>
                    </li>
                    <li>/</li>
                    <li>
                        <a href="{{ route('user.products.index') }}" class="text-gray-500 hover:text-[#F95738]">Produk</a>
                    </li>
                    <li>/</li>
                    <li>
                        <span class="text-gray-800 font-medium">{{ $product->name }}</span>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Product Image -->
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <div class="aspect-square bg-gray-100 rounded-xl flex items-center justify-center mb-4 overflow-hidden">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        @else
                            <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        @endif
                    </div>
                    <!-- Thumbnail Images (Placeholder) -->
                    <div class="grid grid-cols-4 gap-3">
                        <div class="aspect-square bg-gray-100 rounded-lg cursor-pointer border-2 border-[#F95738]"></div>
                        <div class="aspect-square bg-gray-100 rounded-lg cursor-pointer hover:border-2 hover:border-[#F95738]"></div>
                        <div class="aspect-square bg-gray-100 rounded-lg cursor-pointer hover:border-2 hover:border-[#F95738]"></div>
                        <div class="aspect-square bg-gray-100 rounded-lg cursor-pointer hover:border-2 hover:border-[#F95738]"></div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <!-- Category & Badge -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-orange-100 text-[#F95738] text-xs font-semibold rounded-full">
                            {{ $product->category }}
                        </span>
                        @if($product->stock <= 10)
                            <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-full animate-pulse">
                                🔥 Stok Menipis
                            </span>
                        @endif
                        @if($product->stock > 0)
                            <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded-full">
                                ✓ Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm font-semibold text-gray-800">4.9</span>
                        </div>
                        <span class="text-gray-400">|</span>
                        <span class="text-sm text-gray-500">128 Review</span>
                        <span class="text-gray-400">|</span>
                        <span class="text-sm text-gray-500">10.5RB Terjual</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold text-[#F95738]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @php
                                $originalPrice = $product->price * 1.3;
                                $discount = 30;
                            @endphp
                            <span class="text-lg text-gray-400 line-through">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                            <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">{{ $discount }}% OFF</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $product->description ?? 'Produk berkualitas tinggi dengan desain modern dan elegan. Cocok untuk penggunaan sehari-hari. Bahan premium yang nyaman dan tahan lama.' }}
                        </p>
                    </div>

                    <!-- Size Selection (if applicable) -->
                    @if(in_array($product->category, ['Fashion', 'Sepatu']))
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Pilih Ukuran</h3>
                            <div class="flex gap-2">
                                @foreach([39, 40, 41, 42, 43] as $size)
                                    <button class="w-12 h-12 border-2 border-gray-200 rounded-lg hover:border-[#F95738] hover:text-[#F95738] transition-all focus:border-[#F95738] focus:text-[#F95738] font-medium">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Stock Info -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Tersedia: <span class="font-semibold text-gray-800">{{ $product->stock }} unit</span></span>
                            <span class="text-sm text-gray-500">Terjual: 128</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-[#F95738] to-orange-500 h-2 rounded-full" style="width: {{ min(100, ($product->stock / 100) * 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
<div class="mb-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Jumlah</h3>
    <div class="flex items-center gap-3">
        <button type="button" onclick="decreaseQty()" class="w-10 h-10 border-2 border-gray-200 rounded-lg hover:border-[#F95738] transition-colors flex items-center justify-center text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
            </svg>
        </button>
        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
               class="w-20 text-center border-2 border-gray-200 rounded-lg py-2 focus:outline-none focus:border-[#F95738]" readonly>
        <button type="button" onclick="increaseQty()" class="w-10 h-10 border-2 border-gray-200 rounded-lg hover:border-[#F95738] transition-colors flex items-center justify-center text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>
        <span class="text-sm text-gray-500 ml-2">Stok: {{ $product->stock }}</span>
    </div>
</div>

                    <!-- Action Buttons -->
<form action="{{ route('user.cart.add') }}" method="POST" class="flex gap-4 mb-6">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="variant" value="Default">
    <input type="hidden" name="quantity" value="1">

    <button type="button" class="flex-1 py-4 border-2 border-[#F95738] text-[#F95738] rounded-xl font-bold hover:bg-orange-50 transition-all">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        Chat Penjual
    </button>
    <button type="submit" class="flex-1 py-4 bg-[#F95738] hover:bg-orange-600 text-white rounded-xl font-bold transition-all hover:shadow-lg">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        + Keranjang
    </button>
</form>

<!-- Buy Now Button -->
<form action="{{ route('user.cart.add') }}" method="POST" class="mb-6">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="variant" value="Default">
    <input type="hidden" name="quantity" value="1">

    <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#F95738] to-orange-500 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold transition-all hover:shadow-xl">
        Beli Sekarang
    </button>
</form>

<!-- Success Message -->
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
@endif

                    <!-- Guarantees -->
                    <div class="mt-8 pt-8 border-t border-gray-100">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <svg class="w-8 h-8 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-xs text-gray-500">Garansi Original</p>
                            </div>
                            <div>
                                <svg class="w-8 h-8 text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-xs text-gray-500">Gratis Ongkir</p>
                            </div>
                            <div>
                                <svg class="w-8 h-8 text-purple-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <p class="text-xs text-gray-500">Return 7 Hari</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('user.products.show', $related->slug) }}" class="group">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                                <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if($related->image)
                                        <img src="{{ Storage::url($related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    @else
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-2 truncate group-hover:text-[#F95738]">{{ $related->name }}</h3>
                                    <span class="text-lg font-bold text-[#F95738]">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = {{ $product->stock }};
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

        // Show success message and redirect to cart after add to cart
    @if(session('success'))
        setTimeout(() => {
            if (confirm('{{ session('success') }}\n\nLihat keranjang sekarang?')) {
                window.location.href = '{{ route('user.cart.index') }}';
            }
        }, 500);
    @endif

    // Size selection functionality
    document.querySelectorAll('button[onclick*="selectSize"]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('[onclick*="selectSize"]').forEach(b => {
                b.classList.remove('border-[#F95738]', 'text-[#F95738]');
                b.classList.add('border-gray-200');
            });
            this.classList.remove('border-gray-200');
            this.classList.add('border-[#F95738]', 'text-[#F95738]');
        });
    });
        // Promo Popup on Page Load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if already shown today
            const shownToday = localStorage.getItem('promoShown_' + new Date().toDateString());

            if (!shownToday) {
                Swal.fire({
                    title: '🎉 Promo Spesial Hari Ini!',
                    html: `
                        <div class="text-center py-4">
                            <div class="text-6xl mb-4">🔥</div>
                            <p class="text-lg font-semibold text-gray-800 mb-2">Diskon 50% untuk Pembelian Pertama!</p>
                            <p class="text-gray-600 mb-4">Gunakan kode: <span class="bg-orange-100 text-[#F95738] px-3 py-1 rounded font-bold">JARAX50</span></p>
                            <div class="bg-gradient-to-r from-[#F95738] to-orange-500 text-white py-3 rounded-lg font-bold">
                                Berlaku hingga hari ini saja!
                            </div>
                        </div>
                    `,
                    showConfirmButton: true,
                    confirmButtonText: 'Ambil Promo Sekarang!',
                    confirmButtonColor: '#F95738',
                    showCancelButton: true,
                    cancelButtonText: 'Nanti Saja',
                    cancelButtonColor: '#6b7280',
                    background: 'url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23F95738\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")',
                    backdrop: `
                        rgba(0,0,0,0.4)
                        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23F95738' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-6v-1h2zM4 95h2v1H0v-1h4zm69.66-7.05l.76-1.73 1.63.72-.76 1.73-1.63-.72zm-10-10l.76-1.73 1.63.72-.76 1.73-1.63-.72zm10-3.06l.76-1.73 1.63.72-.76 1.73-1.63-.72z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")
                        left top
                        no-repeat
                    `,
                    customClass: {
                        popup: 'rounded-2xl',
                        title: 'text-2xl font-bold text-[#F95738]',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to products or apply coupon
                        window.location.href = '{{ route("user.products.index") }}';
                    }
                    // Mark as shown today
                    localStorage.setItem('promoShown_' + new Date().toDateString(), 'true');
                });
            }
        });
    </script>
</x-user-layout>
