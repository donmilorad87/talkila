    <div class="bookings-inner book-modal" data-popup="classDetails-{{$item['id']}}">
        <div class='d-flex'>
            <div class="d-flex timing-box-left">
                <div class="inner-box-timing">
                    <h6>{{$item['duration']}}</h6>
                    <p>
                        @if($item['duration'] > 1)
                            {{ __('PROFILE_MINUTES') }}
                        @else
                            {{ __('PROFILE_MINUTE') }}
                        @endif
                    </p>
                </div>
                <h5>{{$item['headline']}}</h5>
            </div>
            <div class="timing-box-right d-flex">
                <div class="timezone-inner">
                    <p data-postpone-time="{{ $item['start_call'] }}">{{changeDateFormat(hourMinuteWithAMPM, $item['start_call'])}} - {{changeDateFormat(hourMinuteWithAMPM,$item['end_call'])}}</p>
                    <span>
                        {{ __('TIMEZONE') }} ( {{getLocalTimeZoneName()}} )
                    </span>
                </div>
                <div class="optionButton" data-opened="0">
                    @include('frontend.partials.svg.icons.v-dots')
                    <ul>
                        <li class="noselect cp" data-popup="cancelAppointment"> {{ __('TALK_CANCEL') }} </li>
                        <li class="noselect"> {{ __('MARK_AS_NO_SHOW') }} </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <div class="d-flex social-wrap">
                <div class="social-first-box">
                    @include('frontend.partials.svg.icons.video')
                    <p>{{ __('VIDEO') }}</p>
                </div>
                <div class="social-secend-box">
                    <p>@include('frontend.partials.svg.icons.group') {{ __('GALLERY_CLASS') }} {{ __('GALLERY_CLASSES') }}</p>
                    <p>@include('frontend.partials.svg.icons.video-small') {{ __('VIDEO_TALK') }}
                    <p>
                </div>
            </div>
            <div class="profile-img-box d-flex">
                <div class="anonnymous-wrap">
                    <span>{{ __('ANONNYMOUS_USER') }}</span>
                </div>
                <div class="anonnymous-wrap">
                    @include('frontend.partials.svg.icons.anonymous-black')
                </div>
            </div>
        </div>
    </div>
