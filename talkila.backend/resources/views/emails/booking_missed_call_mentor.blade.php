
@component('mail::message')

<h1>{{ __('YOU_HEADLINE') }} <span class="red-text">{{ __('MISSED_HEADLINE') }}</span> {{ __('A_TALK_HEADLINE') }}</h1>

{!! __('MISSED_TALK_SUPPLIER_DESCRIPTION') !!}
<br>

<table class="table">
<tr>
<th>{{ __('SUPPLIER') }}</th>
<th>{{ $username_mentor }}</th>
</tr>
<tr>
<th>{{ __('TALK') }}</th>
<th>{{ $course_name }}</th>
</tr>
<tr>
<th>{{ __("TYPE") }}</th>
<th>{{ $course_type}}</th>
</tr>
<tr>
<th>{{ __('DATE') }}</th>
<th>{{ $booking_start_date}}</th>
</tr>
<tr>
<th>{{ __('TIME') }}</th>
<th>{{ $booking_start_time}} - {{ $booking_end_time }} ({{ $course_duration }} {{ __("MINUTES_SHORT") }})</th>
</tr>
<tr>
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $price}} {{ __('COINS') }}</th>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

