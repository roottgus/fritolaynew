<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class SyncProductCategoriesSeeder extends Seeder
{
    public function run()
    {
        Product::query()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->each(function($name){
                Category::firstOrCreate(['name' => $name]);
            });
    }
}
