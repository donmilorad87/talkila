<div class="popupBase" id="extend-call-popup" data-opened="0">
    <div class="popuper">
        <div class=" credit-model">
            <ul class="users-mobile-view-wra">
                <li class="group-icon"> @include('frontend.partials.svg.icons.group')</li>
                <li>12</li>
                <li>
                    <a class="inner-box-timing">
                        <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                    </a>
                </li>

                <li>
                    <a class="inner-box-timing">
                        <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                        <span> @include('frontend.partials.svg.icons.no-video') </span>
                    </a>
                </li>

                <li>
                    <a class="inner-box-timing">
                        <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                        <span> @include('frontend.partials.svg.icons.no-audio')</span>
                    </a>
                </li>



            </ul>

            <div class="btn-group-call">
                <span class="right-line">00:00:12</span>
                <span>@include('frontend.partials.svg.icons.extend-call') {{ __('TALK_EXTEND') }}</span>
            </div>
            <div class="group-call-mobile">

                <div class="d-flex">
                    <h5>{{ __('CALCULATOR_BUTTON_GROUP') }}</h5>
                    <span>@include('frontend.partials.svg.icons.group') 12</span>
                </div>
                <span class="btn hollow">{{ __('MUTE_ALL_PARTICIPANTS') }}</span>
                <span class="btn hollow">{{ __('TURN_OFF_ALL_PARTICIPANT_VIDEOS') }} </span>
            </div>
            <div class="chating-main-wrap-inner">
                <h5>{{ __('PARTICIPIANTS') }}</h5>
                <div class="d-flex chating-box-inner">
                    <div class="d-flex chating-inner">
                        <div class="inner-box-timing">
                            <img width="56" src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                        </div>
                        <p>Jessica Jefferson</p>
                    </div>
                    <div class="timing-box-right d-flex">
                        <div class="timezone-inner">
                            <p>@include('frontend.partials.svg.icons.low') {{ __('LOW') }}</p>
                        </div>
                        <div class="three-dotted optionButton" data-opened="0">
                            @include('frontend.partials.svg.icons.v-dots')
                            <ul>
                                <li class="noselect cp" data-popup="cancelAppointment"> {{ __('TALK_CANCEL') }} </li>
                                <li class="noselect"> {{ __('MARK_AS_NO_SHOW') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex chating-box-inner">
                    <div class="d-flex chating-inner">
                        <div class="inner-box-timing">
                            <img width="56" src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                        </div>
                        <p>Jane Doe</p>
                    </div>
                    <div class="timing-box-right d-flex">
                        <div class="three-dotted optionButton" data-opened="0">
                            @include('frontend.partials.svg.icons.v-dots')
                            <ul>
                                <li class="noselect cp" data-popup="cancelAppointment"> {{ __('TALK_CANCEL') }} </li>
                                <li class="noselect"> {{ __('MARK_AS_NO_SHOW') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex chating-box-inner">
                    <div class="d-flex chating-inner">
                        <div class="inner-box-timing">
                            <img width="56" src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                        </div>
                        <p>Jessica Longlas...</p>
                    </div>
                    <div class="timing-box-right d-flex">
                        <div class="timezone-inner red-heading">
                            <p>@include('frontend.partials.svg.icons.bad') Bad</p>
                        </div>
                        <div class="three-dotted optionButton" data-opened="0">
                            @include('frontend.partials.svg.icons.v-dots')
                            <ul>
                                <li class="noselect cp" data-popup="cancelAppointment"> {{ __('TALK_CANCEL') }} </li>
                                <li class="noselect"> {{ __('MARK_AS_NO_SHOW') }} </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="social-wrap social-mobile-view">
                <li><span>@include('frontend.partials.svg.icons.pip')</span></li>
                <li><span>@include('frontend.partials.svg.icons.video-black')</span></li>
                <li><span>@include('frontend.partials.svg.icons.mute')</span></li>
                <li><span class="hangup">@include('frontend.partials.svg.icons.hangup')</span></li>
            </ul>


        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
