@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="oh posrelative">
        <div class="show-for-mobile possticky top0 zi999">
            @include('frontend.partials.components.mobile-page-navigation-header', [
                'page_title' => __('WALLET'),
                'page_back_link' => '/settings/profile',
            ])
        </div>
        @include('frontend.partials.components.settings-navigation-mobile')
        <div class="grid-container">
            @include('frontend.partials.pages.settings.settings-wallets')
        </div>

        <input type="hidden" name="vat_id" id="vat_id" value="{{ $user->id }}">

    </div>
@endsection

@section('popup_section')
    @include('frontend.partials.pages.settings.add_to_wallet_popup')
    @include('frontend.partials.pages.settings.add_coins_to_wallet_popup')
    @include('frontend.partials.pages.settings.cardpopup')
    @include('frontend.partials.pages.settings.delete_card')
    @include('frontend.partials.pages.settings.default_card')

    @include('frontend.partials.components.loading_payment_popup')
@endsection
