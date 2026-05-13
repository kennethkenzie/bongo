<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'demo@estatebongo.com'],
            ['name' => 'Demo Shopper', 'password' => 'password']
        );

        $categories = [
            "Women's Fashion", "Men's Fashion", "Phones & Telecom", "Computer & Office",
            "Consumer Electronics", "Jewelry & Watches", "Home & Garden", "Bags & Shoes",
            "Mother & Kids", "Sports & Outdoor", "Beauty, Health & Hair",
            "Automotive & Motorcycle", "Tools & Home Improvement", "Toys, Kids & Babies",
        ];

        foreach ($categories as $i => $name) {
            $slug = Str::slug($name);
            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'image' => "https://picsum.photos/seed/{$slug}/200/200",
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }

        $titles = [
            'Wireless Bluetooth Earbuds Pro', "Women's Casual Summer Dress",
            'Smart Watch HD Touch Screen', "Men's Slim Fit Cotton Shirt",
            'Portable Mini Projector 1080P', 'Stainless Steel Kitchen Knife Set',
            'LED Strip Lights RGB 16.4ft', 'Anti-Blue Light Computer Glasses',
            'Foldable Travel Backpack 40L', 'Wireless Charging Pad 15W',
            'Robot Vacuum Cleaner Smart', 'Yoga Mat Non-Slip 6mm',
            'Mechanical Gaming Keyboard RGB', 'Air Fryer 5.8 Quart Digital',
            'Sterling Silver Pendant Necklace', "Men's Leather RFID Wallet",
            'Electric Sonic Toothbrush', 'Memory Foam Cervical Pillow',
            'Magnetic Car Phone Holder', 'Resistance Bands Set 5-Piece',
        ];

        $cats = Category::pluck('id')->all();

        for ($i = 0; $i < 120; $i++) {
            $title = $titles[$i % count($titles)] . ' #' . ($i + 1);
            $slug  = Str::slug($title) . '-' . $i;
            $original = round(9.99 + (($i * 7.31) % 200), 2);
            $discount = 10 + (($i * 13) % 70);
            $price = round($original * (1 - $discount / 100), 2);
            $seed = 'prod-' . $i;
            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id'    => $cats[$i % count($cats)],
                    'title'          => $title,
                    'description'    => 'High quality product backed by Estate Bongo Buyer Protection.',
                    'image'          => "https://picsum.photos/seed/{$seed}/600/600",
                    'images'         => [
                        "https://picsum.photos/seed/{$seed}-1/600/600",
                        "https://picsum.photos/seed/{$seed}-2/600/600",
                        "https://picsum.photos/seed/{$seed}-3/600/600",
                    ],
                    'price'          => $price,
                    'original_price' => $original,
                    'discount'       => $discount,
                    'rating'         => round(3.6 + (($i * 0.17) - floor($i * 0.17)) * 1.4, 2),
                    'sold'           => 50 + (($i * 173) % 12000),
                    'stock'          => 100 + (($i * 7) % 900),
                    'shipping'       => $i % 3 === 1 ? '$1.99 shipping' : 'Free shipping',
                    'free_shipping'  => $i % 3 !== 1,
                    'badge'          => $i % 5 === 0 ? 'Choice' : ($i % 7 === 0 ? 'Bestseller' : null),
                    'is_active'      => true,
                ]
            );
        }
    }
}
