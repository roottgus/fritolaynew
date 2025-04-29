<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Collection;
use App\Notifications\NewTicketMessageNotification;
use App\Notifications\UserRepliedNotification;  // <— Importa la nueva notificación

class TicketThread extends Component
{
    // Usamos layout de usuario existente
    protected static string $layout = 'layouts.app-user';

    public Ticket $ticket;
    public Collection $threadMessages;
    public $body = '';

    protected $rules = [
        'body' => 'required|string',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->loadThreadMessages();
    }

    public function loadThreadMessages()
    {
        // Mensaje inicial del ticket
        $initial = collect([ (object)[
            'user'       => $this->ticket->user,
            'user_id'    => $this->ticket->user_id,
            'body'       => $this->ticket->message,
            'created_at' => $this->ticket->created_at,
        ]]);

        // Respuestas posteriores
        $replies = $this->ticket->messages()
                        ->with('user')
                        ->orderBy('created_at')
                        ->get();

        $this->threadMessages = $initial->merge($replies);
    }

    public function sendMessage()
    {
        $this->validate();

        // Creamos nueva respuesta y guardamos el modelo
        $message = $this->ticket->messages()->create([
            'user_id' => Auth::id(),
            'body'    => $this->body,
        ]);

        // Determinamos a quién notificar y con qué notificación
        if (Auth::user()->role === 'admin') {
            // Si responde el admin → notificar al cliente
            $recipient    = $this->ticket->user;
            $notification = new NewTicketMessageNotification($message);
        } else {
            // Si responde el cliente → notificar a todos los admins
            $recipient    = User::where('role', 'admin')->get();
            $notification = new UserRepliedNotification($message);
        }

        Notification::send($recipient, $notification);

        // Limpiamos input y recargamos hilo
        $this->body = '';
        $this->loadThreadMessages();

        session()->flash('supportSuccess', 'Respuesta enviada correctamente.');
    }

    public function render()
    {
        return view('livewire.ticket-thread', [
            'ticket'   => $this->ticket,
            'messages' => $this->threadMessages,
        ]);
    }
}
