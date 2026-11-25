@if (isset($userFavoritesData['users']) && !empty($userFavoritesData['users']))
@for ($j = 0; $j < count($userFavoritesData['users']); $j++)

        <div class="df pBottomItemsSearch">
            <img class="serachImg" src="{{ $userFavoritesData['users'][$j]['profile_picture'] }}"
                alt="{{ $userFavoritesData['users'][$j]['name'] }}">
            <div class="pl16">

                <p class="courseTitleSearch mb4">
                    {{ $userFavoritesData['users'][$j]['name'] }}
                </p>
                <span class="profesorNameSpan">
                    {{ $userFavoritesData['users'][$j]['profession'] ?? $userFavoritesData['users'][$j]['username'] }}
                </span>
                <div class="df profesorNameSpan">

                    @include('frontend.partials.components.rating_stars',['ratings'
                    =>
                    $userFavoritesData['users'][$j]['rating']])


                    <strong class="courseRating mr8 colorBlack">{{ $userFavoritesData['users'][$j]['rating'] }}/5</strong>
                    <span class="courseReviews">({{ $userFavoritesData['users'][$j]['total_followers'] }}
                        {{__('REVIEWS')}})</span>

                </div>

                <div class="df">

                    <div class="iconsSearchItem">
                        <div class="df">
                            <div class="df aic heartSvg" data-device="mobile" data-user="{{ $userFavoritesData['users'][$j]['id'] }}">

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
    @endfor
@endif
