<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat Datang, {{ Auth::user()->first_name }}!</h3>
                    <p class="text-gray-600">Anda login sebagai <span class="font-medium text-[#F95738]">User</span></p>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700">Pesanan Saya</h4>
                            <p class="text-2xl font-bold text-[#F95738] mt-2">0</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700">Total Belanja</h4>
                            <p class="text-2xl font-bold text-blue-600 mt-2">Rp 0</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700">Voucher</h4>
                            <p class="text-2xl font-bold text-green-600 mt-2">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>