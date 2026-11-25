<div class="fav-buttons fr fabButCont">

    @if ($follow)
        <button class="btn extended expanded mb0 unfollow_user" data-device="desktop" data-user="{{ $user_id }}">@include('frontend.partials.svg.icons.check-white')
                {{ __('FOLLOWING') }}
        </button>
    @else
        <button class="btn extended expanded secondary mb0 follow_user" data-user="{{ $user_id }}">
                {{ __('FOLLOW') }}
        </button>
    @endif

    {{-- @if(!empty($favorite))
            @if ($favorite === "0")
                <button class="button extended secondary">
                    @include('frontend.partials.svg.icons.heart-black')
                </button>
            @else
                <button class="button extended warning">
                    @include('frontend.partials.svg.icons.heart-white')
                </button>
            @endif
    @endif --}}

</div>
