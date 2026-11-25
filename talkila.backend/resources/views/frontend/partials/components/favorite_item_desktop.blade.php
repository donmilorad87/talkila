<div class="profile-overview w-100 fl bookingSummaryHDmobile p1rempt2rem">
    <div>
        <div class="icon-sn book-sn-icon box-resize cp fl" data-popup="appStorePupUp">
            <div>
                <h6>
                    <a href="{{ route('profile', $username) }}" class="profPict">
                        @if (isset($imageUrl) && !empty($imageUrl))
                            <div class="noUserImg">
                                <img src="{{ $imageUrl }}" alt="{{ $username }}" title="{{$username}}"/>
                            </div>
                        @else
                            <div class="noUserImg" title="{{$username}}">
                                @include('frontend.partials.svg.icons.no-profile-picture-94')
                            </div>
                        @endif
                    </a>
                </h6>
            </div>
        </div>
        <div class="heading-slider mobileHomAbout fl m0">
            <div class="fl w-100">
                <div class="fl">

                    <h4 class="lh1 text-r-size pt0">
                        <a class="df" href="{{ route('profile', $username) }}">
                            <span class="step1name" data-id="{{ $userId ?? '' }}">{{ $aboutName }}</span>
                        </a>


                    </h4>

                    <p class="step1username" data-id="{{ $userId ?? '' }}">{{ $username }}</p>
                    <div class="social-box">
                        <ul>
                            @if ($rating > 0)
                                <li>
                                    @include('frontend.partials.svg.icons.full-star')
                                    <b class="mr4">{{ $rating }} </b> {{ __('PROFILE_RATING') }}
                                </li>
                            @endif
                            <li><strong>{{ $folowers }} </strong> {{ __('FOLLOWERS') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="fr fallowFavCont mt0">
            @if ($userId != auth()->user()->id)
                @include('frontend.partials.pages.profile.about-buttons', [
                    'follow' => $followButton ? 1 : 0,
                    'user_id' => $userId,
                ])
            @endif


        </div>

        @if ($description ?? null !== null)
            <div class="fl w-100">
                <p class="mobileHeaderText ">{{ $description ?? null }}</p>
            </div>
        @endif

    </div>
</div>
