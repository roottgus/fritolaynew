@component('mail::message')

@include('emails.partials.header')

# Nuevo mensaje del cliente en ticket #{{ $ticket->id }}

El cliente ha agregado una respuesta:

@component('mail::panel')
{{ $messageBody }}
@endcomponent

@component('mail::button', ['url' => route('admin.tickets.show', $ticket)])
Ver ticket en el panel Admin
@endcomponent

Saludos,<br>
**Sistema de Soporte D&J Distribuciones**



@endcomponent
