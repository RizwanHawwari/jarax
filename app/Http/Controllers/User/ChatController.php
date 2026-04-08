<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $adminId = $request->input('admin');

        // Get all admins for sidebar
        $admins = User::where('role', UserRole::ADMIN->value)
            ->orWhere('role', UserRole::PETUGAS->value)
            ->get();

        // Get conversations for sidebar (with last message)
        $conversations = [];
        foreach ($admins as $admin) {
            $lastMessage = Chat::where('user_id', $user->id)
                ->where('admin_id', $admin->id)
                ->latest()
                ->first();

            $unread = Chat::where('user_id', $user->id)
                ->where('admin_id', $admin->id)
                ->where('sender', 'admin')
                ->where('is_read', false)
                ->count();

            $conversations[] = [
                'admin' => $admin,
                'last_message' => $lastMessage,
                'unread' => $unread,
            ];
        }

        // Get messages for selected admin
        if ($adminId) {
            $chats = Chat::where('user_id', $user->id)
                ->where('admin_id', $adminId)
                ->orderBy('created_at', 'asc')
                ->get();

            $currentAdmin = $admins->find($adminId);
        } else {
            // Default: Show general chat (no specific admin)
            $chats = Chat::where('user_id', $user->id)
                ->whereNull('admin_id')
                ->orderBy('created_at', 'asc')
                ->get();

            $currentAdmin = null;
        }

        // Mark messages as read
        Chat::where('user_id', $user->id)
            ->where('admin_id', $adminId)
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Total unread count
        $unreadCount = Chat::where('user_id', $user->id)
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->count();

        return view('user.chat', compact('conversations', 'chats', 'admins', 'adminId', 'currentAdmin', 'unreadCount'));
    }

    public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1000',
        'admin_id' => 'nullable|exists:users,id',
    ]);

    // Simpan pesan user
    $chat = Chat::create([
        'user_id' => auth()->id(),
        'admin_id' => $request->admin_id,
        'message' => $request->message,
        'sender' => 'user',
        'is_read' => false,
    ]);

    // =========================
    // AUTO REPLY BOT (CS AI)
    // =========================
    if (!$request->admin_id) {
        $botReply = $this->generateBotReply($request->message);

        Chat::create([
            'user_id' => auth()->id(),
            'admin_id' => null,
            'message' => $botReply,
            'sender' => 'admin', // dianggap CS
            'is_read' => false,
        ]);
    }

    return redirect()->route('user.chat.index', ['admin' => $request->admin_id])
        ->with('success', 'Pesan terkirim!');
}

private function generateBotReply($message)
{
    $msg = strtolower($message);

    // Keyword sederhana
    if (str_contains($msg, 'halo') || str_contains($msg, 'hai')) {
        return 'Halo! 😊 Ada yang bisa kami bantu?';
    }

    if (str_contains($msg, 'harga')) {
        return 'Untuk informasi harga, silakan cek halaman produk ya 👍';
    }

    if (str_contains($msg, 'pengiriman')) {
        return 'Pengiriman biasanya memakan waktu 2-5 hari kerja 🚚';
    }

    if (str_contains($msg, 'jam kerja')) {
        return 'Jam operasional kami 08:00 - 21:00 WIB ⏰';
    }

    if (str_contains($msg, 'terima kasih')) {
        return 'Sama-sama 😊 Senang bisa membantu!';
    }

    // Default jawabannya
    return 'Terima kasih atas pesan Anda 🙏 Tim kami akan segera membantu Anda.';
}

    public function getMessages($adminId)
    {
        $chats = Chat::where('user_id', auth()->id())
            ->where('admin_id', $adminId)
            ->orderBy('created_at', 'asc')
            ->get();

        Chat::where('user_id', auth()->id())
            ->where('admin_id', $adminId)
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'data' => $chats,
        ]);
    }
}
