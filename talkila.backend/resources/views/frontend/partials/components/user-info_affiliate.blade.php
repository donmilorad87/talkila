<div class="whiteBackground userInfo">

    <div class="mobileAboutContainer posrelative show-for-mobile2">

        <div class="bbt-none mobileAboutHeader w-100 df jcsb">
            <div class="icon-sn book-sn-icon box-resize">
                <div class="posrelative loggedPic cp uldrar br50">

                    @if (!empty($user->profile_picture) || !empty($user->profile_picture_tmp))
                        <img src="{{ $user->profile_picture ?? $user->profile_picture_tmp }}" alt="" />
                    @else
                        @include(
                            'frontend.partials.svg.icons.no-profile-picture'
                        )
                    @endif

                </div>
            </div>

            @if (!empty($user->description))
            @endif
            <div class="flexBoxCont">
                <div class="flex-box posrelative">
                    <div class="profileBio">
                        <h6 class="mobName di cp" data-popup="editFullName"> {{ $user->name }}
                            @if ($user->approved)
                                <div class="info-reload-wrap blue-wrap appIco">
                                    @include(
                                        'frontend.partials.svg.icons.verification-success'
                                    )
                                </div>
                            @else
                                <div class="info-reload-wrap appIco">
                                    @include(
                                        'frontend.partials.svg.icons.verification-pending'
                                    )
                                </div>
                            @endif
                        </h6>
                        <p class="di fl w-100"> {{ $user->username }} </p>
                        <br />
                        <a class="cp di fl" data-popup="addShortDescription">
                            @if ($user->description)
                                {{ strlen($user->description) > 20? substr($user->description, 0, 20) . '...': $user->description }}
                            @else
                                {{ __('ADD_A_SHORT_DESCRIPTION') }}
                            @endif
                        </a>
                    </div>
                    <div class="bwhite">
                        @include(
                            'frontend.partials.components.notifications'
                        )
                    </div>
                </div>

            </div>
        </div>
        <div class="grid-x w-100">
            @if (Route::current()->getName() == 'home' || Route::current()->getName() == 'logged_in')
                <div class="small-10">

                    @if ($user->jtc?->availability < 100)
                        <div class="grid-x d-flex bwhite buttonUserInfo mr4p8 tycim">
                            <div class="small-10">
                                <a href="{{ route('jtc_welcome') }}">
                                    <h5 class="tycim">{{ __('TURN_YOUR_TALK') }}</h5>
                                    <p class="m0 tycim">{{ __('FREE_REGISTRATION') }}</p>
                                </a>
                            </div>
                            <div class="small-2 centerVH">

                                <span class="time-left"><svg width="57" height="57" viewBox="0 0 57 57" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.4123 10.9945C31.0805 7.08005 42.0914 11.7444 46.0058 21.4126C49.9202 31.0807 45.2558 42.0916 35.5877 46.006C25.9195 49.9204 14.9087 45.256 10.9942 35.5879C7.07984 25.9197 11.7442 14.9089 21.4123 10.9945Z"
                                            stroke="white" stroke-width="6"></path>


                                    </svg> <strong id="talkDuration" class="dn">100</strong>
                                    <strong id="timeGone"
                                        class="dn">{{ $user->jtc?->availability }}</strong>
                                    <strong id="timeLeft"><span
                                            id="percentage">{{ $user->jtc?->availability }}</span>%</strong>
                                    <canvas id="progresTalkChanvas2" width="57" height="57">
                                    </canvas></span>


                            </div>
                        </div>
                    @elseif ($user->jtc?->availability == '100')
                        <div class="grid-x bwhite buttonUserInfo mr4p14 p0">
                            <a class="w-100" href="{{route('home')}}">
                                <h6 class="talignc w-100"> {{ __('ADD_TALKS_AVAILABILITES') }} </h6>
                            </a>
                        </div>
                    @endif

                </div>
            @elseif (Route::current()->getName() == 'about_me')
                <div class="small-10">
                    <div class="grid-x bwhite buttonUserInfo mr4p14 p0">
                        <a class="w-100" href="{{route('home')}}">
                            <h6 class="talignc w-100"> {{ __('ADD_TALKS_AVAILABILITES') }} </h6>
                        </a>
                    </div>
                </div>
            @elseif (Route::current()->getName() == 'talk_details')
                @if ($user->id !== $talk_details['talk']['id'])
                    <div class="small-10">



                        @include(
                            'frontend.partials.pages.profile.about-buttons-3',
                            [
                                'follow' => $followButton ?? '',
                                'favorite' => $favoriteButton,
                                'user_id' => $user->id ?? null,
                            ]
                        )


                    </div>
                @else
                    <div class="small-4">



                        @include(
                            'frontend.partials.pages.profile.about-buttons-3',
                            [
                                'follow' => $followButton ?? '',
                                'favorite' => $favoriteButton,
                                'user_id' => $user->id ?? null,
                            ]
                        )


                    </div>
                    <div class="small-4">
                        <a href="{{ route('about_me') }}">
                            <div class="bwhite buttonUserInfo mr4">
                                <h6 class="talignc w-100 mr4p14">{{ __('ABOUT_ME') }}</h6>
                            </div>
                        </a>
                    </div>
                @endif
            @else
                <div class="small-6">



                    @include(
                        'frontend.partials.pages.profile.about-buttons-3',
                        [
                            'follow' => $followButton ?? '',
                            'favorite' => $favoriteButton ?? '',
                            'user_id' => $user->id ?? null,
                        ]
                    )


                </div>
                <div class="small-4">
                    <a href="{{ route('about_me') }}">
                        <div class="bwhite buttonUserInfo mr4">
                            <h6 class="talignc w-100 mr4p14">{{ __('ABOUT_ME') }}</h6>
                        </div>
                    </a>
                </div>
            @endif
            <div class="small-2 bwhite">
                <div class="centerVH height100 posrelative cp supikar" data-popup="shareProfilePopUp2">
                    @include('frontend.partials.svg.icons.share-heart')
                    @include('frontend.partials.svg.icons.share')
                </div>

            </div>
        </div>


    </div>
</div>
