@component('mail::message')

@component('mail::panel')
# OTP
@endcomponent

Kindly use the OTP provided below to verify your email
address so you can start using our services. <br>
{{$otp}}

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thank you for using our service,<br>
Warm Regards {{ config('app.name') }}
@endcomponent
