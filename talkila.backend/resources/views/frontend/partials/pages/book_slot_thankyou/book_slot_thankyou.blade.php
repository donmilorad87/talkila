<div class="cell small-12">
{{--    <div class="booked text-center">--}}
{{--        @if ($bookingObj['postpone_pointer'])--}}
{{--            <h5>{{ __('TALK_POSTPONE') }}!</h5>--}}
{{--        @else--}}
{{--            <h5>{{ __('APPOINTMENT_BOOKED') }}!</h5>--}}
{{--        @endif--}}
{{--    </div>--}}

    <div class="wrapper-video text-center">
        <img src="{{ asset('frontend/assets/img/bg-profile-img.jpg') }}" alt="Thank You" />
        <h5>{{ __('BOOK_SLOT_THANKS') }}!</h5>
        <br>
{{--        <p>{{ __('BOOK_SLOT_STEPS') }}</p>--}}
    </div>
</div>
<div class="grid-x grid-margin-x">
    <div class="cell medium-2 large-2"></div>
    <div class="cell small-12 medium-8 large-8">
        <div class="inner-box-book" style="margin-top: 15px;">
            <div class="thankyou-item">
                <div class="icon-sn book-sn-icon shadow icon-re-size">
                    <img src="{{ asset('frontend/assets/img/helen-icon.png') }}" alt="Thank You" />
                </div>
                <ul class="experience_inner">
                    <li>
                        <h5>{{ __('BOOK_SLOT_BLOCKED') }} </h5>

                        @if ($bookingObj['postpone_pointer'])
                            <p>
                                {!! __('BOOKING_THANK_POSTPONE', [
                                    'dateFromLastBooking' => changeDateFormatLocale(
                                        'Y-m-d H:i:s',
                                        $bookingObj['talk_start_date_from_last_booking'] . ' ' . $bookingObj['talk_start_time_from_last_booking'],
                                        true,
                                    ),
                                    'timeFromLastBooking' => date(
                                        'H:i',
                                        strtotime(
                                            $bookingObj['talk_start_date_from_last_booking'] . ' ' . $bookingObj['talk_start_time_from_last_booking'],
                                        ),
                                    ),
                                    'dateOfPostpone' => changeDateFormatLocale('Y-m-d H:i:s', $bookingObj['bookingDateTime'], true),

                                    'timeOfPostpone' => explode(' ', getTimeZonedDate('Y-m-d H:i', $bookingObj['bookingDateTime']))[1],
                                ]) !!}
                        @else
                            <p>

                                {!! __('BOOKING_THANK_RESERVE', [
                                    'date' =>
                                        changeDateFormatLocale(
                                            'Y-m-d H:i:s',
                                            $bookingObj['bookingDate'] . ' ' . $bookingObj['bookingTime']['start_time'],
                                            true,
                                        ) . ', ',
                                    'start_time' => getTimeZonedDate('H:i', $bookingObj['bookingTime']['start_time']),
                                    'end_time' => getTimeZonedDate('H:i', $bookingObj['bookingTime']['end_time']),
                                ]) !!}
                            </p>
                        @endif

                    </li>
                </ul>
            </div>
            <div class="thankyou-item">
                <div class="icon-sn book-sn-icon shadow icon-re-size">
                    <img src="{{ asset('frontend/assets/img/we-book-icon.png') }}" alt="Thank You" />
                </div>

                <ul class="experience_inner">
                    <li>
                        <h5>{{ __('BOOK_SLOT_INFORM') }} {{ $talkData['user']['name'] }}</h5>
                        <p>
                            {{ __('BOOK_SLOT_NOTIFICATION') }}
{{--                            <br> {{ __('BOOK_SLOT_ABOUT') }}--}}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="thankyou-item">
                <div class="icon-sn book-sn-icon shadow   icon-re-size">
                    <img src="{{ asset('frontend/assets/img/safe-payment-icon.png') }}" alt="Thank You" />
                </div>
                <ul class="experience_inner">
                    <li>
                        <h5>{{ __('BOOK_SLOT_SAFE_1') }}!</h5>
                        <p>
                            {{ __('BOOK_SLOT_SAFE_2') }}
{{--                            <br> {{ __('BOOK_SLOT_SAFE_3') }}--}}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="grid-x grid-margin-x">

    <div class="small-12 medium-12 cell payButton">
        <div class="cell">
            <div class="heading-title-fr p0 m0a">
                <a href="{{ route('booking') }}?select={{$bookingObj['id']}}" class="btn w-100 db m0a">{{ __('GO_BACK_TO_BOOKINGS') }}</a>
            </div>
        </div>
    </div>

</div>
