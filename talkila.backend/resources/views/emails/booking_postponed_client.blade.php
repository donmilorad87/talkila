
@component('mail::message')

{!! __('BOOKING_POSTPONE_MESSAGE') !!}
<br>

<table class="table">
<tr>
<th>{{ __('SUPPLIER') }}</th>
<th><a href="{{ $mentorUrl }}">{{ $username_mentor }}</a></th>
</tr>
<tr>
<th>{{ __('TALK') }}</th>
<th><a href="{{ $talkUrl }}">{{ $course_name }}</a></th>
</tr>
<tr>
<th>{{ __("TYPE") }}</th>
<th>{{ $course_type}}</th>
</tr>
<tr>
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $price }}€ ({{ __('COINS') }})</th>
</tr>
</table>


<table class="table second-table">
<tr>
<th class="column-width-50">{{ __('OLD_TIME') }}</th>
<th>{{ __('NEW_TIME') }}</th>
</tr>
<tr>
<td class="red-text">{{ $original_booking_start_date }}</td>
<td class="green-text">{{ $booking_start_date }}</td>
</tr>
<tr>
<td class="red-text">{{ $original_booking_start_time}} - {{ $original_booking_end_time }}</td>
<td class="green-text">{{ $booking_start_time}} - {{ $booking_end_time }}</td>
</tr>
<tr>
<td class="red-text">{{ $original_duration }} {{ __("MINUTES_SHORT") }}</td>
<td class="green-text">({{ $course_duration }} {{ __("MINUTES_SHORT") }})</td>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

