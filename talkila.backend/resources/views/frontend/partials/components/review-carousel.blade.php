<section class="wrapper_customer w-100 fl" id="testimonialSelection">
    <div>


        <div id="testimonialAboutMe" class="owl-carousel testimonialAboutMe">
            @if (isset($reviews) && !empty($reviews))
                @foreach ($reviews as $review)
                    <div class="grid-x p20">
                        <div class="grid-x small-12">
                            <div class="small-12">
                                <div class="df">

                                    <div class="flex4">
                                        <div class="df">
                                            <img class="rountReviewimage" src="{{$review->reviewer->profile_picture}}" alt="{{$review->reviewer->name}}">
                                            <div>
                                                <b class="nameRviewCar">{{$review->reviewer->name}}</b>
                                                <b class="nameRviewCar">{{$review->booking->talk->headline ?? ''}}</b>
                                                <p class="m0">{{Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex2">
                                        <div class="start-icon-inner">
                                            @include('frontend.partials.components.rating_stars',['ratings' => $review->stars_content ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="small-12">
                            <p>{{$review->description}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
