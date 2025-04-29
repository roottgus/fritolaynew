<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordChanged;

class PasswordChangeController extends Controller
{
    /**
     * Show the form to change the password.
     */
    public function show()
    {
        return view('auth.passwords.change');
    }

    /**
     * Handle the password change submission.
     */
    public function update(Request $request)
    {
        // Validar campos
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        // Verificar contraseña temporal
        if ($request->current_password !== $user->password_temporal) {
            return back()->withErrors([
                'current_password' => 'La contraseña temporal es incorrecta.'
            ]);
        }

        // Actualizar contraseña definitiva
        $user->password_temporal = null;
        $user->password = Hash::make($request->password);
        $user->save();

        // Notificar al usuario vía email
        $user->notify(new PasswordChanged());

        return redirect()
            ->route('inicio')
            ->with('status', 'Contraseña actualizada correctamente.');
    }
}
