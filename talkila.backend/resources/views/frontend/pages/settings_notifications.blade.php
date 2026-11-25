@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="oh posrelative">

        <div class="show-for-mobile possticky top0 zi999">
            @include('frontend.partials.components.mobile-page-navigation-header', [
                'page_title' => __('NOTIFICATIONS'),
                'page_back_link' => '/settings/profile',
            ])
        </div>

        @include('frontend.partials.components.settings-navigation-mobile')

        <div class="grid-container">
            @include('frontend.partials.pages.settings.settings-notifications')
        </div>

    </div>
@endsection
