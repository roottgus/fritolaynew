<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Offer;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard / mi-cuenta
     */
    public function index()
    {
        // Pedidos del usuario (reemplaza el arreglo vacío por tu consulta real)
        $orders = [];

        // Anuncios activos
        $announcements = Announcement::where('active', true)->get();

        // Ofertas activas
        $offers = Offer::where('active', true)
            ->get()
            ->map(function ($o) {
                return [
                    'id'                => $o->id,
                    'image'             => $o->image,               // path o URL
                    'alt'               => $o->alt,
                    'promotion_message' => $o->promotion_message,
                ];
            });

        return view('inicio', compact('orders', 'announcements', 'offers'));
    }

    /**
     * Actualiza email, teléfono y contraseña del usuario autenticado.
     */
    public function actualizar(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'required|string|max:20',
            'password' => 'nullable|min:6',
        ]);

        // Asignar campos editables
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        // Si se proporcionó contraseña, cifrarla
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Tus datos han sido actualizados correctamente.');
    }
}
