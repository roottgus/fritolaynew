<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceChangePassword
{
    /**
     * Handle an incoming request.
     * If the user has a temporary password, redirect them to the change form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (
            $user &&
            $user->password_temporal &&
            ! $request->is('password/change') &&
            ! $request->is('password/change/*')
        ) {
            return redirect()->route('password.change.form');
        }

        return $next($request);
    }
}
