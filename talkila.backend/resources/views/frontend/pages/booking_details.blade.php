@extends('frontend.layouts.frontendlayout')
@section('content')


    <div class="container grid-x white-box">

        <div class="small-12 medium-6 large-4 show-for-medium2 mt0">
            @include('frontend.partials.pages.profile.user-info')

        </div>
        <div class="small-12 medium-6 large-8 mt16Desktop">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
                'page_title' => __('MY_BOOKINGS'),
                'page_back_link' => '00',
                'save_button' => '1',
                'zIndex' => 'zi999',
            ])

            <div class="grid-x grid-margin-x bookingDetailsInner border1Desktop mb16">

                @php
                    $booking_status = \App\Http\Controllers\Frontend\BookingController::bookingSwitchBadge($bookingDetails['booking_status']);
                    $show = \App\Http\Controllers\Frontend\BookingController::compareBookingTime($bookingDetails['start_call']);
                    $user_slots_left = count($bookingDetails['booking_participants']);
                    $activePointer = \App\Http\Controllers\Frontend\BookingController::activePointer($bookingDetails['start_call'], $bookingDetails['end_call']);
                @endphp

                <div class="bookingBadge">
                    @if ($booking_status['badgePointer'] !== 1)
                        <div class="fv600 o07 {{ $booking_status['itemClass'] }}">
                            @include('frontend.partials.svg.icons.info-icon') {{ $booking_status['itemText'] }}
                        </div>
                    @else
                        @if ($activePointer)
                            @if ($bookingDetails['room_status'] === 3)
                                <div class="fv600 o07 rejectedBookingProfesor">
                                    @include('frontend.partials.svg.icons.info-icon') @if ($bookingDetails['teacher_id'] == $user->id)
                                        {{ __('SUPPLIER') . ' | ' }}
                                    @endif @lang('REJECTED_BY_SUPPLIER')
                                </div>
                            @else
                                <div class="fw600 activeBooking">
                                    <a href="{{ route('video_conference') }}">
                                        @include('frontend.partials.svg.icons.info-icon') @if ($bookingDetails['teacher_id'] == $user->id)
                                            {{ __('SUPPLIER') . ' | ' }}
                                        @endif {{ __('ACTIVE_TALK') }}
                                    </a>
                                </div>
                            @endif
                        @else
                            @if ($show)
                                <div class="fw600 {{ $booking_status['itemClass'] ?? 'grayBooking' }}">
                                    @include('frontend.partials.svg.icons.info-icon') {!! __('RECENT_TALK') !!}
                                </div>
                            @elseif (!$show)
                                <div class="fw600 {{ $booking_status['itemClass'] ?? 'upcomingBooking' }}">
                                    @include('frontend.partials.svg.icons.info-icon') {!! __('UPCOMING_TALK') !!}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                <div class="medium-12 large-12 small-12 cell p16">
                    <div class="timing-box-left inner">

                        <a href="/{{ $bookingDetails['teacher_username'] }}/talk/{{ $bookingDetails['talk_id'] }}">
                            <div class="fl">

                                <div class="d-flex">
                                    <div class="profile-img-box df aic">

                                        @include('frontend.partials.svg.icons.favicon')
                                        <h5 class="ml8 bookingDetailsUsername">{{ $bookingDetails['headline'] }}</h5>

                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="inner-box-timing fr duration{{ $bookingDetails['duration'] }}">
                            <h6>{{ $bookingDetails['duration'] }}</h6>
                            <p>
                                @if ($bookingDetails['duration'] > 1)
                                    {!! __('PROFILE_MINUTES') !!}
                                @else
                                    {!! __('PROFILE_MINUTE') !!}
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr class="mb0">

                    @if ($bookingDetails['booking_status'] === 19)
                        @include('frontend.partials.pages.booking.booking_state_information', [
                            'badgeClass' => 'postponedBadger',
                            'start_call' => $bookingDetails['start_call'],
                            'end_call' => $bookingDetails['end_call'],
                            'postponed_start_call' => $bookingDetails['postponed_start_call'],
                            'postponed_end_call' => $bookingDetails['postponed_end_call'],
                        ])
                    @elseif ($bookingDetails['booking_status'] === 7)
                        @include('frontend.partials.pages.booking.booking_state_information_cancel', [
                            'badgeClass' => 'canceledBadger',
                            'cancellation_reason' => $bookingDetails['cancellation_reason'],
                            'cancel_date' => $bookingDetails['start_call'],
                        ])
                    @endif



                    <form class="form-option pl0 pr0 pb0 w-100">
                        <div class="grid-x grid-margin-x">
                            <div class="cell large-12">

                                <h6 class="mb20">{{ __('BOOKING_DETAILS') }}</h6>


                                <div class="radio-option-inner df g8px cblack">

                                    @if ($bookingDetails['call_type'] == CallTypes::ONE_TO_ONE)
                                        @include('frontend.partials.svg.icons.schollar_cap')
                                        <span>{{ __('PRIVATE_TALK') }}</span>
                                    @elseif($bookingDetails['call_type'] == CallTypes::GROUP)
                                        @include('frontend.partials.svg.icons.users')

                                        <div class="df fdc fs14">

                                            <span>{{ __('GALLERY_CLASSES') }}</span>
                                            <span id="peopleLeft">
                                                ({{ $user_slots_left }} {{ $user_slots_left > 1 ? __('STUDENTS_BOOKED') : __('STUDENT_BOOKED') }})
                                            </span>

                                        </div>
                                    @endif



                                </div>




                                <div class="radio-option-inner">
                                    <label class="df aic" for="pocketsRed">
                                        @if ($bookingDetails['talk_type'] == TalkTypes::VOICE_CALL)
                                            <span>@include('frontend.partials.svg.icons.voice-black')</span>
                                            {{ __('VOICE_TALKS') }}
                                        @elseif($bookingDetails['talk_type'] == TalkTypes::VIDEO_CALL)
                                            <span>@include('frontend.partials.svg.icons.video-black2')</span>
                                            {{ __('VIDEO_TALK') }}
                                        @endif
                                    </label>
                                </div>

                                <div class="radio-option-inner">
                                    <span>@include('frontend.partials.svg.icons.calendar')</span><label for="pocketsRed">

                                        {{ changeDateFormatLocale('Y-m-d H:i:s', $bookingDetails['start_call']) }}
                                    </label>
                                </div>
                                <div class="radio-option-inner">
                                    <span>@include('frontend.partials.svg.icons.time')</span>
                                    <label for="pocketsRed" class="wa">
                                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $bookingDetails['start_call'])->format('H:i') }}
                                        -
                                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $bookingDetails['end_call'])->format('H:i') }}
                                    </label>
                                    <div id="timeZoned" class="cblack ml16 fs12">
                                        ({{ getLocalTimeZoneName() }})
                                    </div>
                                </div>
                                <div class="radio-option-inner">
                                    <span>@include('frontend.partials.svg.icons.note')</span><label for="pocketsRed">
                                        {{ $bookingDetails['description'] }} </label>
                                </div>

                            </div>
                        </div>
                    </form>


                    <div class="grid-x grid-margin-x mt16">

                        <div class="medium-12 large-12 small-12 cell">
                            <h6 class="mb20 pt20 bt1">{{ __('BILLING_INFORMATION') }}</h6>
                            <div>
                                <div class="df aic">

                                    <p class="m0 fw600 cblack">@lang('TYPE_OF_PAYMENT')</p>
                                    <p class="bookingDetailsUsername mla cblack mb0">{{ $bookingPaymentType }}</p>
                                </div>
                            </div>
                            <div>
                                <div class="df aic">

                                    <p class="m0 fw600 cblack">@lang('DATE_OF_PAYMENT')</p>
                                    <p class="bookingDetailsUsername mla cblack mb0">{{ $paymentDate }}</p>
                                </div>
                            </div>
                            <div class="tl-pt-wrap w-100 mt16">
                                <h6>{{ __('TOTAL_PAYOUT') }}</h6>

                                @if ($bookingDetails['net_price'])
                                    <div class="total-payyout-wprapper d-flex mb0">
                                        <div class="ant-title-headding">{{ __('BASE_PRICE') }}</div>
                                        <div class="title-code">
                                            {{--   @dd($bookingDetails) --}}
                                            <strong>
                                                {{ priceFormater($bookingDetails['net_price']) }}
                                            </strong>

                                        </div>
                                    </div>
                                @endif
                                @if ($bookingDetails['tax'])
                                    <div class="total-payyout-wprapper d-flex">
                                        <div class="ant-title-headding">{{ __('VAT') }} </div>
                                        <div class="title-code"><strong>
                                                {{ priceFormater($bookingDetails['tax']) }}
                                                ({{ $bookingDetails['vat_value'] }} %)</strong></div>
                                    </div>
                                @endif
                                <hr>

                                <div class="total-payyout-wprapper d-flex">
                                    <div class="ant-title-headding"><strong>{{ __('TOTAL_PAYOUT') }}</strong> </div>
                                    <div class="title-code">
                                        <strong>{{ priceFormater($bookingDetails['gross_price']) }}</strong>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    @include('frontend.partials.pages.booking.extend-item-short', [
                        'item' => $bookingDetails,
                    ])

                </div>

            </div>




        </div>

    </div>



@endsection
