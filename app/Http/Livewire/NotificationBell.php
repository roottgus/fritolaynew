<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class NotificationBell extends Component
{
    /** @var Collection */
    public Collection $notifications;

    /** @var int */
    public int $unreadCount = 0;

    /** @var bool — solo para que Livewire no intente sincronizarlo */
    public bool $initial = false;

    public function mount(): void
    {
        // Carga inicial
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        // Trae las últimas 5 notificaciones
        $this->notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(5)
            ->get();

        // Actualiza el conteo de no leídas
        $this->unreadCount = Auth::user()
            ->unreadNotifications()
            ->count();
    }

    public function markAsRead(string $id): void
    {
        if ($notif = Auth::user()->notifications()->find($id)) {
            $notif->markAsRead();
        }
        $this->loadNotifications();
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->each->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
