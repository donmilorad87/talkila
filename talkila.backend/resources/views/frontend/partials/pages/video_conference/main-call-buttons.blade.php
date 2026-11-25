<div class="video-cta dn">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">

            <div class="cell small-12">
                <ul class="social-wrap">

                    <li class="extendMobileLi hide-for-medium2 extendLessonDuration" data-popup="extendCall">
                        <span id="extendMobile">
                            @include('frontend.partials.svg.icons.extend_icon')

                        </span>
                    </li>
                    {{-- <li class="share_screen">
                        <span>
                            @include('frontend.partials.svg.icons.share-screen')
                        </span>
                    </li> --}}
                    <li class="dn">
                        <span class="showMobileSettingsPanel" data-opened="0">
                            @include('frontend.partials.svg.icons.setting-2')
                            {{-- @include('frontend.partials.svg.icons.pip') --}}
                        </span>
                    </li>
                    <li class="privateMobileSettings">
                        <span class="cp" data-popup="callSetting">
                            @include('frontend.partials.svg.icons.setting-2')

                        </span>
                    </li>
                    <li><span id="video-mute-unmute">@include('frontend.partials.svg.icons.video_talk_video_muted')</span></li>
                    <li><span id="audio-mute-unmute">@include('frontend.partials.svg.icons.video_talk_audio_mute')</span></li>
                    <li><span class="hangup">@include('frontend.partials.svg.icons.hangup')</span></li>
                </ul>

            </div>

        </div>
    </div>
</div>
