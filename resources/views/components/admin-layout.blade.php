<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JaRax') }} - Admin Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 overflow-x-hidden">
    <div class="min-h-screen flex">
        <!-- Mobile Overlay -->
        <div id="sidebarOverlay" 
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"
             onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" 
class="fixed lg:relative inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200
transform -translate-x-full lg:translate-x-0 transition-transform duration-300
flex flex-col">
            
            <!-- Logo & Close Button -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-[#F95738]">JaRax</h1>
                    <p class="text-xs text-gray-400 mt-1">Admin Dashboard</p>
                </div>
                <!-- Close Button (Mobile Only) -->
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 mb-1 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
   class="flex items-center px-4 py-3 mb-1 rounded-lg text-gray-600 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.products.*') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : '' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
    </svg>
    <span class="font-medium">Kelola Produk</span>
</a>

                <a href="{{ route('admin.transactions.index') }}" 
   class="flex items-center px-4 py-3 mb-1 rounded-lg text-gray-600 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.transactions.*') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : '' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
    </svg>
    <span class="font-medium">Kelola Transaksi</span>
</a>

                <a href="{{ route('admin.users.index') }}" 
   class="flex items-center px-4 py-3 mb-1 rounded-lg text-gray-600 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.users.*') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : '' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>
    <span class="font-medium">Kelola User</span>
</a>

                <a href="{{ route('admin.staff.index') }}" 
   class="flex items-center px-4 py-3 mb-1 rounded-lg text-gray-600 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : '' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    <span class="font-medium">Kelola Petugas</span>
</a>

                <a href="{{ route('admin.reports.index') }}" 
   class="flex items-center px-4 py-3 mb-1 rounded-lg text-gray-600 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : '' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    <span class="font-medium">Laporan</span>
</a>

                <a href="{{ route('admin.backup.index') }}" 
   class="flex items-center px-4 py-3 mb-1 rounded-lg text-gray-600 hover:bg-gray-50 transition-all {{ request()->routeIs('admin.backup.*') ? 'bg-orange-50 text-[#F95738] border-r-4 border-[#F95738]' : '' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
    </svg>
    <span class="font-medium">Backup Data</span>
</a>
            </nav>

            <!-- User Profile (Bottom) -->
            <div class="p-4 border-t border-gray-100 mt-auto mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-[#F95738] flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->first_name, 0, 1) }}
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-700">{{ auth()->user()->first_name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-100 px-4 lg:px-8 py-4 sticky top-0 z-30">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <!-- Hamburger Menu (Mobile Only) -->
                        <button onclick="toggleSidebar()" class="lg:hidden mr-4 text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">Dashboard Overview</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500 hidden sm:inline">{{ now()->format('d F Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-8 w-full overflow-hidden min-w-0">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Toggle translate class
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>