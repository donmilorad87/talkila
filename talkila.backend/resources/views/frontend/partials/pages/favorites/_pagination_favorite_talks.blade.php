
@if(!empty($userFavoritesTalkData['talks']))

    @foreach($userFavoritesTalkData['talks'] as $overview)
        <div class="cell small-6 medium-6">
            @include('frontend.partials.pages.profile.course-overview', compact('overview'))
        </div>
    @endforeach
@endif
