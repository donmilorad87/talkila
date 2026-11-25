@include('frontend.partials.pages.book_slot_thankyou.booking-thank-you-summar', [
    'userId' => $talkData['user']['id'],
    'imageUrl' => $talkData['user']['profile_picture'],
    'aboutName' => $talkData['user']['name'],
    'username' => $talkData['user']['username'],
    'rating' => $talkData['ratings'],
    'folowers' => $talkData['countFollowers'],

    'teacher_booked_students' => $talkData['bookingsCount'],
])

<div class="cell small-12 fl pt32 cblacks">
    <div class="inner-box-book leftBS bookingSummaryHDmobile">

        @include('frontend.partials.pages.profile.course-overview2', [
            'userTalks' => $talkData,
        ])
        <div class="w-100 fl mb16">
            @if ($talkData['ratings'] > 0)
                <div class="df aic mb16">

                    @include('frontend.partials.components.rating_stars', [
                        'ratings' => $talkData['ratings'],
                    ])
                    <b class="mr12">{{ $talkData['ratings'] }}</b>
                    <span class="small tdu">{{ $talkData['total_reviews'] }} @if ($talkData['total_reviews'] > 1)
                            {{ __('REVIEWS') }}
                        @else
                            {{ __('REVIEW') }}
                        @endif
                    </span>



                </div>
            @endif
            <div class="df w-100 jcsa">

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

                <div class="iconDiv">
                    @if ($talkData['is_anonymous_allowed'] == 1)
                        <div class="fl tac w-100 funnelIconsFix">
                            @include('frontend.partials.svg.icons.anonymous-black')
                        </div>
                        <div class="fl tac w-100 funnelSmallerText">
                            {{ __('ANON_TALKS') }}
                        </div>
                    @endif

                </div>

                <div class="df fdc">

                    <span id="moneyConta" class="df aic jce funnelBiggerText">{{ $talkData['price'] }} €</span>
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

        <p class="mb16 wbba fl">
            @if (isset($talkData['description']) && !empty($talkData['description']))
                @if (strlen($talkData['description']) > env('NUMBER_OF_CHAR_FOR_SHOW_MORE', 200))
                    @php
                        $first_200_chars = substr($talkData['description'], 0, env('NUMBER_OF_CHAR_FOR_SHOW_MORE', 200));
                        $rest_chars = substr($talkData['description'], env('NUMBER_OF_CHAR_FOR_SHOW_MORE', 200));
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
