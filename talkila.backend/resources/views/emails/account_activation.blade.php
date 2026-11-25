@component('mail::message')
<h1>{{ __('ACCOUNT_ACTIVATION_HEADER') }}</h1>

<p>{{ __('ACCOUNT_ACTIVATION_DESCRIPTION') }} <p>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $activation_link , 'color' => 'talkila'])
    {{ __('ACTIVE_ACCOUNT_BUTTON') }}
@endcomponent
</div>

{{--<hr class="fancy-line">--}}
@endcomponent
