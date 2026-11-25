<div class="grid-x">
    <span id="goBack2">
        @include('frontend.partials.svg.icons.arrow-left')
    </span>

    <div class="bbt-none mobileAboutHeader w-100 small-12 large-7 posrelative">
        <div class="icon-sn book-sn-icon box-resize cp" data-popup="uploadImagePopup" data-user-id="{{$userId}}">
            <div class="posrelative loggedPic">

                @if (isset($userData['profile_picture']) && !empty($userData['profile_picture']))
                    <img src="{{ $userData['profile_picture'] }}" alt="{{$userData['username']}}" />
                @else
                    @include('frontend.partials.svg.icons.no-profile-picture')
                @endif

            </div>
        </div>

        <div class="flexBoxCont ">
            <div class="flex-box">
                <div class="profileBio">
                    <h6 {{-- class="mobName" --}}> {{ $aboutName }} </h6>
                    <p> {{ $username }} </p>
                    <div class="social-box">
                        <ul>
                            <li>
                                @include('frontend.partials.svg.icons.full-star')
                                <strong>{{$rating}} </strong> {{ __('PROFILE_RATING') }}
                            </li>
                            <li><strong class="folowerS">{{$folowers}} </strong> {{ __('FOLLOWERS') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="bwhite show-for-mobile posOptons">
                    {{-- @include('frontend.partials.components.notifications') --}}
                    <div class="optionButton" data-opened="0">
                        @include('frontend.partials.svg.icons.v-dots')
                        <ul>
                            <li class="noselect cp"> {{ __('BLOCK') . ' ' .  __('USER')}} </li>
                            <li class="noselect cp"> {{ __('REPORT') . ' ' .  __('USER')}} </li>
                            <li class="noselect cp"> {{ __('CANCEL') }}</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <div>
        <p class="teacherDesc show-for-mobile">
            @if (isset($userData['description']) && !empty($userData['description']))
                {{$userData['description']}}
            @else
                {{ __('THIS_USER_NOT_HAVE_DESCRIPTION') }}
            @endif

        </p>
    </div>
    <div class="grid-x small-12 large-5 butcontmob posstatic mt16">

            <div class="small-5 large-12">
                <div class="fallowFavCont">

                    @if (auth()->user())
                        @if (auth()->user()->id != $userId)
                            @include('frontend.partials.pages.profile.about-buttons-2', [
                                "follow"    => $followButton === false ? 0 : 1,
                                "favorite"  => $favoriteButton,
                                'user_id'   => $userData['id'] ?? null
                            ])
                        @endif

                    @else

                    @endif


                </div>
            </div>


            <div class=" @if ($userData['id'] == $userData['id']) small-10 @else small-10 @endif large-8 hide-for-large ">
                <div class="bwhite mr4p14 abmebutton">
                    <h6 class="talignc w-100"><a href="/about-me"> {{ __('ABOUT_ME') }} </a></h6>
                </div>
            </div>

        <div class="small-2 large-4 sharbut hide-for-large">
            <div class="centerVH height100 posrelative cp" data-popup="shareProfilePopUp">
                @include('frontend.partials.svg.icons.share-heart')
                @include('frontend.partials.svg.icons.share')
            </div>

             @include('frontend.partials.components.share-profile-popup')
        </div>
    </div>



</div>
