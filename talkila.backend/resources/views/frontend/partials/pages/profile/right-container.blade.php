<section class="large-8 small-order-1 large-order-2">
    <div class="inner-box-book right w-100">


        @if(($userData['visibility'] == 1) || $userData['follower'] || $userData['is_me'])
            @include('frontend.partials.pages.profile.about-description-video')

            @include('frontend.partials.pages.profile.experience')

        @else
            @include('frontend.partials.pages.profile.private-profile')
        @endif
    </div>
</section>
