@component('mail::message')
<style>
.colorRed{
    color:#cd1212;
}
.fw300{
    font-weight: 300;
}
</style>
<h1>{{ __('DECLINE_ACCOUNT') }}</h1>
<br>
<p>@lang('ACCOUNT_VERIFICATION_DECLINE_TEXT_EMAIL')</p>
<table class="table">
<tr>
<th><b>{{ __('NAME') }}</b></th>
<th>{{ __('DATE') }}</th>
<th>{{ __('STATUS') }}</th>
</tr>
<tr>
<th>{{ $clientUsername }}</th>
<th class="fw300">{{ $rejectDate }}</th>
<th class="colorRed">@lang('DECLINE')</th>
</tr>
</table>
<div class="mt-10 mb-10">
@component('mail::button', ['url' => $verificationUrl, 'color' => 'talkila'])
{{ __('ACCOUNT_VERIFICATION') }}
@endcomponent
</div>
@endcomponent

