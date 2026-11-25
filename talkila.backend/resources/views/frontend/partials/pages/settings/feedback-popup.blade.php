<div class="popupBase" id="feedbackPopUp" data-opened="0">
    <div class="popuper ppR">

        <div class="credit-model feedback-popup">

            <div class="field-logout-wrap">
                <h1 class="add-time-title">{{ __('SEND_YOUR_FEEDBACK') }}</h1>
                <p>{{__('YOUR_FEEDBACK_SUBTITLE')}}</p>
            </div>

            <div class="grid-x text-center">
                <div class="cell small-4 rateApp" data-feedback="0">
                    @include('frontend.partials.svg.icons.meh')
                    <p>{{__('BAD')}}</p>
                </div>
                <div class="cell small-4 rateApp" data-feedback="1">
                    @include('frontend.partials.svg.icons.itsok')
                    <p>{{__('GOOD')}}</p>
                </div>
                <div class="cell small-4 rateApp" data-feedback="2">
                    @include('frontend.partials.svg.icons.iloveit')
                    <p>{{__('I_LOVE_IT')}}</p>
                </div>
            </div>
            <div class="feedback-text">
                <label for="feedbackText">{{__('YOUR_REVIEW')}} ({{__('OPTIONAL')}})</label>
                <input id="feedbackText" type="text" value="" placeholder="{{__('YOUR_REVIEW')}}">
                <button class="btn w-100 db" id="feedbackAppButton">{{ __('SEND_YOUR_FEEDBACK') }}</button>
            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
