@component('mail::message')
# Reset Password

We have received a request to reset your password. If you did not make this request, you can safely ignore this email.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/set-password/'.$token])
Reset Password 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
