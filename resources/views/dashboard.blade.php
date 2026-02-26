<x-admin-layout>
    <!-- Welcome Modal Popup -->
    @if($showWelcomeModal ?? false)
    <div id="welcomeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden animate-fade-in">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-[#F95738] to-orange-500 p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>

                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->first_name }}! 👋</h2>
                            <p class="text-orange-100">Super Administrator - JaRax E-Commerce</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-green-50 rounded-xl">
                        <p class="text-2xl font-bold text-green-600">{{ number_format(($totalRevenue ?? 0) / 1000000, 1) }}jt</p>
                        <p class="text-xs text-gray-500">Total Pendapatan</p>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-xl">
                        <p class="text-2xl font-bold text-blue-600">{{ $totalOrders ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total Order</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl">
                        <p class="text-2xl font-bold text-purple-600">{{ $totalUsers ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total User</p>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-xl">
                        <p class="text-2xl font-bold text-orange-600">{{ $totalProducts ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total Produk</p>
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-amber-800 mb-1">Perhatian Diperlukan</h4>
                            <ul class="text-sm text-amber-700 space-y-1">
                                <li>• {{ $pendingOrders ?? 0 }} order menunggu verifikasi pembayaran</li>
                                <li>• {{ $lowStockProducts ?? 0 }} produk stok menipis (&lt; 10)</li>
                                @if(($outOfStockProducts ?? 0) > 0)
                                    <li>• {{ $outOfStockProducts }} produk habis stok</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button onclick="closeWelcomeModal()"
                            class="px-6 py-3 bg-[#F95738] hover:bg-orange-600 text-white rounded-lg transition-colors font-medium">
                        Mulai Dashboard
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->first_name }}! Berikut ringkasan hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200">
                📅 {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pendapatan -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full">
                    @if(($revenueGrowth ?? 0) >= 0) ↑ @else ↓ @endif {{ number_format(abs($revenueGrowth ?? 0), 1) }}%
                </span>
            </div>
            <p class="text-green-100 text-sm mb-1">Total Pendapatan</p>
            <p class="text-3xl font-bold">Rp {{ number_format(($totalRevenue ?? 0) / 1000000, 1) }}jt</p>
            <p class="text-green-100 text-xs mt-3">Bulan ini: Rp {{ number_format(($monthlyRevenue ?? 0) / 1000, 0, ',', '.') }}k</p>
        </div>

        <!-- Total Order -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ $pendingOrders ?? 0 }} pending</span>
            </div>
            <p class="text-gray-500 text-sm mb-1">Total Order</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</p>
            <div class="flex gap-2 mt-3">
                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">{{ $processingOrders ?? 0 }} Proses</span>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ $completedOrders ?? 0 }} Selesai</span>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">+{{ $newUsersThisMonth ?? 0 }} baru</span>
            </div>
            <p class="text-gray-500 text-sm mb-1">Total User</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</p>
            <p class="text-gray-400 text-xs mt-3">{{ $totalStaff ?? 0 }} petugas aktif</p>
        </div>

        <!-- Total Produk -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                @if(($lowStockProducts ?? 0) > 0)
                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">⚠ {{ $lowStockProducts }}</span>
                @else
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">✓ Aman</span>
                @endif
            </div>
            <p class="text-gray-500 text-sm mb-1">Total Produk</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</p>
            <p class="text-gray-400 text-xs mt-3">{{ $activeProducts ?? 0 }} aktif • {{ $outOfStockProducts ?? 0 }} habis</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Sales Chart (2/3 width) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Statistik Penjualan</h3>
                    <p class="text-sm text-gray-500">Tren penjualan 12 bulan terakhir</p>
                </div>
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                    <option>12 Bulan Terakhir</option>
                    <option>6 Bulan Terakhir</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            <div class="relative h-72">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Activity Feed (1/3 width) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @foreach(($recentActivities ?? []) as $activity)
                    <div class="flex items-start gap-3 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($activity['icon'] === 'user')
                                <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @elseif($activity['icon'] === 'shopping-cart')
                                <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            @elseif($activity['icon'] === 'alert-triangle')
                                <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Aksi Cepat</h4>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-100 transition-colors text-center">
                        Verifikasi Order
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 bg-orange-50 text-orange-700 rounded-lg text-xs font-medium hover:bg-orange-100 transition-colors text-center">
                        Kelola Produk
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium hover:bg-purple-100 transition-colors text-center">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('admin.backup.index') }}" class="px-3 py-2 bg-green-50 text-green-700 rounded-lg text-xs font-medium hover:bg-green-100 transition-colors text-center">
                        Backup Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
                <p class="text-sm text-gray-500">10 transaksi terakhir</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm text-[#F95738] hover:underline font-medium">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentTransactions ?? [] as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.transactions.show', $transaction) }}"
                                   class="text-sm font-semibold text-[#F95738] hover:underline">
                                    #{{ $transaction->transaction_code }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-xs font-bold mr-3">
                                        {{ substr($transaction->user->first_name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $transaction->user->full_name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $transaction->created_at->diffForHumans() }}</span>
                                <span class="text-xs text-gray-400 block">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-gray-100 text-gray-700',
                                        'paid' => 'bg-yellow-100 text-yellow-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'shipped' => 'bg-purple-100 text-purple-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.transactions.show', $transaction) }}"
                                   class="text-sm text-[#F95738] hover:underline font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                Belum ada transaksi
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
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json($monthlySales ?? []);
        const labels = salesData.map(item => item.month);
        const values = salesData.map(item => item.value);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan (jt)',
                    data: values,
                    borderColor: '#F95738',
                    backgroundColor: 'rgba(249, 87, 56, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#F95738',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
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
                                return 'Rp ' + context.parsed.y + 'jt';
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
                                return 'Rp ' + value + 'jt';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Welcome Modal Functions
        function closeWelcomeModal() {
            document.getElementById('welcomeModal').classList.add('hidden');
            localStorage.setItem('welcomeModalClosed', 'true');
        }

        // Auto close after 15 seconds
        setTimeout(() => {
            const modal = document.getElementById('welcomeModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeWelcomeModal();
            }
        }, 15000);
    </script>

    <!-- Custom Animation Styles -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</x-admin-layout>
