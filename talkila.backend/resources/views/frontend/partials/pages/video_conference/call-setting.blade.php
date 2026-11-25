<div class="popupBase" id="callSetting" data-opened="0">
    <div class="popuper ppBB">
        <div class="credit-model" id="call-settings">
            <div class="grid-x grid-padding-x">
                <div class="cell small-12 medium-12 large-12">
                    <h4>{{ __('SETTINGS') }}</h4>
                </div>
            </div>
            <br>
            <div class="grid-x grid-margin-x" id="callSettingsInner">
                <div class="cell small-12 medium-7 pt16">
                    <div id="allowCamMainCont">
                        <div class="grid-x cell small-12 csic">
                            <div class="cell small-2">
                                <div class="notApr">
                                    @include('frontend.partials.svg.icons.talkila-x-white')
                                </div>
                            </div>

                            <div class="cell small-10 pl10">

                                <p class="pm0" id="webcammsg">{{ __('WEB_CAMERA_DETECTED') }}</p>
                                <button class="button green m0 allowAcessButton" id="accessCamera">{{ __('ALLOW_ACCESS') }}</button>
                            </div>
                        </div>

                        <div class="grid-x cell small-12 csic dn">
                            <div class="cell small-2">
                                <div class="green">
                                    @include('frontend.partials.svg.icons.talkila-check-white')
                                </div>
                            </div>

                            <div class="cell small-10 pl10">

                                <p class="pm0">{{ __('WEB_CAMERA_DETECTED') }}</p>

                                <select id="videoinput">
                                </select>

                            </div>
                        </div>
                    </div>
                    <div id="allowMicMainCont">
                        <div class="grid-x cell small-12 csic">
                            <div class="cell small-2">
                                <div class="notApr">
                                    @include('frontend.partials.svg.icons.talkila-x-white')
                                </div>
                            </div>

                            <div class="cell small-10 pl10">

                                <p class="pm0" id="micmsg">{{ __('MICROPHONE_DETECTED') }}</p>
                                <button class="button green m0 allowAcessButton" id="allowMic">{{ __('ALLOW_ACCESS') }}</button>
                            </div>
                        </div>

                        <div class="grid-x cell small-12 csic dn">
                            <div class="cell small-2">
                                <div class="green">
                                    @include('frontend.partials.svg.icons.talkila-check-white')
                                </div>
                            </div>

                            <div class="cell small-10 pl10">

                                <p class="pm0" >{{ __('MICROPHONE_DETECTED') }}</p>

                                <select id="audioinput">
                                </select>

                            </div>
                        </div>
                    </div>
                   {{--  <div>
                        <div class="grid-x cell small-12 csic">
                            <div class="cell small-2">
                                <div class="green">
                                    @include('frontend.partials.svg.icons.talkila-check-white')
                                </div>
                            </div>

                            <div class="cell small-10 pl10">

                                <div class="w-100 fl" id="audioOutputSwitchingVideoTalk">
                                    <div class="select">
                                        <label for="audioOutput">{{ __('AUDIO_OUTPUT_DESTINATION') }}: </label>
                                        <select id="audioOutput">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
                <div class="cell small-12 medium-5 posrelative tac" id="videopreviewparent">

                    @include('frontend.partials.svg.icons.video-frame')
                    <video autoplay src="" id="videoinputpreview" style="width: 100%; height: auto;"></video>
                </div>

                <br>
                <div class="applySet w-100 fl pl16 pt16">
                    <div class="text-right d-flex mt-2">
                        <span class="hollow btn my-0 mb16" style="margin-left: auto;" id="room-connect-button">@lang('APPLY')</span>
                    </div>
                </div>

            </div>
            <div class="dn" id="enterRoom" onclick="closePopup('callSetting')">
                <div class="">
                    <span class="btn hollow btn my-0 mb16">@lang('ENTER_ROOM')</span>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
