{{-- {{$talkData['headline']}} --}}
<div class="dn" id="postponePointeringZ">
    @if($postponeTime ?? false)
        {{$postponeTime}}
    @endif
</div>
<div class="sevDaysCaleWrap">
    <div class="sevDaysCale">
        {{-- <h6 class="heading-tile-edit">{{ __('UPCOMING_BOOKINGS') }}</h6>
        <br> --}}

        <div id="sevenDaysCalendarCont" data-start-date=" @if($postponeTime ?? false) {{ $postponeTime }} @endif">
            <div class="owl-carousel" id="sevenDaysCalendar">

            </div>
        </div>
    </div>
</div>
