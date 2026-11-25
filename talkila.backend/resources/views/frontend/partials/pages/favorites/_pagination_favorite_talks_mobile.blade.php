@if (isset($userFavoritesTalkData) && !empty($userFavoritesTalkData))
    @foreach ($userFavoritesTalkData as $favoriteTalk)

        <div class="df pBottomItemsSearch"
            data-talk-id="{{ $favoriteTalk['id'] }}">
            <a href="/{{ $favoriteTalk['teacher_username'] }}">
                <img class="serachImg"
                    src="{{ $favoriteTalk['teacher_profile_picture'] }}"
                    alt="{{ $favoriteTalk['teacher_name'] }}">
            </a>

            <div class="pl16">
                <a
                    href="/{{ $favoriteTalk['teacher_username'] }}/talk/{{ $favoriteTalk['id'] }}">
                    <p class="courseTitleSearch mb4">
                        {{ $favoriteTalk['headline'] }}
                    </p>
                </a>
                <div class="df profesorNameSpan">

                    @include('frontend.partials.components.rating_stars',
                        [
                            'ratings' => $favoriteTalk['ratings']
                        ]
                    )


                    <strong
                        class="courseRating mr8 colorBlack">{{ $favoriteTalk['ratings'] }}/5</strong>
                    <span class="courseReviews">({{ $favoriteTalk['total_reviews'] }}
                        @if ($favoriteTalk['total_reviews'] > 1 )
                            {{__('REVIEWS')}}
                        @else {{__('REVIEW')}}
                        @endif)
                    </span>

                </div>
                <span class="profesorNameSpan"> {{__('BY')}}
                    {{ $favoriteTalk['teacher_name'] }}
                </span>
                <div class="df">

                    <div class="spanSearchBlok colorBlack fw600 duration{{$favoriteTalk['duration']}}">
                        <span>
                            {{ $favoriteTalk['duration'] }}
                            {{__('MINUTES_SHORT')}}
                        </span>
                    </div>
                    <div class="spanSearchBlok colorBlack fw600">
                        <span>
                            {{ priceFormater($favoriteTalk['price']) }}
                        </span>
                    </div>
                    <div class="iconsSearchItem">

                        <span>
                            @include('frontend.partials.svg.icons.phone_icon')
                        </span>

                        <span> | </span>
                        @if ($favoriteTalk['call_type'] === 1)
                            <span>
                                @include('frontend.partials.svg.icons.camera_icon')
                            </span>
                        @else
                            <span>
                                @include('frontend.partials.svg.icons.camera_cross')
                            </span>
                        @endif

                        @if ($favoriteTalk['anonym_call'] === 1)
                            <span> | </span>
                            <span>
                                @include('frontend.partials.svg.icons.anonymous')
                            </span>
                        @endif

                    </div>
                </div>
            </div>
            @if ($favoriteTalk['is_favorite'] === 1)
                <div class="bigHeartSearch">
                    <span class="favoriteHeart2 df aic mobile" data-fallowing="1"
                        data-talk-id="{{ $favoriteTalk['id'] }}">
                        @include('frontend.partials.svg.icons.bigRedHeart')
                    </span>
                </div>
            @elseif ($favoriteTalk['is_favorite'] === 0)
                <div class="bigHeartSearch">
                    <span class="favoriteHeart2 df aic mobile" data-fallowing="0"
                        data-talk-id="{{ $favoriteTalk['id'] }}">
                        @include('frontend.partials.svg.icons.bigHeart')
                    </span>
                </div>
            @endif

        </div>
    @endforeach

@endif
