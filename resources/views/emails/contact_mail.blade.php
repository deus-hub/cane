@component('mail::message')
# New mail from {{$fields['name']}}

{{$fields['message']}}


Sender email: {{$fields['email']}}<br>
@endcomponent
