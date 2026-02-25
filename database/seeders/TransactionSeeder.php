<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty()) {
            $this->command->error('❌ No users found. Please run: php artisan db:seed --class=AdminUserSeeder');
            return;
        }

        if ($products->isEmpty()) {
            $this->command->error('❌ No products found. Please run: php artisan db:seed --class=ProductSeeder');
            return;
        }

        $statuses = ['pending', 'paid', 'processing', 'shipped', 'completed'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang'];

        $this->command->info('🔄 Creating 25 sample transactions...');

        foreach (range(1, 25) as $i) {
            $user = $users->random();
            $subtotal = rand(100000, 1500000);
            $shippingCost = rand(15000, 35000);
            $total = $subtotal + $shippingCost;

            // Random status with weighted distribution
            $statusWeights = [
                'completed' => 40,
                'shipped' => 20,
                'processing' => 15,
                'paid' => 15,
                'pending' => 10,
            ];
            $status = array_rand(array_fill_keys(array_keys($statusWeights), 1));

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => $status,
                'shipping_address' => 'Jl. Contoh No. ' . rand(1, 100) . ', RT ' . rand(1, 10) . '/RW ' . rand(1, 5),
                'shipping_city' => $cities[array_rand($cities)],
                'shipping_postal_code' => rand(10000, 99999),
                'shipping_phone' => '08' . rand(100000000, 999999999),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Add items (1-4 products per transaction)
            $selectedProducts = $products->random(rand(1, 4));
            $itemSubtotal = 0;
            
            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $itemSubtotal += $product->price * $qty;
                
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'subtotal' => $product->price * $qty,
                ]);
            }

            // Update transaction subtotal based on items
            $transaction->update([
                'subtotal' => $itemSubtotal,
                'total' => $itemSubtotal + $shippingCost,
            ]);

            // Set timestamps based on status
            if (in_array($status, ['paid', 'processing', 'shipped', 'completed'])) {
                $transaction->update(['paid_at' => $transaction->created_at->addHours(rand(1, 24))]);
            }
            if (in_array($status, ['shipped', 'completed'])) {
                $transaction->update(['shipped_at' => $transaction->paid_at->addDays(rand(1, 3))]);
            }
            if ($status === 'completed') {
                $transaction->update(['completed_at' => $transaction->shipped_at->addDays(rand(3, 7))]);
            }
        }

        $this->command->info('✅ 25 sample transactions created successfully!');
        $this->command->info('📊 Status distribution:');
        foreach ($statuses as $s) {
            $count = Transaction::where('status', $s)->count();
            $this->command->info("   - {$s}: {$count}");
        }
    }
}