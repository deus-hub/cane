@component('mail::message')

@component('mail::panel')
# PASSWORD RESET OTP
@endcomponent

Kindly use the OTP provided below to reset your password
 so you can continue using our services. <br>
{{$otp}}

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thank you for using our service,<br>
Warm Regards {{ config('app.name') }}
@endcomponent
