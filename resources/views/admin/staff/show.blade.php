<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.staff.index') }}" class="text-sm text-gray-500 hover:text-[#F95738] flex items-center mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Petugas
        </a>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-2xl font-bold mr-4">
                    {{ substr($staff->first_name, 0, 1) }}{{ substr($staff->last_name ?? '', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $staff->full_name }}</h2>
                    <p class="text-sm text-gray-500">#{{ $staff->staff_code ?? 'ST-' . str_pad($staff->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            @php
                $badge = $staff->staff_status_badge;
                $colors = [
                    'green' => 'bg-green-100 text-green-700',
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                    'red' => 'bg-red-100 text-red-700',
                    'gray' => 'bg-gray-100 text-gray-700',
                ];
            @endphp
            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $colors[$badge['color']] ?? 'bg-gray-100 text-gray-700' }}">
                {{ $badge['label'] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Staff Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Pribadi</h3>
                    <a href="{{ route('admin.staff.edit', $staff) }}" class="text-sm text-[#F95738] hover:underline font-medium">
                        Edit Data
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Depan</p>
                        <p class="text-gray-900 font-medium">{{ $staff->first_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Belakang</p>
                        <p class="text-gray-900 font-medium">{{ $staff->last_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Email</p>
                        <p class="text-gray-900 font-medium">{{ $staff->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="text-gray-900 font-medium">{{ $staff->phone_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Role</p>
                        <p class="text-gray-900 font-medium capitalize">{{ $staff->role->value }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bergabung Sejak</p>
                        <p class="text-gray-900 font-medium">{{ $staff->join_date ? \Carbon\Carbon::parse($staff->join_date)->format('d M Y') : $staff->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Job Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Jabatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Jabatan/Posisi</p>
                        <p class="text-gray-900 font-medium">{{ $staff->position_label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Status Kepegawaian</p>
                        <p class="text-gray-900 font-medium">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $colors[$badge['color']] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $badge['label'] }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Staff Code</p>
                        <p class="text-gray-900 font-medium">{{ $staff->staff_code ?? 'ST-' . str_pad($staff->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Terdaftar di Sistem</p>
                        <p class="text-gray-900 font-medium">{{ $staff->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @if($staff->notes)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Catatan</p>
                        <p class="text-gray-900">{{ $staff->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Activity Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Aktivitas</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-[#F95738]">0</p>
                        <p class="text-xs text-gray-500 mt-1">Transaksi</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-blue-600">0</p>
                        <p class="text-xs text-gray-500 mt-1">Verifikasi</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-green-600">0</p>
                        <p class="text-xs text-gray-500 mt-1">Selesai</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-purple-600">0</p>
                        <p class="text-xs text-gray-500 mt-1">Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Actions -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Admin</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.staff.edit', $staff) }}" 
                       class="block w-full px-4 py-3 bg-[#F95738] hover:bg-orange-600 text-white rounded-lg transition-colors font-medium text-center">
                        Edit Data Petugas
                    </a>

                    @if($staff->staff_status === 'active')
                        <form action="{{ route('admin.staff.toggle-status', $staff) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors font-medium">
                                Set Cuti
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.staff.toggle-status', $staff) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium">
                                Set Aktif
                            </button>
                        </form>
                    @endif

                    @if($staff->id !== auth()->id())
                        <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-3 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors font-medium">
                                Hapus Petugas
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Login Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Login</h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Email</span>
                        <span class="text-sm font-medium text-gray-900">{{ $staff->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Status Email</span>
                        @if($staff->email_verified_at)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Verified</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Unverified</span>
                        @endif
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-gray-500">Last Login</span>
                        <span class="text-sm font-medium text-gray-900">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>