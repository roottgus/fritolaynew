@php
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$now  = Carbon::now();

// Pedidos este mes
$ordersMonthCount = Order::where('user_id', $user->id)
    ->whereYear('created_at', $now->year)
    ->whereMonth('created_at', $now->month)
    ->count();

// Total de pedidos (todos los tiempos)
$totalAllCount = Order::where('user_id', $user->id)->count();

// Total gastado (todos los tiempos)
$totalAllSum = Order::where('user_id', $user->id)->sum('total');

// Formateo de moneda
$formatCurrency = fn($value) => 'COP ' . number_format($value, 2, ',', '.');
@endphp

<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
  {{-- Pedidos este mes --}}
  <div class="bg-white p-3 rounded shadow-sm hover:shadow-md transition">
    <div class="flex items-center mb-1">
      <i class="fas fa-calendar-alt text-yellow-500 text-2xl mr-2"></i>
      <span class="text-sm font-medium text-gray-700">Pedidos este mes</span>
    </div>
    <div class="text-xl font-bold text-gray-900">{{ $ordersMonthCount }}</div>
  </div>

  {{-- Total de pedidos --}}
  <div class="bg-white p-3 rounded shadow-sm hover:shadow-md transition">
    <div class="flex items-center mb-1">
      <i class="fas fa-list-ol text-green-500 text-2xl mr-2"></i>
      <span class="text-sm font-medium text-gray-700">Total de pedidos</span>
    </div>
    <div class="text-xl font-bold text-gray-900">{{ $totalAllCount }}</div>
  </div>

  {{-- Total gastado --}}
  <div class="bg-white p-3 rounded shadow-sm hover:shadow-md transition">
    <div class="flex items-center mb-1">
      <i class="fas fa-coins text-red-500 text-2xl mr-2"></i>
      <span class="text-sm font-medium text-gray-700">Total gastado</span>
    </div>
    <div class="text-xl font-bold text-gray-900">{{ $formatCurrency($totalAllSum) }}</div>
  </div>
</div>
