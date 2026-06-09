<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $sepatu = Category::where('name', 'Sepatu')->first();
        $tas = Category::where('name', 'Tas')->first();
        $helm = Category::where('name', 'Helm')->first();

        if ($sepatu) {
            Service::create(['category_id' => $sepatu->id, 'name' => 'Deep Clean', 'price' => 40000, 'estimation_days' => 3]);
            Service::create(['category_id' => $sepatu->id, 'name' => 'Unyellowing', 'price' => 110000, 'estimation_days' => 4]);
            Service::create(['category_id' => $sepatu->id, 'name' => 'Repaint Canvas', 'price' => 150000, 'estimation_days' => 7]);
        }

        if ($tas) {
            Service::create(['category_id' => $tas->id, 'name' => 'Small Bag Clean', 'price' => 50000, 'estimation_days' => 3]);
            Service::create(['category_id' => $tas->id, 'name' => 'Backpack Clean', 'price' => 70000, 'estimation_days' => 3]);
        }

        if ($helm) {
            Service::create(['category_id' => $helm->id, 'name' => 'Half Face Clean', 'price' => 35000, 'estimation_days' => 2]);
            Service::create(['category_id' => $helm->id, 'name' => 'Full Face Clean', 'price' => 45000, 'estimation_days' => 2]);
        }
    }
}
