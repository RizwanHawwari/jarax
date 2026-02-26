<?php

namespace App\Http\Controllers\User; // ✅ Namespace harus ini

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // User's transactions
        $recentOrders = Transaction::where('user_id', $user->id)
            ->with(['items'])
            ->latest()
            ->limit(5)
            ->get();

        // Stats
        $totalOrders = Transaction::where('user_id', $user->id)->count();
        $pendingOrders = Transaction::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'paid', 'processing'])
            ->count();
        $completedOrders = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $totalSpent = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('total');

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
        $user = auth()->user();
        $orders = Transaction::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }
}
