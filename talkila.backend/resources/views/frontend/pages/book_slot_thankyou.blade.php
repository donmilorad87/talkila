@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="grid-container">
        <div class="df aic m0 w-100 hide-for-medium" style="height: 52px;">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
                'page_title' => __('THANK_YOU_FOR_BOOKING'),
                'page_back_link' => '0',
                'save_button' => '1',
                'zIndex' => 'zi999',
            ])
        </div>
        <div class="grid-x">
            @include('frontend.partials.pages.book_slot_thankyou.left-container')
            @include('frontend.partials.pages.book_slot_thankyou.right-container')
        </div>
    </div>
@endsection
