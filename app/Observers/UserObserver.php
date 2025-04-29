<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\NewUserCredentials;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Ejecuta acciones después de que se crea un usuario.
     */
    public function created(User $user)
    {
        // Genera una contraseña temporal
        $temporaryPassword = Str::random(8);

        // Actualiza el usuario: guarda la contraseña hasheada en 'password' y la temporal en 'password_temporal'
        $user->update([
            'password' => bcrypt($temporaryPassword),
            'password_temporal' => $temporaryPassword,
        ]);

        // Envía la notificación de credenciales nuevas
        $user->notify(new NewUserCredentials($user, $temporaryPassword));
    }
}
