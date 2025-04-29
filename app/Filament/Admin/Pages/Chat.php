<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class Chat extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chat-bubble-left';
    protected static string  $view            = 'filament.admin.pages.chat';
    protected static ?string $slug            = 'chat';
    protected static ?string $navigationGroup = 'Comunicación';

    public $users;
    public $selectedUser;
    public $messages = [];
    public $messageText = '';

    public function mount(): void
    {
        $this->users        = User::orderBy('name')->get();
        $this->selectedUser = $this->users->first()?->id;
        if ($this->selectedUser) {
            $this->loadMessagesFor($this->selectedUser);
        }
    }

    /**
     * Selecciona un usuario y carga su historial de mensajes.
     */
    public function select(int $userId): void
    {
        $this->loadMessagesFor($userId);
    }

    /**
     * Carga los mensajes entre el admin y el usuario dado.
     */
    public function loadMessagesFor(int $userId): void
    {
        $this->selectedUser = $userId;
        $adminId = Auth::id();

        $msgs = Message::query()
            ->where(function ($q) use ($adminId, $userId) {
                $q->where('sender_id', $adminId)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($adminId, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $this->messages = $msgs->map(fn($m) => [
            'id'          => $m->id,
            'sender_id'   => $m->sender_id,
            'receiver_id' => $m->receiver_id,
            'message'     => $m->message,
            'created_at'  => $m->created_at->format('H:i'),
        ])->toArray();
    }

    /**
     * Envía un nuevo mensaje y vuelve a cargar el historial.
     */
    public function sendMessage(): void
    {
        $text = trim($this->messageText);
        if ($text === '' || ! $this->selectedUser) {
            return;
        }

        $msg = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $this->selectedUser,
            'message'     => $text,
        ]);

        event(new MessageSent($msg));

        $this->messageText = '';
        $this->loadMessagesFor($this->selectedUser);
    }
}
