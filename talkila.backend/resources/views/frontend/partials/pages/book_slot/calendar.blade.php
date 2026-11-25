@if ($newTeacherAvailability)
    <div id="calendar">
        <h5 class="hide-for-small-only">{{ __('CALENDAR_SELECT_DATE') }}</h5>
        <section class="cell small-12 w-100 fl gropings oh">
            <div class="">
                <div class="grid-x">

                    <div class="small-12">

                        <div class="mb16">
                            @include('frontend.partials.pages.booking.booking-calendar-2')
                            @include('frontend.partials.components.seven-days-calendar')


                        </div>

                    </div>
                </div>
            </div>
        </section>

        <div class="cell large-12">

            <div class="date-wrap-content w-100 fl m0 mb0">
                <div class="button-switch switch d-flex mb0 serpikoSwitch">
                    @if (!empty($calendarsData))<input class="switch-input" id="calendarFunnelHighlightingState" type="checkbox"
                        name="calendarFunnelHighlightingState" checked/>  @endif
                    <div class="posrelative anonim d-flex w-100">
                        <div class="df aic w-100">

                            <p class="posrelative w-100 fl swpl m0 pl14 cblack">
                                @lang('AVAILABLE_TIME')

                            </p>
                        </div>


                    </div>

                    @if (!empty($calendarsData))
                    <div class="cp df" data-popup="connected_calendars">
                        @include('frontend.partials.svg.icons.gear')
                    </div>



                    <label class="ml16 switch-paddle calendarFunnelHighlightingState"
                        data-clicked="1"
                        for="calendarFunnelHighlightingState">

                    </label>
                    @endif
                </div>
            </div>
            <div class="weekly-time">
            </div>
            <div class='desktopingeringz dn'>
                <div class="medium-12 large-12 small-12">
                    <div class="tl-pt-wrap tl-pt-wrap2">


                        <h6>{{ __('EXPECTED_TOTAL') }}</h6>
                        <div class="total-payyout-wprapper d-flex">
                            <div class="ant-title-headding"><b>{{ priceFormater($talkData['price']) }} € x 1
                                    {{ __('TALK') }}</b></div>
                            <div class="title-code"><strong>{{ priceFormater($talkData['price']) }} €</strong></div>
                        </div>
                        <p>{{ __('CALENDAR_CONFIRM_TEXT') }} <a href="/legal/terms-and-conditions"
                                target="_blank">{{ __('TERMS_AND_CONDITIONS') }} </a> @lang('AND')
                            <a href="/legal/privacy-policy" target="_blank">{{ __('FOOTER_LINK_PRIVACY_POLICE') }}.</a>
                        </p>
                        <hr>
                        <div class="w-100 fl dn" id="booking-submit-time2">
                            <div class="cell small-12 large-12">
                                <div class="grid-x grid-padding-x">

                                    @if ($talkData['anonym_call'] === 1)
                                        <div class="medium-6 large-6 small-10">
                                            <h6>{{ __('ANON_TALKS') }}</h6>
                                            <p class="title-tacher">{{ __('CALENDAR_TEXT') }}
                                            <p>
                                        </div>
                                        <div class="medium-6 large-6 small-2 cell">
                                            <div class="date-wrap-content">
                                                <div class="button-switch switch">
                                                    <input class="switch-input" id="exampleSwitch1" type="checkbox"
                                                        name="exampleSwitch">
                                                    <label class="switch-paddle fr" for="exampleSwitch1">
                                                        <span class="show-for-sr">{{ __('DOWNLOAD_KITTENS') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        @if (!auth()->user()->id)
                            <a class="btn mb-none cp fl bkpm" id="booking-payment"
                                data-popup="addBookingLoginPopup">{{ __('BOOK_NOW') }}</a>
                        @else
                            @if (!empty($booking_id))
                                <span class="btn mb-none fl bkpm" id="booking-payment"
                                    data-popup="addBookingPostpone">
                                    @if ($booking_postpone_pointer !== 0)
                                        {{ __('POSTPONE') }}
                                    @else
                                        {{ __('BOOK_NOW') }}
                                    @endif
                                </span>
                            @else

                                <span class="btn mb-none fl bkpm df aic jusb" id="booking-payment">
                                    {{ __('BOOK_NOW') }}
                                    <span class="hideForSmalls">{{ priceFormater($talkData['price']) }}</span>
                                    @include('frontend.partials.svg.icons.arrow_right2')
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@else
    <h2>@lang('SUPPLIER_DO_NOT_HAVE_AVAILABLE_TIMESLOTS')</h2>

@endif
