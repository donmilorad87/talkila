@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container white-box p0 oh">
        <div class="show-for-mobile possticky top0 zi999">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
                'page_title' => __('ACCOUNT_VERIFICATION'),
                'page_back_link' => route('settings_profile'),
                'save_button' => '1',
                'zIndex' => 'zi999',
            ])
        </div>


        <div class="grid-x">
            <div class='cell small-12 medium-6 large-4 hide-for-mobile'>
                @include('frontend.partials.pages.profile.user-info')

            </div>
            <div class='cell small-12 medium-6 large-8 bwhite'>
                @include('frontend.partials.pages.verification.account-verification')
            </div>
        </div>

    </div>
@endsection
@section('popup_section')
    @include('frontend.partials.pages.jtc.upload-popup')

    @include('frontend.partials.components.take-picture-with-camera')
    @include('frontend.partials.components.share-profile-popup2')
@endsection
