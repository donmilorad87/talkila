<div class="optionButton" data-opened="0">
    @include('frontend.partials.svg.icons.v-dots')
    <ul>
        @if ($userId !== $teacher_id)
            @if($showPostpone)
                <li data-popup="appointmentPostpone-{{ $item['id'] }}">
                    <a class="colorW db createPostponeCookie" data-postpone-time="{{$item['start_call']}}" href="/booking-summary/{{ $item['talk_id'] }}?id={{ $item['id'] }}">
                        {{ __('TALK_POSTPONE') }}
                    </a>
                </li>
            @endif
        @endif
        <li class="noselect cp" data-popup="cancelTalkPre-{{ $item['id'] }}"> {{ __('TALK_CANCEL') }} </li>
    </ul>
</div>
