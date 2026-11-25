<div class="w-100 mr12 pr8">

    @if ($follow === 1)
        <button class="btn w-100 hollow unfollow_user mb0" data-user="{{ $user_id }}">@include('frontend.partials.svg.icons.check-white')
                {{ __('FOLLOWING_PENDING') }}
        </button>
    @else
        <button class="btn w-100 hollow follow_user mb0" data-user="{{ $user_id }}">
                {{ __('FOLLOW') }}
        </button>
    @endif
</div>
