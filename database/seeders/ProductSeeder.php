<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Producto Ejemplo',
            'code' => 'PROD001',
            'price' => 10.50,
            'image' => 'img/doritos.png', // Asegúrate de que esta ruta sea válida
            'category' => 'Doritos',
            'available' => true,
            'minQuantity' => 1,
        ]);
        // Puedes crear más productos o usar factories
    }
}
