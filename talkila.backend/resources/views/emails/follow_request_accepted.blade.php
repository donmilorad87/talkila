@component('mail::message')
<h1>{{ __('FOLLOW_REQUEST_ACCEPTED_HEADER') }}</h1>

<p>{{ __('FOLLOW_REQUEST_ACCEPTED_DESCRIPTION') }} <p>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $url , 'color' => 'talkila'])
    {{ __('PROFILE_SHOW_BUTTON_TEXT') }}
@endcomponent
</div>
@endcomponent
