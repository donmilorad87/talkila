<div class="popupBase" id="cancelTalkPre-{{$item['id']}}" onclick="closePopup(this.id)">
    <div class="popuper ppR">
        <div class="credit-modal">
            <h5 class="tac">{{ __('BOOKINGS_CANCEL_MASSAGE') }}</h5>

            @if ($userId !== $teacher_id)
                @if ($showPostpone)
                    <a class="btn w-100 db hollow mb16" href="/booking-summary/{{ $item['talk_id'] }}?id={{ $item['id'] }}">
                        {{ __('TALK_POSTPONE') }}
                    </a>
                @endif
            @endif



            <button class="btn w-100 expanded preCancelAjaxButton cp" data-close-popup="cancelTalkPre-{{$item['id']}}" data-popup="cancelAppointment-{{$item['id']}}" data-course-id="{{$item['id']}}"> {{ __('CANCEL') }} {{ __('TALK') }}</button>
        </div>
        <span class="closeSpanPopup" onclick="closePopup(this.parentElement.parentElement.id)">×</span>
    </div>
</div>
