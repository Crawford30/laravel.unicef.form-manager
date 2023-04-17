@component('mail::message')
Hello {{ $name  }},

{{ $fromName }} has created a new  form, <b>{{ $formName  }}</b> and granted you ownership rights. <br>
As an owner, among others, you are able to see statistics on the data collected using this form. <br>
Kindly click on the button below to login and use the form to collect data.


@component('mail::button', ['url' => route("list-forms")])
LOGIN AND REVIEW FORM
@endcomponent

Regards,<br>
UNICEF Platform Team
@endcomponent



