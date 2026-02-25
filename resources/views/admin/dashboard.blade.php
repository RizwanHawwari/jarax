<x-admin-layout>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Pendapatan -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-800">Rp {{ $stats['revenue'] }}</p>
                    <p class="text-xs text-green-500 mt-2">+12.5% dari bulan lalu</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Order -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Order</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $stats['orders'] }}</p>
                    <p class="text-xs text-blue-500 mt-2">+8.2% dari bulan lalu</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- User Baru -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">User Baru</p>
                    <p class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $stats['new_users'] }}</p>
                    <p class="text-xs text-yellow-500 mt-2">+15.3% dari bulan lalu</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Statistik Penjualan Bulanan</h3>
                <p class="text-sm text-gray-500">Data penjualan tahun 2026</p>
            </div>
            <select class="w-full sm:w-auto border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                <option>Tahun 2026</option>
                <option>Tahun 2025</option>
                <option>Tahun 2024</option>
            </select>
        </div>

        <!-- Chart Canvas -->
        <div class="relative w-full h-[300px] md:h-[350px] lg:h-[400px]">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
        </div>
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">#ORD-001</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Budi Santoso</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">15 Jan 2026</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">Rp 450.000</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Selesai</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">#ORD-002</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Siti Aminah</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">15 Jan 2026</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">Rp 780.000</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Proses</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">#ORD-003</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Ahmad Rizki</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">14 Jan 2026</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">Rp 1.250.000</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Dikirim</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json($monthlySales);
        const labels = salesData.map(item => item.month);
        const values = salesData.map(item => parseInt(item.value.replace('jt', '')));
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan (jt)',
                    data: values,
                    backgroundColor: 'rgba(249, 87, 56, 0.8)',
                    borderColor: 'rgba(249, 87, 56, 1)',
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
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
                layout: {
    padding: {
        top: 10,
        right: 10,
        bottom: 10,
        left: 10
    }
},
interaction: {
    mode: 'index',
    intersect: false,
},
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                        ticks: {
                            callback: function(value) { return 'Rp ' + value + 'jt'; }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-admin-layout>