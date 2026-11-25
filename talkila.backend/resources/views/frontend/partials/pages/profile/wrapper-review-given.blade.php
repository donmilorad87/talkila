<div class="wrapper-review">

    <div class="inner-review">
        <div class="review-left mr8">

            {{-- <div>
                <h5 class="titleRating">{{ $userData['name'] }}'s {{ __('PROFILE_RATING_AND_FEEDBACK') }}</h5>
            </div> --}}

            @php
                $totalRatings = $teacherFeedbackGiven['stars_feedback']['totalRatings'] ?? 0;
                $totalReviews = $teacherFeedbackGiven['stars_feedback']['totalReviews'] ?? 0;
            @endphp

            <div class="grid-x align-middle mb32">
                <div class="cell large-6">

                    <p class="rating-box no-margin allRating df aic" id="allRating" data-pointer="2">

                        <span class="rating-big" id="ratingBigGiven">{{ $totalRatings > 0 ? round($totalRatings / $totalReviews, 1) : 0 }}</span>

                        @include('frontend.partials.svg.icons.book-star')
                    </p>

                    <h6>{{ __('PROFILE_ALL_STAR_RATING') }}</h6>

                    <p class="small">
                        <span id="totalRatingsGiven">{{ $totalRatings }}</span>
                        {{ __('PROFILE_RATINGS_AND') }}
                        <span id="totalReviewsGiven">{{ $totalReviews }}</span>
                        @lang('REVIEWS_SMALL_LETTER')
                    </p>

                </div>

                <div class="cell large-6 ratingS">
                    <div class="grid-x align-middle progress-star" data-rating="2" data-id="5" data-total="{{ $teacherFeedbackGiven['stars_feedback']['five_stars'] ?? 0 }}">
                        <div class="cell small-2">
                            <span class="small">5 {{ __('PROFILE_STAR') }}</span>
                        </div>
                        <div class="cell small-8">
                            <div class="warning progress no-margin">
                                @if(!empty($teacherFeedbackGiven['stars_feedback']))
                                    <div class="progress-meter" style="width: {{ ($teacherFeedbackGiven['stars_feedback']['five_stars'] / $teacherFeedbackGiven['stars_feedback']['totalReviews']) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                        <div class="cell small-2 text-right">
                            <strong class="small black">
                                {{isset($teacherFeedbackGiven['stars_feedback']['five_stars']) ? $teacherFeedbackGiven['stars_feedback']['five_stars'] : 0}}
                            </strong>
                        </div>
                    </div>
                    <div class="grid-x align-middle progress-star" data-rating="2" data-id="4" data-total="{{ $teacherFeedbackGiven['stars_feedback']['four_stars'] ?? 0 }}">
                        <div class="cell small-2">
                            <span class="small">4 {{ __('PROFILE_STAR') }}</span>
                        </div>
                        <div class="cell small-8">
                            <div class="warning progress no-margin">
                                @if(!empty($teacherFeedbackGiven['stars_feedback']))
                                    <div class="progress-meter" style="width: {{ ($teacherFeedbackGiven['stars_feedback']['four_stars'] / $teacherFeedbackGiven['stars_feedback']['totalReviews']) * 100  }}%"></div>
                                @endif
                            </div>
                        </div>
                        <div class="cell small-2 text-right">
                            <strong class="small black">
                                {{isset($teacherFeedbackGiven['stars_feedback']['four_stars']) ? $teacherFeedbackGiven['stars_feedback']['four_stars'] : 0}}
                            </strong>
                        </div>
                    </div>
                    <div class="grid-x align-middle progress-star" data-rating="2" data-id="3" data-total="{{ $teacherFeedbackGiven['stars_feedback']['three_stars'] ?? 0 }}">
                        <div class="cell small-2">
                            <span class="small">3 {{ __('PROFILE_STAR') }}</span>
                        </div>
                        <div class="cell small-8">
                            <div class="warning progress no-margin">
                                @if(!empty($teacherFeedbackGiven['stars_feedback']))
                                    <div class="progress-meter" style="width: {{ ($teacherFeedbackGiven['stars_feedback']['three_stars'] / $teacherFeedbackGiven['stars_feedback']['totalReviews']) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                        <div class="cell small-2 text-right">
                            <strong class="small black">
                                {{isset($teacherFeedbackGiven['stars_feedback']['three_stars']) ? $teacherFeedbackGiven['stars_feedback']['three_stars'] : 0}}
                            </strong>
                        </div>
                    </div>
                    <div class="grid-x align-middle progress-star" data-rating="2" data-id="2" data-total="{{ $teacherFeedbackGiven['stars_feedback']['two_stars'] ?? 0 }}">
                        <div class="cell small-2">
                            <span class="small">2 {{ __('PROFILE_STAR') }}</span>
                        </div>
                        <div class="cell small-8">
                            <div class="warning progress no-margin">
                                @if(!empty($teacherFeedbackGiven['stars_feedback']))
                                    <div class="progress-meter" style="width: {{ ($teacherFeedbackGiven['stars_feedback']['two_stars'] / $teacherFeedbackGiven['stars_feedback']['totalReviews']) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                        <div class="cell small-2 text-right">
                            <strong class="small black">
                                {{isset($teacherFeedbackGiven['stars_feedback']['two_stars']) ? $teacherFeedbackGiven['stars_feedback']['two_stars'] : 0}}
                            </strong>
                        </div>
                    </div>
                    <div class="grid-x align-middle progress-star" data-rating="2" data-id="1" data-total="{{ $teacherFeedbackGiven['stars_feedback']['one_stars'] ?? 0 }}">
                        <div class="cell small-2">
                            <span class="small">1 {{ __('PROFILE_STAR') }}</span>
                        </div>
                        <div class="cell small-8">
                            <div class="warning progress no-margin">
                                @if(!empty($teacherFeedbackGiven['stars_feedback']))
                                    <div class="progress-meter" style="width: {{ ($teacherFeedbackGiven['stars_feedback']['one_stars'] / $teacherFeedbackGiven['stars_feedback']['totalReviews']) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                        <div class="cell small-2 text-right">
                            <strong class="small black">
                                {{isset($teacherFeedbackGiven['stars_feedback']['one_stars']) ? $teacherFeedbackGiven['stars_feedback']['one_stars'] : 0}}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="review-right">

            <div class="no-found-heading dn" id="bookingNoFoundGiven">
                <div>
                    <img src="/frontend/assets/img/taxi-waiting.png" alt="Nothing Found">
                    <h6 class="w-100">@lang('NO_REVIEW')</h6>
                </div>
            </div>

            <div class="feedback-comments" id="givenComentsFalback">
                {!! $feedbackGivenComments !!}
            </div>
            <br/>

            <div class="pl0 pr0 w-100">

                <div class="tac">
                    <button class="btn hollow seeMores @if($numberOfGivenComments <= 2) dn @endif" id="showMoresGiven" data-reviews="2" data-type="1">
                        {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
