<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sepatu Sneakers Putih',
                'category' => 'Fashion',
                'price' => 150000,
                'stock' => 120,
                'description' => 'Sepatu sneakers putih premium dengan bahan berkualitas tinggi. Nyaman dipakai sehari-hari.',
            ],
            [
                'name' => 'Headset Gaming RGB',
                'category' => 'Elektronik',
                'price' => 250000,
                'stock' => 45,
                'description' => 'Headset gaming dengan LED RGB dan sound quality terbaik untuk pengalaman gaming maksimal.',
            ],
            [
                'name' => 'Kemeja Flannel Kotak',
                'category' => 'Fashion',
                'price' => 120000,
                'stock' => 80,
                'description' => 'Kemeja flannel dengan motif kotak-kotak klasik. Bahan katun premium nyaman dipakai.',
            ],
            [
                'name' => 'Mouse Wireless Silent',
                'category' => 'Elektronik',
                'price' => 85000,
                'stock' => 200,
                'description' => 'Mouse wireless dengan fitur silent click. Cocok untuk kerja di kantor atau cafe.',
            ],
            [
                'name' => 'Tas Ransel Laptop',
                'category' => 'Fashion',
                'price' => 180000,
                'stock' => 60,
                'description' => 'Tas ransel khusus laptop hingga 15 inch. Anti air dan banyak kompartemen.',
            ],
            [
                'name' => 'Keyboard Mechanical',
                'category' => 'Elektronik',
                'price' => 350000,
                'stock' => 30,
                'description' => 'Keyboard mechanical dengan switch blue. Tactile feedback terbaik untuk typing dan gaming.',
            ],
            [
                'name' => 'Jaket Hoodie Premium',
                'category' => 'Fashion',
                'price' => 200000,
                'stock' => 100,
                'description' => 'Hoodie premium dengan bahan fleece tebal. Hangat dan nyaman untuk segala cuaca.',
            ],
            [
                'name' => 'Powerbank 20000mAh',
                'category' => 'Elektronik',
                'price' => 150000,
                'stock' => 150,
                'description' => 'Powerbank kapasitas besar 20000mAh. Bisa charge 2 device sekaligus.',
            ],
            [
                'name' => 'Celana Jeans Slim Fit',
                'category' => 'Fashion',
                'price' => 175000,
                'stock' => 90,
                'description' => 'Celana jeans slim fit dengan bahan stretch. Nyaman dan stylish.',
            ],
            [
                'name' => 'Webcam HD 1080p',
                'category' => 'Elektronik',
                'price' => 280000,
                'stock' => 40,
                'description' => 'Webcam Full HD 1080p dengan microphone built-in. Perfect untuk meeting online.',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::where('name', $productData['name'])->first();
            if (!$product) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'category' => $productData['category'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'description' => $productData['description'],
                    'is_active' => true,
                ]);
                $this->command->info("✅ Product created: {$productData['name']}");
            }
        }

        $this->command->info('🎉 Product seeding completed!');
    }
}