<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPlaced;

class OrderController extends Controller
{


    public function store(Request $request)
    {
        try {
            // Validamos la petición JSON
            $data = $request->validate([
                'items'              => 'required|array|min:1',
                'items.*.product_id' => 'required|integer|exists:products,id',
                'items.*.name'       => 'required|string',          
                'items.*.quantity'   => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric',
                'items.*.subtotal'   => 'required|numeric',
                'total'              => 'required|numeric',
            ]);

            // Creamos la orden
            $order = Order::create([
                'user_id' => $request->user()->id,
                'items'   => $data['items'],
                'total'   => $data['total'],
                'status'  => 'Pendiente',
                'origin'  => 'Web',
            ]);

            // Carga el usuario
$order->load('user');

            // Disparamos evento para el correo
            event(new OrderPlaced($order));

            return response()->json([
    'message'   => 'Pedido enviado correctamente.',
    'order_id'  => $order->id,
]);
        } catch (\Throwable $e) {
            // Logueamos el error completo
            Log::error('Error en OrderController@store: '.$e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);
            // Devolvemos JSON con el mensaje para que tu fetch lo reciba
            return response()->json([
                'error' => 'Ocurrió un error interno: '.$e->getMessage()
            ], 500);
        }
    }
}
