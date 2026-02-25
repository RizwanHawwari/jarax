<x-guest-layout>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            
            <!-- Logo & Header -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-[#F95738] tracking-tight">JaRax</h2>
                <h3 class="mt-4 text-2xl font-bold text-gray-900">Masuk ke Akun</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Masukkan email dan password Anda.
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-4">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm"
                                placeholder="user@jarax.com"
                                value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-[#F95738] focus:border-[#F95738] sm:text-sm"
                                placeholder="password123">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#F95738] hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F95738] transition-colors duration-200">
                        MASUK SEKARANG
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center text-sm">
                    <span class="text-gray-600">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="font-medium text-[#F95738] hover:text-orange-600">
                        Daftar Disini
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>