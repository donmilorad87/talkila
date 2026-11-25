@php
    $booking_status = \App\Http\Controllers\Frontend\BookingController::bookingSwitchBadge($item['booking_status']);
    $show = \App\Http\Controllers\Frontend\BookingController::compareBookingTime($item['start_call']);
    $showPostpone = \App\Http\Controllers\Frontend\BookingController::showPostpone($item['start_call']);
    $user_slots_left = count($item['booking_participants']);
    $activePointer = \App\Http\Controllers\Frontend\BookingController::activePointer($item['start_call'], $item['end_call']);
@endphp



<div class="bookings-inner book-modal cp posrelative selectBooking" data-booking-id={{ $item['id'] }}
    data-popup="classDetails-{{ $item['id'] }}">
    <div>
        <div class="posabsolute bookingBadge">

            @if ($booking_status['badgePointer'] === 20)

                <div class="fv600 o07 canceledBookingStudent {{ $booking_status['itemClass'] ?? '' }}">
                    @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                        {{ __('SUPPLIER') . ' | ' }}
                    @endif {{ $booking_status['itemText'] ?? '' }}
                </div>
            @elseif ($booking_status['badgePointer'] !== 1)
                <div class="fv600 o07 {{ $booking_status['itemClass'] }}">
                    @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                        {{ __('SUPPLIER') . ' | ' }}
                    @endif {{ $booking_status['itemText'] }}
                </div>
            @else
                @if ($activePointer)

                    @if ($item['room_status'] === 3)
                        <div class="fv600 o07 rejectedBookingProfesor">
                            @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                                {{ __('SUPPLIER') . ' | ' }}
                            @endif @lang('REJECTED_BY_SUPPLIER')
                        </div>
                    @else
                        <div class="fw600 activeBooking">
                            <a href="{{ route('video_conference') }}">
                                @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                                    {{ __('SUPPLIER') . ' | ' }}
                                @endif {{ __('ACTIVE_TALK') }}
                            </a>
                        </div>
                    @endif
                @else
                    @if ($show)
                        <div class="fw600 {{ $booking_status['itemClass'] ?? 'grayBooking' }}">
                            @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                                {{ __('SUPPLIER') . ' | ' }}
                            @endif {!! __('RECENT_TALK') !!}
                        </div>
                    @elseif (!$show)
                        <div class="fw600 {{ $booking_status['itemClass'] ?? 'upcomingBooking' }}">
                            @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                                {{ __('SUPPLIER') . ' | ' }}
                            @endif {!! __('UPCOMING_TALK') !!}
                        </div>
                    @endif
                @endif
            @endif
        </div>

        <div class='d-flex'>
            <div class="d-flex timing-box-left">

                <div class="inner-box-timing width64px duration{{ $item['duration'] }}">
                    <h6>{{ $item['duration'] }}</h6>
                    <p>
                        @if ($item['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>

                <div class="df aic ml16">
                    <div class="tal">
                        <h5 class="m0">{{ $item['headline'] }}</h5>

                        <p class="fs12 m0">{{ $item['category'] }} {{-- Course --}} * {{ $item['subcategory'] }}
                        </p>
                    </div>
                </div>



            </div>

            <div class="timing-box-right d-flex mwidth167 jcfe">
                <div class="timezone-inner">

                    <p data-postpone-time="{{ $item['start_call'] }}">
                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $item['start_call'])->format('H:i') }} -
                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $item['end_call'])->format('H:i') }}</p>
                    <span>
                        {!! __('TIMEZONE') !!} ( {{ getLocalTimeZoneName() }} )
                    </span>
                </div>

                @if ($booking_status['badgePointer'] === 1)

                    @if ($show)
                        @include('frontend.partials.components.options-button-recent')
                    @else
                        @include('frontend.partials.components.options-button-upcoming', [
                            'showPostpone' => $showPostpone,
                            'userId' => $user->id,
                            'teacher_id' => $item['teacher_id'],
                        ])
                    @endif
                @endif
            </div>
        </div>
        <div class="d-flex">
            <div class="d-flex social-wrap">

                <div class="social-first-box width64px">

                </div>

                <div class="talkDetailsInfoBox">
                    {{-- private turned off --}}
                    <div class="social-secend-box fl">
                        <p class="df aic g8px">

                            @if ($item['call_type'] == CallTypes::ONE_TO_ONE)
                                @include('frontend.partials.svg.icons.schollar_cap')
                                <span>{{ __('PRIVATE_TALK') }}</span>
                            @elseif($item['call_type'] == CallTypes::GROUP)
                            @include('frontend.partials.svg.icons.users')
                                <span>{{ __('GALLERY_CLASSES') }}</span>
                            @endif
                        <p>
                        @if($item['call_type'] == CallTypes::GROUP)
                            (<span id="peopleLeft">{{$user_slots_left}}</span> {{$user_slots_left > 1 ? __('STUDENTS_BOOKED') : __('STUDENT_BOOKED') }})
                        @endif
                    </div>
                    <div class="social-secend-box fl">
                        <p class="df aic g8px">

                            @if ($item['talk_type'] == TalkTypes::VOICE_CALL)
                                @include('frontend.partials.svg.icons.phone-small')
                                <span>{!! __('VOICE_TALK') !!}</span>
                            @elseif($item['talk_type'] == TalkTypes::VIDEO_CALL)
                                @include('frontend.partials.svg.icons.video-small')
                                <span>{!! __('VIDEO_TALK') !!}</span>
                            @endif
                        <p>
                    </div>
                </div>
            </div>

            @if ($item['anonym'] == 1)
                <div class="profile-img-box d-flex">
                    <div class="anonnymous-wrap">
                        @if ($item['participant_user_id'] === $user->id)
                            <b><small><em>({!! __('YOU') !!})</em></small></b>
                        @endif
                        <span>{!! __('ANONNYMOUS_USER') !!}</span>
                    </div>
                    <div class="anonnymous-wrap">
                        @include('frontend.partials.svg.icons.anonymous-black')
                    </div>
                </div>
            @else
                <div class="profile-img-box d-flex">
                    @if ($item['call_type'] == CallTypes::ONE_TO_ONE)

                        <div class="profile-wrap">
                            @if ($item['profile_picture'] && !Str::contains($item['profile_picture'], 'gdpr'))
                                <img class="serachImg" src="{{ $item['profile_picture'] }}"
                                    alt="{{ $item['teacher_username'] }}" title="{{ $item['teacher_name'] }}">
                            @else
                                @include('frontend.partials.svg.icons.no-profile-picture-60')
                            @endif
                        </div>
                    @elseif($item['call_type'] == CallTypes::GROUP)
                        @if ($user->id === $item['teacher_id'])
                            @foreach ($item['booking_participants'] as $participant)
                                <div class="profile-wrap">
                                    <img src="@if ($participant['profile_picture']) {{ $participant['profile_picture'] }}@else {{ env('USER_DEFAULT_IMAGE') }} @endif"
                                        alt="{{ $participant['profile_name'] }}"
                                        title="{{ $participant['profile_name'] }}" />

                                </div>
                            @endforeach
                        @else
                            <div class="profile-wrap">
                                <img src="@if ($item['booking_participants'][0]['profile_picture']) {{ $item['booking_participants'][0]['profile_picture'] }}@else {{ env('USER_DEFAULT_IMAGE') }} @endif"
                                    alt="{{ $item['teacher_username'] }}" title="{{ $item['teacher_username'] }}" />
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="fr w-80">
        @include('frontend.partials.pages.booking.extend-item-short', ['item' => $item])
    </div>



</div>
