<div class="setting-mobile hi">

    <div class="grid-x hi">

        <div class="cell small-12 hi">
            <div class="settingsHeaderMobile">
                @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
                    'page_title' => __('SETTINGS'),
                    'page_back_link' => '0',
                    'save_button' => '1',
                    'zIndex' => 'zi999',
                ])
            </div>

            <div class="cell small-12 p1em pt16">
                <div class="sidebar-menu-wrap zubnjaca">
                    <div class="df aic shader mb4 mt4 nativeShare" id="nativeShare">
                        <div class="mr16 df">
                            @include('frontend.partials.svg.icons.talkila-invite')
                        </div>

                        <p class="m0 mColor"> {{ __('INVITE_FRIENDS_TO_TALKILA') }} </p>
                    </div>
                    <input type="hidden" id="shareTextTalkila" value="@lang('SHARE_YOUR_PROFILE_TEXT')" />
                    <script>
                        if (document.getElementsByClassName('nativeShare')[0]) {

                            let nativeShares = document.getElementsByClassName('nativeShare')

                            for (let i = 0; i < nativeShares.length; i++) {
                                if (!navigator.share) {
                                    nativeShares[i].style.display = 'none';
                                    continue;
                                }

                                const shareData = {
                                    title: 'Talkila',
                                    text: document.getElementById('shareTextTalkila').value,
                                    url: location.origin
                                }

                                // Share must be triggered by "user activation"
                                nativeShares[i].addEventListener('click', async () => {
                                    try {
                                        await navigator.share(shareData)
                                    } catch (err) {
                                        console.log(err)
                                    }
                                })
                            }
                        }
                    </script>
                    <h6>{{ __('PERSONAL_INFO') }}</h6>
                    <ul class="menu-bar">
                        <li class="editPro">
                            <span class="cp" data-popup="profileSettings">
                                <span class="editProSpan">
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-edit-profile')
                                    </div>
                                    {{ __('EDIT_PROFILE') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </span>
                        </li>
                        <li>
                            <span class="cp spanSettingsMobileMenu" data-popup="languagePopUp">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.globe')
                                    </div>
                                    {{ __('LANGUAGES') }}
                                </span>

                                @include('frontend.partials.svg.icons.arrow-right')

                            </span>
                        </li>
                        @if ($user->pendingProfileVerificationRequest)
                            @if ( $user->type === UserRoles::TEACHER && $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved'])
                                <li>
                                    <a href="{{ route('settings_reviews') }}">
                                        <span>
                                            <div class="spacerDivSettings">
                                                @include('frontend.partials.svg.icons.reviews')
                                            </div>
                                            {{ __('FOOTER_LINK_REVIEWS') }}
                                        </span>
                                        @include('frontend.partials.svg.icons.arrow-right')
                                    </a>
                                </li>
                            @endif
                        @else
                        
                        @endif
                       
                        <li>
                            <a href="{{ route('settings_notifications') }}">
                                <span class="editProSpan">
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.reviews')
                                    </div>
                                    {{ __('NOTIFICATIONS') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>
                        {{--    <li>
                            <span class="cp spanSettingsMobileMenu" data-popup="calendar_popup">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.gray_calendar')
                                    </div>
                                    @lang('CONNECT_YOUR_CALENDAR')
                                </span>

                                @include('frontend.partials.svg.icons.arrow-right')

                            </span>
                        </li> --}}
                        <li>
                            <span class="cp spanSettingsMobileMenu" data-popup="connected_calendars">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.gray_calendar')
                                    </div>
                                    @lang('CONNECT_YOUR_CALENDAR')
                                </span>

                                @include('frontend.partials.svg.icons.arrow-right')

                            </span>
                        </li>
                        {{-- <li>
                            <span class="cp spanSettingsMobileMenu" data-popup="social_verify">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.users')
                                    </div>
                                    @lang('SOCIAL_VERIFICATION')
                                </span>

                                @include('frontend.partials.svg.icons.arrow-right')

                            </span>
                        </li> --}}
                    </ul>

                    <h6>{{ __('WALLET') }}</h6>
                    <ul class="menu-bar">
                        <li>
                            <a href="{{ route('settings_wallets') }}">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.wallet')
                                    </div>
                                    {{ __('WALLET') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('settings_transaction_history') }}">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.wallet')
                                    </div>
                                    {{ __('TRANSACTIONS') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>
                    </ul>

                    @if ($user->roles->first()->pivot->role_id === UserRoles::TEACHER || (auth()->user()->jtc && auth()->user()->jtc?->state))
                        <h6>{{ __('PAYMENT') }}</h6>

                        <ul class="menu-bar">

                            @if ($user->roles->first()->pivot->role_id === UserRoles::TEACHER)
                                <li>
                                    <a href="{{ route('settings_payouts_page') }}">
                                        <span>
                                            <div class="spacerDivSettings">
                                                @include('frontend.partials.svg.icons.settings-payout')
                                            </div>
                                            {{ __('PAYOUT') }}
                                        </span>
                                        @include('frontend.partials.svg.icons.arrow-right')
                                    </a>
                                </li>
                            @endif

                            {{-- <li>
                            <a href="{{ route('countryOfResidence') }}">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.billing-address')
                                    </div>
                                    {{ __('COUNTRY_OF_RESIDENCE') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li> --}}
                            @if (auth()->user()->jtc && auth()->user()->jtc?->state)
                                <li>
                                    <a href="{{ route('billing_ingormations') }}">
                                        <span>
                                            <div class="spacerDivSettings">
                                                @include('frontend.partials.svg.icons.billing-address')
                                            </div>
                                            {{ __('BILLING_ADDRESS') }}
                                        </span>
                                        @include('frontend.partials.svg.icons.arrow-right')
                                    </a>
                                </li>


                                <li>
                                    <a href="{{ route('account_verification') }}">
                                        <span>
                                            <div class="spacerDivSettings">
                                                @include('frontend.partials.svg.icons.id_card')
                                            </div>
                                            {{ __('VERIFICATION') }}
                                        </span>
                                        @include('frontend.partials.svg.icons.arrow-right')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif


                    <h6>{{ __('HELP') }}</h6>
                    <ul class="menu-bar">
                        <li>
                            <span class="cp spanSettingsMobileMenu" data-popup="permision_popup">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-privacy')
                                    </div>
                                    {{ __('APP_PERMISSIONS') }}
                                </span>

                                @include('frontend.partials.svg.icons.arrow-right')

                            </span>
                        </li>
                        <li>
                            <span class="spanSettingsMobileMenu" id="showAppFeedbacPopup">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-feedback')
                                    </div>
                                    {{ __('SEND_FEEDBACK') }}
                                </span>

                                @include('frontend.partials.svg.icons.arrow-right')

                            </span>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-faq')
                                    </div>
                                    {{ __('FAQ_HEADLINE_MOBILE') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>
                        <li>
                            <a href="/legal/terms-and-conditions" target="_blank">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-terms')
                                    </div>
                                    {{ __('TERMS_AND_CONDITIONS') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>
                        <li>
                            <a href="/legal/privacy-policy" target="_blank">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-privacy')
                                    </div>
                                    {{ __('FOOTER_LINK_PRIVACY_POLICE') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>

                    </ul>
                    <h6>{{ __('ACCOUNT') }}</h6>
                    <ul class="menu-bar">

                        @if (auth()->user()->visibility === 2)
                            <li class="editPro">
                                <a class="cp" data-popup="privateFollowingPopup">
                                    <span>
                                        <div class="spacerDivSettings">
                                            @include('frontend.partials.svg.icons.id_card')
                                        </div>
                                        {{ __('FAVORITES') }}
                                    </span>
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </a>
                            </li>
                        @endif

                        @if (isset($blockedUsers) && !empty($blockedUsers))
                            <li class="editPro">
                                <a class="cp" data-popup="blockedUsersPopup">
                                    <span>
                                        <div class="spacerDivSettings">
                                            @include('frontend.partials.svg.icons.reviews')
                                        </div>
                                        {{ __('BLOCKED_USERS') }}
                                    </span>
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </a>
                            </li>
                        @endif

                        <li class="editPro">
                            <a class="cp" data-popup="shareProfilePopUp2">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-share')
                                    </div>
                                    {{ __('TELL_A_FRIEND') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <span>
                                    <div class="spacerDivSettings">
                                        @include('frontend.partials.svg.icons.settings-logout')
                                    </div>
                                    {{ __('LOGOUT') }}
                                </span>
                                @include('frontend.partials.svg.icons.arrow-right')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
