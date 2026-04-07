<x-user-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><a href="{{ route('user.orders.index') }}" class="text-gray-500 hover:text-[#F95738]">Pesanan Saya</a></li>
                    <li><span class="mx-2 text-gray-400">/</span></li>
                    <li class="text-gray-800 font-semibold">Detail #{{ $transaction->id }}</li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gray-50/50">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Detail Pesanan</h2>
                        <p class="text-sm text-gray-500">Dipesan pada {{ $transaction->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'paid' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Sudah Dibayar',
                                'shipped' => 'Dalam Pengiriman',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $statusClasses[$transaction->status] ?? 'bg-gray-100' }}">
                            {{ $statusLabels[$transaction->status] ?? $transaction->status }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">
                    <div class="lg:col-span-2 p-6 space-y-8">
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Produk yang Dibeli</h3>
                            <div class="space-y-4">
                                @foreach($transaction->items as $item)
                                <div class="flex gap-4 p-4 rounded-xl border border-gray-50 hover:border-orange-100 transition-colors">
                                    <img src="{{ $item->product->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($item->product->name) }}" 
                                         class="w-20 h-20 object-cover rounded-lg bg-gray-100">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right font-bold text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Pengiriman</h3>
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <p class="font-bold text-gray-900 mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $transaction->address ?? 'Alamat tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50/30 space-y-6">
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Ringkasan Pembayaran</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Total Belanja</span>
                                    <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Biaya Pengiriman</span>
                                    <span class="text-emerald-600 font-medium">Gratis</span>
                                </div>
                                <hr class="border-gray-200">
                                <div class="flex justify-between text-lg font-black text-gray-900">
                                    <span>Total Bayar</span>
                                    <span class="text-[#F95738]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        @if($transaction->status === 'pending')
                        <div class="mt-8 p-5 bg-white rounded-2xl border-2 border-dashed border-orange-200">
                            <h4 class="font-bold text-gray-900 mb-2">Upload Bukti Transfer</h4>
                            <p class="text-xs text-gray-500 mb-4">Kirim foto struk transfer untuk mempercepat verifikasi.</p>
                            
                            <form action="{{ route('user.transactions.upload-proof', $transaction) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="payment_proof" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-[#F95738] hover:file:bg-orange-100 mb-3" required>
                                <button type="submit" class="w-full bg-[#F95738] hover:bg-orange-600 text-white py-2.5 rounded-xl font-bold transition-all shadow-md shadow-orange-200">
                                    Kirim Bukti
                                </button>
                            </form>
                        </div>
                        @elseif($transaction->payment_proof)
                        <div class="mt-8">
                            <h4 class="font-bold text-gray-900 mb-2 text-sm uppercase">Bukti Pembayaran</h4>
                            <a href="{{ Storage::url($transaction->payment_proof) }}" target="_blank">
                                <img src="{{ Storage::url($transaction->payment_proof) }}" class="w-full h-48 object-cover rounded-xl border border-gray-200 hover:opacity-90 transition-opacity">
                            </a>
                            <p class="text-center text-[10px] text-gray-400 mt-2 italic">Klik gambar untuk memperbesar</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>