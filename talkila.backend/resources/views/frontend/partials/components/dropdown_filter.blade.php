<div class="talksSubberCorrection hide-for-medium2 mh400">

    @if ($talks_count > config('app.show_more_talks'))

        <div class="small-12 jcsb w-100 smallFilter">
            <div class="subFilterItems posrelative typers">

                <div class="fl w-100">
                    <p class="pster pster1 zi111">{{ __('TYPE') }}</p>
                    <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
                </div>
                <select id="filterTypes" class="default-select zi999 posrelative selectMultiple" name="filterTypes" multiple>

                    <option value="0" class="dn">
                        0
                    </option>

                    @if ($filters['videoCall'])
                        <option value="2" data-type="video">
                            {{ __('VIDEO_TALK') }}
                        </option>
                    @endif
                    @if ($filters['voiceCall'])
                        <option value="3" data-type="voice">
                            {{ __('PHONE_TALK') }}
                        </option>
                    @endif

                </select>

            </div>

            <div class="subFilterItems posrelative">


                <div class="fl w-100">
                    <p class="pster pster2">{{ __('DURATION') }}</p>
                    <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
                </div>

                <select id="filterDuration" class="default-select zi999 posrelative selectMultiple"
                        name="filterDuration" multiple>
                    <option value="0" class="dn">
                        0
                    </option>

                    @if($filters['duration15'])
                        <option value="15">
                            15
                        </option>
                    @endif
                    @if($filters['duration30'])
                        <option value="30">
                            30
                        </option>
                    @endif
                    @if($filters['duration45'])
                        <option value="45">
                            45
                        </option>
                    @endif
                    @if($filters['duration60'])
                        <option value="60">
                            60
                        </option>
                    @endif
                    @if($filters['duration75'])
                        <option value="75">
                            75
                        </option>
                    @endif
                    @if($filters['duration90'])
                        <option value="90">
                            90
                        </option>
                    @endif
                    @if($filters['duration105'])
                        <option value="105">
                            105
                        </option>
                    @endif
                    @if($filters['duration120'])
                        <option value="120">
                            120
                        </option>
                    @endif


                </select>

            </div>
            <div class="subFilterItems zi999 posrelative">


                <div class="fl w-100">
                    <p class="pster pster1">{{ __('DAYS') }}</p>
                    <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')
                    </div>
                </div>

                <select id="filterDays" class="default-select zi999 posrelative selectMultiple" name="filterDays"
                        multiple>
                    <option value="0" class="dn">
                        0
                    </option>

                    @if ($filters['availableDays'][1])
                        <option value="1" data-day="monday">
                            {{ __('DAY_MONDAY_LONG') }}
                        </option>
                    @endif

                    @if ($filters['availableDays'][2])
                        <option value="2" data-day="tuesday">
                            {{ __('DAY_TUESDAY_LONG') }}
                        </option>
                    @endif

                    @if ($filters['availableDays'][3])
                        <option value="3" data-day="wednesday">
                            {{ __('DAY_WEDNESDAY_LONG') }}
                        </option>
                    @endif

                    @if ($filters['availableDays'][4])
                        <option value="4" data-day="thursday">
                            {{ __('DAY_THURSDAY_LONG') }}
                        </option>
                    @endif

                    @if ($filters['availableDays'][5])
                        <option value="5" data-day="friday">
                            {{ __('DAY_FRIDAY_LONG') }}
                        </option>
                    @endif

                    @if ($filters['availableDays'][6])
                        <option value="6" data-day="saturday">
                            {{ __('DAY_SATURDAY_LONG') }}
                        </option>
                    @endif

                    @if ($filters['availableDays'][7])
                        <option value="7" data-day="sunday">
                            {{ __('DAY_SUNDAY_LONG') }}
                        </option>
                    @endif

                </select>

            </div>
            <div class="subFilterItems zi999 posrelative">
                <div class="fl w-100">
                    <p class="pster pster3">{{ __('LANGUAGE') }}</p>
                    <div class="arrowSvgz">@include('frontend.partials.svg.icons.downBlueArrow')</div>
                </div>

                <select id="filterLanguage" class="default-select zi999 posrelative selectMultiple"
                        name="filterLanguage" multiple>
                    <option value="0" class="dn">
                        0
                    </option>

                    @foreach ($filters['languages']['languages'] as $language)
                            <option value="{{ $language['id'] }}">
                                {{ $language['value'] }}
                            </option>
                    @endforeach


                </select>

            </div>
        </div>

    @endif

    @if ($talks_count)

        <div class="innerResultsSearch">

            <ul class="menu-bar w-100 pb0" id="mobileSearchContainer">

                @foreach ($talks as $talk)
                    <div class="df pBottomItemsSearch" data-talk-id="{{ $talk['id'] }}">

                        <a class="df aic jcc imgATag" href="/{{ $talk['teacher_username']  }}">
                            @if ($talk['teacher_profile_picture'])
                                <img class="serachImg" src="{{ $talk['teacher_profile_picture'] }}" alt="{{ $talk['teacher_name']  }}">
                            @else
                                @include('frontend.partials.svg.icons.no-profile-picture-60')
                            @endif

                        </a>

                        <a href="/{{ $talk['teacher_username']  }}/talk/{{ $talk['id'] }}">
                            <div class="pl16">

                                <p class="courseTitleSearch mb4">
                                    {{ $talk['headline'] }}
                                </p>

                                <div class="df profesorNameSpan">

                                    @if ($talk['total_reviews'] > 0)
                                        @include('frontend.partials.components.rating_stars', [
                                            'ratings' => number_format(floatval($talk['ratings'])/$talk['total_reviews'], 2)
                                        ])
                                        <strong class="courseRating mr8 colorBlack">{{ number_format(floatval($talk['ratings'])/$talk['total_reviews'], 2) }}/5</strong>
                                        <span class="courseReviews">
                                            ({{ $talk['total_reviews'] }} @if ($talk['total_reviews'] > 1)
                                                {{ __('REVIEWS') }}
                                            @else
                                                {{ __('REVIEW') }}
                                            @endif)
                                        </span>
                                    @else
                                        @include('frontend.partials.components.rating_stars', [
                                            'ratings' => 0.00
                                        ])
                                        <strong class="courseRating mr8 colorBlack">0/5</strong>
                                        <span class="courseReviews">
                                            (0 {{ __('REVIEWS') }})
                                        </span>
                                    @endif

                                </div>

                                <span class="profesorNameSpan"> @lang('BY') {{ $talk['teacher_name']  }} </span>
                                <div class="df">


                                    <div class="spanSearchBlok colorBlack fw600 duration{{ $talk['duration'] }}">
                                        <span>
                                            {{ $talk['duration'] }} {{ __('MINUTES_SHORT') }}
                                        </span>
                                    </div>
                                    <div class="spanSearchBlok colorBlack fw600">
                                        <span>
                                            {{ priceFormater($talk['price']) }}
                                        </span>
                                    </div>
                                    <div class="iconsSearchItem">
                                        <span> @include('frontend.partials.svg.icons.phone_icon') </span>
                                        <span> | {{$talk['talk_type']}} | {{$talk['call_type']}} | </span>
                                        @if ($talk['talk_type'] === 2)
                                            <span> @include('frontend.partials.svg.icons.camera_icon')</span>
                                        @else
                                            <span> @include('frontend.partials.svg.icons.camera_cross')</span>
                                        @endif

                                        @if ($talk['anonym_call'] === 1)
                                            <span> | </span>
                                            <span> @include('frontend.partials.svg.icons.anonymous') </span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </a>

                        @if (auth()->check() && ($talk['teacher_user_id'] ?? null) == auth()->id())
                            <div class="mla">
                                <span class="favoriteHeart2 df aic mobile pon o03">
                                    @include('frontend.partials.svg.icons.bigHeart')
                                </span>
                            </div>
                        @elseif ($talk['is_favorite'])
                            <div class="mla">
                                <span class="favoriteHeart2 df aic mobile" data-user-id="{{ $talk['id'] }}" data-fallowing="1" data-talk-id="{{$talk['id'] }}">
                                    @include('frontend.partials.svg.icons.bigRedHeart')
                                </span>
                            </div>
                        @else
                            <div class="mla">
                                <span class="favoriteHeart2 df aic mobile" data-user-id="{{ $talk['id'] }}" data-fallowing="0" data-talk-id="{{$talk['id'] }}">
                                    @include('frontend.partials.svg.icons.bigHeart')
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach


            </ul>

            <div class="df aic jcc pt16 dn" id="noSearchMobile">
                <div class="db">
                    @include('frontend.partials.svg.icons.lazy')
                    <h5>{{ __('NO_FAVORITES_FOUND') }}...</h5>
                </div>
            </div>

        </div>

    @endif
</div>
