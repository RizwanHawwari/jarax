<x-admin-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Pusat Laporan & Arsip</h2>
        <p class="text-sm text-gray-500 mt-1">Analisis data bisnis dan ekspor laporan</p>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Periode:</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                <span class="text-gray-400">-</span>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
            </div>
            <button type="submit" class="px-4 py-2 bg-[#F95738] text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Filter
            </button>
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                Reset
            </a>
        </form>
    </div>

    <!-- Summary Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    <p class="text-green-100 text-xs mt-2">{{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Order</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                    <p class="text-green-500 text-xs mt-2">Periode ini</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">User Baru</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                    <p class="text-blue-500 text-xs mt-2">Periode ini</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Order Pending</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['pending_orders'] }}</p>
                    <p class="text-orange-500 text-xs mt-2">Perlu tindakan</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Tren Penjualan (7 Hari Terakhir)</h3>
                <p class="text-sm text-gray-500">Grafik pendapatan harian</p>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>

    <!-- Report Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Laporan Penjualan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Lengkap</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Penjualan</h3>
            <p class="text-sm text-gray-500 mb-4">Rekap total pendapatan harian, bulanan, dan tahunan dengan detail transaksi.</p>
            <div class="space-y-2 mb-4 pb-4 border-b border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Revenue</span>
                    <span class="font-semibold text-gray-800">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Order</span>
                    <span class="font-semibold text-gray-800">{{ $stats['total_orders'] }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.sales') }}" class="flex-1 px-4 py-2.5 bg-[#F95738] text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition-colors text-center">
                    Lihat Detail
                </a>
                <button onclick="exportReport('sales')" class="px-4 py-2.5 border border-gray-300 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors" title="Export PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Laporan Stok -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                @if($lowStockProducts->count() > 0)
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Warning: {{ $lowStockProducts->count() }}</span>
                @else
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Aman</span>
                @endif
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Stok</h3>
            <p class="text-sm text-gray-500 mb-4">Daftar barang menipis dan riwayat keluar masuk barang.</p>
            @if($lowStockProducts->count() > 0)
                <div class="bg-red-50 border border-red-100 rounded-lg p-3 mb-4">
                    <p class="text-xs text-red-600 font-medium mb-2">⚠️ Stok Menipis (&lt; 10)</p>
                    <ul class="space-y-1">
                        @foreach($lowStockProducts->take(3) as $product)
                            <li class="text-sm text-red-700 flex justify-between">
                                <span class="truncate">{{ $product->name }}</span>
                                <span class="font-semibold">{{ $product->stock }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="bg-green-50 border border-green-100 rounded-lg p-3 mb-4">
                    <p class="text-sm text-green-700">✓ Semua stok aman</p>
                </div>
            @endif
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.stock') }}" class="flex-1 px-4 py-2.5 bg-[#F95738] text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition-colors text-center">
                    Lihat Detail
                </a>
                <button onclick="exportReport('stock')" class="px-4 py-2.5 border border-gray-300 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors" title="Export PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Laporan Transaksi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">{{ $statusDistribution->sum('count') }} Transaksi</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Transaksi</h3>
            <p class="text-sm text-gray-500 mb-4">Arsip status transaksi sukses, gagal, dan refund.</p>
            <div class="space-y-1.5 mb-4 pb-4 border-b border-gray-100">
                @foreach($statusDistribution as $status)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 capitalize">{{ $status->status }}</span>
                        <span class="font-semibold text-gray-800">{{ $status->count }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.transactions') }}" class="flex-1 px-4 py-2.5 bg-[#F95738] text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition-colors text-center">
                    Lihat Detail
                </a>
                <button onclick="exportReport('transactions')" class="px-4 py-2.5 border border-gray-300 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors" title="Export PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Produk Terlaris</h3>
                <p class="text-sm text-gray-500">Top 5 produk dengan penjualan tertinggi</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-[#F95738] hover:underline font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terjual</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pendapatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($topProducts as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $product->product_name }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600">{{ $product->total_sold }} unit</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-semibold text-green-600">Rp {{ number_format($product->revenue, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $stock = \App\Models\Product::where('name', $product->product_name)->first();
                                @endphp
                                @if($stock && $stock->stock <= 10)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">{{ $stock->stock }}</span>
                                @else
                                    <span class="text-sm text-gray-600">{{ $stock->stock ?? '-' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data penjualan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendData = @json($salesTrend);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesTrendData.map(item => new Date(item.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })),
                datasets: [{
                    label: 'Penjualan',
                    data: salesTrendData.map(item => item.total),
                    borderColor: '#F95738',
                    backgroundColor: 'rgba(249, 87, 56, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#F95738',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Export function
        function exportReport(type) {
            alert('Fitur export PDF untuk "' + type + '" akan segera tersedia.\n\nUntuk saat ini, Anda dapat menggunakan fitur Print (Ctrl+P) browser untuk menyimpan sebagai PDF.');
        }
    </script>
</x-admin-layout>