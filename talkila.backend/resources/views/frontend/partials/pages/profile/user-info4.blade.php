<div class="grid-x p16 posrelative pb0">
    <span id="goBack2">
        @include('frontend.partials.svg.icons.arrow-left')
    </span>

    <div class="mb16 df aic g1rem bbt-none mobileAboutHeader w-100 small-12 large-7 posrelative">
        <div class="icon-sn book-sn-icon box-resize cp" data-popup="uploadImagePopup" data-user-id="{{ $userId }}">
            <div class="posrelative loggedPic">

                @if (isset($userData['profile_picture']) && !empty($userData['profile_picture']))
                    <img src="{{ $userData['profile_picture'] }}" alt="" />
                    @if (Route::current()->getName() !== 'profile')
                        @include('frontend.partials.svg.icons.profile-pic-plus')
                    @endif
                @else
                    @include('frontend.partials.svg.icons.no-profile-picture')
                    @if (Route::current()->getName() !== 'profile')
                        @include('frontend.partials.svg.icons.profile-pic-plus')
                    @endif
                @endif
            </div>
        </div>

        <div class="flexBoxCont mla">
            <div class="flex-box">
                <div class="profileBio df fdc">


                    <h6 class="mobName di cp pb0 mb0" data-popup="editFullName"> {{ $userData['name'] }}

                        @if ($userData['type'] === UserRoles::TEACHER)
                            <div class="info-reload-wrap blue-wrap appIco">
                                @include('frontend.partials.svg.icons.verification-success')
                            </div>
                        @else
                            <div class="info-reload-wrap appIco">
                                @include('frontend.partials.svg.icons.verification-pending')
                            </div>
                        @endif
                    </h6>

                    <p> {{ $username }} </p>
                    <div class="social-box df">
                        <ul>
                            <li>
                                @include('frontend.partials.svg.icons.full-star')
                                <strong>{{ $rating }} </strong> {{ __('PROFILE_RATING') }}
                            </li>
                            <li><strong class="folowerS">{{ $folowers }} </strong>
                                {{ __('FOLLOWERS') }}</li>
                        </ul>
                    </div>
                </div>
                @auth
                    @if ($userData['id'] !== $user->id)
                        <div class="bwhite show-for-mobile posOptons">
                            {{-- @include('frontend.partials.components.notifications') --}}
                            <div class="optionButton" data-opened="0">
                                {{-- @include('frontend.partials.svg.icons.v-dots') --}}
                                @include('frontend.partials.svg.icons.three_dots')
                                <ul>
                                    <li class="noselect userBlcok cp"
                                        @if ($userData['blocked']) onclick="userUnblock(this)" @else onclick="userBlock(this)" @endif
                                        data-user-id="{{ $userData['id'] }}">
                                        @if ($userData['blocked'])
                                            {{ __('UNBLOCK') }}
                                        @else
                                            {{ __('BLOCK') }}
                                        @endif
                                    </li>
                                    <li class="noselect cp"> {{ __('REPORT') . ' ' . __('USER') }} </li>
                                    <li class="noselect cp"> {{ __('CANCEL') }}</li>
                                </ul>
                            </div>

                        </div>
                    @endif

                @endauth

            </div>

        </div>

    </div>
    <div class="fl w-100 mb16">
        <p class="fl m0 teacherDesc show-for-mobile pb6 pt6">
            @if (isset($userData['description']) && !empty($userData['description']))
                @if (strlen($userData['description']) > 100)
                    @php
                        $first_100_chars = substr($userData['description'], 0, 100);
                        $rest_chars = substr($userData['description'], 100);
                    @endphp
                    <div class="fl w-100">
                        <p class="shortenDesc fl mb0">{{ $first_100_chars }} <span class="threeDots"> ... </span>
                            <span class="restofchars dn"> {{ $rest_chars }} </span>
                            <span id="showMoreDesc" class="cblue cursorp o1 fr showMoreDesc" data-opened="0">
                                {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }} </span>
                        </p>
                    </div>
                @else
                    {{ $userData['description'] }}
                @endif
            @else
                {{ __('THIS_USER_NOT_HAVE_DESCRIPTION') }}
            @endif

        </p>
    </div>
    <div class="grid-x small-12 large-5 butcontmob mt16">

        <div class="w-100 pb0 df">
            @include('frontend.partials.pages.profile.user-info-buttons')
        </div>

    </div>
</div>
