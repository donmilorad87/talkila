@component('mail::message')
    {{ __('FEEDBACK_DELETED') }}

    {{ __('THANKS') }},<br>
    {{ config('app.name') }}
@endcomponent
