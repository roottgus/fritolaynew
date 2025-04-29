<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Facturación',
            'Reporte de Pago',
            'Contraseña',
            'Modificación de Datos',
            'Otro',
        ];

        foreach ($categories as $name) {
            TicketCategory::firstOrCreate(['name' => $name]);
        }
    }
}
