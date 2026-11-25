<div class="grid-x userInfo3">


    <div class="bbt-none mobileAboutHeader w-100 small-12 large-7">
        <div class="icon-sn book-sn-icon box-resize cp" data-popup="uploadImagePopup">
            <div class="posrelative loggedPic mr8">
                @if (!empty($user->profile_picture) || !empty($user->profile_picture_tmp))
                    <img src="{{ $user->profile_picture ?? $user->profile_picture_tmp}}" alt="" />
                @else
                    @include('frontend.partials.svg.icons.no-profile-picture')
                @endif
            </div>
        </div>

        <div class="flexBoxCont df aic">
            <div class="flex-box posrelative">
                <div class="profileBio">
                    <a href="/{{$username}}">
                        <h6 class="mobName"> {{ $aboutName }}</h6>
                    </a>
                    <p> {{ $username }} </p>

                </div>


            </div>

        </div>

    </div>
    <div>
        <p class="teacherDesc mt8 cp teacherDescOpenBios fs16" data-popup="addShortDescription">
            @if (isset($user->description) && !empty($user->description))
                {{$user->description}}
            @else
                {{ __('THIS_USER_NOT_HAVE_DESCRIPTION') }}
            @endif

        </p>
    </div>




</div>
