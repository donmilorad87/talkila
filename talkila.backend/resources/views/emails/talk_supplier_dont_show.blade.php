
@component('mail::message')

<h1><span class="red-text">{{ __('TALK_SUPPLIER_DOESNT_SHOW_HEADLINE') }} </span></h1>

<p class="mb-0">{{ __('TALK_SUPPLIER_DOESNT_SHOW_DESCRIPTION', ['talk_name' => $talk_name, 'talk_date' => $date, 'start_time' => $start_time]) }}</p>
<br>

<table class="table">
<tr>
<th>{{ __('TALK') }}</th>
<th>{{  $talk_name }}</th>
</tr>
<tr>
<th>{{ __('DATE') }}</th>
<th>{{ $date }}</th>
</tr>
<tr>
<th>{{ __("TYPE") }}</th>
<th>{{ $type}}</th>
</tr>
<tr>
<th>{{ __('BASE_PRICE') }}</th>
<th>{{ $price}} {{ __('COIN') }}</th>
</tr>

</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $bookingsUrl, 'color' => 'talkila'])
{{ __('TALK_OPEN') }}
@endcomponent
</div>

@endcomponent

