@component('mail::message')
<h1>{{ __('PROFILE_VERIFIED_HEADLINE') }}</h1>
<p>{{ __('PROFILE_VERIFIED_DESCRIPTION') }} </p>
<br>
<table style="border-collapse: collapse;margin: 0;padding: 0;width: 100%;margin-bottom: 32px;text-align: center;word-break: break-word;border-radius: 5px;">
<tr style="border-bottom: 1px solid rgba(6, 4, 3, 0.1);margin-bottom: 0;min-height: 92px;border-left: 1px solid rgba(6, 4, 3, 0.1);border: 1px solid rgba(6, 4, 3, 0.1);display: table;">
<td style="width: 321px;display: revert;border-bottom: 1px solid rgba(6, 4, 3, 0.1);">
<div style="width:100%; float:left; display:flex; align-items:centar; text-align:left;">
@if (!empty($teacher_profile_picture))
<a href="/{{$talk_teacher_username}}" style="min-width: 72px;margin-right: 16px; float:left;">
<img style="margin-left: 10px; border-radius:12px;" src="{{ $teacher_profile_picture }}" alt="{{ $talk_teacher_username }}" />
</a>
@else
<a href="{{env('APP_FRONTEND_URL')}}/{{$talk_teacher_username }}" style="min-width: 72px;margin-right: 16px;">
<img style="margin-left: 10px; border-radius:12px;" src="https://www.talkila.com/assets/images/avatar.svg" alt="{{ $talk_teacher_username }}" />
</a>
@endif
<div>
<div style="width:100%; float:left;">
<b style="color: #1D293F;">
{{ $talk_headline }}
</b>
</div>
<div style="width:100%; float:left;">
<span style="font-size: 12px;line-height: 16px;color: #172b4d;opacity: 0.7;">
{{ $talk_category_name }} > {{ $talk_subcategory_name }}
</span>
</div>
<div style="width:100%; float:left;">
<span style="font-size: 12px;line-height: 16px;color: #172b4d;opacity: 0.7;">
{{__('LANGUAGE')}}: {{ $talk_language_name }}
</span>
</div>
<div style="width:100%; float:left;">
<span style="font-size: 12px;line-height: 16px;color: #172b4d;opacity: 0.7;">
{{ __('BY') }} {{ $talk_teacher_name  }}
</span>
</div>
</div>
</div>
</td>
<td style="display: revert;border-bottom: 1px solid rgba(6, 4, 3, 0.1);">
<div>
<p style="font-size: 12px;line-height: 16px;color: #172b4d;opacity: 0.7; margin:0px;"> {{ __('TALK') }} </p>
<div style="display:flex; align-items:center; justify-content: space-evenly; width:36px; margin-right:16px;">
<span> <img src="https://talkila.com/assets/images/phone.png"/></span>
<span> | </span>
@if ($talk_call_type === 1)
<span> <img src="https://talkila.com/assets/images/camera.png"/></span>
@else
<span> <img src="https://talkila.com/assets/images/camera_cross.png"/></span>
@endif
@if ($talk_anonym_call === 1)
<span> | </span>
<span> <img src="https://talkila.com/assets/images/anon.png"/></span>
@endif
</div>
</div>
</td>
<td tyle="justify-content:center; dth:80px;display: revert;border-bottom: 1px solid rgba(6, 4, 3, 0.1);">
<div style="font-size:12px; color: #1D293F; margin-right:16px;">
<b> {{ $talk_price }} € </b>
</div>
</td>
</tr>
</table>
<div>
@component('mail::button', ['url' => $talksUrl, 'color' => 'talkila'])
{{ __('TALK_OPENS') }}
@endcomponent
</div>
@endcomponent

