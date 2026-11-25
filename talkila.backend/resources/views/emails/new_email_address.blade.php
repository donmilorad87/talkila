@component('mail::message')
    {{ __('NEW_ADDRESS_DESCRIPTION') }}

    {{ __('THANKS') }},<br>
    {{ config('app.name') }}
@endcomponent
