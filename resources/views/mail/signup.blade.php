@component('mail::message')
# Welcome to Costack

Thank you for choosing costack for the help. Find best solution for your problems here.


@component('mail::button', ['url' => 'http://127.0.0.1:8000/verified/'.$token])
Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
