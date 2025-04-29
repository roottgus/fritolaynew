<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->exists();
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }
}