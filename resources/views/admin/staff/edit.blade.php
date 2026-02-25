<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.staff.show', $staff) }}" class="text-sm text-gray-500 hover:text-[#F95738] flex items-center mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail Petugas
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Petugas</h2>
    </div>

    <form action="{{ route('admin.staff.update', $staff) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl">
        @csrf
        @method('PUT')

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ $message }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column - Personal Info -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">Informasi Pribadi</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Depan <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $staff->first_name) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Belakang</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $staff->last_name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $staff->phone_number) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('phone_number') border-red-500 @enderror">
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Job Info -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2">Informasi Jabatan</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan/Posisi <span class="text-red-500">*</span></label>
                    <select name="position" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('position') border-red-500 @enderror">
                        <option value="">Pilih Jabatan</option>
                        @foreach($positions as $key => $label)
                            <option value="{{ $key }}" {{ old('position', $staff->position) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('position')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Kepegawaian <span class="text-red-500">*</span></label>
                    <select name="staff_status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('staff_status') border-red-500 @enderror">
                        <option value="active" {{ old('staff_status', $staff->staff_status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="cuti" {{ old('staff_status', $staff->staff_status) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="inactive" {{ old('staff_status', $staff->staff_status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('staff_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung</label>
                    <input type="date" name="join_date" value="{{ old('join_date', $staff->join_date?->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('join_date') border-red-500 @enderror">
                    @error('join_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('notes') border-red-500 @enderror">{{ old('notes', $staff->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Keamanan Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738] @error('password') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F95738]">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('admin.staff.show', $staff) }}" 
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-[#F95738] text-white rounded-lg hover:bg-orange-600 transition-colors font-medium">
                Update Data
            </button>
        </div>
    </form>
</x-admin-layout>