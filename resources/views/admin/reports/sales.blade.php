<x-admin-layout>
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:text-[#F95738] flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <span class="text-gray-300">/</span>
            <span class="text-sm text-gray-500">Laporan Penjualan</span>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Laporan Penjualan Detail</h2>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Group By</label>
                <select name="group_by" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                    <option value="day" {{ $groupBy == 'day' ? 'selected' : '' }}>Harian</option>
                    <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Bulanan</option>
                    <option value="year" {{ $groupBy == 'year' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-[#F95738] text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.reports.sales') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white">
            <p class="text-green-100 text-sm mb-1">Total Revenue</p>
            <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm mb-1">Total Order</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Detail Penjualan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pendapatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rata-rata/Order</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($salesData as $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">
                                    @if($groupBy == 'day')
                                        {{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}
                                    @elseif($groupBy == 'month')
                                        {{ \Carbon\Carbon::parse($data->date . '-01')->format('F Y') }}
                                    @else
                                        {{ $data->date }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">{{ $data->count }} order</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-green-600">Rp {{ number_format($data->total, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">Rp {{ number_format($data->count > 0 ? $data->total / $data->count : 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada data penjualan untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td class="px-6 py-4 font-semibold text-gray-800">TOTAL</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $totalOrders }} order</td>
                        <td class="px-6 py-4 font-semibold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">Rp {{ number_format($totalOrders > 0 ? $totalRevenue / $totalOrders : 0, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-admin-layout>