<div class="mobile-call-wrap">
    <div class="circle-wrap">
                        <div class="circle-wrap-inner">
                        @include('frontend.partials.svg.icons.call-in-bg')
                            <div class="minutes-progress-inner">
                                <h2 class="h1">15</h2>
                                <p>{{ __('MINUTES_LEFT') }}</p>
                            </div>
                        </div>

                        <div class="social-wrap-mob">
                            <ul class="social-wrap">
                    <li><span>@include('frontend.partials.svg.icons.pip')</span></li>
                    <li><span>@include('frontend.partials.svg.icons.video-black')</span></li>
                    <li><span>@include('frontend.partials.svg.icons.mute')</span></li>
                    <li><span class="hangup">@include('frontend.partials.svg.icons.hangup')</span></li>
                            </ul>
                            <div class="tap-to-extend-btn cp" data-popup="extendPopUp">
                            @include('frontend.partials.svg.icons.extend-call') {{ __('TAP_EXTEND_TALK') }}
                            </div>

                            <!-- <div class="tap-to-extend-btn cp" data-popup="paymentPopUp">
                            @include('frontend.partials.svg.icons.extend-call') Payment Method
                            </div> -->
                        </div>
                    <div class="vocice-call-m-wrap">
                        <div class="d-flex">
                            <div class="title-vocice">{{ __('VOICE_TALK') }}</div>
                            <div class="d-flex vocice-time-btn">
                            @include('frontend.partials.svg.icons.network')
                                <div>17:00 - 17:30</div>
                            </div>
                        </div>

                        <div class="user-group-mobile">
                            <div>
                            <img width="80" src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                                <span class="voice-circle-btn">
                                @include('frontend.partials.svg.icons.wave')
                                </span>
                                <p>Jessica</p>
                            </div>
                        </div>

                    </div>
    </div>
</div>
