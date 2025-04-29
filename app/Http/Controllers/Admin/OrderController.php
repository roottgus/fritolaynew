<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusChanged;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $statuses = [
            'pending'   => 'Pendiente',
            'completed' => 'Completado',
            'canceled'  => 'Cancelado',
        ];

        $origins = [
            'web'      => 'Web',
            'vendedor' => 'Vendedor',
        ];

        return view('admin.orders.edit', compact('order', 'statuses', 'origins'));
    }

    /**
     * Update the specified order in storage and notify user.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'total'  => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed,canceled',
            'origin' => 'required|in:web,vendedor',
        ]);

        // Update order
        $order->update($data);

        // Always notify the user about the status change
        $order->load('user');
        $order->user->notify(new OrderStatusChanged($order));

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pedido actualizado correctamente. Notificación enviada al usuario.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}
