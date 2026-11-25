<div class="bwhite mr4p14 abmebutton w-100">

    @if ($follow === 1)
        <button class="btn warning unfollow_user w-100 mb0" data-user="{{ $user_id }}">@include('frontend.partials.svg.icons.check-white')
                {{ __('FOLLOWING') }}
        </button>
    @else
        <button class="hollow btn w-100 secondary follow_user mb0" data-user="{{ $user_id }}">
                {{ __('FOLLOW') }}
        </button>
    @endif
</div>
