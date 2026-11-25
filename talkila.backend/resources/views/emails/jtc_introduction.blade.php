@component('mail::message')

{!! __('JTC_INTRODUCTION', [
   'appName' => config('app.name')
])!!}

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $jtc_route, 'color' => 'talkila'])
{{ __('JOIN_THE_CLUB') }}
@endcomponent
</div>
@endcomponent
