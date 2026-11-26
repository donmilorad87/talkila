<div class="show-for-medium2" id="deskBookings">
    @if (isset($userBookingDataByDate['data']) && !empty($userBookingDataByDate['data']))

        @foreach ($userBookingDataByDate['data'] as $item)
            @include('frontend.partials.pages.booking.booking-item', ['items' => $item])
        @endforeach
    @else
        @include('frontend.partials.components.no-booking-found')
    @endif
</div>

<div class="hide-for-medium2">
    <div class="grid-x">
        <div class="medium-12 large-12 small-12">
            @if (isset($userBookingDataByDate['data']) && !empty($userBookingDataByDate['data']))
                <div class="grid-x p01rem">

                    <div class="small-2 cell">
                        <div class="date-selected">
                            <span>{{ substr(changeDateFormat(shortWeek, $userBookingDataByDate['data'][0]['end_call']), 0, 3) }}
                            </span>
                            <strong>{{ changeDateFormat(day, $userBookingDataByDate['data'][0]['end_call']) }}</strong>
                        </div>
                    </div>

                    <div class="small-10 cell" id="mobileBookings">

                        @foreach ($userBookingDataByDate['data'] as $item)
                            @php
                                $booking_status = \App\Http\Controllers\Frontend\BookingController::bookingSwitchBadge($item['booking_status']);
                                $show = \App\Http\Controllers\Frontend\BookingController::compareBookingTime($item['start_call']);
                                $showPostpone = \App\Http\Controllers\Frontend\BookingController::showPostpone($item['start_call']);
                                $user_slots_left = count($item['booking_participants']);
                                $activePointer = \App\Http\Controllers\Frontend\BookingController::activePointer($item['start_call'], $item['end_call']);
                            @endphp

                            <div data-booking-id="{{ $item['id'] }}"
                                class="selectBooking bookings-inner mobile-timing-wrap posrelative cp mr16"
                                data-popup="classDetails-{{ $item['id'] }}">

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


                                <div class="posabsolute bookingBadge">

                                    @if ($booking_status['badgePointer'] === 20)
                                        <div
                                            class="fv600 o07 canceledBookingStudent {{ $booking_status['itemClass'] }}">
                                            @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                                                {{ __('SUPPLIER') . ' | ' }}
                                            @endif {{ $booking_status['itemText'] }}
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
                                                        @endif{{ __('ACTIVE_TALK') }}
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
                                                <div
                                                    class="fw600 {{ $booking_status['itemClass'] ?? 'upcomingBooking' }}">
                                                    @include('frontend.partials.svg.icons.info-icon') @if ($item['teacher_id'] == $user->id)
                                                        {{ __('SUPPLIER') . ' | ' }}
                                                    @endif{!! __('UPCOMING_TALK') !!}
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>

                                <div class="@if ($show || $booking_status['badgePointer'] !== 1) o07 @endif">

                                    <div class="w-100 fl df aic mb16">
                                        @if ($item['profile_picture'] && !Str::contains($item['profile_picture'], 'gdpr'))
                                            <img class="serachImg" src="{{ $item['profile_picture'] }}"
                                                alt="{{ $item['teacher_username'] }}"
                                                title="{{ $item['teacher_name'] }}">
                                        @else
                                            @include('frontend.partials.svg.icons.no-profile-picture-60')
                                        @endif

                                        <div class="bbdasged f1">
                                            <h5 class="m0 pr32">{{ $item['headline'] }}</h5>
                                            {{-- {!! __('BOOKING_CATEGORY_SUBCATEGORY',[
                                                'category' => $item['category'],
                                                'subcategory' => $item['subcategory'],
                                            ]) !!} --}}
                                            <p class="fs12">{{ $item['category'] }} {{-- Course --}} *
                                                {{ $item['subcategory'] }}</p>
                                        </div>
                                    </div>

                                    <div class="w-100 fl df aic svgss minh40">
                                        <div class="boicon df aic">
                                            @include('frontend.partials.svg.icons.clock')
                                        </div>

                                        <div class="w-100 fl mainc">
                                            <p class="fs13 m0 mainc">
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $item['start_call'])->format('H:i') }}
                                                -
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $item['end_call'])->format('H:i') }}
                                                ({{ $item['duration'] . ' ' . __('global.minutes') }})
                                            </p>
                                            <p class="fs12 m0">{!! __('TIMEZONE') !!} (
                                                {{ getLocalTimeZoneName() }} )</p>
                                        </div>
                                    </div>
                                    {{-- private turned off --}}
                                    <div class="w-100 fl df aic svgss minh40">
                                        <div class="boicon df aic">
                                            @if ($item['call_type'] == CallTypes::ONE_TO_ONE)
                                                @include('frontend.partials.svg.icons.course-grey')
                                            @elseif($item['call_type'] == CallTypes::GROUP)
                                                <span>@include('frontend.partials.svg.icons.group', [
                                                    'numberOfStudents' => $user_slots_left,
                                                ])</span>
                                            @endif
                                        </div>

                                        <div class="w-100 fl df aic mainc">
                                            @if ($item['call_type'] == CallTypes::ONE_TO_ONE)
                                                <p class="fs14 m0">{{ __('PRIVATE') }} {{ __('TALK') }}</p>
                                            @elseif($item['call_type'] == CallTypes::GROUP)
                                                <p class="fs14 m0">{{ __('GALLERY_TALK') }} </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-100 fl df aic svgss mh40s">
                                        <div class="boicon df aic">
                                            @if ($item['talk_type'] == TalkTypes::VOICE_CALL)
                                                @include('frontend.partials.svg.icons.phone')
                                            @elseif($item['talk_type'] == TalkTypes::VIDEO_CALL)
                                                @include('frontend.partials.svg.icons.camera_hollow')
                                            @endif
                                        </div>

                                        <div class="w-100 fl df aic mainc">
                                            @if ($item['talk_type'] == TalkTypes::VOICE_CALL)
                                                <p class="fs14 m0"> {{ __('AUDIO') . ' ' . __('TALK') }}</p>
                                            @elseif($item['talk_type'] == TalkTypes::VIDEO_CALL)
                                                <p class="fs14 m0"> {{ __('VIDEO') . ' ' . __('TALK') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($user->id === $item['teacher_id'])
                                        <div class="w-100 fl svgss">
                                            <p class="w-100 mt8 mb0 partText">{{ __('PARTICIPIANTS') }}
                                                ({{ count($item['booking_participants']) }})</p>

                                            <div class="profile-wrap">
                                                <img class="bookingParticipantImg"
                                                    src="@if ($item['booking_participants'][0]['profile_picture']) {{ $item['booking_participants'][0]['profile_picture'] }}@else {{ config('app.default_image') }} @endif"
                                                    alt="{{ $item['booking_participants'][0]['profile_name'] }}"
                                                    title="{{ $item['booking_participants'][0]['profile_name'] }}" />
                                                <span></span>
                                            </div>


                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if (isset($item['extends']) && !empty($item['extends']))
                                @foreach ($item['extends'] as $extendItem)
                                    <div class="pr16">
                                        <div class="posrelative white-box fr mb16 w-100 pt26 h72 df aic mr0 mt0 pr16">
                                            <div class="posabsolute bookingBadge h26 ">

                                                <div class="fv600 o07 grayBooking h26 oh">
                                                    @include('frontend.partials.svg.icons.info-icon')
                                                    <span clss="fs14">
                                                        @lang('EXTENDION')
                                                    </span>
                                                </div>

                                            </div>

                                            <div class='d-flex jcsb w-100 p01rem aic lh2rem'>




                                                <div class="w-100 fl df aic svgss minh40">
                                                    <div class="boicon df aic">
                                                        @include('frontend.partials.svg.icons.clock')
                                                    </div>

                                                    <div class="w-100 fl mainc">
                                                        <p class="fs13 m0 mainc">
                                                            {{ DateTime::createFromFormat('Y-m-d H:i:s', $extendItem['start_call'])->format('H:i') }}
                                                            -
                                                            {{ DateTime::createFromFormat('Y-m-d H:i:s', $extendItem['end_call'])->format('H:i') }}
                                                            ({{ $item['duration'] . ' ' . __('global.minutes') }})
                                                        </p>
                                                        <p class="fs12 m0">{!! __('TIMEZONE') !!} (
                                                            {{ getLocalTimeZoneName() }} )</p>
                                                    </div>
                                                </div>
                                            </div>





                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="no-found-heading">
                    @include('frontend.partials.svg.icons.lazy')
                    <h5>{!! __('NO_BOOKINGS_FOUND') !!}</h5>
                    <a href="{{ route('courses') }}">{!! __('TRY_USING_FILTERS') !!}</a>
                </div>
            @endif
        </div>
    </div>
</div>

@if (isset($userBookingDataByDate['data']) && !empty($userBookingDataByDate['data']))
    @foreach ($userBookingDataByDate['data'] as $item)
        @php
            $booking_status = \App\Http\Controllers\Frontend\BookingController::bookingSwitchBadge($item['booking_status']);
            $show = \App\Http\Controllers\Frontend\BookingController::compareBookingTime($item['start_call']);
            $showPostpone = \App\Http\Controllers\Frontend\BookingController::showPostpone($item['start_call']);
            $user_slots_left = count($item['booking_participants']);
        @endphp

        @include('frontend.partials.pages.booking.class-details', [
            'item' => $item,
            'show' => !$show,
            'booking_status' => $booking_status,
            'teacher_id' => $item['teacher_id'],
            'userId' => $user->id,
        ])
    @endforeach
@endif
