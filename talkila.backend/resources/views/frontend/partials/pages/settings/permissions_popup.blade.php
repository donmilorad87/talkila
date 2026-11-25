<div class="popupBase" id="permision_popup" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' => __('SET') . ' ' .__('PERMISSIONS'),
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'0',
                    'back_popup' => 'permision_popup',
                    'saveButtonText' => 'saveButtonTextEducation'
                ]
            )

            <div class="grid-container">
                <div class="dfpermision">
                    <div class="red framePermision">
                       @include('frontend.partials.svg.icons.permissions_pending')
                    </div>
                    <div class="green framePermision dn">
                        @include('frontend.partials.svg.icons.permissions')
                     </div>
                    <h6> @lang('PERMISSION_NOT_SUFFICIENT') </h6>
                </div>
                <div class="mt16 fs14">
                    @lang('PERMISSION_BODY_TEXT')
                </div>

                <div class="dfTablePerm bb1">
                    <p>@lang('NAME')</p>
                    <p>@lang('STATUS')</p>
                </div>

                <div class="dfTablePerm aic bb1 webCam mh88">
                    <div class="diss">
                        <div class="df aic">
                            <div class="mr12 df">
                                @include('frontend.partials.svg.icons.shutter')
                            </div>
                            <div class="fw600 fs14">
                                @lang('CAMERA')
                            </div>
                        </div>
                        <p class="fs12 pr12">
                            @lang('CAMERA_TEXT_PERMISSIONS')
                        </p>
                    </div>
                    <div class="fs14 diss buttonField">
                        <button class="fw600 btn hollow mb0 w116px webCamButton">
                            @lang('NOT_APPROVED')
                        </button>
                        <p class="greenColor fw600 tac dn">
                            @lang('APPROVED')
                        </p>
                    </div>

                    <div id="webCameraIsNotPressent" class="dn">
                        @lang('WEB_CAMERA_IS_NOT_PRESENT')
                    </div>
                </div>

                <div class="dfTablePerm aic microPhone mh88">
                    <div class="diss">
                        <div class="df aic">
                            <div class="mr12 df">
                                @include('frontend.partials.svg.icons.microphone')
                            </div>
                            <div class="fw600 fs14">
                                @lang('MICROPHONE')
                            </div>
                        </div>
                        <p class="fs12 pr12">
                            @lang('MICROPHONE_PERMISSION_TEXT')
                        </p>
                    </div>
                    <div class="fw600 fs14 diss buttonField">
                        <button class="fw600 btn hollow mb0 w116px microphoneButton">
                            @lang('NOT_APPROVED')
                        </button>
                        <p class="greenColor fw600 tac dn">
                            @lang('APPROVED')
                        </p>
                    </div>
                    <div id="microphoneIsNotPresent" class="dn">
                        @lang('MICROPHONE_IS_NOT_PRESENT')
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
