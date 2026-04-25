<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Cafe Latte',
                'price' => 120.00,
                'stock' => 50,
                'category' => 'Coffee',
                'image' => 'https://placehold.co/400x300/e0f7fa/006064?text=☕+Latte'
            ],
            [
                'name' => 'Espresso',
                'price' => 90.00,
                'stock' => 50,
                'category' => 'Coffee',
                'image' => 'https://placehold.co/400x300/e0f7fa/006064?text=☕+Espresso'
            ],
            [
                'name' => 'Cappuccino',
                'price' => 120.00,
                'stock' => 50,
                'category' => 'Coffee',
                'image' => 'https://placehold.co/400x300/e0f7fa/006064?text=Cappuccino'
            ],
            [
                'name' => 'Americano',
                'price' => 100.00,
                'stock' => 50,
                'category' => 'Coffee',
                'image' => 'https://placehold.co/400x300/e0f7fa/006064?text=Americano'
            ],
            [
                'name' => 'Chocolate Cake',
                'price' => 150.00,
                'stock' => 30,
                'category' => 'Pastry',
                'image' => 'https://placehold.co/400x300/fce4ec/880e4f?text=Cake'
            ],
            [
                'name' => 'Cheesecake',
                'price' => 160.00,
                'stock' => 30,
                'category' => 'Pastry',
                'image' => 'https://placehold.co/400x300/fce4ec/880e4f?text=Cheesecake'
            ],
            [
                'name' => 'Blueberry Muffin',
                'price' => 80.00,
                'stock' => 40,
                'category' => 'Pastry',
                'image' => 'https://placehold.co/400x300/fce4ec/880e4f?text=Muffin'
            ],
            [
                'name' => 'Chicken Sandwich',
                'price' => 180.00,
                'stock' => 25,
                'category' => 'Food',
                'image' => 'https://placehold.co/400x300/e8f5e9/1b5e20?text=Sandwich'
            ],
            [
                'name' => 'Tuna Pasta',
                'price' => 220.00,
                'stock' => 20,
                'category' => 'Food',
                'image' => 'https://placehold.co/400x300/e8f5e9/1b5e20?text=Pasta'
            ],
            [
                'name' => 'Green Tea',
                'price' => 110.00,
                'stock' => 45,
                'category' => 'Tea',
                'image' => 'https://placehold.co/400x300/e0f7fa/006064?text=Green+Tea'
            ],
            [
                'name' => 'Mango Juice',
                'price' => 130.00,
                'stock' => 35,
                'category' => 'Beverage',
                'image' => 'https://placehold.co/400x300/e0f7fa/006064?text=Juice'
            ],
            [
                'name' => 'Croissant',
                'price' => 95.00,
                'stock' => 40,
                'category' => 'Pastry',
                'image' => 'https://placehold.co/400x300/fce4ec/880e4f?text=Croissant'
            ],
        ];

        DB::table('products')->insert($products);
    }
}