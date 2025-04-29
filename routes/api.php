<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí puedes definir tus rutas API. Por ahora dejamos una básica
| para que no falle el cargado de RouteServiceProvider.
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
