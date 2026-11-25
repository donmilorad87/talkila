
@component('mail::message')

<h1>{{ __('CLIENT_LEFT_TALK_HEADLINE') }}</h1>
<p class="mb-0">{{ __('CLIENT_LEFT_TALK_DESCRIPTION', ['talk_name' => $talk_name]) }}</p>
<br>
<p class="mb-0"><strong>{{ $reason }}</strong></p>
<br>
@if($badReview)
<p class="mb-0">{{ __('CLIENT_LEFT_TALK_DESCRIPTION_BAR_REVIEW') }}</p>
<br>
@endif
<table class="table">
<tr>
<th>{{ __('SUPPLIER') }}</th>
<th><a href="{{ $mentorUrl }}">{{ $username_mentor }}</a></th>
</tr>
<tr>
<th>{{ __('TALK') }}</th>
<th><a href="{{ $courseUrl }}">{{ $talk_name }}</a></th>
</tr>
<tr>
<th>{{ __("TYPE") }}</th>
<th>{{ $course_type }}</th>
</tr>
<tr>
<th>{{ __('DATE') }}</th>
<th>{{ $booking_start_date }}</th>
</tr>
<tr>
<th>{{ __('BOOKED_TIME') }}</th>
<th>{{ $booking_start_time}} - {{ $booking_end_time }} ({{ $booked_minutes }} {{ __("MINUTES_SHORT") }})</th>
</tr>
<tr>
<th>{{ __('SUPPLIER_ENTERED') }}</th>
<th>{{ $supplier_enter_time}} {{ $supplier_exit_time}} ({{ $supplier_minutes }} {{ __("MINUTES_SHORT") }})</th>
</tr>
<tr>
<th>{{ __('CLIENT_ENTERED') }}</th>
<th>{{ $client_enter_date}}  {{ $client_exit_time}} ({{ $client_minutes }} {{ __("MINUTES_SHORT") }})</th>
</tr>
<tr>
<th>{{ __('SUPPLIER_LOGIN_TYPE') }}</th>
<th>{{ $supplier_login_type}} </th>
</tr>
<tr>
<th>{{ __('CLIENT_LOGIN_TYPE') }}</th>
<th>{{ $client_login_type}} </th>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingsUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

