<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Product;
use Carbon\Carbon;

class CustomDashboard extends Page
{
    protected static string $view = 'filament.pages.custom-dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public int $ordersThisMonth;
    public int $totalOrders;
    public int $totalSpent;
    public \Illuminate\Support\Collection $recentOrders;
    public \Illuminate\Support\Collection $recentTickets;
    public array $labels;
    public array $counts;
    public \Illuminate\Support\Collection $rotatingProducts;

    public function mount(): void
    {
        // Cantidades
        $this->totalOrders = Order::count();
        $this->ordersThisMonth = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $this->totalSpent = Order::sum('total');

        // Pedidos recientes
        $this->recentOrders = Order::latest()->limit(5)->get();

        // Tickets recientes
        $this->recentTickets = Ticket::latest()->limit(5)->get();

        // Datos para gráfico de últimos 7 días
        $data = Order::selectRaw("DATE(created_at) as date, count(*) as count")
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $this->labels = $data->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d/m'))->toArray();
        $this->counts = $data->pluck('count')->toArray();

        // Productos destacados aleatorios
        $this->rotatingProducts = Product::inRandomOrder()->limit(5)->get();
    }
}
