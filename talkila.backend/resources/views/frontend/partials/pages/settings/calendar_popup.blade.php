<div class="popupBase" id="calendar_popup" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

        <div class="step-heading-wrap mt52 popupWhiteRounded">


            @include(
                'frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' => __('CONNECT_YOUR_CALENDAR'),
                    'page_back_link' => '/jtc/welcome',
                    'save_button' => '0',

                    'back_popup' => 'calendar_popup',
                    'saveButtonText' => 'saveButtonText',
                ]
            )


            <p class="subTitle">@lang('CONNECT_YOU_CALENDAR_POPUP_TEXT')</p>
            <ul class="menu-bar w-100 fl lsn db">

                <li class="w-100">
                    <a
                    @if (Route::current()->getName() === 'home')
                        href="{{config('app.appUrl')}}/jtc/add/calendar?addCalendarFromHome=fromHome"
                    @else
                        href="https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar.readonly https://www.googleapis.com/auth/calendar.app.created&access_type=offline&include_granted_scopes=true&response_type=code&state=state_parameter_passthrough_value&redirect_uri={{config('services.google.calendar_redirect')}}&client_id={{config('services.google.client_id')}}"
                    @endif
                    >
                        <span class="spanSettingsMobileMenu">
                            <span>
                                <div class="spacerDivSettings">
                                    @include('frontend.partials.svg.icons.google_calendar')
                                </div>


                            </span>

                            @include('frontend.partials.svg.icons.arrow-right')

                        </span>
                    </a>

                </li>

                {{-- <li>
                    <span class="spanSettingsMobileMenu">
                        <span>
                            <div class="spacerDivSettings">
                                @include('frontend.partials.svg.icons.yahoo_icon')
                            </div>
                        </span>

                        @include('frontend.partials.svg.icons.arrow-right')

                    </span>
                </li>
                <li>
                    <span class="spanSettingsMobileMenu">
                        <span>
                            <div class="spacerDivSettings">
                                <img src="{{ asset('/assets/images/icloud-logo 1.png') }}" alt="iCloud" class="iCloudIcon">
                            </div>
                        </span>

                        @include('frontend.partials.svg.icons.arrow-right')

                    </span>
                </li>
                <li>
                    <span class="spanSettingsMobileMenu">
                        <span>
                            <div class="spacerDivSettings">
                                <img src="{{ asset('/assets/images/Outlook_logo_and_wordmark_(2012-2019) 2.png') }}" alt="outlookIcon" class="outlookIcon">
                            </div>

                        </span>

                        @include('frontend.partials.svg.icons.arrow-right')

                    </span>
                </li> --}}



            </ul>


        </div>


        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
