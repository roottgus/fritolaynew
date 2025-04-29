@component('mail::message')

@include('emails.partials.header')

{{-- Título --}}
# Cambio de Contraseña Exitoso

<p style="font-size: 16px; color: #333;">
Hola <strong>{{ \$user->name }}</strong>,
</p>

<p style="font-size: 16px; color: #333;">
Tu contraseña ha sido actualizada satisfactoriamente. Si no reconoces esta acción, por favor ponte en contacto con nuestro equipo de soporte de inmediato.
</p>

{{-- Botón de inicio de sesión --}}
@component('mail::button', ['url' => route('login'), 'color' => 'primary'])
Iniciar Sesión
@endcomponent

<p style="font-size: 14px; color: #555; margin-top: 20px;">
Si necesitas ayuda adicional o tienes alguna duda, escríbenos a <a href="gerencia@distrimargarita.com">gerencia@distrimargarita.com</a>.
</p>

<p style="font-size: 14px; color: #333; margin-top: 40px;">
Saludos cordiales,<br>
<strong>Equipo D&J Distribuciones</strong>
</p>

@endcomponent
