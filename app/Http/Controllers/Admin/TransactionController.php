<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by transaction code or user name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('transaction_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $transactions = $query->latest()->paginate(15);

        $statusCounts = [
            'all' => Transaction::count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'paid' => Transaction::where('status', 'paid')->count(),
            'processing' => Transaction::where('status', 'processing')->count(),
            'shipped' => Transaction::where('status', 'shipped')->count(),
            'completed' => Transaction::where('status', 'completed')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'statusCounts'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'items.product']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function verify(Request $request, Transaction $transaction)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            if ($request->action === 'approve') {
                $transaction->update([
                    'status' => 'processing',
                    'admin_notes' => $request->admin_notes,
                    'paid_at' => now(),
                ]);

                // Reduce stock
                foreach ($transaction->items as $item) {
                    if ($item->product) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            } else {
                $transaction->update([
                    'status' => 'rejected',
                    'admin_notes' => $request->admin_notes,
                ]);

                // Restore stock
                foreach ($transaction->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi berhasil ' . ($request->action === 'approve' ? 'diterima' : 'ditolak') . '!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function ship(Request $request, Transaction $transaction)
    {
        $request->validate([
            'courier' => 'required|string|max:100',
            'tracking_number' => 'required|string|max:100',
        ]);

        $transaction->update([
            'status' => 'shipped',
            'courier' => $request->courier,
            'tracking_number' => $request->tracking_number,
            'shipped_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditandai sebagai dikirim!');
    }

    public function complete(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil diselesaikan!');
    }

    public function updateProof(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($transaction->payment_proof) {
            Storage::disk('public')->delete($transaction->payment_proof);
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status' => 'paid',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupdate!');
    }
}