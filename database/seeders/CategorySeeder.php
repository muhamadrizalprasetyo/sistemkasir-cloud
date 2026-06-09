<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Sepatu',
            'Tas',
            'Helm',
            'Topi',
            'Shoes Cleaning',
            'Shoes Repair',
            'Shoes Repaint',
            'Helm Cleaning',
            'Cap Cleaning',
            'Bag Cleaning',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
