@component('mail::message')
Hello {{ $user->name }}
Thank you for creating your email account. Please verify your email using this button below:

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
