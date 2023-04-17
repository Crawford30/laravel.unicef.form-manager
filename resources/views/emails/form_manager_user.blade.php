@component('mail::message')
Hello {{ $name  }},

{{ $fromName }} has created a new  form, <b>{{ $formName  }}</b> and added you as a user. <br>
Kindly click on the button below to login and use the form to collect data.


@component('mail::button', ['url' => route("use-form", $formId)])
LOGIN AND USE FORM
@endcomponent

Regards,<br>
UNICEF Platform Team
@endcomponent
