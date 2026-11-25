@extends('frontend.layouts.frontendlayout')
@section('content')

    <div class="container">
        @include('frontend.partials.pages.courses.talk_details')
    </div>

    <div class="shareHelper">
        @include('frontend.partials.components.share-profile-popup')
        @include('frontend.partials.components.share-profile-popup2')
        @include('frontend.partials.components.share-profile-popup-talk-details')
    </div>

@endsection
