<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        // Hanya admin yang bisa akses
    }

    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        // Date range filter
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Summary Statistics
        $stats = [
            'total_revenue' => Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total'),
            'total_orders' => Transaction::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_users' => User::where('role', 'user')
                ->whereBetween('created_at', [$startDate, $endDate])->count(),
            'pending_orders' => Transaction::where('status', 'pending')->count(),
        ];

        // Sales Trend (Last 7 days)
        $salesTrend = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top Products
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'completed')
            ->select('transaction_items.product_name', DB::raw('SUM(transaction_items.quantity) as total_sold'), DB::raw('SUM(transaction_items.subtotal) as revenue'))
            ->groupBy('transaction_items.product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Low Stock Products
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Transaction Status Distribution
        $statusDistribution = Transaction::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'salesTrend',
            'topProducts',
            'lowStockProducts',
            'statusDistribution',
            'startDate',
            'endDate'
        ));
    }

    public function sales(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $groupBy = $request->input('group_by', 'day'); // day, month, year

        $query = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($groupBy === 'day') {
            $salesData = $query->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } elseif ($groupBy === 'month') {
            $salesData = $query->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $salesData = $query->select(DB::raw('YEAR(created_at) as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        $totalRevenue = $salesData->sum('total');
        $totalOrders = $salesData->sum('count');

        return view('admin.reports.sales', compact('salesData', 'totalRevenue', 'totalOrders', 'startDate', 'endDate', 'groupBy'));
    }

    public function stock(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        $filter = $request->input('filter', 'all'); // all, low, out

        $query = Product::query();

        if ($filter === 'low') {
            $query->whereBetween('stock', [1, 10]);
        } elseif ($filter === 'out') {
            $query->where('stock', 0);
        }

        $products = $query->orderBy('stock')->paginate(20);

        $stockStats = [
            'total_products' => Product::count(),
            'low_stock' => Product::whereBetween('stock', [1, 10])->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'in_stock' => Product::where('stock', '>', 10)->count(),
        ];

        return view('admin.reports.stock', compact('products', 'stockStats', 'filter'));
    }

    public function transactions(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'all');

        $query = Transaction::with(['user'])->whereBetween('created_at', [$startDate, $endDate]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->paginate(20);

        $transactionStats = [
            'total' => Transaction::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed' => Transaction::whereBetween('created_at', [$startDate, $endDate])->where('status', 'completed')->count(),
            'pending' => Transaction::whereBetween('created_at', [$startDate, $endDate])->where('status', 'pending')->count(),
            'cancelled' => Transaction::whereBetween('created_at', [$startDate, $endDate])->whereIn('status', ['cancelled', 'rejected'])->count(),
        ];

        return view('admin.reports.transactions', compact('transactions', 'transactionStats', 'startDate', 'endDate', 'status'));
    }

    // Export functions (simplified - in production use proper PDF library)
    public function exportSales(Request $request)
    {
        // Implementasi export PDF/Excel
        // Untuk sekarang, return data JSON untuk demo
        return response()->json(['message' => 'Export feature - implement with dompdf or maatwebsite/excel']);
    }
}