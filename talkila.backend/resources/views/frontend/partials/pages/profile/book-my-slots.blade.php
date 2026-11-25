@if(empty($userPrivateTalks) && empty($userPrivateTalks))
    @include('frontend.partials.pages.profile.no-talks-box')
@elseif(($userData['visibility'] == 1 || $userData['follower'] || $userData['is_me']) && ($userData['type'] == 2 && $userData['approved']))
    <section class="p16 gropings">
        @include('frontend.partials.pages.profile.book-my-slots-inner')
    </section>
@else
    @include('frontend.partials.pages.profile.private-course-box')
@endif
