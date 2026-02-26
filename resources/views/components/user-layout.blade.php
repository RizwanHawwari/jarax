<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JaRax') }} - E-Commerce Modern</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #F95738 0%, #ff8c69 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #F95738 0%, #ff6b35 50%, #ff8c69 100%);
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(249, 87, 56, 0.15);
        }
        .nav-link:hover {
            color: #F95738;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold gradient-text">JaRax</a>
                </div>

                <!-- Search Bar (Desktop) -->
<div class="hidden md:flex flex-1 mx-8">
    <form action="{{ route('user.products.index') }}" method="GET" class="relative w-full max-w-2xl mx-auto">
        <input type="text" name="search" id="searchInput" placeholder="Cari produk favoritmu..."
               value="{{ request('search') }}"
               class="w-full px-4 py-2 pl-12 pr-4 bg-gray-100 border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-[#F95738] focus:bg-white transition-all">
        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#F95738] hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>

        <!-- Search Suggestions Dropdown -->
        <div id="searchSuggestions" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50"></div>
    </form>
</div>

                <!-- Right Menu -->
<div class="flex items-center space-x-6">
    @auth
        <!-- Chat -->
        <a href="{{ route('user.chat.index') }}" class="relative nav-link text-gray-600 hover:text-[#F95738] transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            @php
                $unreadChats = \App\Models\Chat::where('user_id', auth()->id())
                    ->where('sender', 'admin')
                    ->where('is_read', false)
                    ->count();
            @endphp
            @if($unreadChats > 0)
                <span class="absolute -top-2 -right-2 bg-[#F95738] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $unreadChats }}</span>
            @endif
        </a>

        <!-- Cart -->
<a href="{{ route('user.cart.index') }}" class="relative nav-link text-gray-600 hover:text-[#F95738] transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    @php
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
    @endphp
    @if($cartCount > 0)
        <span class="absolute -top-2 -right-2 bg-[#F95738] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center" id="cartCount">{{ $cartCount }}</span>
    @endif
</a>

        <!-- Orders -->
        <a href="{{ route('user.orders') }}" class="nav-link text-gray-600 hover:text-[#F95738] transition-colors hidden sm:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </a>

        <!-- User Menu -->
        <div class="relative" x-data="{ open: false }">
            <button onclick="document.getElementById('userMenu').classList.toggle('hidden')"
                    class="flex items-center space-x-2 nav-link text-gray-600 hover:text-[#F95738] transition-colors">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#F95738] to-orange-500 flex items-center justify-center text-white font-semibold text-sm">
                    {{ substr(auth()->user()->first_name, 0, 1) }}
                </div>
                <span class="hidden md:block text-sm font-medium">{{ auth()->user()->first_name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100">
                <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F95738]">Dashboard</a>
                <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F95738]">Pesanan Saya</a>
                <a href="{{ route('user.chat.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F95738]">Chat Penjual</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F95738]">Wishlist</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#F95738]">Pengaturan</a>
                <hr class="my-2 border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                </form>
            </div>
        </div>
    @else
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#F95738] font-medium transition-colors">Masuk</a>
        <a href="{{ route('register') }}" class="bg-[#F95738] hover:bg-orange-600 text-white px-5 py-2 rounded-full font-medium transition-colors">Daftar</a>
    @endauth
</div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <!-- Main Footer -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <h3 class="text-2xl font-bold gradient-text mb-4">JaRax</h3>
                    <p class="text-gray-400 text-sm mb-4">Platform e-commerce modern dengan produk berkualitas terbaik untuk gaya hidup Anda.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#F95738] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#F95738] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#F95738] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Press</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan Pelanggan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Cara Pembelian</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Pengembalian</a></li>
                        <li><a href="#" class="hover:text-[#F95738] transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Newsletter</h4>
                    <p class="text-gray-400 text-sm mb-4">Dapatkan info promo terbaru dan diskon eksklusif.</p>
                    <form class="space-y-2">
                        <input type="email" placeholder="Email Anda"
                               class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                        <button type="submit" class="w-full bg-[#F95738] hover:bg-orange-600 text-white py-2 rounded-lg font-medium transition-colors">
                            Langganan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">© 2026 JaRax E-Commerce. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            id="scrollTopBtn"
            class="fixed bottom-6 right-6 bg-[#F95738] hover:bg-orange-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all opacity-0 pointer-events-none hover:scale-110">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Search Script -->
<script>
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('searchSuggestions');
    let debounceTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            const query = e.target.value;

            if (query.length < 2) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`{{ route('user.search') }}?q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            suggestionsBox.innerHTML = data.data.map(product => `
                                <a href="/user/products/${product.slug}" class="flex items-center gap-3 p-3 hover:bg-orange-50 transition-colors border-b border-gray-100 last:border-0">
                                    ${product.image ? `<img src="${product.image}" class="w-10 h-10 object-cover rounded">` : ''}
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">${product.name}</p>
                                        <p class="text-sm text-[#F95738]">Rp ${product.price.toLocaleString('id-ID')}</p>
                                    </div>
                                </a>
                            `).join('');
                            suggestionsBox.classList.remove('hidden');
                        } else {
                            suggestionsBox.classList.add('hidden');
                        }
                    });
            }, 300);
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });
    }
</script>
</body>
</html>
