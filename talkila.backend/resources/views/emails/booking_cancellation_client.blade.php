
@component('mail::message')

<h1>{{ __('BOOKING_CANCELLATION_CLIENT_HEADLINE') }} <span class="red-text">{{ __('CANCELLED') }}</span></h1>

<p class="mb-0">{{ __('SUCCESSFULLY_CANCELLED_YOUR_TALK_DESCRIPTION') }} </p>
<br>

<table class="table">
<tr>
<th>{{ __('SUPPLIER') }}</th>
<th><a href="{{ $mentorUrl }}">{{ $username_mentor }}</a></th>
</tr>
<tr>
<th>{{ __('TALK') }}</th>
<th><a href="{{ $bookingUrl }}">{{ $course_name }}</a></th>
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

