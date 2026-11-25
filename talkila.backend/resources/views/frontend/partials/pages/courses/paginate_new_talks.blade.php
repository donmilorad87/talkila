<tr data-talk-id="{{ $talk['id'] }}">
    <td class="width321">
        <div class="w-100 fl df aic tal">
            @if (!empty($talk['teacher_profile_picture']))
                <a href="/{{ $talk['teacher_username'] }}" class="w-20 fl">
                    <img src="{{ $talk['teacher_profile_picture'] }}" alt="{{ $talk['teacher_username'] }}" />
                </a>
            @else
                <a href="/{{ $talk['teacher_username'] }}" class="tableimage w-20 fl oh br50 xzxz">
                    @include('frontend.partials.svg.icons.no-profile-picture-60')
                </a>
            @endif

            <div class="w-80 fl pl16 posrelative">

                <div class="w-100 fl talkLink">
                    <a href="{{ route('book_slot', ['talk' => $talk['id']]) }}" class="boldTalkTalksTAble">
                        {{ $talk['headline'] }}
                    </a>
                </div>

                <div class="w-100 fl">
                    <span class="grayTextTable">
                        {{ $talk['talk_category'] }} > {{ $talk['talk_subcategory'] }}
                    </span>
                </div>

                <div class="w-100 fl">
                    <span class="grayTextTable">
                        {{ __('LANGUAGE') }}: {{ $talk['language_value'] }}

                    </span>
                </div>

                <div class="w-100 fl">
                    <span class="grayTextTable">
                        {{ __('BY') }} <a class="o1"
                            href="/{{ $talk['teacher_username'] }}">{{ $talk['teacher_name'] }}</a>
                    </span>
                </div>

            </div>
        </div>

    </td>

    <td class="w-87p jcc">
        <div>

            @if ($talk['call_type'] == CallTypes::ONE_TO_ONE)
                <div class="w-100 fl tac">
                    @include('frontend.partials.svg.icons.schollar_cap')
                </div>
                <div class="w-100 fl tac talkTypeAva jcc"> {{ __('PRIVATE_TALK') }} </div>
            @elseif ($talk['call_type'] == CallTypes::GROUP)
                <div class="w-100 fl tac">
                    @include('frontend.partials.svg.icons.chat-users')
                </div>
                <div class="w-100 fl tac talkTypeAva jcc"> {{ __('GALLERY_TALK') }} </div>
            @endif



            <div class="fl w-100 iconsSearchItem jcc">

                <span> @include('frontend.partials.svg.icons.phone_icon') </span>

                <span> | </span>

                @if ($talk['talk_type'] !== 1)
                    <span> @include('frontend.partials.svg.icons.camera_icon')
                    </span>
                @else
                    <span> @include('frontend.partials.svg.icons.camera_cross')
                    </span>
                @endif

                @if ($talk['anonym_call'] === 1)
                    <span> | </span>
                    <span> @include('frontend.partials.svg.icons.anonymous') </span>
                @endif
            </div>

        </div>
    </td>
    <td class="w-110p">
        <div class="df fdc aic">

            <div class="df profesorNameSpan">
                @if ($talk['total_reviews'])
                    @include('frontend.partials.components.rating_stars', [
                        'ratings' => number_format(floatval($talk['ratings']) / $talk['total_reviews'], 2),
                    ])

                    <strong
                        class="courseRating mr8 colorBlack">{{ number_format(floatval($talk['ratings']) / $talk['total_reviews'], 2) }}</strong>
                @else
                    @include('frontend.partials.components.rating_stars', ['ratings' => 0])

                    <strong class="courseRating mr8 colorBlack">0</strong>
                @endif


            </div>

            <div class="df">
                <span class="courseReviews">({{ $talk['total_reviews'] }}
                    @if ($talk['total_reviews'] > 1){{ strtolower(__('REVIEWS')) }}@else{{ strtolower(__('REVIEW')) }}@endif)
                </span>
            </div>

        </div>

    </td>

    <td class="w-80p jcc">
        <div class="">
            <b> {{ $talk['duration'] }} min </b>
        </div>
    </td>

    <td class="w-80p jcc">
        <div class="">
            <b> {{ priceFormater($talk['price']) }}</b>
        </div>
    </td>

    <td class="w-80p jcc">
        <div class="df aic jcc">
            @if (auth()->check() && ($talk['teacher_user_id'] ?? null) == auth()->id())
                <div>
                    <span class="favoriteHeart2 df aic pon o03">
                        @include('frontend.partials.svg.icons.bigHeart')
                    </span>
                </div>
            @elseif ($talk['is_favorite'])
                <div>
                    <span class="favoriteHeart2 df aic" data-user-id="{{ $talk['id'] }}" data-fallowing="1"
                        data-talk-id="{{ $talk['id'] }}">
                        @include('frontend.partials.svg.icons.bigRedHeart')
                    </span>
                </div>
            @else
                <div>
                    <span class="favoriteHeart2 df aic" data-user-id="{{ $talk['id'] }}" data-fallowing="0"
                        data-talk-id="{{ $talk['id'] }}">
                        @include('frontend.partials.svg.icons.bigHeart')
                    </span>
                </div>
            @endif
        </div>
    </td>
</tr>
