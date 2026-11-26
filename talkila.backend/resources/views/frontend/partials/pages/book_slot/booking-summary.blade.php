
@include('frontend.partials.pages.book_slot_thankyou.booking-thank-you-summar', [
    'userId' => $userData['id'],
    'imageUrl' => $userData['profile_picture'],
    'aboutName' => $userData['name'],
    'username' => $userData['username'],
    'rating' => $userData['ratings'],
    'folowers' => $userData['total_followers'],

    'teacher_booked_students' => $userData['teacher_booked_students'],
])

<div>
    <div class="cell small-12 fl mt32 cblack">
        <div class="inner-box-book leftBS bookingSummaryHDmobile">

            @include('frontend.partials.pages.profile.course-overview2', [
                'userTalks' => $talkData,
            ])
            <div class="w-100 fl">

                @if ((float) $talkData['ratings'] > 0)
                    <div class="df aic mb16">
                        {{-- <span class="hotHotter"> {{ __('HOT') }}</span> --}}
                        @include('frontend.partials.components.rating_stars', [
                            'ratings' => $talkData['ratings'],
                        ])
                        <b class="mr12">{{ number_format($talkData['ratings'], 1) }}</b>
                        <span class="small tdu">{{ $talkData['total_reviews'] }} @if ($talkData['total_reviews'] > 1)
                                {{ __('REVIEWS') }}
                            @else
                                {{ __('REVIEW') }}
                            @endif
                        </span>
                    </div>
                @endif


                <div class="df aib mb16">
                    <div class="df aib w-100 jcsb">
                        {{-- <div>
                        <div class="fl tac w-100 funnelIconsFix">
                            @include('frontend.partials.svg.icons.phone_hollow_black')
                        </div>
                        <div class="fl tac w-100 funnelSmallerText">
                            {{ __('TALK') }}
                        </div>
                        </div> --}}
                        <div class="iconDiv">

                            @if ($talkData['talk_type'] == TalkTypes::VIDEO_CALL)
                                <div class="fl tac w-100 funnelIconsFix">
                                    @include('frontend.partials.svg.icons.camera_hollow')
                                </div>
                                <div class="fl tac w-100 funnelSmallerText">
                                    {{ __('VIDEO_TALK') }}
                                </div>
                            @else
                                <div class="fl tac w-100 funnelIconsFix">
                                    @include('frontend.partials.svg.icons.phone_hollow_black')
                                </div>
                                <div class="fl tac w-100 funnelSmallerText">
                                    {{ __('PHONE_TALK') }}
                                </div>
                            @endif

                        </div>
                        {{-- private turned off --}}
                        <div class="iconDiv">
                            @if ($talkData['call_type'] == CallTypes::ONE_TO_ONE)
                                <div class="fl tac w-100 funnelIconsFix">
                                    @include('frontend.partials.svg.icons.private_hollow')
                                </div>
                                <div class="fl tac w-100 funnelSmallerText">
                                    {{ __('PRIVATE_TALK') }}
                                </div>
                            @else
                                <div class="fl tac w-100 funnelIconsFix">
                                    @include('frontend.partials.svg.icons.group2')
                                </div>
                                <div class="fl tac w-100 funnelSmallerText">
                                    {{ __('GALLERY_TALK') }}
                                </div>
                            @endif

                        </div>



                        @if (Route::current()->getName() == 'book_slot_payment')
                            @if ($talkData['is_anonymous_allowed'] == 1)
                                <div class="iconDiv">
                                    <div class="fl tac w-100 funnelIconsFix">
                                        @include('frontend.partials.svg.icons.anonymous-black')
                                    </div>
                                    <div class="fl tac w-100 funnelSmallerText">
                                        {{ __('ANON_TALKS') }}
                                    </div>
                                </div>
                            @endif
                        @elseif (Route::current()->getName() == 'book_slot')
                            @if ($talkData['anonym_call'] == 1)
                                <div class="iconDiv">
                                    <div class="fl tac w-100 funnelIconsFix">
                                        @include('frontend.partials.svg.icons.anonymous-black')
                                    </div>
                                    <div class="fl tac w-100 funnelSmallerText">
                                        {{ __('ANON_TALKS') }}
                                    </div>
                                </div>
                            @endif

                        @endif



                    </div>
                    <div class="tar w-100">

                        <div class="fl w-100 funnelBiggerText">

                            <span id="moneyConta" class="df aic jce">{{ priceFormater($talkData['price']) }}</span>

                            <input id="moneyContar" type="hidden" value={{floatval($talkData['price'])}}>
                        </div>
                        <div class="fl w-100">

                            <p class="m0 funnelSmallerText" id="talkMinutes">{{ $talkData['duration'] }}
                                @if ($talkData['duration'] > 1)
                                    {!! __('PROFILE_MINUTES') !!}
                                @else
                                    {!! __('PROFILE_MINUTE') !!}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <p class="mb16 wbba">
            @if (isset($talkData['description']) && !empty($talkData['description']))
                @if (strlen($talkData['description']) > config('talkila.number_of_char_for_show_more', 200))
                    @php
                        $first_200_chars = substr($talkData['description'], 0, config('talkila.number_of_char_for_show_more', 200));
                        $rest_chars = substr($talkData['description'], config('talkila.number_of_char_for_show_more', 200));
                    @endphp
                    <div>
                        <p class="shortenDesc fl mb0">{{ $first_200_chars }} <span class="threeDots"> ... </span>
                            <span class="restofchars dn"> {{ $rest_chars }} </span>
                        </p>
                        <button id="showMoreDesc" class="btn cwhite fr showMoreDesc mb16" data-opened="0">
                            {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }} </button>
                    </div>
                @else
                    {{ $talkData['description'] }}
                @endif
            @else
                {{ __('NO_DESCRIPTION') }}
            @endif
        </p>
        {{-- <a href="#" class="btn hollow expanded">{{ __('CHANGE_SELECTED_COURSE') }}</a> --}}
    </div>
    <div id="funnelReviewWrapTotal">
        <div class="cell small-12 fl" id="funnelReviewWrap">

            <div class="reviewContRecieved">
                @include('frontend.partials.pages.profile.rating2')
            </div>
        </div>
    </div>
