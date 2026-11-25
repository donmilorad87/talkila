
@component('mail::message')
<style>
table{
    width: 100%;
}
.second-table table, .second-table th, .second-table td {
border: 1px solid rgba(6,4,3,.1);
}
.thead{
background:#d9d9d9;
}
.tac{
    text-align: left;
}
.padding-5{
    padding-top: 8px!important;
    padding-bottom: 8px!important;
}
</style>
<h1>{!! __('BILLING_ADDED_HEADLINE') !!}</h1>
<p class="mb-0">{!! __('BILLING_ADDED_DESCRIPTION') !!}</p>
<br>
<table class="table">
<tbody>
<tr>
<td class="padding-5">{!! __('NAME') !!}</td>
<td class="tac padding-5"><strong>{!! $original_full_name !!}</strong></td>
</tr>
<tr>
<td class="padding-5">{!! __('ADDRESS') !!}</td>
<td class="tac padding-5"><strong>{!! $original_address !!}</strong></td>
</tr>
<tr>
<td class="padding-5">{!! __('CITY') !!}</td>
<td class="tac padding-5"><strong>{!! $original_city!!}</strong></td>
</tr>
<tr>
<td class="padding-5">{!! __('ZIP_CODE') !!}</td>
<td class="tac padding-5"><strong>{!! $original_zip_code !!}</strong></td>
</tr>
{{--<tr>--}}
{{--<td class="padding-5">{!! __('BILLING_ADDED_TAX_ID') !!}</td>--}}
{{--<td class="tac padding-5"><strong>{!! $original_tax_id !!}</strong></td>--}}
{{--</tr>--}}
<tr>
<td class="padding-5">{!! __('COUNTRY') !!}</td>
<td class="tac padding-5"><strong>{!! $original_country !!}</strong></td>
</tr>
</tbody>
</table>
<div class="mt-10 mb-10 tac">
@component('mail::button', ['url' => $bilingInformationUrl, 'color' => 'talkila'])
{!! __('BILLING_ADDED_OPEN') !!}
@endcomponent
</div>
@endcomponent

