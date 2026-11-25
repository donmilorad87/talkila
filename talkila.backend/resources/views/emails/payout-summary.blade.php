@component('mail::message')

<style>
table {
display: block;
overflow: auto;
}
th {
background : #d0d3d8;
border-left : 1px solid;
}

td:last-child {
border-right : 1px solid;
}

.table-row:nth-child(odd) {
background-color : #d0d3d8;
}

td {
border-left : 1px solid;
}

td:last-child {
border-right : 1px solid;
}
</style>
<h1 style="text-align: center;">{!! __('PAYOUT_SUMMARY_TITLE', ['date' => \Carbon\Carbon::parse($payout->payout_date)->format('Y F'), 'amount' => $payout->price]) !!}</h1>

<ul style="list-style: none; margin: 0; padding: 0; text-align: left;">
<li>
<strong>{{ __('PAYOUT_SUMMARY_BILLING_ADDRESS') }}</strong>
</li>
<li>{{ $billing->company_name }}</li>
<li>{{ $billing->street }}</li>
<li>{{ $billing->zip . ' ' . $billing->city }}</li>
<li>{{ $billing->countries->name }}</li>
<li>{{ $payout_method->value }}</li>
</ul>
<p style="margin: 8px 0; padding: 0; text-align: left">
{!! __('PAYOUT_SUMMARY_DESCRIPTION', [
'date' => \Carbon\Carbon::parse($payout->payout_date)->format('d.m.Y H:i'),
'method' => 'IBAN'
]) !!}
{{ $billing->email }}
</p>
<br>
<table class="" style="padding: 8px; border: 1px solid black; border-spacing: 0; width: 100%;">
<tr class="table-row">
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_COUNTRY') }}</th>
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_BOOKINGS') }}</th>
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_TAX') }}</th>
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_GROSS') }}</th>
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_PAYOUT') }}</th>
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_TAX') }}</th>
<th style="background-color: #d0d3d8; padding: 8px;">{{ __('PAYOUT_SUMMARY_NET') }}</th>
</tr>
@foreach($bookings as $booking)
<tr class="table-row">
<td style="padding: 8px; text-align: center">{{ $booking['country_of_residence'] }}</td>
<td style="padding: 8px; text-align: right;">{{ $booking['bookings_count'] }}</td>
<td style="padding: 8px; text-align: right;">{{ $booking['vat_value'] . '%' }}</td>
<td style="padding: 8px; text-align: right;">{{ $booking['revenue'] . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $booking['payout'] . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $booking['tax'] . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $booking['net'] . '€' }}</td>
</tr>
@endforeach
<tfoot>
<tr class="table-row">
<td style="padding: 8px; text-align: right;" colspan="3">{{ __('PAYOUT_SUMMARY_TOTAL') }}</td>
<td style="padding: 8px; text-align: right;">{{ $bookings->sum('revenue') . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $bookings->sum('payout') . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $bookings->sum('tax') . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $bookings->sum('net') . '€' }}</td>
</tr>
</tfoot>
</table>
<h2 style="margin: 16px 0;">{{ $payout->bookings->count() }} {{ __('PAYOUT_SUMMARY_TALKS') }}</h2>
<table class="" style="padding: 8px; border: 1px solid black; border-spacing: 0; width: 100%;">
<tr class="table-row">
<th style="padding: 8px; width: 0;">{{ __('PAYOUT_SUMMARY_DATE') }}</th>
<th style="padding: 8px; width: 25%">{{ __('PAYOUT_SUMMARY_TALK') }}</th>
<th style="padding: 8px; width: 0;">{{ __('PAYOUT_SUMMARY_BASE_PRICE') }}</th>
<th style="padding: 8px; width: 0;">{{ __('PAYOUT_SUMMARY_PAYOUT') }}</th>
<th style="padding: 8px; width: 0;">{{ __('PAYOUT_SUMMARY_LOCATION') }}</th>
</tr>
@foreach($talks as $talk)
<tr class="table-row">
<td style="padding: 8px; text-align: center;">{!! Str::replaceFirst(' ', '<br><span style="font-size: 12px;">', $talk->date)  !!}</td>
<td style="padding: 8px;">
<a href="{{ route('booking_details', $talk->id) }}">{{ $talk->headline }}</a></td>
<td style="padding: 8px; text-align: right;">{{ $talk->price . '€' }}</td>
<td style="padding: 8px; text-align: right;">{{ $talk->price * 0.8 . '€' }}</td>
<td style="padding: 8px; text-align: center">{{ $talk->location }}</td>
</tr>
@endforeach
</table>

@endcomponent

