<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Notifications\NewTicketMessageNotification;
use App\Notifications\TicketClosedNotification;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Lista todos los tickets ordenados por fecha.
     */
    public function index()
    {
        $tickets = Ticket::latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Muestra un ticket específico junto con su hilo de mensajes.
     */
    public function show(Ticket $ticket)
    {
        // Carga el usuario que abrió el ticket y todos los mensajes con sus autores
        $ticket->load(['user', 'messages.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Almacena una nueva respuesta (mensaje) al ticket y notifica al cliente.
     */
    public function storeMessage(Request $request, Ticket $ticket)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        // Crea el mensaje asociado al ticket
        $message = $ticket->messages()->create([
            'user_id' => auth()->id(),  // Admin
            'body'    => $request->body,
        ]);

        // Opcional: actualizar el estado del ticket
        $ticket->update(['status' => 'in_progress']);

        // Notificar al cliente propietario del ticket
        $ticket->user->notify(
            new NewTicketMessageNotification($message)
        );

        return back()->with('success', 'Respuesta enviada exitosamente y cliente notificado por email.');
    }

    /**
     * Elimina un ticket.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Ticket eliminado correctamente.');
    }

    /**
     * Cierra un ticket y notifica al cliente.
     */
    public function close(Ticket $ticket)
    {
        // Solo tickets que no estén ya cerrados
        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'closed']);

            // Notificar al cliente
            $ticket->user->notify(new TicketClosedNotification($ticket));
        }

        return back()->with('success', 'El ticket ha sido cerrado y el cliente notificado.');
    }
}
