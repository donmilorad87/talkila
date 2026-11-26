
@if (isset($item['extends']) && !empty($item['extends']))
        <div class="fl w-100 mt16">
            @foreach ($item['extends'] as $extendItem)
                <div class="posrelative white-box fr mb16 w-80">
                    <div class="posabsolute bookingBadge">

                        <div class="fv600 o07 canceledBookingStudent">
                            @include('frontend.partials.svg.icons.info-icon') @lang('EXTENDION')
                        </div>

                    </div>

                    <div class='d-flex'>
                        <div class="d-flex timing-box-left">
                            <div class="inner-box-timing width64px duration{{ $extendItem['duration'] }}">
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

                                    <p class="fs12 m0">{{ $item['category'] }} {{-- Course --}} *
                                        {{ $item['subcategory'] }}</p>
                                </div>
                            </div>



                        </div>

                        <div class="timing-box-right d-flex mwidth167 jcfe">
                            <div class="timezone-inner">

                                <p data-postpone-time="{{ $item['start_call'] }}">
                                    {{ DateTime::createFromFormat('Y-m-d H:i:s', $extendItem['start_call'])->format('H:i') }}
                                    -
                                    {{ DateTime::createFromFormat('Y-m-d H:i:s', $extendItem['end_call'])->format('H:i') }}
                                </p>
                                <span>
                                    {!! __('TIMEZONE') !!} ( {{ getLocalTimeZoneName() }} )
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="d-flex social-wrap">

                            <div class="social-first-box width64px">

                            </div>

                            <div class="talkDetailsInfoBox">

                                <div class="social-secend-box fl">
                                    <p>

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
                                                alt="{{ $item['teacher_username'] }}"
                                                title="{{ $item['teacher_name'] }}">
                                        @else
                                            @include('frontend.partials.svg.icons.no-profile-picture-60')
                                        @endif
                                    </div>
                                @elseif($item['call_type'] == CallTypes::GROUP)
                                    @if ($userData['id'] === $item['teacher_id'])
                                        @foreach ($item['booking_participants'] as $participant)
                                            <div class="profile-wrap">
                                                <img src="@if ($participant['profile_picture']) {{ $participant['profile_picture'] }}@else {{ config('app.default_image') }} @endif"
                                                    alt="{{ $participant['profile_name'] }}"
                                                    title="{{ $participant['profile_name'] }}" />

                                            </div>
                                        @endforeach
                                    @else
                                        <div class="profile-wrap">
                                            <img src="@if ($item['booking_participants'][0]['profile_picture']) {{ $item['booking_participants'][0]['profile_picture'] }}@else {{ config('app.default_image') }} @endif"
                                                alt="{{ $item['teacher_username'] }}"
                                                title="{{ $item['teacher_username'] }}" />
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    @endif
