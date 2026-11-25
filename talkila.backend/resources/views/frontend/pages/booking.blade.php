@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container white-box">

        @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
            'page_title' => __('MY_BOOKINGS'),
            'page_back_link' => '0',
            'save_button' => '1',
            'zIndex' => 'zi999',
        ])

        <div class='show-for-medium2'>

            <p class="subTitle bookingSubTitle lh4rem bb1">{!! __('THIS_IS_WHERE_YOU_CAN_KEEP_TRACK') !!}</p>


        </div>

        <div class="grid-x bookingMainCont">

            <div class='small-12 medium-4 bookingsLeft pb0 pt0'>
                <div class="mt1rem">
                    @include('frontend.partials.pages.booking.booking-calendar-2')
                    @include('frontend.partials.components.seven-days-calendar')
                </div>
            </div>

            <div class="small-12 medium-8 p0" id="bookingContent">
                @php
                    $userBookingDataByDate = [];
                    if (isset($userBookingsList['first_upcoming_booking'][date('Y-m-d')][0])) {
                        $userBookingDataByDate['data'][] = $userBookingsList['first_upcoming_booking'][date('Y-m-d')][0];
                    }
                @endphp

                @include('frontend.partials.pages.booking.booking-render', [
                    'userBookingDataByDate' => $userBookingDataByDate,
                ])

            </div>
        </div>
    </div>
    @include('frontend.partials.pages.video_conference.loading-popup')
@endsection
