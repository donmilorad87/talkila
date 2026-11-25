@if (isset($overview))

    <div class="course-item">

        <a href=""
            data-hrefm="{{ route('talk_details', ['username' => $item['username'], 'id' => $overview['id']]) }}"
            data-hrefd="{{ route('book_slot', $overview['id']) }}" data-overview="1" class="dataTalkId"
            data-talk-id="{{ $overview['id'] }}">
            <div class="icon-sn book-sn-icon gray-bg duration{{ $overview['duration'] }}">
                <div>
                    <h6>{{ $overview['duration'] }}</h6>
                    <p>
                        @if ($overview['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>
            </div>
            <div class="heading-slider">
                <div class="df aic">
                    <h6 class="f5">{{ $overview['headline'] }} </h6>
                </div>


                {{-- @if ($overview['ratings'] > 0) --}}

                <div class="df aic">
                    <ul>
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $overview['ratings'])
                                <li>@include('frontend.partials.svg.icons.full-star')</li>
                            @else
                                <li>@include('frontend.partials.svg.icons.zero-star')</li>
                            @endif
                        @endfor
                        <li>
                            <span class="small">({{ $overview['reviews'] }} {{ __('PROFILE_REVIEWS') }})</span>

                        </li>
                        <li>
                            <span class="f2 prices">{{ $overview['price'] }} €</span>
                        </li>
                    </ul>

                </div>
                {{-- @else

                @endif --}}

                <div class="social-box">

                    <div class="df aic jssb">
                        <ul class="fl">
                            @if ($overview['call_type'] == 1)
                                <li> @include('frontend.partials.svg.icons.phone') {{ __('PROFILE_PHONE') }}</li>
                            @elseif($overview['call_type'] == 2)
                                <li> @include('frontend.partials.svg.icons.video-camera') {{ __('VIDEO_TALK') }}</li>
                            @endif
                            @if (isset($overview['anonym_call']))
                                @if ($overview['anonym_call'] === 1)
                                    <li> @include('frontend.partials.svg.icons.anonymous')
                                        {{ __('ANONS_ALLOWED') }}</li>
                                @else
                                    <li> @include('frontend.partials.svg.icons.user-black') {{ __('USER') }}</li>
                                @endif
                            @else
                                @if ($overview['is_anonymous_allowed'] === 1)
                                    <li> @include('frontend.partials.svg.icons.anonymous')
                                        {{ __('ANONS_ALLOWED') }}</li>
                                @else
                                    <li> @include('frontend.partials.svg.icons.user-black') {{ __('USER') }}</li>
                                @endif
                            @endif


                        </ul>
                        @if (isset($overview['following_talk']))
                            <h6 class="fr m0">

                                @if ($overview['following_talk'] === 1)
                                    <span class="favoriteHeart df aic" data-fallowing="1">
                                        @include('frontend.partials.svg.icons.full-heart2')
                                    </span>
                                @else
                                    <span class="favoriteHeart df aic" data-fallowing="0">
                                        @include('frontend.partials.svg.icons.heart-black')
                                    </span>
                                @endif
                            </h6>
                        @elseif (isset($overview['is_favorite']))
                            <h6 class="fr m0">

                                @if ($overview['is_favorite'] === 1)
                                    <span class="favoriteHeart df aic" data-fallowing="1">
                                        @include('frontend.partials.svg.icons.full-heart2')
                                    </span>
                                @else
                                    <span class="favoriteHeart df aic" data-fallowing="0">
                                        @include('frontend.partials.svg.icons.heart-black')
                                    </span>
                                @endif
                            </h6>
                        @endif
                    </div>
                    {{-- {{ dd($overview) }} --}}

                </div>
            </div>
        </a>
    </div>
@elseif(isset($userTalks))
    <div class="course-item privateCourseItem">

        <a data-talk-id="{{ $userTalks['id'] }}" class="dataTalkId">
            <div class="icon-sn book-sn-icon gray-bg divPrivTalk0 duration{{ $userTalks['duration'] }}">
                <div class="divPrivTalk">
                    <h6>{{ $userTalks['duration'] }}</h6>
                    <p>
                        @if ($userTalks['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>
            </div>
            <div class="heading-slider df fdc g4px">
                <h6>{{ $userTalks['headline'] }} </h6>

                {{-- @if ($userTalks['ratings'] > 0) --}}
                <ul>
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < $userTalks['ratings'])
                            <li>@include('frontend.partials.svg.icons.full-star')</li>
                        @else
                            <li>@include('frontend.partials.svg.icons.zero-star')</li>
                        @endif
                    @endfor
                    <li><span class="small">({{ $userTalks['total_reviews'] }}
                            {{ __('PROFILE_REVIEWS') }})</span></li>
                    <li class="mla fs14 cblack fw600">
                        <span>{{ priceFormater($userTalks['price']) }}</span>
                    </li>
                </ul>
                {{-- @else

                    @endif --}}

                <div class="social-box">
                    <ul>
                        {{-- {{ dd($userTalks) }} --}}
                        @if ($userTalks['call_type'] == 1)
                            <li> @include('frontend.partials.svg.icons.phone') {{ __('PROFILE_PHONE') }}</li>
                        @elseif($userTalks['call_type'] == 2)
                            <li> @include('frontend.partials.svg.icons.video-camera') {{ __('VIDEO_TALK') }}</li>
                        @endif

                        @if (isset($userTalks['anonym_call']))
                            @if ($userTalks['anonym_call'] == 1)
                                <li> @include('frontend.partials.svg.icons.anonymous')
                                    {{ __('ANONS_ALLOWED') }}</li>
                            @endif

                        @endif


                    </ul>
                </div>
            </div>
        </a>
    </div>
@else
@endif
