<div class="course-item privateCourseItem">

    <div class="dataTalkId" data-talk-id="{{ $userTalks['id'] }}">
        <div class="icon-sn book-sn-icon gray-bg divPrivTalk0 duration{{ $userTalks['duration'] }}">
            <div class="divPrivTalk">
                <h6>{{ $userTalks['duration'] }}</h6>
                <p>
                    @if ($userTalks['duration'] > 1)
                        {!! __('PROFILE_MINUTES') !!}
                    @else
                        {!! __('PROFILE_MINUTE') !!}
                    @endif
                </p>
            </div>
        </div>
        <div class="heading-slider df gap4 aic">
            <div class="f1">

                <h6 class="boldTalkTalksTAble">{{ $userTalks['headline'] }} </h6>

                @if ($userTalks['total_reviews'])
                    <ul class="reviewStarBox">


                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $userTalks['ratings'])
                                <li>@include('frontend.partials.svg.icons.full-star')</li>
                            @else
                                <li>@include('frontend.partials.svg.icons.zero-star')</li>
                            @endif
                        @endfor
                        <li><span class="small df aic ml4">({{ $userTalks['total_reviews'] }}
                                {{ __('PROFILE_REVIEWS') }})</span></li>




                    </ul>
                @endif




                <div class="social-box">
                    <ul class="df aic">

                        @if ($userTalks['talk_type'] == 1)
                            <li> @include('frontend.partials.svg.icons.phone') {{ __('PROFILE_PHONE') }}</li>
                        @elseif($userTalks['talk_type'] == 2)
                            <li> @include('frontend.partials.svg.icons.video-camera') {{ __('VIDEO_TALK') }}</li>
                        @endif

                        @if (isset($userTalks['is_anonymous_allowed']))
                            @if ($userTalks['is_anonymous_allowed'] == 1)
                                <li> @include('frontend.partials.svg.icons.anonymous')
                                    {{ __('ANONS_ALLOWED') }}</li>
                            @endif

                        @endif


                    </ul>
                </div>
            </div>
            <div class="mla">
                <span class="fw600 cblack fs13 pricing">{{ priceFormater($userTalks['price']) }}</span>
            </div>

        </div>
    </div>
</div>
