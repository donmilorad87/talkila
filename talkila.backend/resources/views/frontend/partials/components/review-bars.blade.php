<div class="cell large-6 ratingS">
    <div class="grid-x align-middle progress-star" data-rating="{{$pointer}}" data-id="5" data-total="{{ $teacherFeedback['stars_feedback']['five_stars'] ?? 0 }}">
        <div class="cell small-2">
            <span class="small">5 {{ __('PROFILE_STAR') }}</span>
        </div>
        <div class="cell small-8">
            <div class="warning progress no-margin">
                @if(!empty($teacherFeedback['stars_feedback']))
                    <div class="progress-meter" style="width: {{ ($teacherFeedback['stars_feedback']['five_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100 }}%"></div>
                @endif
            </div>
        </div>
        <div class="cell small-2 text-right">
            <strong class="small black">
                {{isset($teacherFeedback['stars_feedback']['five_stars']) ? $teacherFeedback['stars_feedback']['five_stars'] : 0}}
            </strong>
        </div>
    </div>
    <div class="grid-x align-middle progress-star" data-rating="{{$pointer}}" data-id="4" data-total="{{ $teacherFeedback['stars_feedback']['four_stars'] ?? 0 }}">
        <div class="cell small-2">
            <span class="small">4 {{ __('PROFILE_STAR') }}</span>
        </div>
        <div class="cell small-8">
            <div class="warning progress no-margin">
                @if(!empty($teacherFeedback['stars_feedback']))
                    <div class="progress-meter" style="width: {{ ($teacherFeedback['stars_feedback']['four_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100  }}%"></div>
                @endif
            </div>
        </div>
        <div class="cell small-2 text-right">
            <strong class="small black">
                {{isset($teacherFeedback['stars_feedback']['four_stars']) ? $teacherFeedback['stars_feedback']['four_stars'] : 0}}
            </strong>
        </div>
    </div>
    <div class="grid-x align-middle progress-star" data-rating="{{$pointer}}" data-id="3" data-total="{{ $teacherFeedback['stars_feedback']['three_stars'] ?? 0 }}">
        <div class="cell small-2">
            <span class="small">3 {{ __('PROFILE_STAR') }}</span>
        </div>
        <div class="cell small-8">
            <div class="warning progress no-margin">
                @if(!empty($teacherFeedback['stars_feedback']))
                    <div class="progress-meter" style="width: {{ ($teacherFeedback['stars_feedback']['three_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100 }}%"></div>
                @endif
            </div>
        </div>
        <div class="cell small-2 text-right">
            <strong class="small black">
                {{isset($teacherFeedback['stars_feedback']['three_stars']) ? $teacherFeedback['stars_feedback']['three_stars'] : 0}}
            </strong>
        </div>
    </div>
    <div class="grid-x align-middle progress-star" data-rating="{{$pointer}}" data-id="2" data-total="{{ $teacherFeedback['stars_feedback']['two_stars'] ?? 0 }}">
        <div class="cell small-2">
            <span class="small">2 {{ __('PROFILE_STAR') }}</span>
        </div>
        <div class="cell small-8">
            <div class="warning progress no-margin">
                @if(!empty($teacherFeedback['stars_feedback']))
                    <div class="progress-meter" style="width: {{ ($teacherFeedback['stars_feedback']['two_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100 }}%"></div>
                @endif
            </div>
        </div>
        <div class="cell small-2 text-right">
            <strong class="small black">
                {{isset($teacherFeedback['stars_feedback']['two_stars']) ? $teacherFeedback['stars_feedback']['two_stars'] : 0}}
            </strong>
        </div>
    </div>
    <div class="grid-x align-middle progress-star" data-rating="{{$pointer}}" data-id="1" data-total="{{ $teacherFeedback['stars_feedback']['one_stars'] ?? 0 }}">
        <div class="cell small-2">
            <span class="small">1 {{ __('PROFILE_STAR') }}</span>
        </div>
        <div class="cell small-8">
            <div class="warning progress no-margin">
                @if(!empty($teacherFeedback['stars_feedback']))
                    <div class="progress-meter" style="width: {{ ($teacherFeedback['stars_feedback']['one_stars'] / $teacherFeedback['stars_feedback']['totalReviews']) * 100 }}%"></div>
                @endif
            </div>
        </div>
        <div class="cell small-2 text-right">
            <strong class="small black">
                {{isset($teacherFeedback['stars_feedback']['one_stars']) ? $teacherFeedback['stars_feedback']['one_stars'] : 0}}
            </strong>
        </div>
    </div>
</div>
