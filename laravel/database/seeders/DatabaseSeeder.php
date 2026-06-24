<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => 'password', 'is_admin' => true],
        );

        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            ['name' => 'Customer', 'password' => 'password', 'is_admin' => false],
        );

        $categories = collect(['Phones', 'Laptops', 'Accessories'])->mapWithKeys(function ($name) {
            return [$name => Category::updateOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name, 'description' => "Shop {$name}"],
            )];
        });

        $products = [
            ['Phones', 'Aurora Phone X', 699, 15],
            ['Phones', 'Nova Mini 5G', 399, 22],
            ['Laptops', 'StudioBook Pro 14', 1299, 8],
            ['Laptops', 'Campus Laptop Air', 749, 12],
            ['Accessories', 'Wireless Headphones', 129, 30],
            ['Accessories', 'Fast USB-C Charger', 29, 50],
        ];

        foreach ($products as [$category, $name, $price, $stock]) {
            Product::updateOrCreate(
                ['slug' => str($name)->slug()],
                [
                    'category_id' => $categories[$category]->id,
                    'name' => $name,
                    'description' => "High quality {$name} for everyday shopping.",
                    'price' => $price,
                    'stock' => $stock,
                    'is_active' => true,
                ],
            );
        }
    }
}
