@extends('frontend.layouts.frontendlayout')
@section('content')


    <div class="oh posrelative">
        <div class="show-for-mobile">
            @include('frontend.partials.components.mobile-page-navigation-header', [
                    'page_title'        => __('FOOTER_LINK_REVIEWS'),
                    'page_back_link'    => route('settings_profile')
                ]
            )
        </div>
        @include('frontend.partials.components.settings-navigation-mobile')

        <div class="container">
            @include('frontend.partials.pages.settings.settings-reviews')
        </div>
    </div>

@endsection
