<div class="popupBase webCampPopup" id="takePictureWithWebCam">
    <div class="popuper ppBB popupBackgroundGray">
        <div class="p16 pb0 mt52 popupWhiteRounded">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' =>  __('TAKE_PHOTO_WITH_WEB_CAM'),
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'1',
                    'back_popup' => 'takePictureWithWebCam',
                    'saveButtonText' => 'saveButtonTextEducation'
                ]
            )

            <div id="webCamContTakePic" class="tac">


                <div class="w-100 fl" id="videoSourceSelect">
                    <div class="select">
                        <label for="videoSource" class="grayText">{{ __('VIDEO_SOURCE') }}: </label>
                        <select id="videoSource"></select>
                    </div>
                </div>
                <div class="w-100 fl" id="videoSourceInput">
                    <video id="video" playsinline autoplay></video>
                </div>
                <div class="w-100 fl mt16" id="takePhotoButton">
                    <button id="startbutton" class="btn w-50 warning mb0 m0a">{{ __('TAKE_PHOTO') }}</button>
                    <canvas id="canvas" class="dn">
                    </canvas>
                </div>
                <div class="output w-100 fl lh0">
                    <img id="photo">
                    <img id="photo2">

                </div>
                <div class="output w-100 fl mt16 mb16">
                    <button id="takePictureAgain" class="takePictureAgain btn w-40 warning dn fl mb0">{{ __('TAKE_ANOTHER_PICTURE') }}</button>
                    <button id="submitButton" class="btn w-40 warning dn fr mb0">{{ __('UPLOAD_PHOTO') }}</button>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup webCampPopup dn">×</span>
    </div>
</div>
