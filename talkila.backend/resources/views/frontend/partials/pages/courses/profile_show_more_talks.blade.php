
@foreach($userPrivateTalks as $userTalk)

    @if($type == 1)
        <div class="course-item privateCourseItem">

            <a data-talk-id="{{ $userTalk['id'] }}" class="dataTalkId jcsb">
                <div class="icon-sn book-sn-icon divPrivTalk0">
                    <div class="divPrivTalk duration{{$userTalk['duration']}}">

                        <div class="df aic">

                            <h6 class="lh1">{{ $userTalk['duration'] }}</h6>
                            <p class="m0">
                                @if ($userTalk['duration'] > 1)
                                    {!! __('PROFILE_MINUTES') !!}
                                @else
                                    {!! __('PROFILE_MINUTE') !!}
                                @endif
                            </p>
                        </div>

                    </div>
                    <div class="profileTalksHeadline">
                        <h6 class="lh1 mb0 pb0">{{ $userTalk['headline'] }}</h6>
                        <div class="social-box">


                                @if ($userTalk['call_type'] === 1)

                                    <li class="mr16">
                                        {{__('PRIVATE_TALK')}}
                                    </li>

                                @else

                                    <li class="mr16">
                                        {{__('GALLERY_TALK')}}
                                    </li>

                                @endif

                                <li> @include('frontend.partials.svg.icons.phone') {{-- {{ __('PROFILE_PHONE') }} --}}</li>
                                <li>|</li>
                                @if($userTalk['talk_type'] == 2)
                                    <li> @include(
                                        'frontend.partials.svg.icons.video-camera'
                                    )</li>

                                @else

                                    <li>
                                        @include('frontend.partials.svg.icons.camera_cross')
                                    </li>
                                @endif

                                @if (isset($userTalk['is_anonymous_allowed']))

                                    @if ($userTalk['is_anonymous_allowed'] == 1)
                                        <li>|</li>
                                        <li> @include(
                                            'frontend.partials.svg.icons.anonymous'
                                        )
                                        {{--     {{ __('ANONS_ALLOWED') }} --}}</li>
                                    @endif

                                @endif

                            </ul>
                        </div>
                    </div>
                </div>

                <div>

                    <div class="df profesorNameSpan">

                        @include('frontend.partials.components.rating_stars',['ratings' => $userTalk['ratings'] ])

                        <strong class="courseRating colorBlack profileStrongStarsText">{{ $userTalk['ratings'] }}</strong>

                    </div>

                    <div class="df">
                        <span class="courseReviews tdu o07">
                            {{ $userTalk['total_reviews'] }}
                            @if ($userTalk['total_reviews'] > 1) {{strtolower(__('REVIEWS')) }}@else{{ strtolower(__('REVIEW'))}}@endif
                        </span>
                    </div>

                </div>

                <div class="df aic jcc posrelative orange_price_profile mla">
                    <span class="cwhite fw600 fs24 pcppi"><span class="fs14 pcpi">€</span> {{ $userTalk['price'] }}<span class="fs14 pcpi">.00</span> </span>

                    <div class="arrow_right_profile_price">
                        @include('frontend.partials.svg.icons.arrow_right_white')
                    </div>

                </div>


            </a>
        </div>

    @endif
@endforeach
