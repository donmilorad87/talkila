@include('frontend.partials.components.favorites_menu', ['pointer' => __('TALKS')])


@if (isset($talks) && !empty($talks))
    @if ($talks_count > config('app.show_more_talks'))
        @include('frontend.partials.components.dropdown_filter2')
    @endif
@endif

<div class="hide-for-medium2 innerResultsSearch fullHeighter w-100 m0a">
    <div class="menu-bar w-100 thxer" id="mobileSearchContainer">


            @foreach ($talks as $talk)
                <div class="df pBottomItemsSearch" data-talk-id="{{ $talk['id'] }}">
                    <a href="/{{ $talk['teacher_username'] }}">
                        <img class="serachImg" src="{{ $talk['teacher_profile_picture'] }}"
                            alt="{{ $talk['teacher_name'] }}">
                    </a>

                    <div class="pl16">
                        <a href="/{{ $talk['teacher_username'] }}/talk/{{ $talk['id'] }}">
                            <p class="courseTitleSearch mb4">{{ $talk['headline'] }}</p>
                        </a>
                        <div class="df profesorNameSpan">
                            @include('frontend.partials.components.rating_stars', [
                                'ratings' => $talk['ratings'],
                            ])
                            <strong class="courseRating mr8 colorBlack">{{ $talk['ratings'] }}/5</strong>
                            <span class="courseReviews">({{ $talk['total_reviews'] }} @if ($talk['total_reviews'] > 1)
                                    {{ __('REVIEWS') }}
                                @else
                                    {{ __('REVIEW') }}
                                @endif )</span>
                        </div>
                        <span class="profesorNameSpan">
                            {{ __('BY') . ' ' . ($talk['teacher_name'] ) }}
                        </span>
                        <div class="df">

                            <div class="spanSearchBlok colorBlack fw600 duration{{$talk['duration']}}">
                                <span>{{ $talk['duration'] . ' ' . __('MINUTES_SHORT') }}</span>
                            </div>
                            <div class="spanSearchBlok colorBlack fw600">
                                <span>{{ priceFormater($talk['price']) }}</span>
                            </div>
                            <div class="iconsSearchItem">
                                <span>
                                    @include('frontend.partials.svg.icons.phone_icon')
                                </span>
                                <span> | </span>
                                @if ($talk['talk_type'] === 1)
                                    <span>
                                        @include('frontend.partials.svg.icons.camera_icon')
                                    </span>
                                @else
                                    <span>
                                        @include('frontend.partials.svg.icons.camera_cross')
                                    </span>
                                @endif

                                @if ($talk['anonym_call'] === 1)
                                    <span> | </span>
                                    <span>
                                        @include('frontend.partials.svg.icons.anonymous')
                                    </span>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="bigHeartSearch">
                        <span class="favoriteHeart2 df aic mobile" data-fallowing="1"
                            data-talk-id="{{ $talk['id'] }}">
                            @include('frontend.partials.svg.icons.bigRedHeart')
                        </span>
                    </div>
                </div>
            @endforeach



    </div>



    <div class="talksBlock">
        <div class="talksShowMore df jcc @if ($talks_count <= config('app.show_more_talks')) dn @endif">
            <button class="btn btnShowMore w-100 mt16 mb12">{{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}</button>

        </div>
    </div>

</div>

<div class="w-100 grid-x show-for-medium2 desktopContainer">
    @if (count($talks) > 0)
        @include('frontend.partials.components.filter-sidebar')
        <div class="small-12 medium-12 large-9 fl pl24768">
            <div
                class="w-100 searchContainerMain pointerForFilter bakareza2 white-box-rounded bordersSquareOposite h50px">
                <div class="w100 fl df breadCrumps w-100 fl specialDesktopPaddings25">
                    <h5>{{ __('MAKE_EVERY_DAY_COUNT_WITH_TALKILA') }}</h5>
                </div>
            </div>



            <div class="favorite_talks_holder">

                @if (isset($talks) && !empty($talks))
                    <table id="categorySubcategoryTalksTable">
                        <thead>
                            <tr>
                                <td class="width321">
                                    {{ __('TALK_INFO') }}(<span
                                        id="talks_countField">{{ $talks_count }}</span>)
                                </td>
                                <td class="w-87p tac">{{ __('TYPE') }}
                                </td>
                                <td class="w-110p">
                                    <div class="fl" id="ratingSort">
                                        {{ __('RATING') }}</div>
                                    <div class="sortingSearch fl">
                                        @include('frontend.partials.svg.icons.bottom_', [
                                            'class' => 'w-100 fl orderByRateASC',
                                        ])
                                        @include('frontend.partials.svg.icons.bottom_', [
                                            'class' => 'w-100 fl rotate180 orderByRateDESC',
                                        ])
                                    </div>
                                </td>
                                <td class="w-80p jcc">
                                    <div>
                                        <div class="fl" id="durationSort">
                                            {{ __('DURATION') }}</div>
                                        <div class="sortingSearch fl">
                                            @include('frontend.partials.svg.icons.bottom_', [
                                                'class' => 'w-100 fl orderByDurationASC',
                                            ])
                                            @include('frontend.partials.svg.icons.bottom_', [
                                                'class' => 'w-100 fl rotate180 orderByDurationDESC',
                                            ])
                                        </div>
                                    </div>
                                </td>
                                <td class="w-80p jcc">
                                    <div>
                                        <div class="fl" id="priceSort">
                                            {{ __('BASE_PRICE') }}
                                        </div>
                                        <div class="sortingSearch fl">
                                            @include('frontend.partials.svg.icons.bottom_', [
                                                'class' => 'w-100 fl orderByPriceASC',
                                            ])
                                            @include('frontend.partials.svg.icons.bottom_', [
                                                'class' => 'w-100 fl rotate180 orderByPriceDESC',
                                            ])
                                        </div>
                                    </div>
                                </td>
                                <td class="w-80p jcc">
                                    <div class="fl">
                                        {{ __('BOOKMARKS') }}</div>
                                    <div class="sortingSearch2 fl tooltipser">
                                        @include('frontend.partials.svg.icons.union')
                                        <span class="tooltiptexter">{{ __('BOOKMARK_FOLLOW_TEXT') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($talks as $talk)
                                @include('frontend.partials.pages.courses.paginate_new_talks', ['talk' => $talk])

                            @endforeach
                        </tbody>
                    </table>
                @else
                    <a href="/talks">
                        <div class="df aic jcc">
                            <div class="db">
                                <img src="/frontend/assets/img/no-booking-found.png" alt="No Booking Found">
                                <h5>{{ __('NO_FAVORITES_FOUND') }}...</h5>
                            </div>
                        </div>
                    </a>
                @endif

                <div class="talksBlock">
                    <div class="talksShowMore tac @if ($talks_count <= config('app.show_more_talks')) dn @endif">
                        <button class="btn btnShowMore">{{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}</button>

                    </div>
                </div>

                @include('frontend.partials.components.nothing-found', [
                    'display' => 'dn',
                ])
            </div>
        </div>
    @else
        <div class="cell small-12">
            <div class="df aic jcc pt16">
                <div class="db">
                    <img src="/frontend/assets/img/no-booking-found.png" alt="No Booking Found">
                    <h5 class="tac">{{ __('NOT_TALKS_FOUND') }}...</h5>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="w-100 df noFavoriteTalksPicture fdc aic jcc pt16 @if ($talks_count > 0) dn @endif">

    <img src="/frontend/assets/img/no-booking-found.png" alt="No Booking Found">
    <h5 class="tac">{{ __('NOT_TALKS_FOUND') }}...</h5>

</div>
