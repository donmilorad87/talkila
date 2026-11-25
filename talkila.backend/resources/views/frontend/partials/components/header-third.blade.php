<div class="third_header">
    <div class="container p0">
        <div class="headerArea">
            <div class="logoCont">
                <a class="logoLink" href="/">@include('frontend.partials.svg.icons.favicon')</a>
                <h1 class="page-title">{{ $page_name ?? 'Talkila' }}
                </h1>
            </div>
            @auth
                <div class="loggedInProfileMenu">
                    <div class="dropMenuContainer">
                        <ol class="profile-area2" data-opened="0">
                            <li class="profilAreaLi zi1 cVH pon">
                                <span class="menuIcon2" data-is-open="0">
                                    <div></div>
                                </span>
                            </li>
                            <li class="profilAreaLi zi2 cVH pon">
                                <span class="dn" id="usernameValue">{{ $user->username }}</span>
                                @if (!empty($user->profile_picture) || !empty($user->profile_picture_tmp))
                                    <img id="profile-img" width="32"
                                        src="{{ $user->profile_picture ?? $user->profile_picture_tmp }}"
                                        alt="{{ $user->username }}" />
                                @else
                                    <svg id="profile-img" width="32" height="32" viewBox="0 0 72 72" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="boxShadowedSVG">
                                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0"
                                            y="0" width="72" height="72">
                                            <rect width="72" height="72" rx="36" fill="white"></rect>
                                        </mask>
                                        <g mask="url(#mask0)">

                                            <path fill-rule="evenodd" opacity="0.3" clip-rule="evenodd"
                                                d="M48 36C48 29.3726 42.6274 24 36 24C29.3726 24 24 29.3726 24 36C24 42.6274 29.3726 48 36 48C42.6274 48 48 42.6274 48 36ZM60 63C60 54.99 44.01 51 36 51C27.99 51 12 54.99 12 63V72H60V63Z"
                                                fill="#1d293f"></path>
                                        </g>
                                    </svg>
                                @endif

                                @if (isset($notificationsCount['notificationsCount']) && !empty($notificationsCount['notificationsCount']))
                                    <div class="notificationBadgeHeaderDropdownMenu">
                                        <div>
                                            {{ $notificationsCount['notificationsCount'] }}
                                        </div>

                                    </div>
                                @endif
                                <div id="profile-menuParent" class="pea">
                                    <div class="dropdown-box" id="profile-menu">
                                        <span class="closeDropDownMenu">×</span>


                                        <div class="fl w-100 mb16 zoranPivot df aic">
                                            <div class="fl w-20 tac">

                                                @if (!empty($user->profile_picture) || !empty($user->profile_picture_tmp))
                                                    <img width="64"
                                                        src="{{ $user->profile_picture ?? $user->profile_picture_tmp }}"
                                                        alt="{{ $user->username }}" />
                                                @else
                                                    <svg id="profile-img22" data-opened="0" width="64" height="64"
                                                        viewBox="0 0 72 72" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" class="boxShadowedSVG br50">

                                                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse"
                                                            x="0" y="0" width="72" height="72">
                                                            <rect width="72" height="72" rx="36"
                                                                fill="white"></rect>
                                                        </mask>
                                                        <g mask="url(#mask0)">
                                                            <path fill-rule="evenodd" opacity="0.3" clip-rule="evenodd"
                                                                d="M48 36C48 29.3726 42.6274 24 36 24C29.3726 24 24 29.3726 24 36C24 42.6274 29.3726 48 36 48C42.6274 48 48 42.6274 48 36ZM60 63C60 54.99 44.01 51 36 51C27.99 51 12 54.99 12 63V72H60V63Z"
                                                                fill="#1d293f"></path>
                                                        </g>
                                                    </svg>
                                                @endif

                                            </div>
                                            <div class="fl w-80 pl16">
                                                <a href="/{{ $user->username ?? '' }}"
                                                    class="m0 linkTopProfileDropdown"><strong>{{ $user->name ?? '' }}</strong></a>
                                                <span class="emailSpan">{{ $user->email ?? '' }}</span>
                                                <div class="mt4 fl w-100">
                                                    @include('frontend.partials.components.header-language', ['class' => ''])
                                                </div>
                                            </div>

                                        </div>

                                        <ul class="menu-bar">

                                            <li>
                                                <a href="{{ route('settings_notifications') }}">
                                                    <span class="editProSpan">
                                                        <div
                                                            class="spacerDivSettings  @if (isset($notificationsCount['notificationsCount']) && !empty($notificationsCount['notificationsCount'])) mr6 @endif">
                                                            @if (isset($notificationsCount['notificationsCount']) && !empty($notificationsCount['notificationsCount']))
                                                                @include('frontend.partials.svg.icons.notification-bell')
                                                            @else
                                                                @include('frontend.partials.svg.icons.notification')
                                                            @endif
                                                        </div>

                                                        {{ __('NOTIFICATIONS') }} @if (isset($notificationsCount['notificationsCount']) && !empty($notificationsCount['notificationsCount']))
                                                            <span
                                                                class="grayColor">({{ $notificationsCount['notificationsCount'] }})
                                                            </span>
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('favorites_talks') }}">
                                                    <span class="editProSpan">
                                                        <div class="spacerDivSettings">
                                                            @include('frontend.partials.svg.icons.favorite_heart_dropdown_menu')
                                                        </div>
                                                        {{ __('BOOKMARKS') }}
                                                    </span>

                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('booking') }}">
                                                    <span class="editProSpan">
                                                        <div class="spacerDivSettings">
                                                            @include('frontend.partials.svg.icons.bookings_dropdown_menu')
                                                        </div>
                                                        {{ __('BOOKINGS') }}
                                                    </span>

                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('home') }}">
                                                    <span class="editProSpan">
                                                        <div class="spacerDivSettings">
                                                            @include('frontend.partials.svg.icons.availability_clock_dropdown_menu')
                                                        </div>
                                                        {{ __('AVAILABILITY') }}
                                                    </span>

                                                </a>
                                            </li>

                                        </ul>

                                        <h6 class="mt28 fl w-100">{{ __('ACCOUNT') }}</h6>
                                        <ul class="menu-bar">
                                            <li>
                                                <a href="{{ route('settings_profile') }}">

                                                    <span class="editProSpan">
                                                        <div class="spacerDivSettings">
                                                            @include('frontend.partials.svg.icons.settings_dropdown')
                                                        </div>
                                                        {{ __('SETTINGS') }}
                                                    </span>

                                                </a>
                                            </li>

                                            @if (auth()->user()->username)
                                                <li>
                                                    <div class="cp divInsteadOfA shbt" data-popup="shareProfilePopUp2">
                                                        <span class="editProSpan">
                                                            <div class="spacerDivSettings">
                                                                @include('frontend.partials.svg.icons.settings-share')
                                                            </div>
                                                            <span class="spanFixer ml4">
                                                                {{ __('TELL_A_FRIEND') }}
                                                            </span>

                                                        </span>

                                                    </div>
                                                </li>
                                            @endif

                                            <li>
                                                <a href="{{ route('logout') }}" class="bb0">
                                                    <span class="editProSpan">
                                                        <div class="spacerDivSettings">
                                                            @include('frontend.partials.svg.icons.settings-logout')
                                                        </div>
                                                        {{ __('LOGOUT') }}
                                                    </span>
                                                </a>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ol>

                    </div>
                </div>

                <ul class="thirdHeadereUl">
                    <li>
                        <a @if (Route::current()->getName() == 'booking') class="active" @endif
                            href="{{ route('booking') }}">{{ __('BOOKINGS') }}</a>
                    </li>
                    <li>
                        <a @if (Route::current()->getName() == 'courses') class="active" @endif
                            href="{{ route('courses') }}">{{ __('DISCOVER_TALKS') }}</a>
                    </li>
                    <li>
                        @if ($user->jtc && $user->jtc?->available)
                            <a @if (Route::current()->getName() == 'home') class="active" @endif href="{{ route('home') }}">
                                {{ __('OFFER_TALKS') }}
                            </a>
                        @else
                            <a @if (Route::current()->getName() == 'jtc_welcome') class="active" @endif
                                href="{{ route('jtc_welcome') }}">{{ __('JOIN_THE_CLUB') }}
                            </a>
                        @endif
                    </li>
                    @if (Route::current()->getName() !== 'settings_wallets' &&
                            Route::current()->getName() !== 'book_slot_payment' &&
                            Route::current()->getName() !== 'video_conference')
                        <li class="df aic fdi h74">
                            @auth
                                <a href="{{ route('settings_wallets', ['openAddCoins' => '1']) }}"
                                    class="fdi m0 df aic jcc g4px">
                                    @include('frontend.partials.svg.icons.coins')
                                    <b class="bCoins">{{ priceFormater($user->wallet_balance, true) }}</b>
                                </a>
                            @endauth



                        </li>
                    @endif
                </ul>

            @endauth
        </div>
    </div>
</div>

@auth
    @if (Route::current()->getName() !== 'talk_details')
        @include('frontend.partials.components.share-profile-popup2')
    @endif
@endauth
