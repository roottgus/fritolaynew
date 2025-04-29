<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ForceChangePassword;
use App\Http\Middleware\EnsureAdmin;               // <-- Importa tu middleware aquí

use App\Http\Livewire\SupportTickets;
use App\Http\Livewire\TicketsList;
use App\Http\Livewire\TicketThread;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\OrderController as PublicOrderController;
use App\Http\Controllers\MiCuentaController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\CategoryController;

// Rutas Públicas
Route::get('/', fn() => view('welcome'))->name('home');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.perform');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Forzar cambio de contraseña
Route::get('password/change', [PasswordChangeController::class, 'show'])
    ->name('password.change.form');
Route::post('password/change', [PasswordChangeController::class, 'update'])
    ->name('password.update');

// Rutas para usuarios autenticados (incluye cambio de contraseña forzado)
Route::middleware(['auth', ForceChangePassword::class])->group(function () {
    Route::get('/inicio', [DashboardController::class, 'index'])->name('inicio');
    Route::get('/pedidos', [PedidosController::class, 'index'])->name('pedidos');
    Route::get('/mi-cuenta', [MiCuentaController::class, 'index'])->name('mi-cuenta');
    Route::post('/mi-cuenta/actualizar', [MiCuentaController::class, 'actualizar'])
         ->name('mi-cuenta.actualizar');

    Route::post('/orders', [PublicOrderController::class, 'store'])
         ->name('orders.store');

    // Soporte: creación en modal y listado detallado
    Route::get('/tickets', TicketsList::class)->name('tickets.index');
    Route::get('/tickets/{ticket}', TicketThread::class)->name('tickets.show');
});

// Rutas para administración (solo admins)
// Usamos la clase EnsureAdmin directamente
Route::middleware(['auth', ForceChangePassword::class, EnsureAdmin::class])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [AdminDashboardController::class, 'index'])
              ->name('dashboard');

         // Pedidos
         Route::resource('orders', OrderController::class);

         // Productos
         Route::resource('products', ProductController::class);

         // Usuarios
         Route::resource('users', UserController::class);

         // Anuncios
         Route::resource('announcements', AnnouncementController::class);

         // Ofertas
         Route::resource('offers', OfferController::class);

         // Tickets
         Route::resource('tickets', TicketController::class);
         Route::post('tickets/{ticket}/messages', [TicketController::class, 'storeMessage'])
              ->name('tickets.messages.store');
         Route::post('tickets/{ticket}/close', [TicketController::class, 'close'])
              ->name('tickets.close');

         // Categorías
         Route::resource('categories', CategoryController::class);
     });
