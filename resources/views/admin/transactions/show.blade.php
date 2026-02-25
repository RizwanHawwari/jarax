<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="text-sm text-gray-500 hover:text-[#F95738] flex items-center mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Transaksi
        </a>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Detail Transaksi</h2>
                <p class="text-sm text-gray-500 mt-1">#{{ $transaction->transaction_code }}</p>
            </div>
            @php
                $badge = $transaction->status_badge;
                $colors = [
                    'gray' => 'bg-gray-100 text-gray-700',
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                    'blue' => 'bg-blue-100 text-blue-700',
                    'purple' => 'bg-purple-100 text-purple-700',
                    'green' => 'bg-green-100 text-green-700',
                    'red' => 'bg-red-100 text-red-700',
                ];
            @endphp
            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $colors[$badge['color']] ?? 'bg-gray-100 text-gray-700' }}">
                {{ $badge['label'] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Transaction Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Produk yang Dipesan</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($transaction->items as $item)
                        <div class="p-6 flex items-center gap-4">
                            @if($item->product && $item->product->image)
                                <img src="{{ Storage::url($item->product->image) }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-6 bg-gray-50">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-base pt-2 border-t border-gray-200">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="font-bold text-[#F95738]">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengiriman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Alamat</p>
                        <p class="text-gray-900">{{ $transaction->shipping_address }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Kota</p>
                        <p class="text-gray-900">{{ $transaction->shipping_city }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Kode Pos</p>
                        <p class="text-gray-900">{{ $transaction->shipping_postal_code ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Telepon</p>
                        <p class="text-gray-900">{{ $transaction->shipping_phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Actions -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pelanggan</h3>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold">
                        {{ substr($transaction->user->first_name, 0, 1) }}{{ substr($transaction->user->last_name ?? '', 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">{{ $transaction->user->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ $transaction->user->email }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Email</span>
                        <span class="text-gray-900">{{ $transaction->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Telepon</span>
                        <span class="text-gray-900">{{ $transaction->user->phone_number ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Terdaftar</span>
                        <span class="text-gray-900">{{ $transaction->user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bukti Pembayaran</h3>
                @if($transaction->payment_proof)
                    <img src="{{ Storage::url($transaction->payment_proof) }}" 
                         alt="Bukti Pembayaran" 
                         class="w-full rounded-lg border border-gray-200 mb-4">
                    <a href="{{ Storage::url($transaction->payment_proof) }}" target="_blank" 
                       class="block w-full text-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                        Buka Gambar
                    </a>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada bukti pembayaran</p>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Admin</h3>
                <div class="space-y-3">
                    @if($transaction->status === 'paid')
                        <form action="{{ route('admin.transactions.verify', $transaction) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" 
                                    onclick="return confirm('Terima pembayaran ini?')"
                                    class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Terima Pembayaran
                            </button>
                        </form>
                        <form action="{{ route('admin.transactions.verify', $transaction) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" 
                                    onclick="return confirm('Tolak pembayaran ini?')"
                                    class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Pembayaran
                            </button>
                        </form>
                    @elseif($transaction->status === 'processing')
                        <button type="button" onclick="document.getElementById('shipModal').classList.remove('hidden')"
                                class="w-full px-4 py-3 bg-[#F95738] hover:bg-orange-600 text-white rounded-lg transition-colors font-medium flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                            Proses Pengiriman
                        </button>
                    @elseif($transaction->status === 'shipped')
                        <form action="{{ route('admin.transactions.complete', $transaction) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Tandai transaksi sebagai selesai?')"
                                    class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tandai Selesai
                            </button>
                        </form>
                    @endif

                    @if($transaction->admin_notes)
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Catatan Admin:</p>
                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $transaction->admin_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-2 h-2 rounded-full bg-green-500 mt-2 mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Transaksi Dibuat</p>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($transaction->paid_at)
                        <div class="flex items-start">
                            <div class="w-2 h-2 rounded-full bg-yellow-500 mt-2 mr-3"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Pembayaran Dikonfirmasi</p>
                                <p class="text-xs text-gray-500">{{ $transaction->paid_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($transaction->shipped_at)
                        <div class="flex items-start">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 mr-3"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dikirim</p>
                                <p class="text-xs text-gray-500">{{ $transaction->shipped_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($transaction->completed_at)
                        <div class="flex items-start">
                            <div class="w-2 h-2 rounded-full bg-green-500 mt-2 mr-3"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Selesai</p>
                                <p class="text-xs text-gray-500">{{ $transaction->completed_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ship Modal -->
    <div id="shipModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Proses Pengiriman</h3>
            <form action="{{ route('admin.transactions.ship', $transaction) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kurir</label>
                        <input type="text" name="courier" required placeholder="Contoh: JNE, J&T, SiCepat"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Resi</label>
                        <input type="text" name="tracking_number" required placeholder="Masukkan nomor resi"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="document.getElementById('shipModal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#F95738] text-white rounded-lg hover:bg-orange-600 transition-colors">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>