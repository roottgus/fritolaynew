{{-- resources/views/emails/new_user_credentials.blade.php --}}
<x-mail::message>

  {{-- Cabecera con logo --}}
  <x-slot name="header">
    @include('emails.partials.header')
  </x-slot>


  @php
    $brandColor = '#38c172';  // verde corporativo
  @endphp

  {{-- Título coloreado --}}
  <h1 style="color: {{ $brandColor }}; text-align: center; margin-bottom: 1rem;">
    ¡Bienvenido, {{ $user->name }}!
  </h1>

  {{-- Intro --}}
  Gracias por registrarte en **D&J Distribuciones**. Tus credenciales de acceso son:

  {{-- Panel con borde verde --}}
  <div style="border: 1px solid {{ $brandColor }}; border-radius: 6px; padding: 1rem; margin: 1rem 0;">
    <table style="width:100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="text-align:left; padding-bottom: .5rem;">Correo</th>
          <th style="text-align:right; padding-bottom: .5rem;">Contraseña temporal</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding: .5rem 0;">{{ $user->email }}</td>
          <td style="padding: .5rem 0; text-align:right;"><code>{{ $password }}</code></td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- Botón con color primario del tema --}}
  <x-mail::button :url="url('/login')" color="primary">
    Iniciar sesión
  </x-mail::button>

  {{-- Cierre --}}
  Si tienes alguna pregunta, escríbenos a <a href="mailto:gerencia@distrimargarita.com">gerencia@distrimargarita.com</a>.<br>
  **Saludos,**<br>
  **Equipo {{ config('app.name') }}**

  {{-- Subcopy --}}
  <x-slot name="subcopy">
    Si no solicitaste estas credenciales, ignora este correo o contáctanos.
  </x-slot>

</x-mail::message>
