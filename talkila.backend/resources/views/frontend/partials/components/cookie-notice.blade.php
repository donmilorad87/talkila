@php
    $subscribed = false;
    if (isset($_COOKIE['allow_cookies']) && !empty($_COOKIE['allow_cookies'])) {
        $subscribed = true;
    }
@endphp

<div class="zi999 acceptedCookieContainer @if ($subscribed) accepted @endif" id="acceptedCookieClosed">
    @include('frontend.partials.svg.icons.cookie')
</div>
<div class="zi998 grid-container" id="cookieCont">
    <div class="callout callout-wrapper acceptedCookie @if ($subscribed) accepted @endif" data-closable
        id="cookieMainCont">
        <div class="learn-btn allow-btn">
            <div class="cookies-body f5">@include('frontend.partials.svg.icons.cookie') {{ __('COOKIES_TEXT') }}
            </div>
            <div class="df f2 aic jcc">
                <a class="btn hollow small mr8 cp" data-popup="cookieOptions" id="" aria-label="Dismiss alert"
                    data-close>
                    {{ __('OPTIONS') }}
                </a>
                <a class="btn small mr8" id="cookieAllowAll" aria-label="Dismiss alert" data-close>
                    {{ __('COOKIES_BUTTON_TEXT_2') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="popupBase closeAllSuboptions" id="cookieOptions" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            <div class="d-flex step steperko caki CVHeading">
                <span class="zi999 cpointer closeCookie df closeSubOptions closeAllSuboptions"
                    data-close-popup='cookieOptions'>
                    @include('frontend.partials.svg.icons.arrow-left')
                </span>

                <div class="tac fw add-time-title">@lang('COOKIE_OPTIONS')</div>



            </div>


            <div class="grid-x">
                <p class="small-12 mb24"> @lang('CHOSE_COOKIE_DESCRIPTION') </p>

                <div class="small-12">
                    <div>

                        <div class="grid-x grid-margin-x">

                            <div class="date-wrap-content w-100 p16">

                                <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                    <input class="switch-input" id="cookieNecessary" type="checkbox"
                                        name="cookieNecessary" checked disabled>
                                    <div class="posrelative anonim d-flex clickLabel">

                                        <p class="ml0 posrelative">
                                            {{ __('NECESSARY') }}
                                        </p>
                                    </div>

                                    <svg class="mla mr0dot5rem cookieSubOptionsOpen" data-property="necessary"
                                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.66669 10.0003C1.66669 14.6027 5.39765 18.3337 10 18.3337C14.6024 18.3337 18.3334 14.6027 18.3334 10.0003C18.3334 5.39795 14.6024 1.66699 10 1.66699C5.39765 1.66699 1.66669 5.39795 1.66669 10.0003ZM16.8182 10.0004C16.8182 13.7659 13.7656 16.8185 10 16.8185C6.23447 16.8185 3.18186 13.7659 3.18186 10.0004C3.18186 6.23477 6.23447 3.18217 10 3.18217C13.7656 3.18217 16.8182 6.23477 16.8182 10.0004ZM10.0003 13.787C10.4188 13.787 10.7581 13.4479 10.7581 13.0295C10.7581 12.6111 10.4188 12.2719 10.0003 12.2719C9.58172 12.2719 9.24243 12.6111 9.24243 13.0295C9.24243 13.4479 9.58172 13.787 10.0003 13.787ZM9.24239 11.5153H10.7575C10.7575 10.9105 10.8526 10.7997 11.4751 10.4884C12.5571 9.94738 13.0303 9.39535 13.0303 8.10623C13.0303 6.45519 11.7305 5.45471 9.99997 5.45471C8.32638 5.45471 6.96967 6.81142 6.96967 8.48501H8.48482C8.48482 7.64822 9.16317 6.96986 9.99997 6.96986C10.9675 6.96986 11.5151 7.39138 11.5151 8.10623C11.5151 8.71104 11.4201 8.82189 10.7975 9.13318C9.71556 9.67416 9.24239 10.2262 9.24239 11.5153Z"
                                            fill="#172B4D"></path>
                                    </svg>

                                    <label class="switch-paddle" for="cookieNecessary">

                                    </label>

                                </div>

                                <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                    <input class="switch-input mainCookieInput mainCookieSwitchChange"
                                        id="cookieMarketing" type="checkbox" name="cookieMarketing" checked
                                        data-property="marketing">
                                    <div class="posrelative anonim d-flex clickLabel">

                                        <p class="ml0 posrelative">
                                            {{ __('MARKETING') }}
                                        </p>
                                    </div>

                                    <svg class="mla mr0dot5rem cookieSubOptionsOpen" data-property="marketing"
                                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.66669 10.0003C1.66669 14.6027 5.39765 18.3337 10 18.3337C14.6024 18.3337 18.3334 14.6027 18.3334 10.0003C18.3334 5.39795 14.6024 1.66699 10 1.66699C5.39765 1.66699 1.66669 5.39795 1.66669 10.0003ZM16.8182 10.0004C16.8182 13.7659 13.7656 16.8185 10 16.8185C6.23447 16.8185 3.18186 13.7659 3.18186 10.0004C3.18186 6.23477 6.23447 3.18217 10 3.18217C13.7656 3.18217 16.8182 6.23477 16.8182 10.0004ZM10.0003 13.787C10.4188 13.787 10.7581 13.4479 10.7581 13.0295C10.7581 12.6111 10.4188 12.2719 10.0003 12.2719C9.58172 12.2719 9.24243 12.6111 9.24243 13.0295C9.24243 13.4479 9.58172 13.787 10.0003 13.787ZM9.24239 11.5153H10.7575C10.7575 10.9105 10.8526 10.7997 11.4751 10.4884C12.5571 9.94738 13.0303 9.39535 13.0303 8.10623C13.0303 6.45519 11.7305 5.45471 9.99997 5.45471C8.32638 5.45471 6.96967 6.81142 6.96967 8.48501H8.48482C8.48482 7.64822 9.16317 6.96986 9.99997 6.96986C10.9675 6.96986 11.5151 7.39138 11.5151 8.10623C11.5151 8.71104 11.4201 8.82189 10.7975 9.13318C9.71556 9.67416 9.24239 10.2262 9.24239 11.5153Z"
                                            fill="#172B4D"></path>
                                    </svg>

                                    <label class="switch-paddle" for="cookieMarketing">

                                    </label>

                                </div>

                                <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                    <input class="switch-input mainCookieInput mainCookieSwitchChange"
                                        id="cookieStatistic" type="checkbox" name="cookieStatistic" checked
                                        data-property="statistics">
                                    <div class="posrelative anonim d-flex clickLabel">

                                        <p class="ml0 posrelative">
                                            {{ __('STATISTICS') }}
                                        </p>
                                    </div>

                                    <svg class="mla mr0dot5rem cookieSubOptionsOpen" data-property="statistics"
                                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.66669 10.0003C1.66669 14.6027 5.39765 18.3337 10 18.3337C14.6024 18.3337 18.3334 14.6027 18.3334 10.0003C18.3334 5.39795 14.6024 1.66699 10 1.66699C5.39765 1.66699 1.66669 5.39795 1.66669 10.0003ZM16.8182 10.0004C16.8182 13.7659 13.7656 16.8185 10 16.8185C6.23447 16.8185 3.18186 13.7659 3.18186 10.0004C3.18186 6.23477 6.23447 3.18217 10 3.18217C13.7656 3.18217 16.8182 6.23477 16.8182 10.0004ZM10.0003 13.787C10.4188 13.787 10.7581 13.4479 10.7581 13.0295C10.7581 12.6111 10.4188 12.2719 10.0003 12.2719C9.58172 12.2719 9.24243 12.6111 9.24243 13.0295C9.24243 13.4479 9.58172 13.787 10.0003 13.787ZM9.24239 11.5153H10.7575C10.7575 10.9105 10.8526 10.7997 11.4751 10.4884C12.5571 9.94738 13.0303 9.39535 13.0303 8.10623C13.0303 6.45519 11.7305 5.45471 9.99997 5.45471C8.32638 5.45471 6.96967 6.81142 6.96967 8.48501H8.48482C8.48482 7.64822 9.16317 6.96986 9.99997 6.96986C10.9675 6.96986 11.5151 7.39138 11.5151 8.10623C11.5151 8.71104 11.4201 8.82189 10.7975 9.13318C9.71556 9.67416 9.24239 10.2262 9.24239 11.5153Z"
                                            fill="#172B4D"></path>
                                    </svg>

                                    <label class="switch-paddle" for="cookieStatistic">

                                    </label>

                                </div>

                                <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                    <input class="switch-input mainCookieInput mainCookieSwitchChange"
                                        id="cookiePreferances" type="checkbox" name="cookiePreferances" checked
                                        data-property="preferances">
                                    <div class="posrelative anonim d-flex clickLabel">

                                        <p class="ml0 posrelative">
                                            {{ __('PREFERANCES') }}
                                        </p>
                                    </div>

                                    <svg class="mla mr0dot5rem cookieSubOptionsOpen" data-property="preferances"
                                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.66669 10.0003C1.66669 14.6027 5.39765 18.3337 10 18.3337C14.6024 18.3337 18.3334 14.6027 18.3334 10.0003C18.3334 5.39795 14.6024 1.66699 10 1.66699C5.39765 1.66699 1.66669 5.39795 1.66669 10.0003ZM16.8182 10.0004C16.8182 13.7659 13.7656 16.8185 10 16.8185C6.23447 16.8185 3.18186 13.7659 3.18186 10.0004C3.18186 6.23477 6.23447 3.18217 10 3.18217C13.7656 3.18217 16.8182 6.23477 16.8182 10.0004ZM10.0003 13.787C10.4188 13.787 10.7581 13.4479 10.7581 13.0295C10.7581 12.6111 10.4188 12.2719 10.0003 12.2719C9.58172 12.2719 9.24243 12.6111 9.24243 13.0295C9.24243 13.4479 9.58172 13.787 10.0003 13.787ZM9.24239 11.5153H10.7575C10.7575 10.9105 10.8526 10.7997 11.4751 10.4884C12.5571 9.94738 13.0303 9.39535 13.0303 8.10623C13.0303 6.45519 11.7305 5.45471 9.99997 5.45471C8.32638 5.45471 6.96967 6.81142 6.96967 8.48501H8.48482C8.48482 7.64822 9.16317 6.96986 9.99997 6.96986C10.9675 6.96986 11.5151 7.39138 11.5151 8.10623C11.5151 8.71104 11.4201 8.82189 10.7975 9.13318C9.71556 9.67416 9.24239 10.2262 9.24239 11.5153Z"
                                            fill="#172B4D"></path>
                                    </svg>

                                    <label class="switch-paddle" for="cookiePreferances">

                                    </label>

                                </div>

                                <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                    <input class="switch-input mainCookieInput mainCookieSwitchChange"
                                        id="cookieThirdParty" type="checkbox" name="cookieThirdParty" checked
                                        data-property="thirdParty">
                                    <div class="posrelative anonim d-flex clickLabel">

                                        <p class="ml0 posrelative">
                                            {{ __('THIRD_PARTY_SCRIPTS') }}
                                        </p>
                                    </div>

                                    <svg class="mla mr0dot5rem cookieSubOptionsOpen" data-property="thirdParty"
                                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.66669 10.0003C1.66669 14.6027 5.39765 18.3337 10 18.3337C14.6024 18.3337 18.3334 14.6027 18.3334 10.0003C18.3334 5.39795 14.6024 1.66699 10 1.66699C5.39765 1.66699 1.66669 5.39795 1.66669 10.0003ZM16.8182 10.0004C16.8182 13.7659 13.7656 16.8185 10 16.8185C6.23447 16.8185 3.18186 13.7659 3.18186 10.0004C3.18186 6.23477 6.23447 3.18217 10 3.18217C13.7656 3.18217 16.8182 6.23477 16.8182 10.0004ZM10.0003 13.787C10.4188 13.787 10.7581 13.4479 10.7581 13.0295C10.7581 12.6111 10.4188 12.2719 10.0003 12.2719C9.58172 12.2719 9.24243 12.6111 9.24243 13.0295C9.24243 13.4479 9.58172 13.787 10.0003 13.787ZM9.24239 11.5153H10.7575C10.7575 10.9105 10.8526 10.7997 11.4751 10.4884C12.5571 9.94738 13.0303 9.39535 13.0303 8.10623C13.0303 6.45519 11.7305 5.45471 9.99997 5.45471C8.32638 5.45471 6.96967 6.81142 6.96967 8.48501H8.48482C8.48482 7.64822 9.16317 6.96986 9.99997 6.96986C10.9675 6.96986 11.5151 7.39138 11.5151 8.10623C11.5151 8.71104 11.4201 8.82189 10.7975 9.13318C9.71556 9.67416 9.24239 10.2262 9.24239 11.5153Z"
                                            fill="#172B4D"></path>
                                    </svg>

                                    <label class="switch-paddle" for="cookieThirdParty">

                                    </label>

                                </div>

                                <div class="date-wrap-content w-100 cookieSubOptions" data-property="necessary">

                                    <p class="small-12 mb24"> @lang('NECESSARY_COOKIE_DESCRIPTION') </p>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input" id="cookieConsentManager" type="checkbox"
                                            name="cookieConsentManager" checked disabled>
                                        <div class="posrelative d-flex clickLabel">

                                            <div class="posrelative df fdc">
                                                <p class="m0 lh1dot5">
                                                    {{ __('COOKIE_CONSENT_MANAGER') }}
                                                </p>
                                                <p class="m0 lh1dot5">
                                                    ({{ __('NECESSARY') }})
                                                </p>

                                            </div>

                                        </div>



                                        <label class="switch-paddle" for="cookieConsentManager">

                                        </label>

                                    </div>


                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input" id="stripeSDK" type="checkbox" name="stripeSDK"
                                            checked disabled>
                                        <div class="posrelative d-flex clickLabel">

                                            <div class="posrelative df fdc">
                                                <p class="m0 lh1dot5">
                                                    {{ __('STRIPE_SDK') }}
                                                </p>
                                                <p class="m0 lh1dot5">
                                                    ({{ __('NECESSARY_3RD_PARTY_SCRIPT') }})
                                                </p>

                                            </div>

                                        </div>



                                        <label class="switch-paddle" for="stripeSDK">

                                        </label>

                                    </div>


                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input" id="payPalSDK" type="checkbox" name="payPalSDK"
                                            checked disabled>
                                        <div class="posrelative d-flex clickLabel">

                                            <div class="posrelative df fdc">
                                                <p class="m0 lh1dot5">
                                                    {{ __('PAYPAL_SDK') }}
                                                </p>
                                                <p class="m0 lh1dot5">
                                                    ({{ __('NECESSARY_3RD_PARTY_SCRIPT') }})
                                                </p>

                                            </div>

                                        </div>



                                        <label class="switch-paddle" for="payPalSDK">

                                        </label>

                                    </div>

                                    <button class="fr mt16 btn cookieSubButton closeCookieSubOptions">
                                        @lang('BACK')
                                    </button>
                                </div>

                                <div class="date-wrap-content w-100 cookieSubOptions" data-property="marketing">

                                    <p class="small-12 mb24"> @lang('MARKETING_COOKIE_DESCRIPTION') </p>
                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="bingAds"
                                            type="checkbox" name="bingAds" checked data-property="marketing">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('BING_ADS') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="bingAds">

                                        </label>

                                    </div>



                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="googleAds"
                                            type="checkbox" name="googleAds" checked data-property="marketing">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('GOOGLE_ADS') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="googleAds">

                                        </label>

                                    </div>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="googleDoubleClick"
                                            type="checkbox" name="googleDoubleClick" checked
                                            data-property="marketing">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('GOOGLE_DOUBLECLICK') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="googleDoubleClick">

                                        </label>

                                    </div>

                                    <button class="fr mt16 btn cookieSubButton closeCookieSubOptions">
                                        @lang('BACK')
                                    </button>
                                </div>

                                <div class="date-wrap-content w-100 cookieSubOptions" data-property="statistics">

                                    <p class="small-12 mb24"> @lang('STATISTICS_COOKIE_DESCRIPTION') </p>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="googleTagManager"
                                            type="checkbox" name="googleTagManager" checked
                                            data-property="statistics">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('GOOGLE_TAG_MANAGER') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="googleTagManager">

                                        </label>

                                    </div>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="googleAnalytics"
                                            type="checkbox" name="googleAnalytics" checked
                                            data-property="statistics">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('GOOGLE_ANALYTICS') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="googleAnalytics">

                                        </label>

                                    </div>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="hotjarBehaviorAnalyrics"
                                            type="checkbox" name="hotjarBehaviorAnalyrics" checked
                                            data-property="statistics">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('HOTJAR_BEHAVIOR_ANALYTICS') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="hotjarBehaviorAnalyrics">

                                        </label>

                                    </div>

                                    <button class="fr mt16 btn cookieSubButton closeCookieSubOptions">
                                        @lang('BACK')
                                    </button>
                                </div>

                                <div class="date-wrap-content w-100 cookieSubOptions" data-property="preferances">

                                    <p class="small-12 mb24"> @lang('PREFERANCES_COOKIE_DESCRIPTION') </p>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="googleReCaptcha"
                                            type="checkbox" name="googleReCaptcha" checked
                                            data-property="preferances">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('GOOGLE_RECAPTCHA') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="googleReCaptcha">

                                        </label>

                                    </div>



                                    <button class="fr mt16 btn cookieSubButton closeCookieSubOptions">
                                        @lang('BACK')
                                    </button>
                                </div>

                                <div class="date-wrap-content w-100 cookieSubOptions" data-property="thirdParty">

                                    <p class="small-12 mb24"> @lang('THIRD_PARTY_COOKIE_DESCRIPTION') </p>

                                    <div class="button-switch switch switch-re-edit d-flex bb1 pb8 pt8">
                                        <input class="switch-input selectParentCheckbox" id="googleFonts"
                                            type="checkbox" name="googleFonts" checked data-property="thirdParty">
                                        <div class="posrelative d-flex clickLabel">

                                            <p class="ml0 posrelative">
                                                {{ __('GOOGLE_FONTS') }}
                                            </p>

                                        </div>



                                        <label class="switch-paddle" for="googleFonts">

                                        </label>

                                    </div>



                                    <button class="fr mt16 btn cookieSubButton closeCookieSubOptions">
                                        @lang('BACK')
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="flex-content-right mt16">
                        <button class="btn closeAllSuboptions" data-button="saveButton">{{ __('SAVE') }}</button>
                    </div>


                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
