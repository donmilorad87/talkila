<div class="setting-tabs">

    @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
        'page_title' => __('BOOKMARKS'),
        'page_back_link' => '0',
        'save_button' => '1',
        'zIndex' => 'zi999',
    ])

    <div class="grid-x">
        <div class="grid-x cell medium-12 favMenuS">
            @include('frontend.partials.components.favorites_menu', [
                'pointer' => __('USERS'),
            ])
        </div>
        <div class="hide-for-medium2 w-100">
            <div class="innerResultsSearch">
                <ul class="menu-bar w-100 thxer">

                    @if (isset($userFavoritesData['users']) && !empty($userFavoritesData['users']))

                        @for ($j = 0; $j < count($userFavoritesData['users']); $j++)
                            @if ($userFavoritesData['users'][$j]['id'] != 1 && $userFavoritesData['users'][$j]['name'] !== 'Admin')
                                <div class="df pBottomItemsSearch">
                                    <a href="/{{ $userFavoritesData['users'][$j]['username'] }}">
                                        <img class="serachImg"
                                            src="{{ $userFavoritesData['users'][$j]['profile_picture'] }}"
                                            alt="{{ $userFavoritesData['users'][$j]['name'] }}">
                                    </a>

                                    <div class="pl16">
                                        <a href="/{{ $userFavoritesData['users'][$j]['username'] }}">
                                            <p class="courseTitleSearch mb4">
                                                {{ $userFavoritesData['users'][$j]['name'] }}
                                            </p>
                                        </a>
                                        <span class="profesorNameSpan">
                                            {{ $userFavoritesData['users'][$j]['profession'] ?? $userFavoritesData['users'][$j]['username'] }}
                                        </span>
                                        <div class="df profesorNameSpan">

                                            @include('frontend.partials.components.rating_stars', [
                                                'ratings' => $userFavoritesData['users'][$j]['rating'],
                                            ])

                                            <strong
                                                class="courseRating mr8 colorBlack">{{ $userFavoritesData['users'][$j]['rating'] }}/5</strong>
                                            <span
                                                class="courseReviews">({{ $userFavoritesData['users'][$j]['total_followers'] }}
                                                {{ __('REVIEWS') }})</span>

                                        </div>

                                        <div class="df">

                                            <div class="iconsSearchItem noselect">
                                                <div class="df">
                                                    <div class="df aic heartSvg" data-device="mobile" data-follow="1"
                                                        data-user="{{ $userFavoritesData['users'][$j]['id'] }}">
                                                        @include('frontend.partials.svg.icons.redHeartFull')
                                                    </div>

                                                    <span class="fw600 cblack fs12 numberF">

                                                        {{ $userFavoritesData['users'][$j]['total_followers'] }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endfor
                    @endif
                </ul>

                <div class="no-found-heading mb32 @if (!empty($userFavoritesData)) dn @endif">
                    <img src="/frontend/assets/img/no-booking-found.png" alt="No Booking Found">
                    <h5>{{ __('NO_FAVORITES_FOUND') }}...</h5>
                </div>


                <div class="buttCont">
                    <div class="cell small-6 medium-4 df jcc">
                        <button
                            class="mb16 mt16 hollow btn favoritesShowMore @if (
                                !empty($userFavoritesData)
                                    ? $userFavoritesData['users_total'] <= config('app.default_favorites_show_more_users')
                                    : true) dn @endif">
                            {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="grid-x small-12 show-for-medium2 desktopContainer" id="Users">

            @if (!empty($userFavoritesData))

                <div class="cell small-12 fl">

                    <div
                        class="w-100 searchContainerMain pointerForFilter bakareza2 white-box-rounded bordersSquareOposite h50px">
                        <div class="w100 fl df breadCrumps w-100 fl specialDesktopPaddings25">
                            <h5>{{ __('MAKE_EVERY_DAY_COUNT_WITH_TALKILA') }}</h5>
                        </div>
                    </div>

                    <div class="bwhite w-100 searchContainerMain bordersSquare" id="containerFavorites">

                        <div class="tabDeskFavUsers show-for-medium2">
                            @if (isset($userFavoritesData['users']) && !empty($userFavoritesData['users']))

                                @foreach ($userFavoritesData['users'] as $item)
                                    @if ($item['id'] != 1 && $item['name'] !== 'Admin')
                                        <div class="fav-item favorites_holder">
                                            <div class="grid-x grid-margin-x aic">
                                                <div class="cell small-12 medium-12 userInfoLeft">


                                                    @include(
                                                        'frontend.partials.components.favorite_item_desktop',
                                                        [
                                                            'userId' => $item['id'] ?? '',
                                                            'imageUrl' => $item['profile_picture'] ?? '',
                                                            'online' => '1',
                                                            'aboutName' => $item['name'] ?? '',
                                                            'username' => $item['username'] ?? '',
                                                            'profession' => $item['profession'] ?? '',
                                                            /* "verified" => "1", */
                                                            'rating' => $item['rating'] ?? 0,
                                                            'folowers' => $item['total_followers'] ?? '',
                                                            'followButton' => '1',
                                                            'favoriteButton' => '1',
                                                        ]
                                                    )


                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="dfc fdc no-found-heading @if (count($userFavoritesData['users']) > 0) dn @endif">
                                <img src="/frontend/assets/img/no-booking-found.png" alt="No Booking Found">
                                <h5>{{ __('NO_FAVORITES_FOUND') }}...</h5>
                            </div>

                            {{-- @include('frontend.partials.components.pagination') --}}
                        </div>

                        <div class="buttCont @if ($userFavoritesData['users_total'] <= config('app.default_favorites_show_more_users')) dn @endif">
                            <div class="cell small-6 medium-4 posrelative df jcc">
                                <button class="hollow btn favoritesShowMore mb16">
                                    {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="cell small-12 fl">

                    <div
                        class="w-100 searchContainerMain pointerForFilter bakareza2 white-box-rounded bordersSquareOposite h50px">
                        <div class="w100 fl df breadCrumps w-100 fl specialDesktopPaddings25">
                            <h5>{{ __('MAKE_EVERY_DAY_COUNT_WITH_TALKILA') }}</h5>
                        </div>
                    </div>

                    <div class="bwhite w-100 searchContainerMain bordersSquare" id="containerFavorites">

                        <div class="tabDeskFavUsers show-for-medium2">
                            <div class="df aic jcc">
                                <div class="no-found-heading">
                                    <div>
                                        <img src="/frontend/assets/img/no-booking-found.png" alt="No Booking Found">
                                        <h5>{{ __('NO_FAVORITES_FOUND') }}...</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>

</div>
