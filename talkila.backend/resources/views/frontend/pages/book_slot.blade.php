@extends('frontend.layouts.frontendlayout')
@section('content')
    <div>
        <input type="hidden" value="{{ $booking_id }}" id="bookingIdForPostpone">


        @include('frontend.partials.pages.jtc.mobile-steps-navigation', [
            'page_title' => __('Book Talk'),
            'page_back_link' => '0',
            'save_button' => '0',
            'talk_name' => $talkData['headline'],
            'addCoins'  => true
        ])

        <div class="container">


            <div class="bookWhiter oh">
                <div class="grid-x">
                    @include('frontend.partials.pages.book_slot.left-container')
                    @include('frontend.partials.pages.book_slot.right-container')
                </div>
            </div>

            <div class='summaryButtonFixedBottom'>
                <div class="medium-12 large-12 small-12">
                    <div class="tl-pt-wrap">

                        <div class="hiddenElementFixedBottom">
                            <h6>{{ __('EXPECTED_TOTAL') }}</h6>
                            <div class="total-payyout-wprapper d-flex">
                                <div class="ant-title-headding"><b>{{ priceFormater($talkData['price']) }} € x 1
                                        {{ __('TALK') }}</b></div>
                                <div class="title-code"><strong>{{ priceFormater($talkData['price']) }} €</strong></div>
                            </div>
                            <p>{{ __('CALENDAR_CONFIRM_TEXT') }} <a href="/legal/terms-and-conditions"
                                    target="_blank">{{ __('TERMS_AND_CONDITIONS') }} </a> {{ __('AND') }}
                                <a href="/legal/privacy-policy" target="_blank">{{ __('FOOTER_LINK_PRIVACY_POLICE') }}.</a>
                            </p>
                            <hr>
                            <div class="w-100 fl dn" id="booking-submit-time">
                                <div class="cell small-12 large-12">
                                    <div class="grid-x grid-padding-x">

                                        @if ($talkData['anonym_call'] === 1)
                                        <div class="bokirna">
                                            <div id="bookingAnonCont" class="bookingAnonCont df aic jcsb">
                                                <div class="df aic">
                                                    <div class="mt16">
                                                        <h6 class="m0">
                                                            {{ __('ANON_TALKS') }}
                                                        </h6>
                                                        <p class="title-tacher m0">
                                                            {{ __('CALENDAR_TEXT') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="h-100 df aic">
                                                    <div class="date-wrap-content">
                                                        <div class="button-switch switch">
                                                            <input class="switch-input" id="anonSwitch" type="checkbox"
                                                                name="anonSwitch">
                                                            <label class="switch-paddle fr" for="anonSwitch">
                                                                <span
                                                                    class="show-for-sr">{{ __('DOWNLOAD_KITTENS') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('popup_section')

    @include('frontend.partials.components.blank_popup')
    @include('frontend.partials.components.book-login-popup')
    @include('frontend.partials.components.callendar_used_slots_popup')

    @if (!empty($calendarsData))
        @include('frontend.partials.pages.settings.connected_callendars')
    @endif

@endsection
