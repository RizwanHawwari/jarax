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
            <span class="text-sm text-gray-500">Laporan Stok</span>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Laporan Stok Detail</h2>
    </div>

    <!-- Stats & Filter -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Total Produk</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stockStats['total_products'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 border-l-4 border-l-green-500">
            <p class="text-xs text-gray-500 mb-1">Stok Aman</p>
            <p class="text-2xl font-bold text-green-600">{{ $stockStats['in_stock'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 border-l-4 border-l-yellow-500">
            <p class="text-xs text-gray-500 mb-1">Stok Menipis</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stockStats['low_stock'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 border-l-4 border-l-red-500">
            <p class="text-xs text-gray-500 mb-1">Habis Stok</p>
            <p class="text-2xl font-bold text-red-600">{{ $stockStats['out_of_stock'] }}</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('admin.reports.stock') }}" method="GET" class="flex items-center gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Stok</label>
                <select name="filter" onchange="this.form.submit()" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Produk</option>
                    <option value="low" {{ $filter == 'low' ? 'selected' : '' }}>Stok Menipis (1-10)</option>
                    <option value="out" {{ $filter == 'out' ? 'selected' : '' }}>Habis Stok (0)</option>
                </select>
            </div>
            <a href="{{ route('admin.reports.stock') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium self-end">
                Reset
            </a>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" class="w-10 h-10 object-cover rounded-lg mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3"></div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">{{ $product->category }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($product->stock == 0)
                                    <span class="text-lg font-bold text-red-600">{{ $product->stock }}</span>
                                @elseif($product->stock <= 10)
                                    <span class="text-lg font-bold text-yellow-600">{{ $product->stock }}</span>
                                @else
                                    <span class="text-lg font-medium text-gray-900">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($product->stock == 0)
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Habis</span>
                                @elseif($product->stock <= 10)
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Menipis</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada produk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>