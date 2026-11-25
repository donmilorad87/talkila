
@component('mail::message')

<h1>{{ __('TALK_PAUSED_HEADLINE') }}</h1>

<p class="mb-0">{{ __('TALK_PAUSED_DESCRIPTION') }} </p>
<br>

<table class="table">
<tr>
<th>{{ __('TALK') }}</th>
<th><a href="{{ $talkUrl }}">{{ $course_name }}</a></th>
</tr>
<tr>
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $talk_price }} €</th>
</tr>
<tr>
<th>{{ __("DURATION") }}</th>
<th>{{ $talk_duration}} {{ __("MINUTES_SHORT") }}</th>
</tr>
<tr>
<th>{{ __('TYPE') }}</th>
<th>{{ $talk_type}}</th>
</tr>
<tr>
<th>{{ __('ANONYMOUS') }}</th>
<th>{{ $talk_anonymous }}</th>
</tr>
<tr>
<th>{{ __('LANGUAGE') }}</th>
<th>{{ $talk_language}}</th>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $talkUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

