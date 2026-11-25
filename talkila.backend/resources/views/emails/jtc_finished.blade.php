
@component('mail::message')

<h1>{{ __('JTC_FINISHED_HEADLINE') }}</h1>

<p class="mb-0">{{ __('JTC_FINISHED_DESCRIPTION') }} </p>
<br>

<table class="table">
<colgroup>
<col style="width:53%">
<col style="width:40%">
</colgroup>
<tr>
<td>{{ __('NAME') }}</td>
<td><strong>{{ $name }}</strong></td>
</tr>
<tr>
<td>{{ __('USERNAME') }}</td>
<td><strong>{{ $username }}</strong></td>
</tr>
</table>

<br>

<h3>{{ __('SET_ACCOUNTING') }}</h3>

<table class="table">
<colgroup>
<col style="width:53%">
<col style="width:40%">
</colgroup>
<tr>
<td>{{ __('NAME') }}</td>
<td><strong>{{ $billing_full_name }}</strong></td>
</tr>

<tr>
<td>{{ __('ADDRESS') }}</td>
<td><strong>{{ $billing_address }}</strong></td>
</tr>

<tr>
<td>{{ __('CITY') }}</td>
<td><strong>{{ $billing_city}}</strong></td>
</tr>

<tr>
<td>{{ __('BILLING_CHANGED_ZIP_CODE') }}</td>
<td><strong>{{ $billing_zip_code }}</strong></td>
</tr>

{{--<tr>--}}
{{--<td>{{ __('BILLING_CHANGED_TAX_ID') }}</td>--}}
{{--<td><strong>{{ $billing_tax_id }}</strong></td>--}}
{{--</tr>--}}

<tr>
<td>{{ __('COUNTRY') }}</td>
<td><strong>{{ $billing_country }}</strong></td>
</tr>

</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $verificationUrl, 'color' => 'talkila'])
{{ __('OPEN_VERIFICATION') }}
@endcomponent
</div>

@endcomponent

