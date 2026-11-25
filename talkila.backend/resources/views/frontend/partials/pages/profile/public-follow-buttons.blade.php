<div class="f1 small-10 fallowFavCont mr8 desktopFollow">

    <div class="bwhite mr4p14 abmebutton w-100">

        @if ($userData['following'])
            <button class="btn warning unfollow_user w-100 mb0"
                data-user="{{ $userData['id'] }}">@include('frontend.partials.svg.icons.check-white')
                {{ __('FOLLOWING') }}
            </button>
        @else
            <button class="hollow btn w-100 secondary follow_user mb0"
                data-user="{{ $userData['id'] }}">
                {{ __('FOLLOW') }}
            </button>
        @endif

    </div>

</div>
