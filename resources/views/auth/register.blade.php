<x-guest-layout>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            
            <!-- Header -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-[#F95738]">Buat Akun Baru</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Lengkapi form di bawah ini untuk membuat akun baru.
                </p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Grid untuk Nama Depan & Belakang -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Nama Depan</label>
                        <input id="first_name" name="first_name" type="text" required 
                            class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm"
                            value="{{ old('first_name') }}">
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                        <input id="last_name" name="last_name" type="text" 
                            class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm"
                            value="{{ old('last_name') }}">
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" required 
                        class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm"
                        value="{{ old('email') }}">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input id="phone_number" name="phone_number" type="text" required 
                        class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm"
                        placeholder="08123456789"
                        value="{{ old('phone_number') }}">
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required 
                        class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                        class="mt-1 block w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#F95738] hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F95738] transition-colors">
                        DAFTAR
                    </button>
                </div>
                
                <div class="text-center text-sm">
                    <span class="text-gray-600">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="font-medium text-[#F95738] hover:text-orange-600">
                        Masuk Disini
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>