
@component('mail::message')

<h1>{{ __('BILLING_CHANGED_HEADLINE') }}</h1>
<p class="mb-0">{{ __('BILLING_CHANGED_DESCRIPTION', [
    'time' => $time,
    'date' => \Carbon\Carbon::parse($date)->format('d.m.Y')
]) }}</p>
<br>

<table class="" style="padding: 8px; border: 1px solid black; border-spacing: 0; width: 100%;">
<tr>
<th></th>
<th style="padding: 8px; border-right: 0px solid black;">{{ __('BILLING_CHANGED_OLD_VALUES') }}</th>
<th style="padding: 8px; border-left: 0px solid black;">{{ __('BILLING_CHANGED_NEW_VALUES') }}</th>
</tr>
<tr>
<td style="padding: 8px; border-right: 1px solid black;">{{ __('NAME') }}</td>
<td style="padding: 8px; border-right: 1px solid black; @if($original_full_name === $new_full_name) color: black @else color: red; font-weight: bold; @endif">{{ $original_full_name }}</td>
<td style="padding: 8px; border-left: 0px solid black; @if($original_full_name === $new_full_name) color: black @else color: #0bb07b; font-weight: bold; @endif">{{ $new_full_name }}</td>
</tr>

<tr>
<td style="padding: 8px; border-right: 1px solid black;">{{ __('ADDRESS') }}</td>
<td style="padding: 8px; border-right: 1px solid black; @if($original_address === $new_address) color: black @else color: red; font-weight: bold; @endif">{{ $original_address }}</td>
<td style="padding: 8px; border-left: 0px solid black; @if($original_address === $new_address) color: black @else color: #0bb07b; font-weight: bold; @endif">{{ $new_address }}</td>
</tr>

<tr>
<td style="padding: 8px; border-right: 1px solid black;">{{ __('CITY') }}</td>
<td style="padding: 8px; border-right: 1px solid black; @if($original_city === $new_city) color: black @else color: red; font-weight: bold; @endif">{{ $original_city}}</td>
<td style="padding: 8px; border-left: 0px solid black; @if($original_city === $new_city) color: black @else color: #0bb07b; font-weight: bold; @endif">{{ $new_city }}</td>
</tr>

<tr>
<td style="padding: 8px; border-right: 1px solid black;">{{ __('BILLING_CHANGED_ZIP_CODE') }}</td>
<td style="padding: 8px; border-right: 1px solid black; @if($original_zip_code === $new_zip_code) color: black @else color: red; font-weight: bold; @endif">{{ $original_zip_code }}</td>
<td style="padding: 8px; border-left: 0px solid black; @if($original_zip_code === $new_zip_code) color: black @else color: #0bb07b; font-weight: bold; @endif">{{ $new_zip_code }}</td>
</tr>
<tr>
<td style="padding: 8px; border-right: 1px solid black;">{{ __('VAT') }}</td>
<td style="padding: 8px; border-right: 1px solid black; @if($original_vat === $new_vat) color: black @else color: red; font-weight: bold; @endif">{{ $original_vat }}</td>
<td style="padding: 8px; border-left: 0px solid black; @if($original_vat === $new_vat) color: black @else color: #0bb07b; font-weight: bold; @endif">{{ $new_vat }}</td>
</tr>
<tr>
<td style="padding: 8px; border-right: 1px solid black;">{{ __('COUNTRY') }}</td>
<td style="padding: 8px; border-right: 1px solid black; @if($original_country === $new_country) color: black @else color: red; font-weight: bold; @endif">{{ $original_country }}</td>
<td style="padding: 8px; border-left: 0px solid black; @if($original_country === $new_country) color: black @else color: #0bb07b; font-weight: bold; @endif">{{ $new_country }}</td>
</tr>

</table>
<div class="mt-10 mb-10">
@component('mail::button', ['url' => $billingInformationUrl, 'color' => 'talkila'])
{{ __('BILLING_CHANGED_OPEN') }}
@endcomponent
</div>

@endcomponent

