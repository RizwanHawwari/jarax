<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cartItems = Cart::where('user_id', $user->id)
            ->with(['product'])
            ->get();

        $selectedItems = $cartItems->where('is_selected', true);

        $subtotal = $selectedItems->sum(fn($item) => $item->price * $item->quantity);
        $shippingCost = $subtotal > 0 ? 20000 : 0;
        $total = $subtotal + $shippingCost;
        $selectedCount = $selectedItems->sum('quantity');

        // Cek stok yang bermasalah
        $outOfStockItems = $selectedItems->filter(fn($item) => !$item->product?->isAvailable() || $item->product->stock < $item->quantity);

        return view('user.cart', compact(
            'cartItems', 'selectedItems', 'subtotal', 'shippingCost', 'total', 'selectedCount', 'outOfStockItems'
        ));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'variant'    => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        // === VALIDASI STOK SAAT ADD ===
        if (!$product->isAvailable() || $product->stock < $request->quantity) {
            return redirect()->back()->with('error', "Stok {$product->name} tidak mencukupi atau sudah habis!");
        }

        $existingCart = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('variant', $request->variant)
            ->first();

        if ($existingCart) {
            $newQty = $existingCart->quantity + $request->quantity;
            if ($product->stock < $newQty) {
                return redirect()->back()->with('error', "Stok {$product->name} tidak mencukupi!");
            }
            $existingCart->quantity = $newQty;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'variant'    => $request->variant,
                'price'      => $product->price,
                'is_selected'=> true,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product = $cart->product;

        if (!$product->isAvailable() || $product->stock < $request->quantity) {
            return redirect()->back()->with('error', "Stok {$product->name} tidak mencukupi!");
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->back()->with('success', 'Keranjang diupdate!');
    }

    public function toggleSelect(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->is_selected = !$cart->is_selected;
        $cart->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'variant'    => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validasi stok
        if (!$product->isAvailable() || $product->stock < $request->quantity) {
            return redirect()->back()
                ->with('error', "Stok {$product->name} tidak mencukupi atau sudah habis!");
        }

        $user = Auth::user();

        // Simpan data buy now ke session
        $buyNowItem = [
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'variant'    => $request->variant ?? 'Default',
            'price'      => $product->price,
            'name'       => $product->name,
        ];

        session(['buy_now_item' => $buyNowItem]);

        // PERBAIKAN: Gunakan nama route yang benar sesuai routes/web.php
        return redirect()->route('user.checkout.index');
    }

                public function checkout()
    {
        $buyNowItem = session('buy_now_item');

        if ($buyNowItem) {
            // === MODE BUY NOW ===
            $product = Product::findOrFail($buyNowItem['product_id']);

            $cartItems = collect([
                (object) [
                    'product_id' => $product->id,
                    'product'    => $product,
                    'quantity'   => $buyNowItem['quantity'],
                    'price'      => $buyNowItem['price'],
                    'is_selected'=> true,
                ]
            ]);

            // JANGAN forget di sini! Biarkan session tetap ada sampai processCheckout berhasil
        } 
        else {
            // === MODE KERANJANG NORMAL ===
            $cartItems = Cart::where('user_id', Auth::id())
                ->where('is_selected', true)
                ->with('product')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Tidak ada item untuk di checkout!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shippingCost = 20000;
        $total = $subtotal + $shippingCost;

        return view('user.checkout', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'payment_method'   => 'required|in:transfer_bank,ewallet,cod,qris',
            'shipping_address' => 'required|string|max:500',
            'shipping_city'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_cost'    => 'nullable|numeric|min:0',
            'notes'            => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $buyNowItem = session('buy_now_item');
        $isBuyNow = !is_null($buyNowItem);

        DB::beginTransaction();
        try {
            if ($isBuyNow) {
                // ==================== BUY NOW MODE ====================
                $product = Product::lockForUpdate()->findOrFail($buyNowItem['product_id']);

                if (!$product->isAvailable() || $product->stock < $buyNowItem['quantity']) {
                    DB::rollBack();
                    session()->forget('buy_now_item');
                    return redirect()->back()
                        ->with('error', "❌ Stok {$product->name} tidak mencukupi atau sudah habis!");
                }

                $cartItems = collect([
                    (object) [
                        'product_id' => $product->id,
                        'quantity'   => $buyNowItem['quantity'],
                        'price'      => $product->price,
                    ]
                ]);
            } 
            else {
                // ==================== NORMAL CART MODE ====================
                $cartItems = Cart::where('user_id', $user->id)
                    ->where('is_selected', true)
                    ->with('product')
                    ->get();

                if ($cartItems->isEmpty()) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Keranjang kosong!');
                }

                foreach ($cartItems as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item->product_id);

                    if (!$product->isAvailable() || $product->stock < $item->quantity) {
                        DB::rollBack();
                        return redirect()->back()
                            ->with('error', "❌ Stok {$product->name} tidak mencukupi atau sudah habis!");
                    }

                    $product->decrement('stock', $item->quantity);
                }
            }

            // Hitung total
            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $shippingCost = $request->shipping_cost ?? 20000;
            $total = $subtotal + $shippingCost;

            $orderReference = 'ORD-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);

            $transaction = Transaction::create([
                'user_id'          => $user->id,
                'order_reference'  => $orderReference,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'total'            => $total,
                'status'           => 'pending',
                'payment_method'   => $validated['payment_method'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city'    => $validated['shipping_city'],
                'shipping_phone'   => $validated['shipping_phone'],
                'notes'            => $validated['notes'] ?? null,
            ]);

            // Buat Transaction Items
            foreach ($cartItems as $item) {
                $productForItem = $isBuyNow 
                    ? Product::find($item->product_id) 
                    : $item->product;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item->product_id,
                    'product_name'   => $productForItem->name,
                    'quantity'       => $item->quantity,
                    'price'          => $item->price,
                    'subtotal'       => $item->price * $item->quantity,
                ]);

                // Kurangi stok (sudah dicek di atas)
                if ($isBuyNow) {
                    Product::find($item->product_id)->decrement('stock', $item->quantity);
                }
            }

            // Hapus dari keranjang hanya jika bukan Buy Now
            if (!$isBuyNow) {
                Cart::where('user_id', $user->id)
                    ->where('is_selected', true)
                    ->delete();
            }

            // Hapus session Buy Now setelah berhasil
            if ($isBuyNow) {
                session()->forget('buy_now_item');
            }

            DB::commit();

            return redirect()->route('user.orders.index')
                ->with('success', 'Pesanan berhasil dibuat!')
                ->with('payment_method', $validated['payment_method'])
                ->with('qris_data', $validated['payment_method'] === 'qris' ? [
                    'amount'    => $total,
                    'order_id'  => $orderReference,
                    'qr_string' => 'QRIS|' . $orderReference . '|' . $total . '|TOKO-DEMO'
                ] : null);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($isBuyNow) session()->forget('buy_now_item');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }

    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}