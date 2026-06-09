<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Service;

class PricelistSeeder extends Seeder
{
    public function run(): void
    {
        $pricelist = [
            [
                'category' => 'Shoes Cleaning',
                'estimation_days' => 5,
                'services' => [
                    ['name' => 'Woman Shoes', 'price' => 25000],
                    ['name' => 'Kids Shoes', 'price' => 25000],
                    ['name' => 'Regular Clean', 'price' => 30000],
                    ['name' => 'Clean n Care', 'price' => 40000],
                    ['name' => 'Full Suede', 'price' => 45000],
                    ['name' => 'Full Leather', 'price' => 45000],
                    ['name' => 'Express', 'price' => 50000],
                    ['name' => 'Hard Clean', 'price' => 50000],
                    ['name' => 'Whitening', 'price' => 55000],
                    ['name' => 'Trail Shoes', 'price' => 60000],
                ],
            ],
            [
                'category' => 'Shoes Repair',
                'estimation_days' => 7,
                'services' => [
                    ['name' => 'Unyellowing Midsole', 'price' => 70000],
                    ['name' => 'Reglue Easy', 'price' => 55000],
                    ['name' => 'Reglue Medium', 'price' => 60000],
                    ['name' => 'Reglue Hard', 'price' => 80000],
                    ['name' => 'Stitching/Sol', 'price' => 35000],
                ],
            ],
            [
                'category' => 'Shoes Repaint',
                'estimation_days' => 14,
                'services' => [
                    ['name' => 'Repaint Midsole', 'price' => 80000],
                    ['name' => 'Repaint Canvas', 'price' => 110000],
                    ['name' => 'Repaint Mesh', 'price' => 120000],
                    ['name' => 'Repaint Leather', 'price' => 140000],
                    ['name' => 'Repaint Suede', 'price' => 150000],
                    ['name' => 'Recolour Canvas', 'price' => 120000],
                ],
            ],
            [
                'category' => 'Helm Cleaning',
                'estimation_days' => 5,
                'services' => [
                    ['name' => 'Retro', 'price' => 35000],
                    ['name' => 'Half Face', 'price' => 50000],
                    ['name' => 'Full Face', 'price' => 70000],
                ],
            ],
            [
                'category' => 'Cap Cleaning',
                'estimation_days' => 4,
                'services' => [
                    ['name' => 'Clean', 'price' => 30000],
                    ['name' => 'Whitening', 'price' => 40000],
                    ['name' => 'Repaint', 'price' => 80000],
                ],
            ],
            [
                'category' => 'Bag Cleaning',
                'estimation_days' => 8,
                'services' => [
                    ['name' => 'Small Bag', 'price' => 30000],
                    ['name' => 'Medium Bag', 'price' => 50000],
                    ['name' => 'Large Bag', 'price' => 80000],
                    ['name' => 'Backpack', 'price' => 100000],
                ],
            ],
        ];

        foreach ($pricelist as $group) {
            $category = Category::firstOrCreate(
                ['name' => $group['category']]
            );

            foreach ($group['services'] as $service) {
                Service::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name' => $service['name'],
                    ],
                    [
                        'price' => $service['price'],
                        'estimation_days' => $group['estimation_days'],
                    ]
                );
            }
        }
    }
}
