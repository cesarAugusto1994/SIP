@component('mail::message')
# Login de um novo Dispositivo

Sua conta {{ config('app.name') }} foi conectada de um novo dispositivo.

> **Conta:** {{ $account->email }}<br>
> **Tempo:** {{ $time->toCookieString() }}<br>
> **IP:** {{ $ipAddress }}<br>
> **Navegador:** {{ $browser }}

Se este era você, você pode ignorar esse alerta. Se você encontrar qualquer atividade suspeita em sua conta, altere sua senha.

Esta é uma mensagem automática, favor não responder,<br>{{ config('app.name') }}
@endcomponent
