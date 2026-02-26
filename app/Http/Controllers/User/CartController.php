<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $cartItems = Cart::where('user_id', $user->id)
        ->with(['product'])
        ->get();

    // Hitung items yang dipilih
    $selectedItems = $cartItems->where('is_selected', true);

    // Hitung subtotal dari items yang dipilih
    $subtotal = $selectedItems->sum(function($item) {
        return $item->price * $item->quantity;
    });

    // Ongkir flat rate
    $shippingCost = $subtotal > 0 ? 20000 : 0;

    // Total
    $total = $subtotal + $shippingCost;

    // Hitung jumlah barang yang dipilih
    $selectedCount = $selectedItems->sum('quantity');

    return view('user.cart', compact(
        'cartItems',
        'selectedItems',
        'subtotal',
        'shippingCost',
        'total',
        'selectedCount'
    ));
}

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = auth()->user();

        // Check if already in cart
        $existingCart = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('variant', $request->variant)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'variant' => $request->variant,
                'price' => $product->price,
                'is_selected' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->back()->with('success', 'Keranjang diupdate!');
    }

    public function toggleSelect(Request $request, $id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cart->is_selected = !$cart->is_selected;
        $cart->save();

        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function checkout()
    {
        $user = auth()->user();

        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_selected', true)
            ->with(['product'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang kosong!');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $shippingCost = 20000;
        $total = $subtotal + $shippingCost;

        return view('user.checkout', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer_bank,ewallet,cod',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_phone' => 'required|string|max:20',
        ]);

        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_selected', true)
            ->with(['product'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Create transaction
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $shippingCost = 20000;
        $total = $subtotal + $shippingCost;

        $transaction = \App\Models\Transaction::create([
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_phone' => $request->shipping_phone,
            'notes' => $request->notes,
        ]);

        // Create transaction items
        foreach ($cartItems as $item) {
            \App\Models\TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
            ]);

            // Reduce stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Remove purchased items from cart
        Cart::where('user_id', $user->id)
            ->where('is_selected', true)
            ->delete();

        return redirect()->route('user.orders')
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function count()
    {
        $count = Cart::where('user_id', auth()->id())->count();
        return response()->json(['count' => $count]);
    }
}
