@if (isset($userTalks))
    <div class="course-item privateCourseItem">

        <div data-talk-id="{{ $userTalks['id'] }}" class="dataTalkId">
            <div class="icon-sn book-sn-icon gray-bg divPrivTalk0 duration{{ $userTalks['duration'] }}">
                <div class="divPrivTalk df fdc aic jcc">
                    <h6 class="fs18 cblack fv600 mb0 pb0 talkDurationMinutes">{{ $userTalks['duration'] }}</h6>
                    <p class="fs14 cblack fv600">
                        @if ($userTalks['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>
            </div>
            <div class="heading-slider df g4px fdc">
                <h6 class="w-100 df m0 jcsb"><span class="lefter">{{ $userTalks['headline'] }}</span> </h6>

                @php
                    $uRevies = $userTalks['reviews'] ?? $userTalks['total_reviews'];
                @endphp


                @if ($uRevies > 0)
                    <ul class="coursesStars pt6">

                        <li> @include('frontend.partials.components.rating_stars_affiliate', [
                            'ratings' => $uRevies / ($uRevies != 0 ? $uRevies : 1),
                        ])</li>

                        @if ($uRevies > 0)
                            <li><span class="small">({{ $uRevies }}
                                    {{ __('PROFILE_REVIEWS') }})</span></li>
                        @endif



                    </ul>

                @endif




                <div class="social-box">


                    @include('frontend.partials.components.talk-icons', [
                        'talk_type' => $userTalks['talk_type'],
                        'is_anonymous_allowed' =>
                            Route::current()->getName() === 'jtc2_add_your_first_talk'
                                ? $userTalks['anonym_call']
                                : $userTalks['is_anonymous_allowed'],
                        'call_type' => $userTalks['call_type']
                    ])

                </div>

            </div>
            <div class="mla fs14 fw600 tar minw64px">
                <span class="righter cblack">
                    {{ priceFormater($userTalks['price'], true) }} €</span>
            </div>
        </div>
    </div>
@else
@endif
