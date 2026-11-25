@foreach ($talks as $talk)
    <div class="df pBottomItemsSearch" data-talk-id="{{ $talk['id'] }}">

        <a class="df aic jcc imgATag" href="/{{ $talk['teacher_username'] }}">
            @if ($talk['teacher_profile_picture'])
                <img class="serachImg" src="{{ $talk['teacher_profile_picture'] }}" alt="{{ $talk['teacher_name'] }}">
            @else
                @include('frontend.partials.svg.icons.no-profile-picture-60')
            @endif

        </a>

        <a href="/{{ $talk['teacher_username'] }}/talk/{{ $talk['id'] }}">
            <div class="pl16">

                <p class="courseTitleSearch mb4">
                    {{ $talk['headline'] }}
                </p>

                <div class="df profesorNameSpan">

                    @if ($talk['total_reviews'] > 0)
                        @include('frontend.partials.components.rating_stars', [
                            'ratings' => number_format(floatval($talk['ratings']) / $talk['total_reviews'], 2),
                        ])
                        <strong
                            class="courseRating mr8 colorBlack">{{ number_format(floatval($talk['ratings']) / $talk['total_reviews'], 2) }}/5</strong>
                        <span class="courseReviews">
                            ({{ $talk['total_reviews'] }} @if ($talk['total_reviews'] > 1)
                                {{ __('REVIEWS') }}@else{{ __('REVIEW') }}
                            @endif)
                        </span>
                    @else
                        @include('frontend.partials.components.rating_stars', [
                            'ratings' => 0.0,
                        ])
                        <strong class="courseRating mr8 colorBlack">0/5</strong>
                        <span class="courseReviews">
                            (0 {{ __('REVIEWS') }})
                        </span>
                    @endif

                </div>

                <span class="profesorNameSpan"> @lang('BY') {{ $talk['teacher_name'] }} </span>
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
                        <span> | {{$talk['talk_type']}} | </span>
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
                <span class="favoriteHeart2 df aic pon o03">
                    @include('frontend.partials.svg.icons.bigHeart')
                </span>
            </div>
        @elseif ($talk['is_favorite'])
            <div class="mla">
                <span class="favoriteHeart2 df aic" data-user-id="{{ $talk['id'] }}" data-fallowing="1"
                    data-talk-id="{{ $talk['id'] }}">
                    @include('frontend.partials.svg.icons.bigRedHeart')
                </span>
            </div>
        @else
            <div class="mla">
                <span class="favoriteHeart2 df aic" data-user-id="{{ $talk['id'] }}" data-fallowing="0"
                    data-talk-id="{{ $talk['id'] }}">
                    @include('frontend.partials.svg.icons.bigHeart')
                </span>
            </div>
        @endif
    </div>
@endforeach
