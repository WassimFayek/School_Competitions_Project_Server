@component('mail::message')
#Welcome to this website :)

Thanks For Registration.
we are so glad to be a memeber in this website..

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
