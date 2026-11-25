<div class="grid-container full posrelative">
    <div class="grid-x overflow-hidden">
        <div class="cell small-12">
            <div class="top-bar top-bar-video">
                <div class="top-bar-left d-flex">
                    <a href="{{route('home')}}" class="logoCall">
                        @include('frontend.partials.svg.icons.talkila-logo')
                    </a>
                    <div id="timeInfoLessonCont" class="h64px">
                        <ul class="dropdown menu" data-dropdown-menu>
                            <li class="d-flex heading-title-wrap-german dn">
                                @include('frontend.partials.svg.icons.hotspot')
                                <div class="heading-group">
                                    <p></p>
                                    <p class="languages-title"><span class="talkCategoryLanguage"> </span>
                                        <span id="startCalltime"></span> - <span id="endCallTime"></span>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>



                <div class="top-bar-right d-flex top-header-manage h64px dn">
                    <div class="h64px">
                        <ul class="posrelative h64px dropdown menu d-flex menu-right">


                            {{-- <li class="share_screen">
                                    <div>
                                        @include('frontend.partials.svg.icons.screen_share_with_frame')
                                    </div>
                                </li> --}}

                                <li id="raise_hand_list_button" data-opened="0" class="dn">
                                    <div>
                                        @include('frontend.partials.svg.icons.hands-up-talk')
                                    </div>
                                </li>

                                <li id="raise_hand" class="dn">
                                    <div>
                                        @include('frontend.partials.svg.icons.raise_hand')
                                    </div>
                                </li>

                                <li id="stop_raise_hand" data-event="0" class="dn">
                                    <div>
                                        @include('frontend.partials.svg.icons.raise_hand_cross')
                                    </div>
                                </li>

                                <li id="extendThisCallLi" class="mr12 dn"><span href="profile-preview.html"
                                    class="yellow-btn-extend btn extendLessonDuration" id="extendLessonDuration"
                                    data-popup="extendCall">{{ __('TALK_EXTEND') }}</span></li>
                            <li id="settingsForTalk">
                                <div class="cp" data-popup="callSetting">
                                    @include('frontend.partials.svg.icons.setting')
                                </div>
                            </li>
                            <li>
                                <div class="mute-all-video dn">
                                    @include('frontend.partials.svg.icons.video-black')
                                </div>
                            </li>
                            <li>
                                <div class="mute-all-audio dn">
                                    @include('frontend.partials.svg.icons.mute')
                                </div>
                            </li>
                            <li class="d-flex" id="time-left-wrapper">
                                <span class="time-left">@include('frontend.partials.svg.icons.time-left')
                                    <strong id="talkDuration" class="dn"></strong>
                                    <strong id="timeGone" class="dn"></strong>
                                    <strong id="timeLeft"></strong>
                                    <canvas id="progresTalkChanvas" width="57" height="57"></canvas>
                                </span>
                                <p class="minutes-title">{{ __('MINUTES_LEFT') }}</P>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
