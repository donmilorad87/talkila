<section class="wrapper_customer w-100 fl" id="testimonialSelection">
    <div>


        <div id="testimonialAboutMeProfile" class="owl-carousel testimonialAboutMe">
            @if (isset($teacherFeed) && !empty($teacherFeed))
                @foreach ($teacherFeed['feedback_comments'] as $feedback)
                    <div class="grid-x p20 m1 revCarouselItem">
                        <div class="grid-x small-12">

                            <div class="small-12">
                                <div class="df">

                                    <div class="flex4">
                                        <div class="df aic">
                                            @if (isset($feedback['profile_picture']) && !empty($feedback['profile_picture']))
                                                <img class="rountReviewimage" src="{{$feedback['profile_picture']}}" alt="{{$feedback['name']}}">
                                            @else
                                                @include('frontend.partials.svg.icons.no-profile-picture-40')
                                            @endif

                                            <div>

                                                <b class="nameRviewCar">{{$feedback['name']}}</b>

                                                <div class="df aic">
                                                    <div class="df aic lh1 fs14">
                                                        @include('frontend.partials.components.rating_stars',['ratings' => $feedback['stars_content'] ])
                                                        <span class="fw600 cblack">{{sprintf("%.1f", $feedback['stars_content'])}}</span>
                                                    </div>

                                                    <p class="ml10 revMonthsAgo lh1 fs14">{{ \Carbon\Carbon::parse($feedback['created_date'])->diffForHumans()}}</p>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>
                        <div class="small-12">
                            <p class="m0 mt16 fs14 lh20">
                                <b class="nameRviewCar">{{$feedback['headline']}}</b>
                            </p>
                            <p class="m0 fs14 lh20">{{$feedback['description']}}
                            </p>
                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
