@component('mail::message')
    {!! __('YOUR_IMAGE_VERIFIED', [
       'username' => $username
    ])!!}
    {{ config('app.name') }}
@endcomponent
