<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    /**
     * Maneja la petición entrante.
     * Si no es admin, muestra la vista de privacidad (403).
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Ajusta aquí tu comprobación de rol si no es exactamente 'admin'
        if (! $user || $user->role !== 'admin') {
            return response()->view('errors.privacy', [], 403);
        }

        return $next($request);
    }
}
