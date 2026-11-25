<div class="profile-overview w-100 fl bookingSummaryHDmobile p1rempt2rem">
    <div>
        <div class="icon-sn book-sn-icon box-resize cp fl" data-popup="appStorePupUp">
            <div>
                <h6>
                    <div class="profPict">
                        @if (isset($imageUrl) && !empty($imageUrl))
                            <div class="noUserImg">
                                <img src="{{ $imageUrl }}" alt="{{$username}}" title="{{$username}}" />
                            </div>
                        @else
                            <div class="noUserImg" title="{{$username}}">
                                @include('frontend.partials.svg.icons.no-profile-picture-94')
                            </div>
                        @endif
                    </div>
                </h6>
            </div>
        </div>
        <div class="heading-slider mobileHomAbout fl m0">
            <div class="fl w-100">
                <div class="fl">

                    <h4 class="text-r-size pt0" {{-- @if ($online === '1') on @else off @endif" --}}>
                        <div class="df">
                            <span class="step1name"
                                data-id="{{ $userData['id'] ?? ($userId ?? '') }}">{{ $aboutName }}</span>
                        </div>

                    </h4>

                    <p class="step1username" data-id="{{ $userData['id'] ?? ($userId ?? '') }}">{{ $username }}</p>
                    <div class="social-box">
                        <ul>
                            @if ($rating > 0)
                                <li>
                                    @include('frontend.partials.svg.icons.full-star')
                                    <b class="mr4">{{ $rating }} </b> {{ __('PROFILE_RATING') }}
                                </li>
                            @endif
                            <li><strong>{{ $folowers ?? 0 }}</strong>
                                {{ __('FOLLOWERS') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if (
            (Route::current()->getName() != 'favorites_users' || Route::current()->getName() != 'favorites_talks') &&
                auth()->check())
            @php

                if (!empty($userData['id'])) {
                    $user_id = $userData['id'];
                } elseif ($userId) {
                    $user_id = $userId;
                } else {
                    $user_id = null;
                }

            @endphp

            <div class="fr fallowFavCont mt0">

                @include('frontend.partials.pages.profile.about-buttons', [
                    'follow' => $followButton ? 1 : 0,
                    'user_id' => $userData['id'] ?? $user_id,
                ])

            </div>
        @endif

        @if ($description ?? null !== null)
            <div class="fl w-100">
                <p class="mobileHeaderText ">{{ $description ?? null }}</p>
            </div>
        @endif

    </div>
</div>
