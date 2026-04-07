<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

/**
 * Tampilkan detail pesanan user
 */
public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['items.product', 'user']);

        // Safety tambahan: cek apakah ada item dengan stok bermasalah
        $outOfStockItems = $transaction->items->filter(function ($item) {
            return $item->product && !$item->product->isAvailable();
        });

        if ($outOfStockItems->isNotEmpty()) {
            // Optional: beri notifikasi ke user
            session()->flash('warning', 'Beberapa produk dalam pesanan ini sudah habis stok.');
        }

        return view('user.order-show', compact('transaction'));
    }

public function store(Request $request)
{
    $cart = session('cart'); // atau $request->cart_items

    DB::beginTransaction();
    try {
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total'   => $request->total,
            'status'  => 'pending',
            // ... field lain
        ]);

        foreach ($cart as $item) {
            $product = Product::lockForUpdate()->findOrFail($item['id']);

            // === VALIDASI STOK ===
            if (!$product->isAvailable() || $product->stock < $item['qty']) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', "❌ Stok {$product->name} tidak mencukupi atau sudah habis!");
            }

            // Kurangi stok
            $product->decrement('stock', $item['qty']);

            // Buat item
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $product->id,
                'quantity'       => $item['qty'],
                'price'          => $product->price,
            ]);
        }

        // Bersihkan cart
        session()->forget('cart');

        DB::commit();

        return redirect()->route('user.orders.show', $transaction)
            ->with('success', 'Pesanan berhasil dibuat!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout.');
    }
}

    public function uploadProof(Request $request, Transaction $transaction)
    {
        // 🪵 Logging untuk debugging
        Log::info('Upload proof attempt', [
            'transaction_id' => $transaction->id,
            'user_id' => Auth::id(),
            'status' => $transaction->status,
            'has_file' => $request->hasFile('payment_proof')
        ]);

        // 🔐 1. Check ownership
        if ($transaction->user_id !== Auth::id()) {
            Log::warning('Unauthorized upload attempt', [
                'transaction_id' => $transaction->id,
                'expected_user_id' => $transaction->user_id,
                'actual_user_id' => Auth::id()
            ]);
            abort(403, 'Unauthorized action.');
        }

        // 🔐 2. Only allow if status pending
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Pembayaran hanya bisa diupload untuk status "Menunggu Pembayaran".');
        }

        try {
            // 📦 3. Validation
            $validated = $request->validate([
                'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'payment_proof.required' => 'Silakan pilih file bukti pembayaran.',
                'payment_proof.image' => 'File harus berupa gambar.',
                'payment_proof.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'payment_proof.max' => 'Ukuran file maksimal 2MB.',
            ]);

            // 🧹 4. Delete old file if exists
            if ($transaction->payment_proof) {
                Storage::disk('public')->delete($transaction->payment_proof);
            }

            // 📤 5. Store new file
            $file = $request->file('payment_proof');
            $path = $file->store('payment_proofs', 'public');

            // 🔄 6. Update transaction
            $transaction->update([
                'payment_proof' => $path,
                'status' => 'paid',
                'paid_at' => now(), // 👈 penting agar status paid konsisten
            ]);

            Log::info('Payment proof uploaded successfully', [
                'transaction_id' => $transaction->id,
                'file_path' => $path
            ]);

            return back()->with('success', '✅ Bukti pembayaran berhasil diupload! Pesanan akan segera diproses.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error validasi sudah otomatis redirect back dengan $errors
            Log::warning('Validation failed for upload proof', [
                'transaction_id' => $transaction->id,
                'errors' => $e->errors()
            ]);
            throw $e; // biarkan Laravel handle redirect + error display

        } catch (\Exception $e) {
            Log::error('Upload proof failed - Unexpected error', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', '❌ Gagal mengupload bukti: ' . $e->getMessage());
        }
    }
}