@component('mail::message')

@include('emails.partials.header')

# Ticket #{{ $ticket->id }} Cerrado

Hola **{{ $user->name }}**,

Te informamos que tu ticket con asunto **"{{ $ticket->subject }}"** ha sido **cerrado** por nuestro equipo de soporte.

@if($ticket->messages->count())
**Último mensaje de soporte:**  
@component('mail::panel')
{{ $ticket->messages->last()->body }}
@endcomponent
@endif

Si consideras que el problema no se ha resuelto, puedes **responder** a este correo o **reabrir** el ticket en tu panel de soporte.

@component('mail::button', ['url' => route('tickets.show', $ticket)])
Ver mi ticket
@endcomponent

Gracias por confiar en nosotros,<br>
**Equipo de Soporte D&J Distribuciones**


@endcomponent
