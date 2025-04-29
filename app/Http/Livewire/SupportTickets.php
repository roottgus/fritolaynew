<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewTicketNotification;
use App\Models\User;

class SupportTickets extends Component
{
    public $categories;
    public $categoryId;
    public $priority = 'medium';
    public $details = '';
    public $tickets = [];

    protected $rules = [
        'categoryId' => 'required|exists:ticket_categories,id',
        'priority'   => 'required|in:low,medium,high',
        'details'    => 'required|string',
    ];

    public function mount()
    {
        $this->categories = TicketCategory::all();
        $this->categoryId = $this->categories->first()->id ?? null;
        $this->priority   = 'medium';
        $this->loadTickets();
    }

    public function loadTickets()
    {
        $this->tickets = Ticket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createTicket()
    {
        $data = $this->validate();

        $category = TicketCategory::find($this->categoryId);

        $ticket = Ticket::create([
            'user_id'     => Auth::id(),
            'category_id' => $this->categoryId,
            'subject'     => $category->name,
            'priority'    => $this->priority,
            'status'      => 'new',
            'message'     => $this->details,
        ]);

        // Enviar notificación a administradores
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewTicketNotification($ticket));

        // Resetear formulario y actualizar lista
        $this->reset(['details']);
        $this->categoryId = $this->categories->first()->id ?? null;
        $this->priority   = 'medium';
        $this->loadTickets();

        session()->flash('supportSuccess', 'Ticket creado correctamente.');
    }

    public function render()
    {
        return view('livewire.support-tickets');
    }
}
