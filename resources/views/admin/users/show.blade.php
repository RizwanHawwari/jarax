<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-[#F95738] flex items-center mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar User
        </a>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-2xl font-bold mr-4">
                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name ?? '', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->full_name }}</h2>
                    <p class="text-sm text-gray-500">#U-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            @php
                $badge = $user->status_badge;
                $colors = [
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
        <!-- Left Column - User Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Pribadi</h3>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-sm text-[#F95738] hover:underline font-medium">
                        Edit Data
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Depan</p>
                        <p class="text-gray-900 font-medium">{{ $user->first_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Belakang</p>
                        <p class="text-gray-900 font-medium">{{ $user->last_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Email</p>
                        <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="text-gray-900 font-medium">{{ $user->phone_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Role</p>
                        <p class="text-gray-900 font-medium capitalize">{{ $user->role->value }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Terdaftar Sejak</p>
                        <p class="text-gray-900 font-medium">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Ban Information (if banned) -->
            @if($user->isBanned())
                <div class="bg-red-50 rounded-xl shadow-sm border border-red-100 p-6">
                    <h3 class="text-lg font-semibold text-red-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Suspended
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-red-600">Alasan:</span>
                            <span class="text-sm text-red-900 font-medium">{{ $user->ban_reason }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-red-600">Diban Pada:</span>
                            <span class="text-sm text-red-900 font-medium">{{ $user->banned_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($user->bannedBy)
                            <div class="flex justify-between">
                                <span class="text-sm text-red-600">Diban Oleh:</span>
                                <span class="text-sm text-red-900 font-medium">{{ $user->bannedBy->full_name }}</span>
                            </div>
                        @endif
                    </div>
                    <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                            Unban User
                        </button>
                    </form>
                </div>
            @endif

            <!-- Transaction History -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Transaksi</h3>
                @if($user->transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID Transaksi</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($user->transactions->take(10) as $transaction)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-sm text-[#F95738] hover:underline font-medium">
                                                #{{ $transaction->transaction_code }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            {{ $transaction->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
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
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($user->transactions->count() > 10)
                        <p class="text-sm text-gray-500 mt-4 text-center">
                            Menampilkan 10 dari {{ $user->transactions->count() }} transaksi
                        </p>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik User</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Total Transaksi</span>
                        <span class="text-lg font-bold text-gray-900">{{ $user->transactions->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Total Belanja</span>
                        <span class="text-lg font-bold text-[#F95738]">Rp {{ number_format($user->transactions->sum('total'), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Transaksi Terakhir</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->transactions->max('created_at') ? \Carbon\Carbon::parse($user->transactions->max('created_at'))->format('d M Y') : '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm text-gray-500">Status Email</span>
                        @if($user->email_verified_at)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Verified</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Unverified</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Admin</h3>
                <div class="space-y-3">
                    @if(!$user->isBanned())
                        <button type="button" onclick="openBanModal({{ $user->id }}, '{{ $user->full_name }}')"
                                class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Ban / Suspend User
                        </button>
                    @else
                        <form action="{{ route('admin.users.unban', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                </svg>
                                Unban User
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="block w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-center">
                        Edit Data User
                    </a>

                    @if(!$user->isAdmin() && !$user->isPetugas())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus user ini? Semua data transaksi akan ikut terhapus!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-3 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors font-medium">
                                Hapus User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ban Modal (same as index) -->
    <div id="banModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Ban User</h3>
            <p class="text-sm text-gray-500 mb-4" id="banModalText"></p>
            
            <form id="banForm" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Ban <span class="text-red-500">*</span></label>
                        <textarea name="ban_reason" required rows="3" placeholder="Jelaskan alasan user ini di-ban..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] text-sm"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeBanModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                        Ban User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBanModal(userId, userName) {
            document.getElementById('banModalText').textContent = `Apakah Anda yakin ingin ban user "${userName}"? User ini tidak akan bisa login lagi.`;
            document.getElementById('banForm').action = `/admin/users/${userId}/ban`;
            document.getElementById('banModal').classList.remove('hidden');
        }

        function closeBanModal() {
            document.getElementById('banModal').classList.add('hidden');
            document.getElementById('banForm').reset();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBanModal();
            }
        });
    </script>
</x-admin-layout>