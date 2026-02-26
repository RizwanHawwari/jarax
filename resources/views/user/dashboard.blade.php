<x-user-layout>
    <!-- Hero Banner dengan Background Image -->
    <div class="relative hero-gradient overflow-hidden min-h-[500px] md:min-h-[600px]">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-white rounded-full blur-3xl"></div>
        </div>

        <!-- Animated Circles -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-yellow-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-white">
                    <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6 border border-white/30">
                        <span class="mr-2">🔥</span>
                        <span>Promo Gajian Sale - Hingga 80% OFF</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                        Temukan Gaya<br/>
                        <span class="text-yellow-300">Terbaikmu</span> Disini
                    </h1>

                    <p class="text-lg text-white/90 mb-8 max-w-lg leading-relaxed">
                        Koleksi produk premium dengan harga terbaik. Gratis ongkir ke seluruh Indonesia untuk pembelian minimal Rp 100.000
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="#products" class="bg-white text-[#F95738] px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-all hover:scale-105 shadow-xl hover:shadow-2xl flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Belanja Sekarang
                        </a>
                        <a href="#categories" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-full font-bold hover:bg-white/30 transition-all border border-white/30 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Kategori
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex flex-wrap gap-6 mt-12 pt-8 border-t border-white/20">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-yellow-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold">Produk Original</p>
                                <p class="text-sm text-white/70">100% Terjamin</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-yellow-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <div>
                                <p class="font-semibold">Gratis Ongkir</p>
                                <p class="text-sm text-white/70">Min. Rp 100k</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-yellow-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold">Pembayaran Aman</p>
                                <p class="text-sm text-white/70">Enkripsi SSL</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Showcase dengan Gambar Real -->
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    @php
                        $showcaseProducts = $recommendedProducts->take(4);
                    @endphp
                    @foreach($showcaseProducts as $index => $product)
                        <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-4 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl {{ $index % 2 === 1 ? 'mt-8' : '' }}">
                            <div class="bg-white rounded-2xl h-48 flex items-center justify-center mb-4 overflow-hidden relative group">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                @endif
                                @if($product->stock <= 10)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-medium">
                                        Stok Menipis
                                    </span>
                                @endif
                                <button class="absolute bottom-3 right-3 w-10 h-10 bg-[#F95738] hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 hover:scale-110 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-white/70 mb-1">{{ $product->category }}</p>
                            <h3 class="text-white font-semibold mb-2 truncate">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-yellow-300 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->stock < 50)
                                    <span class="text-xs text-red-300">Sisa {{ $product->stock }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </div>

    <!-- Categories Section -->
    <div id="categories" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Kategori Populer</h2>
                <p class="text-gray-500">Temukan produk berdasarkan kategori favoritmu</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $categories = [
                        ['name' => 'Fashion', 'icon' => '👕', 'color' => 'from-pink-500 to-rose-500'],
                        ['name' => 'Elektronik', 'icon' => '📱', 'color' => 'from-blue-500 to-cyan-500'],
                        ['name' => 'Gaming', 'icon' => '🎮', 'color' => 'from-purple-500 to-violet-500'],
                        ['name' => 'Aksesoris', 'icon' => '⌚', 'color' => 'from-orange-500 to-amber-500'],
                        ['name' => 'Rumah', 'icon' => '🏠', 'color' => 'from-green-500 to-emerald-500'],
                        ['name' => 'Lainnya', 'icon' => '📦', 'color' => 'from-gray-500 to-slate-500'],
                    ];
                @endphp

                @foreach($categories as $category)
    <a href="{{ route('user.products.index', ['category' => $category['name']]) }}" class="group">
        <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br {{ $category['color'] }} flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                {{ $category['icon'] }}
            </div>
            <h3 class="font-semibold text-gray-800 group-hover:text-[#F95738] transition-colors">{{ $category['name'] }}</h3>
        </div>
    </a>
@endforeach
            </div>
        </div>
    </div>

    <!-- Flash Sale Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl">⚡</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Flash Sale</h2>
                    </div>
                    <p class="text-gray-500">Diskon spesial berakhir dalam:</p>
                </div>

                <!-- Countdown Timer -->
                <div class="flex gap-3" id="countdown">
                    <div class="bg-[#F95738] text-white rounded-xl px-4 py-3 text-center min-w-[70px]">
                        <p class="text-2xl font-bold" id="hours">00</p>
                        <p class="text-xs">Jam</p>
                    </div>
                    <div class="bg-[#F95738] text-white rounded-xl px-4 py-3 text-center min-w-[70px]">
                        <p class="text-2xl font-bold" id="minutes">00</p>
                        <p class="text-xs">Menit</p>
                    </div>
                    <div class="bg-[#F95738] text-white rounded-xl px-4 py-3 text-center min-w-[70px]">
                        <p class="text-2xl font-bold" id="seconds">00</p>
                        <p class="text-xs">Detik</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4" id="products">
                @foreach($recommendedProducts as $product)
    <a href="{{ route('user.products.show', $product->slug) }}" class="group">
        <div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <!-- Product Image -->
            <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <!-- Product Info -->
            <div class="p-4">
                <p class="text-xs text-gray-500 mb-1">{{ $product->category }}</p>
                <h3 class="font-semibold text-gray-800 mb-2 truncate group-hover:text-[#F95738] transition-colors">{{ $product->name }}</h3>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-[#F95738]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <button class="w-8 h-8 bg-[#F95738] hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $product->stock }} stok tersedia</p>
            </div>
        </div>
    </a>
@endforeach
            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-block bg-white border-2 border-[#F95738] text-[#F95738] px-10 py-4 rounded-full font-bold hover:bg-[#F95738] hover:text-white transition-all hover:scale-105 shadow-lg">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="py-16 bg-gradient-to-br from-gray-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Kenapa Belanja di JaRax?</h2>
                <p class="text-gray-500">Kami berkomitmen memberikan pengalaman belanja terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-2xl">
                        ✓
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Produk Original</h3>
                    <p class="text-sm text-gray-500">100% produk asli dengan jaminan kualitas</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center text-white text-2xl">
                        🚚
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-500">Diproses dalam 24 jam, sampai dalam 2-3 hari</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-purple-400 to-violet-500 flex items-center justify-center text-white text-2xl">
                        🔒
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Pembayaran Aman</h3>
                    <p class="text-sm text-gray-500">Transaksi terenkripsi dengan berbagai metode</p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center text-white text-2xl">
                        💬
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Support 24/7</h3>
                    <p class="text-sm text-gray-500">Tim customer service siap membantu anytime</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Countdown Timer Script -->
    <script>
        // Set countdown to end of day
        function updateCountdown() {
            const now = new Date();
            const endOfDay = new Date();
            endOfDay.setHours(23, 59, 59, 999);

            const diff = endOfDay - now;

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</x-user-layout>
