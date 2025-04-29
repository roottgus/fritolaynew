<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostrar el panel de administración.
     */
    public function index()
    {
        // Estadísticas básicas
        $ordersThisMonth = Order::whereMonth('created_at', now())->count();
        $totalOrders     = Order::count();
        $totalSpent      = Order::sum('total');

        // Pedidos recientes: id, total, status, created_at
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'total', 'status', 'created_at']);

        // Datos para gráfico: pedidos por día del mes actual
        $labels = [];
        $counts = [];
        $startOfMonth = Carbon::now()->startOfMonth();
        $today = Carbon::today();
        for ($date = $startOfMonth->copy(); $date->lte($today); $date->addDay()) {
            $labels[] = $date->format('d/m');
            $counts[] = Order::whereDate('created_at', $date->toDateString())->count();
        }

        // Productos rotativos (5 aleatorios)
        $rotatingProducts = Product::inRandomOrder()
            ->limit(5)
            ->get();

        // Últimos tickets
        $recentTickets = Ticket::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Retornar vista con todos los datos
        return view('admin.dashboard', compact(
            'ordersThisMonth',
            'totalOrders',
            'totalSpent',
            'recentOrders',
            'labels',
            'counts',
            'rotatingProducts',
            'recentTickets'
        ));
    }
}
