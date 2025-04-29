@component('mail::message')

@include('emails.partials.header')

{{-- Cuerpo del correo --}}
<div style="padding: 20px; background-color: #f2f4f6;">

# Nuevo ticket #{{ $ticket->id }}

<p style="font-size: 16px; color: #333;">
Hola <strong>{{ $user->name }}</strong>,
</p>

<p style="font-size: 16px; color: #333;">
Se ha registrado un nuevo ticket de soporte por <strong>{{ $ticket->user->name }}</strong> con los siguientes detalles:
</p>

{{-- Panel con los detalles --}}
@component('mail::panel')
<ul style="list-style: none; padding: 0; margin: 0;">
  <li style="margin-bottom: 8px;"><strong>Asunto:</strong> {{ $ticket->subject }}</li>
  <li style="margin-bottom: 8px;"><strong>Prioridad:</strong> 
    <span style="color: {{ $ticket->priority === 'high' ? '#D32A1E' : ($ticket->priority === 'medium' ? '#FCAF17' : '#4CAF50') }};">
      {{ ucfirst($ticket->priority) }}
    </span>
  </li>
  <li><strong>Detalle:</strong> {{ $ticket->message }}</li>
</ul>
@endcomponent

{{-- Botón de acción con estilo --}}
@component('mail::button', ['url' => url("/tickets/{$ticket->id}"), 'color' => 'primary'])
Ver Ticket
@endcomponent

{{-- Pie del correo --}}
<p style="font-size: 14px; color: #999; margin-top: 20px;">
Saludos cordiales,<br>
<strong>Equipo D&J Distribuciones</strong>
</p>
</div>
@endcomponent
