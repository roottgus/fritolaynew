<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketsList extends Component
{
    public $tickets;

    public function mount()
    {
        // Carga todos los tickets del usuario autenticado
        $this->tickets = Ticket::where('user_id', Auth::id())
                               ->orderBy('created_at', 'desc')
                               ->get();
    }

    public function render()
    {
        return view('livewire.tickets-list', [
            'tickets' => $this->tickets,
        ]);
    }
}
