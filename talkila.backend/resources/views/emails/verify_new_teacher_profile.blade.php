
@component('mail::message')
<style>
    table td {
        padding-top: 4px!important;
        padding-bottom: 4px!important;
    }
</style>
<h1>{{ __('VERIFY_NEW_SUPPLIER_HEADLINE', ['name' => $name]) }}</h1>

<p class="mb-0">{{ __('VERIFY_NEW_SUPPLIER_DESCRIPTION') }} </p>
<br>

<table class="table">
<colgroup>
<col style="width:53%">
<col style="width:40%">
</colgroup>
<tr>
<td>{{ __('NAME') }}</td>
<td>{{ $name }}</td>
</tr>
<tr>
<td>{{ __('USERNAME') }}</td>
<td><a href="{{ $usernameUrl }}">{{ $username }}</a></td>
</tr>
<tr>
<td>{{ __('EMAIL') }}</td>
<td>{{ $email}} </td>
</tr>
<tr>
<td>{{ __("DATE") }}</td>
<td>{{ $finishedTime }} </td>
</tr>
@if (!empty($profile_picture))
<tr>
<td>{{ __("PROFILE_PICTURE") }}</td>
<td>
<a href="/{{$username}}" class="w-20 fl">
<img src="{{ $profile_picture }}" alt="{{ $username }}" />
</a>
</td>
</tr>
@endif
</table>

<h3>{{ __('SET_ACCOUNTING') }}</h3>
<table class="table second-table">
<colgroup>
<col style="width:53%">
<col style="width:40%">
</colgroup>
<tr>
<td>{{ __('NAME') }}</td>
<td><strong>{{ $billingAddress->company_name }}</strong></td>
</tr>

<tr>
<td>{{ __('ADDRESS') }}</td>
<td><strong>{{ $billingAddress->street }}</strong></td>
</tr>

<tr>
<td>{{ __('CITY') }}</td>
<td><strong>{{ $billingAddress->city}}</strong></td>
</tr>

<tr>
<td>{{ __('BILLING_CHANGED_ZIP_CODE') }}</td>
<td><strong>{{ $billingAddress->zipcode }}</strong></td>
</tr>

<tr>
<td>{{ __('BILLING_CHANGED_TAX_ID') }}</td>
<td><strong>{{ $billingAddress->tax_number }}</strong></td>
</tr>

<tr>
<td>{{ __('COUNTRY') }}</td>
<td><strong>{{ $billingAddress->countries->name }}</strong></td>
</tr>

</table>

<h3>{{ __('AVAILABILITIES') }}</h3>
<table class="table">
<colgroup>
<col style="width:57%">
<col style="width:25%">
<col style="width:25%">
</colgroup>
@foreach($availabilities as $availability)

@if($availability->weekday == 1)
<tr>
<td>{{ trans('global.monday') }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@if($availability->weekday == 2)
<tr>
<td>{{ trans('global.tuesday') }}</td>
<td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
<td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@if($availability->weekday == 3)
<tr>
<td>{{ trans('global.wednesday') }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@if($availability->weekday == 4)
<tr>
<td>{{ trans('global.thursday') }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@if($availability->weekday == 5)
<tr>
<td>{{ trans('global.friday') }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@if($availability->weekday == 6)
<tr>
<td>{{ trans('global.saturday') }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@if($availability->weekday == 7)
<tr>
<td>{{ trans('global.sunday') }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->start_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->start_time }}</td>
    <td>{{ session('timezone_offset') ? \Carbon\Carbon::parse($availability->end_time)->subMinutes(session('timezone_offset'))->toTimeString() : $availability->end_time }}</td>
</tr>
@endif
@endforeach
</table>

<h3>{{ __('TALK') }}</h3>
<table class="table">
<colgroup>
<col style="width:57%">
<col style="width:50%">
</colgroup>
<tr>
<td>{{ __('TALK') }}</td>
<td><a href="{{ $talkUrl }}">{{ $talk->headline }}</a></td>
</tr>
<tr>
<td>{{ __('BASE_PRICE') }}</td>
<td>{{ $talk->price }} €</td>
</tr>
<tr>
<td>{{ __("DURATION") }}</td>
<td>{{ $talk->duration}} {{ __("MINUTES_SHORT") }}</td>
</tr>
<tr>
<td>{{ __('TYPE') }}</td>
<td>{{ $talk_type}}</td>
</tr>
<tr>
<td>{{ __('ANONYMOUS') }}</td>
<td>{{ $talk->anonymous ? 'Allow' : 'Disallow' }}</td>
</tr>
<tr>
<td>{{ __('LANGUAGE') }}</td>
<td>{{ $talk_language}}</td>
</tr>
</table>

<div class="mt-10 mb-10">
@component('mail::button', ['url' => $verificationUrl, 'color' => 'talkila'])
{{ __('OPEN_VERIFICATION_ADMIN') }}
@endcomponent
</div>

@endcomponent

