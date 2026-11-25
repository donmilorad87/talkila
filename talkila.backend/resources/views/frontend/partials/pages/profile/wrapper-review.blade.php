<div class="wrapper-review">

    <div class="inner-review">
        <div class="review-left mr8">

            {{-- <div>
                <h5 class="titleRating">{{ $userData['name'] }}'s {{ __('PROFILE_RATING_AND_FEEDBACK') }}</h5>
            </div> --}}

            @php
                $totalRatings = $teacherFeedback['stars_feedback']['totalRatings'] ?? 0;
                $totalReviews = $teacherFeedback['stars_feedback']['totalReviews'] ?? 0;
            @endphp

            <div class="grid-x align-middle mb32">
                <div class="cell large-6">

                    <p class="rating-box no-margin allRating df aic" id="allRating" data-pointer="1">

                        <span class="rating-big" id="ratingBigReceived">{{ $totalRatings > 0 ? round($totalRatings / $totalReviews, 1) : 0 }}</span>

                        @include('frontend.partials.svg.icons.book-star')
                    </p>

                    <h6>{{ __('PROFILE_ALL_STAR_RATING') }}</h6>

                    <p class="small">
                        <span id="totalRatingsRecieved">{{ $totalRatings }}</span>
                        {{ __('PROFILE_RATINGS_AND') }}
                        <span id="totalReviewsRecieved">{{ $totalReviews }}</span>
                        @lang('REVIEWS_SMALL_LETTER')
                    </p>

                </div>
                @include('frontend.partials.components.review-bars', ['teacherFeedback' => $teacherFeedback, 'pointer' => $pointer])

            </div>
        </div>

        <div class="review-right">

            <div class="no-found-heading @if ($numberOfComments > 0)dn @endif" id="bookingNoFoundRecieved">
                <div>
                    <img src="/frontend/assets/img/taxi-waiting.png" alt="Nothing Found">
                    <h6 class="w-100">@lang('NO_REVIEW')</h6>
                </div>
            </div>

            <div class="feedback-comments" id="recievedComentsFalback">
                {!! $feedbackComments !!}
            </div>
            <br/>
            <div class="pl0 pr0 w-100">

                <div class="tac">
                    <button class="btn hollow seeMores @if($numberOfComments <= 2) dn @endif" id="showMoresReceived" data-reviews="1" data-type="1">
                        {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
