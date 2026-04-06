<x-user-layout>
    <!-- Hero Banner dengan Background Image -->
    <!-- UI: Enhanced hero with stronger depth layering and refined glow effects -->
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
                    <!-- UI: Badge refined with tighter tracking and stronger backdrop contrast -->
                    <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6 border border-white/30 tracking-wide shadow-sm">
                        <span class="mr-2">🔥</span>
                        <span>Promo Gajian Sale - Hingga 80% OFF</span>
                    </div>

                    <!-- UI: Improved leading and tracking for headline legibility -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-[1.1] tracking-tight">
                        Temukan Gaya<br/>
                        <span class="text-yellow-300 drop-shadow-sm">Terbaikmu</span> Disini
                    </h1>

                    <!-- UI: Slightly looser leading for body copy readability -->
                    <p class="text-lg text-white/90 mb-8 max-w-lg leading-relaxed tracking-normal">
                        Koleksi produk premium dengan harga terbaik. Gratis ongkir ke seluruh Indonesia untuk pembelian minimal Rp 100.000
                    </p>

                    <!-- UI: CTA buttons with stronger shadow depth and focus rings -->
                    <div class="flex flex-wrap gap-4">
                        <a href="#products" class="bg-white text-[#F95738] px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-all duration-200 hover:scale-105 shadow-xl hover:shadow-2xl flex items-center gap-2 focus:outline-none focus-visible:ring-4 focus-visible:ring-white/60 active:scale-95">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Belanja Sekarang
                        </a>
                        <a href="#categories" class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-full font-bold hover:bg-white/30 transition-all duration-200 border border-white/30 flex items-center gap-2 hover:shadow-lg focus:outline-none focus-visible:ring-4 focus-visible:ring-white/40 active:scale-95">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Kategori
                        </a>
                    </div>

                    <!-- UI: Trust badges with refined spacing and icon alignment -->
                    <div class="flex flex-wrap gap-6 mt-12 pt-8 border-t border-white/20">
                        <div class="flex items-center gap-3">
                            <div class="shrink-0 w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm leading-tight">Produk Original</p>
                                <p class="text-xs text-white/70 mt-0.5">100% Terjamin</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="shrink-0 w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm leading-tight">Gratis Ongkir</p>
                                <p class="text-xs text-white/70 mt-0.5">Min. Rp 100k</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="shrink-0 w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm leading-tight">Pembayaran Aman</p>
                                <p class="text-xs text-white/70 mt-0.5">Enkripsi SSL</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UI: Product showcase cards with stronger layering and polish -->
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    @php
                        $showcaseProducts = $recommendedProducts->take(4);
                    @endphp
                    @foreach($showcaseProducts as $index => $product)
                        <!-- UI: Card hover with ring highlight for depth -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-4 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl hover:bg-white/15 ring-1 ring-white/10 hover:ring-white/25 {{ $index % 2 === 1 ? 'mt-8' : '' }}">
                            <div class="bg-white rounded-2xl h-48 flex items-center justify-center mb-4 overflow-hidden relative group shadow-sm">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                @endif
                                @if($product->stock <= 10)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-sm">
                                        Stok Menipis
                                    </span>
                                @endif
                                <button class="absolute bottom-3 right-3 w-10 h-10 bg-[#F95738] hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-all duration-200 opacity-0 group-hover:opacity-100 hover:scale-110 shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#F95738] focus-visible:ring-offset-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- UI: Tighter vertical rhythm inside card -->
                            <p class="text-xs text-white/60 mb-1 uppercase tracking-wider font-medium">{{ $product->category }}</p>
                            <h3 class="text-white font-semibold mb-2.5 truncate text-sm leading-snug">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-yellow-300 font-bold text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->stock < 50)
                                    <span class="text-xs text-red-300 font-medium">Sisa {{ $product->stock }}</span>
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
    <!-- UI: Section header hierarchy improved with tighter subtitle spacing -->
    <div id="categories" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2 tracking-tight">Kategori Populer</h2>
                <p class="text-gray-500 text-base">Temukan produk berdasarkan kategori favoritmu</p>
            </div>

            <!-- UI: Category cards with improved icon container and hover transitions -->
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
                    <a href="{{ route('user.products.index', ['category' => $category['name']]) }}" class="group focus:outline-none focus-visible:ring-4 focus-visible:ring-[#F95738]/40 rounded-2xl">
                        <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100 hover:border-gray-200">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br {{ $category['color'] }} flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300 shadow-sm group-hover:shadow-md">
                                {{ $category['icon'] }}
                            </div>
                            <h3 class="font-semibold text-sm text-gray-800 group-hover:text-[#F95738] transition-colors duration-200 tracking-wide">{{ $category['name'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Flash Sale Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- UI: Flash sale header row with improved vertical alignment -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1.5">
                        <span class="text-3xl">⚡</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight">Flash Sale</h2>
                    </div>
                    <p class="text-gray-500 text-sm ml-[52px]">Diskon spesial berakhir dalam:</p>
                </div>

                <!-- UI: Countdown blocks with tighter proportions and subtle inner shadow -->
                <div class="flex gap-3" id="countdown">
                    <div class="bg-[#F95738] text-white rounded-xl px-4 py-3 text-center min-w-[70px] shadow-md shadow-[#F95738]/20">
                        <p class="text-2xl font-bold tabular-nums leading-none mb-1" id="hours">00</p>
                        <p class="text-[10px] uppercase tracking-widest font-medium opacity-80">Jam</p>
                    </div>
                    <div class="bg-[#F95738] text-white rounded-xl px-4 py-3 text-center min-w-[70px] shadow-md shadow-[#F95738]/20">
                        <p class="text-2xl font-bold tabular-nums leading-none mb-1" id="minutes">00</p>
                        <p class="text-[10px] uppercase tracking-widest font-medium opacity-80">Menit</p>
                    </div>
                    <div class="bg-[#F95738] text-white rounded-xl px-4 py-3 text-center min-w-[70px] shadow-md shadow-[#F95738]/20">
                        <p class="text-2xl font-bold tabular-nums leading-none mb-1" id="seconds">00</p>
                        <p class="text-[10px] uppercase tracking-widest font-medium opacity-80">Detik</p>
                    </div>
                </div>
            </div>

            <!-- UI: Product grid cards with layered hover, refined typography hierarchy -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4" id="products">
                @foreach($recommendedProducts as $product)
                    <a href="{{ route('user.products.show', $product->slug) }}" class="group focus:outline-none focus-visible:ring-4 focus-visible:ring-[#F95738]/40 rounded-2xl">
                        <div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-gray-200 hover:-translate-y-1">
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
                            <!-- UI: Product info with tighter rhythm and clearer price hierarchy -->
                            <div class="p-4">
                                <p class="text-[10px] text-gray-400 mb-1 uppercase tracking-wider font-medium">{{ $product->category }}</p>
                                <h3 class="font-semibold text-gray-800 mb-3 truncate group-hover:text-[#F95738] transition-colors duration-200 text-sm leading-snug">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-base font-bold text-[#F95738] leading-none">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <button class="w-8 h-8 bg-[#F95738] hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#F95738] focus-visible:ring-offset-1 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 font-medium">{{ $product->stock }} stok tersedia</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- UI: CTA button with stronger visual weight and active state -->
            <div class="text-center mt-12">
                <a href="#" class="inline-block bg-white border-2 border-[#F95738] text-[#F95738] px-10 py-4 rounded-full font-bold hover:bg-[#F95738] hover:text-white transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-[#F95738]/30 hover:shadow-xl active:scale-95 focus:outline-none focus-visible:ring-4 focus-visible:ring-[#F95738]/40">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <!-- UI: Feature cards with refined icon containers and consistent inner spacing -->
    <div class="py-16 bg-gradient-to-br from-gray-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2 tracking-tight">Kenapa Belanja di JaRax?</h2>
                <p class="text-gray-500 text-base">Kami berkomitmen memberikan pengalaman belanja terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-7 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100/80">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-2xl shadow-sm">
                        ✓
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2 text-sm tracking-wide">Produk Original</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">100% produk asli dengan jaminan kualitas</p>
                </div>

                <div class="bg-white rounded-2xl p-7 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100/80">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center text-white text-2xl shadow-sm">
                        🚚
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2 text-sm tracking-wide">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Diproses dalam 24 jam, sampai dalam 2-3 hari</p>
                </div>

                <div class="bg-white rounded-2xl p-7 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100/80">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-purple-400 to-violet-500 flex items-center justify-center text-white text-2xl shadow-sm">
                        🔒
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2 text-sm tracking-wide">Pembayaran Aman</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Transaksi terenkripsi dengan berbagai metode</p>
                </div>

                <div class="bg-white rounded-2xl p-7 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100/80">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center text-white text-2xl shadow-sm">
                        💬
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2 text-sm tracking-wide">Support 24/7</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Tim customer service siap membantu anytime</p>
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