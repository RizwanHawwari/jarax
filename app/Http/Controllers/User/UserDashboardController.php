<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 🔹 Gunakan query scope / reusable logic jika sering dipakai
        $transactionQuery = Transaction::where('user_id', $user->id);

        // Stats - lebih efisien dengan single query jika memungkinkan
        $totalOrders = $transactionQuery->count();
        $pendingOrders = (clone $transactionQuery)->whereIn('status', ['pending', 'paid', 'processing'])->count();
        $completedOrders = (clone $transactionQuery)->where('status', 'completed')->count();
        $totalSpent = (clone $transactionQuery)
            ->where('status', 'completed')
            ->sum('total');

        // Recent orders untuk dashboard
        $recentOrders = (clone $transactionQuery)
            ->with(['items.product']) // 🔹 Tambahkan .product agar bisa akses nama/gambar produk di view
            ->latest()
            ->limit(5)
            ->get();

        // Recommended products
        $recommendedProducts = Product::where('is_active', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view('user.dashboard', compact(
            'recentOrders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'recommendedProducts'
        ));
    }

    public function orders()
    {
        $user = Auth::user();
        
        $orders = Transaction::where('user_id', $user->id)
            ->with(['items.product']) // 🔹 Pastikan relasi product di-load untuk tampilan item
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }
}