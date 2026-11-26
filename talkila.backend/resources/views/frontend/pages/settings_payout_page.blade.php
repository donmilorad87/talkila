@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container">
        <div class="show-for-mobile">
            <input type="hidden" id="appUrl" value="{{ config('app.frontend_url') }}" />
            <input type="hidden" id="settingsAppId" value="{{ config('paypal.client_id') }}" />

            @include('frontend.partials.components.mobile-page-navigation-header', [
                'page_title' => __('PAYOUT'),
                'page_back_link' => route('settings_profile'),
            ])
        </div>

        @include('frontend.partials.components.settings-navigation-mobile')

        @include('frontend.partials.pages.settings.settings-payouts-page')

    </div>
@endsection

@section('popup_section')
    @include('frontend.partials.components.chose-payment-method-popup')
    @include('frontend.partials.pages.settings.payout_popup')
@endsection

@section('footer_scripts')
    <script src="/frontend/assets/js/iban.js"></script>
    <script src='https://www.paypalobjects.com/js/external/connect/api.js'></script>
@endsection
