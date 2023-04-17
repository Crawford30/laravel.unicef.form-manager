@component('mail::message')
Hello {{$name}},

A user account has been create for you on {{env("APP_NAME")}} with the following credentials.

<strong>Email:</strong> {{$email}}<br>
<strong>Password:</strong> {{$password}}

@component('mail::button', ['url' => route("home")])
Login
@endcomponent

Regards,<br>
UNICEF Team
@endcomponent
