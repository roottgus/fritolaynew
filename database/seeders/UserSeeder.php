<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@fritolay.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',         
        ]);
    
        // Crear usuario normal
        User::create([
            'name' => 'Usuario Prueba',
            'email' => 'usuario@fritolay.com',
            'password' => Hash::make('password'), // Utiliza un password seguro en producción
        ]);
    }
}
