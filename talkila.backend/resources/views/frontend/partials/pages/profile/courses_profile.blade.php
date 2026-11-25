@foreach ($userPrivateTalks as $userTalks)
    @if ($loop->index < config('app.default_profile_talks_show_more'))
        @include('frontend.partials.pages.profile.course_overview_new', [
            'userTalks' => $userTalks
        ])
    @endif
@endforeach
