<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $temp = Str::random(8);

        User::updateOrCreate(
            ['email' => 'admin@fritolay.test'],
            [
                'name'               => 'Administrador',
                'password'           => bcrypt('secret123'),
                'password_temporal'  => $temp,
                'role'               => 'admin',
            ]
        );

        $this->command->info("Admin creado/actualizado con password temporal: {$temp}");
    }
}
