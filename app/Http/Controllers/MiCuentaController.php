<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ← importa Storage
use App\Models\Order;
use App\Models\Announcement;
use App\Models\Offer;

class MiCuentaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
                       ->latest()
                       ->get();

        // Anuncios activos
        $announcements = Announcement::where('active', true)->get();

        // Ofertas activas
        $offers = Offer::where('active', true)
            ->get()
            ->map(function($o) {
                return [
                    'id'                => $o->id,
                    'image'             => $o->image,               // path o URL, el partial lo resolverá
                    'alt'               => $o->alt,
                    'promotion_message' => $o->promotion_message,
                ];
            });


        return view('mi-cuenta', compact('user', 'orders', 'announcements', 'offers'));
    }
}