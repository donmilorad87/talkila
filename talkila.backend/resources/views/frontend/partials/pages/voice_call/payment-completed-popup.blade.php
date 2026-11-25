<div class="popupBase" id="paymentCompletedPopUp">
    <div class="popuper ppR tac">
        <div class="reveal credit-model">
            <div class="show-for-mobile fl w-100 mt18">
                <div class="phoneTopLine"></div>
                <h5>{{__('PAYMENT_COMPLETED')}}!</h5>
                <div class="w-100 fl df jcse mt16">

                    <p class="grayBackgrounder">
                        <span id="extendedTimeZ"></span>
                        {{__('MINUTES_SHORT') . ' ' . __('AVAILABLE')}}
                    </p>

                    <div class="grayBackgrounder df aic">
                        <div class="mr12 df">
                            @include('frontend.partials.svg.icons.white_extend_icon')
                        </div>
                        <span id="finishedPopupTimes">

                        </span>
                    </div>

                </div>
            </div>
            <div class="hide-for-mobile">
                @include(
                    'frontend.partials.pages.video_conference.breadcrumb_extend',
                    ['pointer' => 5]
                )
                <h5 class="add-time-title">@include(
                    'frontend.partials.svg.icons.white-checkmark'
                ){{ __('PAYMENT_COMPLETED') }} </h5>

                <div class="grid-x grid-margin-x w-100">
                    <div class="col-sm-12 large-12 cell">
                        <div class="mobile-call-wrap height-auto">
                            <div class="circle-wrap">
                                <div class="circle-wrap-inner">
                                    <div class="hide-for-mobile">
                                        @include(
                                            'frontend.partials.svg.icons.extended-bg'
                                        )
                                    </div>
                                    <div class="show-for-mobile">
                                        @include(
                                            'frontend.partials.svg.icons.extended-bg2'
                                        )
                                    </div>
                                    <div class="minutes-progress-inner">
                                        <h2 class="h1">+<span class="extend_call_time"></span></h2>
                                        <p>{{ __('PROFILE_MINUTES') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="small-12 label-12 cell">
                        <div class="call-extend-title text-center">
                            <h5>{{ __('TALK_EXTENDED_SUCCESSFULLY') }}</h5>
                            <p>Your call is now extended for <span class="extend_call_time"></span> more minutes. Have
                                fun text here</p>
                        </div>
                    </div>
                </div>
                <button class="pt-completed">

                    @include('frontend.partials.svg.icons.check-verified')

                    {{ __('PAYMENT_COMPLETED') }}

                </button>
                <button class="pt-completed2 w-100">{{ __('CLOSE') }}</button>
            </div>

        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
