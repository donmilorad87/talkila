@auth
    @if ($userData['visibility'] === 1)
        @if ($userData['id'] == $user->id)
            @include('frontend.partials.pages.profile.about-me-button')
        @else
            @include('frontend.partials.pages.profile.public-follow-buttons')
        @endif
    @elseif ($userData['visibility'] === 2)
        @if ($userData['id'] == $user->id)
            @include('frontend.partials.pages.profile.about-me-button')
        @else
            @include('frontend.partials.pages.profile.private-follow-buttons')
        @endif
    @endif
@endauth


<div class="f1 small-12 sharbut">
    <div class="centerVH height100 posrelative cp openShareForTeacher" data-popup="shareProfilePopUpEr">
        @include('frontend.partials.svg.icons.share-heart')
        @include('frontend.partials.svg.icons.share')
    </div>


</div>
