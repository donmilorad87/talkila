
@component('mail::message')

<h1>{!! __('THANK_YOU_FOR_BOOKING_INVOICE_CLIENT') !!}</h1>

<p class="mb-0">{{ __('CONFIRMATION_INVOICE_CLIENT_DESCRIPTION') }}</p>
<br>

<table class="table">
<tr>
<th>{{ __('SUPPLIER') }}</th>
<th><a href="{{ $mentorUrl }}">{{ $username_mentor }}</a></th>
</tr>
<tr>
<th>{{ __('TALK') }}</th>
<th><a href="{{ $courseUrl }}">{{ $course_name }}</a></th>
</tr>
@if($teacher_billing->pays_vat)
<tr>
<th>{{ __('TOTAL') }}</th>
<th>{{ $price }}€ ({{ __('COINS') }})</th>
</tr>
<tr>
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $price - ($price / 100) * $vat }} {{ __('COINS') }}</th>
</tr>
<tr>
<th>{{ __('VAT') }}</th>
<th>{{ ($price / 100) * $vat  }} {{ __('COINS') }}</th>
</tr>
<tr>
<th>{{ __('VAT') }}</th>
<th>{{ $vat }}%</th>
</tr>
@else
<tr>
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $price }}€ ({{ __('COINS') }})</th>
</tr>
@endif
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

