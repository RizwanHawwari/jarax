<x-user-layout>
    <div class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Chat Penjual</h1>
                <p class="text-gray-500">Hubungi admin untuk pertanyaan seputar produk dan pesanan</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6" style="min-height: calc(100vh - 200px);">
                <!-- Conversations Sidebar (1/4 width) -->
                <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-[#F95738] to-orange-500">
                        <h2 class="text-white font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Pesan Masuk
                        </h2>
                    </div>

                    <!-- Conversation List -->
                    <div class="flex-1 overflow-y-auto">
                        <!-- Customer Service (Default) -->
                        <a href="{{ route('user.chat.index') }}"
                           class="block p-4 border-b border-gray-100 hover:bg-orange-50 transition-colors {{ !$adminId ? 'bg-orange-50 border-l-4 border-l-[#F95738]' : '' }}">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-semibold mr-3">
                                        CS
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-sm">Customer Service</h3>
                                        <p class="text-xs text-gray-500">Otomatis</p>
                                    </div>
                                </div>
                                @php
                                    $csUnread = \App\Models\Chat::where('user_id', auth()->id())
                                        ->whereNull('admin_id')
                                        ->where('sender', 'admin')
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                @if($csUnread > 0 && !$adminId)
                                    <span class="bg-[#F95738] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $csUnread }}</span>
                                @endif
                            </div>
                            @php
                                $csLastMessage = \App\Models\Chat::where('user_id', auth()->id())
                                    ->whereNull('admin_id')
                                    ->latest()
                                    ->first();
                            @endphp
                            <p class="text-xs text-gray-500 truncate">
                                {{ $csLastMessage ? ($csLastMessage->sender === 'user' ? 'Anda: ' : '') . Str::limit($csLastMessage->message, 30) : 'Halo! Ada yang bisa kami bantu?' }}
                            </p>
                            @if($csLastMessage)
                                <p class="text-xs text-gray-400 mt-1">{{ $csLastMessage->created_at->diffForHumans() }}</p>
                            @endif
                        </a>

                        <!-- Admin Conversations -->
                        @foreach($conversations as $conv)
                            <a href="{{ route('user.chat.index', ['admin' => $conv['admin']->id]) }}"
                               class="block p-4 border-b border-gray-100 hover:bg-orange-50 transition-colors {{ $adminId == $conv['admin']->id ? 'bg-orange-50 border-l-4 border-l-[#F95738]' : '' }}">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F95738] to-orange-500 flex items-center justify-center text-white font-semibold mr-3">
                                            {{ substr($conv['admin']->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-800 text-sm">{{ $conv['admin']->full_name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $conv['admin']->role->label() }}</p>
                                        </div>
                                    </div>
                                    @if($conv['unread'] > 0 && $adminId == $conv['admin']->id)
                                        <span class="bg-[#F95738] text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $conv['unread'] }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $conv['last_message'] ? ($conv['last_message']->sender === 'user' ? 'Anda: ' : '') . Str::limit($conv['last_message']->message, 30) : 'Belum ada pesan' }}
                                </p>
                                @if($conv['last_message'])
                                    <p class="text-xs text-gray-400 mt-1">{{ $conv['last_message']->created_at->diffForHumans() }}</p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Chat Area (3/4 width) -->
                <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-green-400 to-emerald-500">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold mr-3">
                                    {{ $currentAdmin ? substr($currentAdmin->first_name, 0, 1) : 'CS' }}
                                </div>
                                <div>
                                    <h2 class="text-white font-semibold">
                                        {{ $currentAdmin ? $currentAdmin->full_name : 'Customer Service' }}
                                    </h2>
                                    <p class="text-white/80 text-xs flex items-center">
                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                        Online
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </button>
                                <button class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 bg-gradient-to-br from-gray-50 to-green-50" style="min-height: 400px;">
                        @forelse($chats as $chat)
                            @if($chat->sender === 'user')
                                <!-- User Message (Orange) -->
                                <div class="flex justify-end mb-4">
                                    <div class="max-w-lg">
                                        <div class="bg-gradient-to-r from-[#F95738] to-orange-500 text-white rounded-2xl rounded-tr-sm px-4 py-3 shadow-md">
                                            <p class="text-sm">{{ $chat->message }}</p>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1 text-right">{{ $chat->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Admin Message (White) -->
                                <div class="flex justify-start mb-4">
                                    <div class="max-w-lg">
                                        <div class="bg-white text-gray-800 rounded-2xl rounded-tl-sm px-4 py-3 shadow-md border border-gray-100">
                                            <p class="text-sm">{{ $chat->message }}</p>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">{{ $chat->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <!-- Welcome Message -->
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Selamat Datang di Chat JaRax!</h3>
                                <p class="text-gray-500 text-sm">Kami akan membalas pesan Anda secepatnya.<br>Jam operasional: 08:00 - 21:00 WIB</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Input Area -->
                    <div class="p-4 border-t border-gray-100 bg-white">
                        <form action="{{ route('user.chat.send') }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <input type="hidden" name="admin_id" value="{{ $adminId }}">

                            <!-- Message Input -->
                            <div class="flex-1 relative">
                                <input type="text"
                                       name="message"
                                       id="messageInput"
                                       placeholder="Tulis pesan..."
                                       required
                                       autocomplete="off"
                                       class="w-full px-4 py-3 bg-gray-100 border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-[#F95738] focus:bg-white transition-all">
                            </div>

                            <!-- Send Button -->
                            <button type="submit" class="w-12 h-12 bg-gradient-to-r from-[#F95738] to-orange-500 hover:from-orange-600 hover:to-orange-700 text-white rounded-full flex items-center justify-center transition-all hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto Scroll to Bottom -->
    <script>
        const messagesContainer = document.getElementById('messagesContainer');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Focus on input
        const messageInput = document.getElementById('messageInput');
        if (messageInput) {
            messageInput.focus();
        }
    </script>
</x-user-layout>
