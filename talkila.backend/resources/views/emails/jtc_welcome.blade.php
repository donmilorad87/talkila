
@component('mail::message')
<h1>{{ __('JTC_WELCOME_HEADLINE') }}</h1>
<p class="mb-0">{{ __('JTC_WELCOME_DESCRIPTION') }} </p>
<br>
<table class="table">
<tr>
<th>
<div class="icon-sn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
@include('frontend.partials.svg.icons.offer-your-time')
</div>
</th>
<th style="color: #2684ff; font-size:22px;">{{ __('SLIDER_1_HEADLINE_1') }}</th>
</tr>
<tr>
<th></th>
<th style="color: #7c8087; font-size: 16px; font-weight: normal">{{ __('SLIDER_1_TEXT_1') }}</th>
</tr>
<tr>
<th>
<div class="icon-sn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
@include('frontend.partials.svg.icons.rethinking-privacy')
</div>
</th>
<th style="color: #2684ff; font-size:22px;">{{ __('SLIDER_1_HEADLINE_2') }}</th>
</tr>
<tr>
<th></th>
<th style="color: #7c8087; font-size: 16px; font-weight: normal">{{ __('SLIDER_1_TEXT_2') }}</th>
</tr>
<tr>
<th>
<div class="icon-sn" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
@include('frontend.partials.svg.icons.safe-payment')
</div>
</th>
<th style="color: #2684ff; font-size:22px;">{{ __('SLIDER_1_HEADLINE_3') }}</th>
</tr>
<tr>
<th></th>
<th style="color: #7c8087; font-size: 16px; font-weight: normal">{{ __('SLIDER_1_TEXT_3') }}</th>
</tr>
</table>
<div class="mt-10 mb-10">
@component('mail::button', ['url' => $jtcUrl, 'color' => 'talkila'])
{{ __('JOIN_THE_CLUB') }}
@endcomponent
</div>
@endcomponent

