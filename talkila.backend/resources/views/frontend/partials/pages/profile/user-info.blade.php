<div class="whiteBackground userInfo">
    <div
        class="mobileAboutContainer posrelative


        @if ($user->pendingProfileVerificationRequest) @if (
            !(
                $user->type === UserRoles::TEACHER &&
                $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved']
            ) && $user->jtc?->state)
                pt40 @endif
@else
@endif

        ">
        @if ($user->pendingProfileVerificationRequest)
            @if (
                !(
                    $user->type === UserRoles::TEACHER &&
                    $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved']
                ) && $user->jtc?->state)

                @if ($user->pendingProfileVerificationRequest->status === 2)
                    @include('frontend.partials.pages.verification.account_verification_badge', [
                        'background_color_class' => 'redb',
                        'verification_text' => __('DECLINE_ACCOUNT'),
                    ])
                @else
                    @include('frontend.partials.pages.verification.account_verification_badge', [
                        'background_color_class' => 'orangeb',
                        'verification_text' => __('ACCOUNT_VERIFICATION_PENDING'),
                    ])
                @endif

            @endif
        @else
        @endif

        <div class="bbt-none mobileAboutHeader w-100 df jcsb aic">
            <div class="icon-sn book-sn-icon box-resize">
                <div class="posrelative loggedPic cp uldrar br50 imagePointerForCropper" data-popup="uploadDropArea">

                    @if (!empty($user->profile_picture) || !empty($user->profile_picture_tmp))
                        <img src="{{ $user->profile_picture ?? $user->profile_picture_tmp }}" alt="" />
                        @include('frontend.partials.svg.icons.profile-pic-plus')
                    @else
                        @include('frontend.partials.svg.icons.no-profile-picture')
                        @include('frontend.partials.svg.icons.profile-pic-plus')
                    @endif


                </div>
            </div>
            <div class="flexBoxCont df aic jcc">
                <div class="df jcsb w-100">
                    <div class="profileBio df fdc">
                        <h6 class="mobName di cp" data-popup="editFullName"> {{ $user->name }}
                            @if ($user->pendingProfileVerificationRequest)
                                @if (
                                    $user->type === UserRoles::TEACHER &&
                                        $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved']
                                )
                                    <div class="info-reload-wrap blue-wrap appIco">
                                        @include('frontend.partials.svg.icons.verification-success')
                                    </div>
                                @elseif ($user->jtc?->state === 1)
                                    <div class="info-reload-wrap appIco">
                                        @include('frontend.partials.svg.icons.verification-pending')
                                    </div>
                                @endif
                            @else
                            @endif

                        </h6>
                        <p class="di fl w-100"> {{ $user->username }} </p>


                        <div class="social-box fl" id="buttonConta">

                            <ul class="df lsn m0">
                                @if ($user->reviews > 0)
                                    <li class="df aic fs12">
                                        @include('frontend.partials.svg.icons.full-star')
                                        <strong>{{ floatFormater($user->ratings / ($user->reviews === 0 ? 1 : $user->reviews), 2) }}
                                        </strong> {{ __('PROFILE_RATING') }}
                                    </li>
                                @endif

                                @if ($user->followers->count() > 0)
                                    <li class="fs12">
                                        <strong class="folowerS">
                                            {{ $user->followers->count() }}
                                        </strong>
                                        {{ $user->followers->count() === 1 ? __('FOLLOWER') : __('FOLLOWERS') }}
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    @if ($user->pendingProfileVerificationRequest)
                        <div class="fdc df g4px">

                            @include('frontend.partials.components.notifications')

                            @auth
                                <a class="bwhite df aic jcc g4px p3p2"
                                    href="{{ route('settings_wallets', ['openAddCoins' => '1']) }}">
                                    @include('frontend.partials.svg.icons.coins')
                                    <b class="bCoins">{{ priceFormater($user->wallet_balance, true) }}</b>
                                </a>
                            @endauth

                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="tac" id="intersectTester">{{ $user->name }} <div
                class="centerVH height100 posabsolute right1rem cp supikar" data-popup="shareProfilePopUp2">

                @include('frontend.partials.svg.icons.share')
            </div>
        </div>
        <div class="grid-x w-100">
            @if (Route::current()->getName() == 'about_me')
                <div class="small-10">
                    <div class="grid-x bwhite buttonUserInfo mr4p14 p0">
                        <a class="w-100" href="{{ route('home') }}">
                            <h6 class="talignc w-100 lh40"> {{ __('ADD_TALKS_AVAILABILITES') }} </h6>
                        </a>
                    </div>
                </div>
            @elseif (Route::current()->getName() == 'talk_details')
                @if ($user->id !== $talk_details['talk']['id'])
                    <div class="small-10">


                        @include('frontend.partials.pages.profile.about-buttons-3', [
                            'follow' => $followButton ?? '',
                            'favorite' => $favoriteButton,
                            'user_id' => $user->id ?? null,
                        ])


                    </div>
                @else
                    <div class="small-6">
                        <div class="bwhite buttonUserInfo mr4">
                            <a href="{{ route('home') }}">
                                <h6 class="talignc w-100 mr4p14">{{ __('CHANGE_AVAILABILITY') }}</h6>
                            </a>

                        </div>
                    </div>
                    <div class="small-4">
                        <a href="{{ route('about_me') }}">
                            <div class="bwhite buttonUserInfo mr4">
                                <h6 class="talignc w-100 mr4p14">{{ __('ABOUT_ME') }}</h6>
                            </div>
                        </a>
                    </div>
                @endif
            @elseif (Route::current()->getName() == 'home' || Route::current()->getName() == 'logged_in')
                @if (!$user->pendingProfileVerificationRequest)

                    <div class="small-12">
                        <div class="bwhite buttonUserInfo mr4 verifyGreen">
                            <a class="w-100 df jcc" href="{{ route('jtc2_verify_account') }}">
                                <h6 class="talignc w-100 mr4p14">{{ __('PLEASE_VERIFY_ACCOUNT') }}</h6>
                            </a>

                        </div>
                    </div>
                @else
                    <div class="small-6">
                        <div class="bwhite buttonUserInfo mr4">
                            <h6 class="talignc cp mr4p14" data-popup="changeAvailability">
                                {{ __('CHANGE_AVAILABILITY') }}</h6>

                        </div>
                    </div>
                    <div class="small-4">
                        <a href="{{ route('about_me') }}">
                            <div class="bwhite buttonUserInfo mr4">
                                <h6 class="talignc mr4p14">{{ __('ABOUT_ME') }}</h6>
                            </div>
                        </a>
                    </div>
                @endif
            @else
            @endif
            @if ($user)
                @if ($user->pendingProfileVerificationRequest)
                    <div class="small-2 bwhite">
                        <div class="centerVH height100 posrelative cp supikar" data-popup="shareProfilePopUp2">
                            @include('frontend.partials.svg.icons.share-heart')
                            @include('frontend.partials.svg.icons.share')
                        </div>

                    </div>
                @endif
            @else
                <div class="small-2 bwhite">
                    <div class="centerVH height100 posrelative cp supikar" data-popup="shareProfilePopUp2">
                        @include('frontend.partials.svg.icons.share-heart')
                        @include('frontend.partials.svg.icons.share')
                    </div>

                </div>
            @endif

        </div>


    </div>
</div>
