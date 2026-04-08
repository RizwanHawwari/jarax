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

        $recommendedProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // Jika guest (belum login) → hanya tampilkan produk + promo
        if (!$user) {
            return view('user.dashboard', compact(
                'recommendedProducts'
            ));
        }

        // Jika sudah login → tampilkan full dashboard + statistik
        $transactionQuery = Transaction::where('user_id', $user->id);

        $totalOrders     = $transactionQuery->count();
        $pendingOrders   = (clone $transactionQuery)->whereIn('status', ['pending', 'paid', 'processing'])->count();
        $completedOrders = (clone $transactionQuery)->where('status', 'completed')->count();
        $totalSpent      = (clone $transactionQuery)
                            ->where('status', 'completed')
                            ->sum('total');

        $recentOrders = (clone $transactionQuery)
            ->with(['items.product'])
            ->latest()
            ->limit(5)
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
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }
}