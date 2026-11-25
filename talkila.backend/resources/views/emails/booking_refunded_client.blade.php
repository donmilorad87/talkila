
@component('mail::message')

{!! __('BOOKING_REFUNDED_CLIENT_MESSAGE', [
   'username_mentor' => $username_mentor,
   'appName' => config('app.name')
])!!}
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
<th>{{ $price }}€ ({{ __('COINS') }})</th>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

