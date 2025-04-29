@component('mail::message')

@include('emails.partials.header')

# Actualización en tu ticket de soporte

Hola **{{ $user->name }}**, 

Tu ticket **#{{ $ticket->id }} – {{ $ticket->subject }}** ha recibido una nueva respuesta:

@component('mail::panel')
{{ $messageBody }}
@endcomponent

@component('mail::button', ['url' => route('tickets.show', $ticket)])
Ver conversación y responder
@endcomponent

Si tienes alguna otra consulta, simplemente responde a este correo o visita tu panel de soporte para más detalles.

**Gracias por confiar en D&J Distribuciones**,

Equipo de Soporte D&J Distribuciones

@endcomponent
