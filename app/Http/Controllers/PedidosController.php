<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Offer;
use App\Models\Category;

class PedidosController extends Controller
{
    public function index()
    {
        // Productos: convierte el path en URL pública (/storage/...)
        $productos = Product::all()->map(function ($p) {
            return [
                'id'          => $p->id,
                'name'        => $p->name,
                'code'        => $p->code,
                'price'       => $p->price,
                'minQuantity' => $p->minQuantity,
                'available'   => $p->available,
                'category'    => $p->category,
                'image'       => $p->image
                    ? Storage::disk('public')->url($p->image)
                    : null,
            ];
        });

        // Ofertas activas: idem para la imagen
        $offers = Offer::where('active', true)
            ->get()
            ->map(function ($o) {
                return [
                    'id'                => $o->id,
                    'image'             => $o->image
                        ? Storage::disk('public')->url($o->image)
                        : null,
                    'alt'               => $o->alt,
                    'promotion_message' => $o->promotion_message ?? '',
                ];
            });

        // Categorías maestras (todas, incluso sin productos)
        $categories = Category::orderBy('name')
            ->get(['name'])
            ->map(function ($c) {
                return [
                    'name' => $c->name,
                    'img'  => asset('img/categorias/' . Str::slug($c->name) . '.png'),
                ];
            })
            ->toArray();

        // Token para peticiones AJAX (opcional)
        $token = auth()->user()
            ->createToken('pedido-token')
            ->plainTextToken;

        return view('pedidos', compact('productos', 'offers', 'categories', 'token'));
    }
}
