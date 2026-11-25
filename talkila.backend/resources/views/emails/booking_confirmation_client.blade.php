@component('mail::message')
<h1>{{ __('BOOK_SLOT_THANKS') }}</h1>
<p class="mb-0">
{{ __('BOOKING_CONFIRMATION_SUPPLIER_DESCRIPTION', [
'iOS' => 'iOS',
'android' => 'Android',
]) }}</p>
<br>
<table class="table">
<tr class="bb1">
<th class="thf">{{ __('SUPPLIER') }}</th>
<th class="ths">
<a href="{{ $mentorUrl }}">{{ $username_mentor }}</a>
</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('TALK') }}</th>
<th class="ths">
<a href="{{ $courseUrl }}">{{ $course_name }}</a>
</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('TYPE') }}</th>
<th class="ths">{{ $course_type }}</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('DATE') }}</th>
<th class="ths">{{ $booking_start_date }} {{ $timezone ? '- Timezone (' . $timezone . ')' : '' }}</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('TIME') }}</th>
<th class="ths">{{ $booking_start_time }} - {{ $booking_end_time }} ({{ $course_duration }}
{{ __('MINUTES_SHORT') }})</th>
</tr>
@if (optional($teacher_billing)->pays_vat)
<tr class="bb1">
<th class="thf">{{ __('TOTAL') }}</th>
<th class="ths">{{ priceFormater($price) }} ({{ priceFormater($price, true) . ' ' . __('COINS') }})</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('BASE_PRICE') }}</th>
<th class="ths">{{ priceFormater($price - ($price / 100) * $vat) }}</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('VAT') }}</th>
<th class="ths">{{ priceFormater(($price / 100) * $vat) }}</th>
</tr>
<tr class="bb1">
<th class="thf">{{ __('VAT') }}</th>
<th class="ths">{{ $vat }}%</th>
</tr>
@else
<tr class="bb1">
<th class="thf">{{ __('BASE_PRICE') }}</th>
<th class="ths">{{ priceFormater($price) }} ({{ priceFormater($price, true) . ' ' . __('COINS') }})</th>
</tr>
@endif
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>
@endcomponent
