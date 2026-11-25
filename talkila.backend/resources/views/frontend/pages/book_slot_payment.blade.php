@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="grid-container">
        @include('frontend.partials.pages.jtc.mobile-steps-navigation', [
            'page_title' => 'Booking Payment',
            'page_back_link' => '0',
            'save_button' => '0',
            'talk_name' => $talkData['headline'],
            'addCoins'  => false
        ])
        <div class="pointerZ123 oh">
            <div class="grid-x">
                @include('frontend.partials.pages.book_slot_payment.left-container')
                @include('frontend.partials.pages.book_slot_payment.right-container')
            </div>
        </div>
    </div>
@endsection

@section('popup_section')

    @include('frontend.partials.pages.settings.cardpopup')

    @include('frontend.partials.components.loading_payment_popup')

@endsection