</div>

@if (Route::current()->getName() !== 'book_slot')
    <div class="cell small-12 pt-0 fl">
        <div class="inner-box-book headingTimeAndDate">
            <h6 class="heading-title-book">{{ __('TIME') }} {{ __('AND') }} {{ __('DATE') }}</h6>
            <div class="time-date-summary pb-0">

                @if (isset($bookingObj) && !empty($bookingObj))

                    <div class="heading-slider heading-date dateHolderBookingToShow">

                        @include('frontend.partials.svg.icons.calendar')

                        <h6 class="bookingDateToShow">
                            {{ changeDateFormatLocale(
                                'Y-m-d H:i:s',
                                $bookingObj['bookingDate'] . ' ' . $bookingObj['bookingTime']['start_time'] . ':00',
                            ) }}
                        </h6>

                    </div>

                    <div class="heading-slider heading-date">
                        @if (!empty($bookingObj['bookingTime']['start_time']))
                            @include('frontend.partials.svg.icons.time')

                            <h6>{{ date('H:i', strtotime($bookingObj['bookingTime']['start_time'])) }} -
                                {{ date('H:i', strtotime($bookingObj['bookingTime']['end_time'])) }}</h6>
                        @endif
                    </div>

                @endif


            </div>

            @if (Route::current()->getName() == 'book_slot_payment')
                <a href="{{ route('book_slot', [$talkData['id']]) }}"
                    class="btn hollow dnSmalls">{{ __('BACK') }}</a>
            @endif

        </div>
    </div>

@endif
