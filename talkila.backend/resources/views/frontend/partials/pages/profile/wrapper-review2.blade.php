@if (isset($teacherFeedback) && !empty($teacherFeedback))
    <div class="wrapper-review">
        <h6 class="">{{ __('PROFILE_RATINGS') }}</h6>
        <div class="inner-review">
            <div class="review-left mr8">

                @php
                    $totalRatings = $teacherFeedback['stars_feedback']['totalRatings'] ?? 0;
                    $totalReviews = $teacherFeedback['stars_feedback']['totalReviews'] ?? 0;
                @endphp

                <div class="grid-x align-middle mb32">
                    @if ($teacherFeedback)
                        <div class="cell small-4 allRating" id="allRating">
                            <div class="rating-box no-margin tac">

                                <p class="w-100 m0 rating-big">
                                    {{ $totalRatings > 0 ? number_format((float) ($totalRatings / $totalReviews), 1, '.', '') : 0 }}
                                </p>

                                @include(
                                    'frontend.partials.components.rating_stars_funnel',
                                    [
                                        'ratings' =>
                                            $totalRatings > 0 ? $totalRatings / $totalReviews : 0,
                                    ]
                                )
                            </div>
                            <p class="small smllreviewTextings tac w-100 aic jcc">
                                {{ $totalReviews }} @if ($totalReviews > 1)
                                    {{ __('REVIEWS') }}
                                @else
                                    {{ __('REVIEW') }}
                                @endif
                            </p>

                        </div>

                        <div class="cell small-8 ratingS reviewPosRelCor">
                            <div class="grid-x align-middle progress-star" data-id="5"
                                data-total="{{ $teacherFeedback['stars_feedback']['five_stars'] ?? 0 }}"
                                style="@if ($teacherFeedback['stars_feedback']['five_stars'] == 0) pointer-events:none; @else pointer-events:all; @endif">
                                <div class="cell small-1 tal">
                                    <span class="small">5</span>
                                </div>
                                <div class="cell small-10 pt9">
                                    <div class="warning progress no-margin">
                                        @if (!empty($teacherFeedback['stars_feedback']))
                                            <div class="progress-meter"
                                                style="width: {{ ($teacherFeedback['stars_feedback']['five_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) *100 }}%">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="cell small-1 tar text-right">
                                    <strong class="small black">
                                        {{ isset($teacherFeedback['stars_feedback']['five_stars'])? $teacherFeedback['stars_feedback']['five_stars']: 0 }}
                                    </strong>
                                </div>
                            </div>
                            <div class="grid-x align-middle progress-star" data-id="4"
                                data-total="{{ $teacherFeedback['stars_feedback']['four_stars'] ?? 0 }}"
                                style="@if ($teacherFeedback['stars_feedback']['four_stars'] == 0) pointer-events:none; @else pointer-events:all; @endif">
                                <div class="cell small-1 tal">
                                    <span class="small">4</span>
                                </div>
                                <div class="cell small-10 pt9">
                                    <div class="warning progress no-margin">
                                        @if (!empty($teacherFeedback['stars_feedback']))
                                            <div class="progress-meter"
                                                style="width: {{ ($teacherFeedback['stars_feedback']['four_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) *100 }}%">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="cell small-1 tar text-right">
                                    <strong class="small black">
                                        {{ isset($teacherFeedback['stars_feedback']['four_stars'])? $teacherFeedback['stars_feedback']['four_stars']: 0 }}
                                    </strong>
                                </div>
                            </div>
                            <div class="grid-x align-middle progress-star" data-id="3"
                                data-total="{{ $teacherFeedback['stars_feedback']['three_stars'] ?? 0 }}"
                                style="@if ($teacherFeedback['stars_feedback']['three_stars'] == 0) pointer-events:none; @else pointer-events:all; @endif">
                                <div class="cell small-1 tal">
                                    <span class="small">3</span>
                                </div>
                                <div class="cell small-10 pt9">
                                    <div class="warning progress no-margin">
                                        @if (!empty($teacherFeedback['stars_feedback']))
                                            <div class="progress-meter"
                                                style="width: {{ ($teacherFeedback['stars_feedback']['three_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) *100 }}%">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="cell small-1 tar text-right">
                                    <strong class="small black">
                                        {{ isset($teacherFeedback['stars_feedback']['three_stars'])? $teacherFeedback['stars_feedback']['three_stars']: 0 }}
                                    </strong>
                                </div>
                            </div>
                            <div class="grid-x align-middle progress-star" data-id="2"
                                data-total="{{ $teacherFeedback['stars_feedback']['two_stars'] ?? 0 }}"
                                style="@if ($teacherFeedback['stars_feedback']['two_stars'] == 0) pointer-events:none; @else pointer-events:all; @endif">
                                <div class="cell small-1 tal">
                                    <span class="small">2</span>
                                </div>
                                <div class="cell small-10 pt9">
                                    <div class="warning progress no-margin">
                                        @if (!empty($teacherFeedback['stars_feedback']))
                                            <div class="progress-meter"
                                                style="width: {{ ($teacherFeedback['stars_feedback']['two_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100 }}%">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="cell small-1 tar text-right">
                                    <strong class="small black">
                                        {{ isset($teacherFeedback['stars_feedback']['two_stars']) ? $teacherFeedback['stars_feedback']['two_stars'] : 0 }}
                                    </strong>
                                </div>
                            </div>
                            <div class="grid-x align-middle progress-star" data-id="1"
                                data-total="{{ $teacherFeedback['stars_feedback']['one_stars'] ?? 0 }}"
                                style="@if ($teacherFeedback['stars_feedback']['one_stars'] == 0) pointer-events:none; @else pointer-events:all; @endif">
                                <div class="cell small-1 tal">
                                    <span class="small">1</span>
                                </div>
                                <div class="cell small-10 pt9">
                                    <div class="warning progress no-margin">
                                        @if (!empty($teacherFeedback['stars_feedback']))
                                            <div class="progress-meter"
                                                style="width: {{ ($teacherFeedback['stars_feedback']['one_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100 }}%">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="cell small-1 tar text-right">
                                    <strong class="small black">
                                        {{ isset($teacherFeedback['stars_feedback']['one_stars']) ? $teacherFeedback['stars_feedback']['one_stars'] : 0 }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ route('get_feedback_comments') }}" id="feedbackCommentsUrl">
        <input type="hidden" value="{{ $teacherFeedback['stars_feedback']['five_stars'] ?? 0 }}"
            id="totalFeedbackCount">
        <div class="grid-container grid-x pl0 pr0 w-100">
            <div class="cell small-0 medium-6"></div>
            <div class="cell small-12 medium-6">
                <button class="dn" id="seeMore">
                    {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                </button>
            </div>
        </div>
    </div>
@else
    {{-- <div>
        <img src="/frontend/assets/img/taxi-waiting.png" alt="Nothing Found">
            <h6 class="w-100 tac">{{__('SUPPLIER_NO_REVIEWS')}}</h6>
    </div> --}}
@endif
