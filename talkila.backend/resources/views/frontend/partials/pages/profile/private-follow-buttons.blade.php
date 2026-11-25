@if ($userData['pending_follower'])
    <div class="f1 small-10 fallowFavCont mr8 desktopFollow">
        <div class="bwhite buttonUserInfo mr4p14 abmebutton w-100">
            <button class="btn warning followingPending w-100 mb0 cp" data-popup="privatePopupCancel"
                data-user="{{ $userData['id'] }}"
                data-private="{{ $userData['visibility'] }}">@include('frontend.partials.svg.icons.check-white')
                {{ __('FOLLOWING_PENDING') }}
            </button>
        </div>
    </div>
@else
    @if ($userData['following'])
        <div class="f1 small-10 fallowFavCont mr8 desktopFollow">
            <div class="bwhite buttonUserInfo mr4p14 abmebutton w-100">
                <button class="hollow btn w-100 secondary unfollow_user mb0" data-user="{{ $userData['id'] }}">
                    {{ __('FOLLOWING') }}
                </button>
            </div>
        </div>
    @else
        <div class="f1 small-10 fallowFavCont mr8 desktopFollow">
            <div class="bwhite buttonUserInfo mr4p14 abmebutton w-100">
                <button class="hollow btn w-100 secondary follow_user mb0" data-user="{{ $userData['id'] }}"
                    data-private="{{ $userData['visibility'] }}">
                    {{ __('FOLLOW') }}
                </button>
            </div>
        </div>
    @endif
@endif
