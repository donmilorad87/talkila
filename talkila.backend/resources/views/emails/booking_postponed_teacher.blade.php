
@component('mail::message')

{!! __('BOOKING_POSTPONED_SUPPLIER_HEADLINE') !!}
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
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $price }}€ ({{ __('COINS') }})</th>
</tr>
<tr>
<th>{{ __('ANONYMOUS') }}</th>
<th>{{ $anonym}} {{ __('COINS') }}</th>
</tr>
</table>


<table class="table second-table">
<tr>
<th>{{ __('OLD_TIME') }}</th>
<th>{{ __('NEW_TIME') }}</th>
</tr>
<tr>
<td class="red-text">{{ $original_booking_start_date }}</td>
<td class="green-text">{{ $booking_start_date }}</td>
</tr>
<tr>
<td class="red-text">{{ $original_booking_start_time}} - {{ $original_booking_end_time }} ({{ $original_duration }} {{ __("MINUTES_SHORT") }})</td>
<td class="green-text">{{ $booking_start_time}} - {{ $booking_end_time }} ({{ $course_duration }} {{ __("MINUTES_SHORT") }})</td>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

