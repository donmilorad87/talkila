<div class="popupBase" id="classDetails-{{ $item['id'] }}">

    <div class="popuper ppB zz2">
        <div class="credit-modal p2em">

            <div class="timing-box-left inner">
                <a href="/{{ $item['teacher_username'] }}/talk/{{ $item['talk_id'] }}">
                    <div class="fl">

                        <div class="d-flex">
                            @include('frontend.partials.pages.booking.participants-pictures',
                                compact('item'))
                        </div>
                    </div>
                </a>
                <div class="inner-box-timing fr duration{{$item['duration']}}">
                    <h6>{{ $item['duration'] }}</h6>
                    <p>
                        {{ __('PROFILE_MINUTES') }}
                    </p>
                </div>
            </div>

            <hr class="mb0">

            @if ($item['booking_status'] === 19)
                @include('frontend.partials.pages.booking.booking_state_information', [
                    'badgeClass'            => 'postponedBadger',
                    'start_call'            => $item['start_call'],
                    'end_call'              => $item['end_call'],
                    'postponed_start_call'  => $item['postponed_start_call'],
                    'postponed_end_call'    => $item['postponed_end_call']

                ])
            @elseif ($item['booking_status'] === 7)
                @include('frontend.partials.pages.booking.booking_state_information_cancel', [
                    'badgeClass'            => 'canceledBadger',
                    'cancellation_reason'   => $item['cancellation_reason'],
                    'cancel_date'           => $item['start_call'],
                ])
            @endif


            <form class="form-option pl0 pr0 pb0 w-100">
                <div class="grid-x grid-margin-x">
                    <fieldset class="cell large-12">
                        <h6 class="mb20">{{ __('TALK_DETAILS') }}</h6>
                        <div class="radio-option-inner">
                            <a href="/{{ $item['teacher_username'] }}">
                                <label for="pocketsRed" class="dRed">
                                    @include('frontend.partials.svg.icons.favicon')
                                    {{ $item['teacher_username'] }}
                                </label>
                            </a>
                        </div>

                        <div class="radio-option-inner">
                            <label class="df aic" for="pocketsRed">
                                @if ($item['talk_type'] == TalkTypes::VOICE_CALL)
                                    <span>@include('frontend.partials.svg.icons.voice-black')</span>
                                    {{ __('VOICE_TALKS') }}
                                @elseif($item['talk_type'] == TalkTypes::VIDEO_CALL)
                                    <span>@include('frontend.partials.svg.icons.video-black2')</span>
                                    {{ __('VIDEO_TALK') }}
                                @endif
                            </label>
                        </div>

                        <div class="radio-option-inner">
                            <span>@include('frontend.partials.svg.icons.calendar')</span><label for="pocketsRed">

                                {{ changeDateFormatLocale('Y-m-d H:i:s', $item['start_call'], true) }}
                            </label>
                        </div>
                        <div class="radio-option-inner">
                            <span>@include('frontend.partials.svg.icons.time')</span>
                            <label for="pocketsRed">
                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $item['start_call'])->format('H:i') }} -
                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $item['end_call'])->format('H:i') }}
                            </label>
                        </div>
                        <div class="radio-option-inner">
                            <span>@include('frontend.partials.svg.icons.note')</span>
                            <label for="pocketsRed">
                            @if (strlen($item['description']) > 20)
                                @php
                                    $first_200_chars = substr($item['description'], 0, 20);
                                    $rest_chars = substr($item['description'], 20);
                                @endphp
                                <div>
                                    <p class="shortenDesc fl mb0">{{ $first_200_chars }} <span class="threeDots"> ... </span>
                                        <span class="restofchars dn"> {{ $rest_chars }} </span>
                                    </p>
                                    <button id="showMoreDesc" class="btn cwhite fr showMoreDesc mb16" data-opened="0">
                                        {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }} </button>
                                </div>
                            @else
                                {{ $item['description'] }}
                            @endif

                            </label>
                        </div>

                        <div class="radio-option-inner">
                            <span>@include('frontend.partials.svg.icons.credit-card-black')</span>
                            <label for="pocketsRed">
                                <span style="display: block">@lang('TOTAL')</span>
                                {{ priceFormater($item['gross_price']) }}
                            </label>
                            @if ($item['pays_vat'])
                                <label for="pocketsRed">
                                    <span style="display: block">@lang('BASE_PRICE')</span>
                                    {{ priceFormater($item['net_price']) }}
                                </label>
                                <label for="pocketsRed">
                                    <span style="display: block">@lang('VAT')</span>
                                    {{ priceFormater($item['tax']) }}
                                    ({{ $item['vat_value'] }} %)
                                </label>
                            @endif
                        </div>
                        @if ($booking_status['badgePointer'] === 1)
                            @if ($show)
                                <div class="radio-option-inner space-around">
                                    <div class="d-flex">
                                        <span>@include('frontend.partials.svg.icons.remind')</span><label for="pocketsRed">
                                            {!! __('MINUTES_BEFORE') !!} </label>
                                    </div>

                                    <div class="date-wrap-content">
                                        <div class="button-switch switch">
                                            <input class="switch-input notificationBeforeMeeting"
                                                data-booking-id="{{ $item['booking_id'] }}"
                                                id="exampleSwitch-{{ $item['id'] }}" type="checkbox"
                                                name="exampleSwitch-{{ $item['id'] }}"
                                                @if ($item['notification_before_meeting']) checked @endif>
                                            <label class="switch-paddle" for="exampleSwitch-{{ $item['id'] }}">
                                                <span class="show-for-sr">{!! __('DOWNLOAD_KITTENS') !!}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </fieldset>
                </div>

                @if ($booking_status['badgePointer'] === 1)
                    <hr>

                    @if ($show)
                        @if ($userId !== $teacher_id)
                            @if ($showPostpone)
                                <a class="btn hollow mb0 fl createPostponeCookie"
                                    data-postpone-time="{{ $item['start_call'] }}"
                                    href="/booking-summary/{{ $item['talk_id'] }}?id={{ $item['id'] }}">
                                    {{ __('TALK_POSTPONE') }}
                                </a>
                            @endif
                        @endif
                        <span class="btn cp mb0 fr" data-popup="cancelTalkPre-{{ $item['id'] }}">
                            {!! __('CANCEL') !!} </span>
                    @else
                        @if ($userId !== $teacher_id)
                            <a href="/booking-summary/{{ $item['talk_id'] }}?reebok_time={{ $item['start_call'] }}"
                                class="btn mb0"> {!! __('REBOOK_TALK') !!}
                            </a>
                        @endif
                    @endif
                @endif
            </form>
            @include('frontend.partials.pages.booking.extend-item-short', ['items' => $item])
        </div>
        <span class="closeSpanPopup" onclick="closePopup(this.parentElement.parentElement.id)">×</span>
    </div>

</div>
@if ($booking_status['badgePointer'] === 1)
    @include('frontend.partials.pages.booking.cancel-booking-popup')
    @include('frontend.partials.pages.booking.cancel-appointment')
@endif
