<div class="course-item privateCourseItem">

    <a data-talk-id="{{ $userTalks['id'] }}" class="dataTalkId jcfs" href="{{ route('book_slot', [$userTalks['id']]) }}">

        <div class="df aic">
            <div class="df aic jcc divPrivTalk mr16 duration{{ $userTalks['duration'] }}">
                <div>
                    <h6 class="lh1">{{ $userTalks['duration'] }}</h6>
                    <p class="m0">
                        @if ($userTalks['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>
            </div>

            <div class="profileTalksHeadline">
                <h6 class="mb0 pb0">{{ $userTalks['headline'] }}</h6>
                <div class="social-box">
                    <ul class="df lstn listItemTalksProfile">


                        @if ($userTalks['call_type'] === CallTypes::ONE_TO_ONE)
                            <li class="mr16">
                                {{ __('PRIVATE_TALK') }}
                            </li>
                        @else
                            <li class="mr16">
                                {{ __('GALLERY_TALK') }}
                            </li>
                        @endif

                        <li> @include('frontend.partials.svg.icons.phone')</li>
                        <li>|</li>
                        @if ($userTalks['talk_type'] == TalkTypes::VIDEO_CALL)
                            <li> @include('frontend.partials.svg.icons.video-camera')</li>
                        @else
                            <li>
                                @include('frontend.partials.svg.icons.camera_cross')
                            </li>
                        @endif


                        @if (isset($userTalks['is_anonymous_allowed']))

                            @if ($userTalks['is_anonymous_allowed'] == 1)
                                <li>|</li>
                                <li>
                                    @include('frontend.partials.svg.icons.anonymous')
                                </li>
                            @endif

                        @endif

                    </ul>
                </div>
            </div>

        </div>


        @php
            $uRevies = $userTalks['reviews'] ?? $userTalks['total_reviews'];
        @endphp
        <div>
            <div class="df profesorNameSpan">

                @include('frontend.partials.components.rating_stars', [
                    'ratings' =>
                        (float) $userTalks['ratings'] / ($uRevies != 0 ? $uRevies : 1),
                ])

                <strong class="courseRating mr8 colorBlack fs14">
                    {{ number_format((float) $userTalks['ratings'] / ($uRevies != 0 ? $uRevies : 1), 2, '.', ' ') }}
                </strong>
            </div>

            <div class="df">
                <span class="courseReviews tdu o07">

                    {{ $uRevies }}
                    @if ($uRevies > 1)
                        {{ strtolower(__('REVIEWS')) }}
                    @elseif ($uRevies == 0)
                        {{ strtolower(__('REVIEWS')) }} @else{{ strtolower(__('REVIEW')) }}
                    @endif
                </span>
            </div>

        </div>

        <div class="df aic jcc posrelative orange_price_profile mla">
            <span class="cwhite fw600 fs24 pcppi"><span class="fs14 pcpi">€</span>
                {{ explode('.', $userTalks['price'])[0] }}<span
                    class="fs14 pcpi">.{{ explode('.', $userTalks['price'])[1] }}</span> </span>
            <div class="arrow_right_profile_price">
                @include('frontend.partials.svg.icons.arrow_right_white')
            </div>
        </div>
    </a>
</div>
