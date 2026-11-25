@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="oh posrelative">
        <div class="show-for-mobile">
            @include('frontend.partials.components.mobile-page-navigation-header', [
                'page_title' => __('BILLING_INFORMATION'),
                'page_back_link' => '/settings/profile',
            ])
        </div>
        @include('frontend.partials.components.settings-navigation-mobile')
        <div class="container">
            <div class="setting-page white-box p16mob">
                <div class="setting-inner">
                    <div class="grid-x grid-margin-x">
                        <div class='cell medium-12'>
                            <div class="setting-tabs">

                                @include('frontend.partials.components.settings-menu', [
                                    'pointer' => __('BILLING_INFORMATION'),
                                    'loggedUserData' => $loggedUserData,
                                ])

                            </div>
                            <div class="tabs-content">
                                <div class="tabs-panel is-active pt0" id="Profile">

                                    <div class="grid-x">
                                        <div class="show-for-mobile mt8 w-100"></div>
                                        <h6 class="mb25 dn">{{ __('BILLING_INFORMATION') }}</h6>
                                        <p class="subTitle w-100">{{ __('BILLING_INFORMATION_DESCRIPTION') }}</p>

                                        <div
                                            class="cell medium-12 large-12">

                                            <div class="setting-inner">
                                                <div class="step-heading-wrap">
                                                    <h6 class="title-billing-info show-for-mobile">
                                                        {{ __('BILLING_INFORMATION') }}</h6>

                                                        @include('frontend.partials.pages.jtc.billing-informations')

                                                        <hr class="pr24">

                                                        <div class="cell text-right">
                                                            <button class="btn warning fr submit-button mb16">
                                                                {{ __('SAVE') }}
                                                            </button>
                                                        </div>
                                                        <hr>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
