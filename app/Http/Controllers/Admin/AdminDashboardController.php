<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        // Date ranges
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // === REAL DATABASE STATS ===

        // 1. Revenue Stats
        $totalRevenue = Transaction::where('status', 'completed')->sum('total');
        $monthlyRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', $today->month)
            ->sum('total');
        $lastMonthRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', $lastMonth->month)
            ->sum('total');

        $revenueGrowth = $lastMonthRevenue > 0
            ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // 2. Order Stats
        $totalOrders = Transaction::count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $processingOrders = Transaction::whereIn('status', ['paid', 'processing'])->count();
        $completedOrders = Transaction::where('status', 'completed')->count();

        // 3. User Stats
        $totalUsers = User::where('role', UserRole::USER->value)->count();
        $newUsersThisMonth = User::where('role', UserRole::USER->value)
            ->whereMonth('created_at', $today->month)
            ->count();
        $totalStaff = User::where('role', UserRole::PETUGAS->value)->count();

        // 4. Product Stats
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        $activeProducts = Product::where('is_active', true)->count();

        // 5. Recent Transactions (Real Data)
        $recentTransactions = Transaction::with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        // 6. Monthly Sales Chart Data (Last 12 months)
        $monthlySales = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthData = Transaction::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');

            $monthlySales[] = [
                'month' => $date->format('M'),
                'value' => round($monthData / 1000000, 1), // In millions
                'year' => $date->format('Y')
            ];
        }

        // 7. Top Products
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            ->select('transaction_items.product_name',
                     DB::raw('SUM(transaction_items.quantity) as total_sold'),
                     DB::raw('SUM(transaction_items.subtotal) as revenue'))
            ->groupBy('transaction_items.product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // 8. Activity Log (Recent Activities)
        $recentActivities = [
            [
                'icon' => 'user',
                'color' => 'blue',
                'message' => "{$newUsersThisMonth} user baru bergabung bulan ini",
                'time' => $today->format('d M Y')
            ],
            [
                'icon' => 'shopping-cart',
                'color' => 'green',
                'message' => "{$completedOrders} transaksi selesai",
                'time' => $today->format('d M Y')
            ],
            [
                'icon' => 'alert-triangle',
                'color' => 'red',
                'message' => "{$lowStockProducts} produk stok menipis",
                'time' => $today->format('d M Y')
            ],
            [
                'icon' => 'clock',
                'color' => 'yellow',
                'message' => "{$pendingOrders} order menunggu verifikasi",
                'time' => $today->format('d M Y')
            ],
        ];

        // Check if first login today (for welcome modal)
        $lastLogin = session('last_login', null);
        $showWelcomeModal = !$lastLogin || Carbon::parse($lastLogin)->diffInDays(now()) > 0;
        session(['last_login' => now()]);

        return view('admin.dashboard', compact(
            'totalRevenue',
            'monthlyRevenue',
            'revenueGrowth',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalUsers',
            'newUsersThisMonth',
            'totalStaff',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'activeProducts',
            'recentTransactions',
            'monthlySales',
            'topProducts',
            'recentActivities',
            'showWelcomeModal'
        ));
    }
}
