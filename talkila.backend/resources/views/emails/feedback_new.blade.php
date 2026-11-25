@component('mail::message')
<h1>{{ __('FEEDBACK_HEADLINE') }}</h1>

<p class="mb-0">{{ __('FEEDBACK_DESCRIPTION') }}</p>
<br>

<table class="table">
<tr>
<th>{{ __('TALK') }}</th>
<th><a href="{{ $courseUrl }}">{{ $course_name }}</a></th>
</tr>
@if($feedbackUserName != 'Anonymous')
<tr>
<th>{{ __('USERS') }}</th>
<th><a href="{{ $userUrl }}">{{ $feedbackUserName }}</a></th>
</tr>
@else
<tr>
<th>{{ __('USERS') }}</th>
<th>{{ $feedbackUserName }}</th>
</tr>
@endif
<tr>
<th>{{ __('FEEDBACK_RATING_DESCRIPTION') }}</th>
<th>{{ $description ?: 'No comment' }}</th>
</tr>
<tr>
<th>{{ __('RATING') }}</th>
<th>
@for ($i = 0; $i < 5; $i++)
@if (floatVal($stars_content) >= ($i+1))
@include('frontend.partials.svg.icons.yellow_star')
@else
@if (abs(floatVal($stars_content) - ($i+1)) <= 0.5 && abs(floatVal($stars_content) - ($i+1)) < 1)
@include('frontend.partials.svg.icons.half_star')
@elseif (abs(floatVal($stars_content) - ($i+1)) >= 0.5)
@include('frontend.partials.svg.icons.gray_star')
@endif
@endif
@endfor
</th>
</tr>
</table>


@endcomponent
