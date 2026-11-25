@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="grid-container grid-x h-100">

        <div class="hide-for-medium2 w-100">
            <div class="posrelative w-100 cblack fw600 tac pt16">
                <a href="/" class="cblack backToHome">
                    @include('frontend.partials.svg.icons.arrow-left-blue')
                    @lang('BACK_TO_LOGGED')
                </a>
            </div>

        </div>



        <div class="cell medium-5 bg-grey lLW hide-for-small lleft posrelative">
            @include('frontend.partials.components.back-to-home', [
                'back_text' => __('BACK_TO_LOGGED'),
                'back_url' => '/',
            ])
            <div class="welcome-steps-wrap">
                <div class="text-center start-main-wrap">
                    <img width="300" src="{{ asset('frontend/assets/img/mobile-join-club.png') }}" alt="user" />

                </div>
            </div>
        </div>
        <div class="cell small-12 medium-7 oya h-100 padResJtcWel">
            @if (!$user->jtc?->jtc_started)
                <div class="w-80 mauto posrelative" id="jtcWelcomeSteps1">
                    <div id="jtcCarousel" class="owl-carousel owl-theme ovh">
                        <div class="innerJTCItem">
                            <div class="overImg2">
                                <img src="{{ asset('/assets/images/jtc_first_exp_1.png') }}" alt="">
                            </div>

                            <h5>@lang('SLIDE_1_TITLE_JTC_FIRST_TIME')</h5>
                            <p>@lang('SLIDE_1_TEXT_JTC_FIRST_TIME')</p>
                        </div>
                        <div class="innerJTCItem">
                            <div class="overImg">
                                <img src="{{ asset('/assets/images/jtc_first_exp_2.png') }}" alt="">
                            </div>
                            <h5>@lang('SLIDE_2_TITLE_JTC_FIRST_TIME')</h5>
                            <p>@lang('SLIDE_2_TEXT_JTC_FIRST_TIME')</p>
                        </div>
                        <div class="innerJTCItem">
                            <div class="overImg2">
                                <img src="{{ asset('/assets/images/jtc_first_exp_3.png') }}" alt="">
                            </div>
                            <h5>@lang('SLIDE_3_TITLE_JTC_FIRST_TIME')</h5>
                            <p>@lang('SLIDE_3_TEXT_JTC_FIRST_TIME')</p>
                        </div>
                    </div>
                    <pre id="counter" class="fw600"></pre>
                    <button class="nextCarousel" style="display: none">
                        @include('frontend.partials.svg.icons.arrow_right_blue')
                    </button>
                    <button class="blueButton w-100" id="getStartedJtc" style="display: none">
                        @lang('GET_STARTED')
                    </button>
                </div>
            @endif


        </div>

    </div>

@endsection
