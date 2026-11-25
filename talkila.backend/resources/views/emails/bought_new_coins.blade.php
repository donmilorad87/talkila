
@component('mail::message')

<h1>{{ __('BOUGHT_COINS_HEADLINE') }} <span class="green-text">{{ $new_amount }} {{ __('COINS') }}</span></h1>

<p class="mb-0">{{ __('BOUGHT_COINS_DESCRIPTION', ['amount' => $new_amount, 'method' => $method]) }}</p>
<br>

<table class="table">
<tr>
<th>{{ __('AMOUNT_SUM') }}</th>
<th>{{  $new_amount }}</th>
</tr>
<tr>
<th>{{ __('PAYMENT_TYPE') }}</th>
<th>{{ $payment_method }}</th>
</tr>
<tr>
<th>{{ __("DATE") }}</th>
<th>{{ $date}}</th>
</tr>
<tr>
<th>{{ __('BOUGHT_COINS_OLD_BALANCE') }}</th>
<th>{{ $coins_old_balance > 0 ? $coins_old_balance : '0' }}</th>
</tr>
<tr>
<th>{{ __('BOUGHT_COINS_NEW_BALANCE') }}</th>
<th>{{ $coins_new_balance}} </th>
</tr>

</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $walletUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

