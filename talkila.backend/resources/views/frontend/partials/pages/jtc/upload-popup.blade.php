<div class="popupBase" id="uploadDropArea">
    <div class="popuper ppBB popupBackgroundGray">
        <div class="p16 fl w-100 mt52 popupWhiteRounded">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' =>  __('UPLOAD_PROFILE_IMAGE'),
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'1',
                    'back_popup' => 'uploadDropArea',
                    'saveButtonText' => 'saveButtonTextEducation'
                ]
            )

            <p> {{ __('DRAG_FILES_TO_DROP') }}</p>
            @include('frontend.partials.components.upload-drop-area',['id' => '2'])

            <span class="btn w-100 fl warning fr checkImageBeforeUpload">{{ __('UPLOAD_THIS_IMAGE') }}</span>

            <div class="uplCamPicButton m0 w-100 mt16">
                <span class="btn w-100 hollow fl cp takePictureWithWebCam mb0" data-popup="takePictureWithWebCam"> {{ __('TAKE_PHOTO_WITH_CAMERA') }}</span>
            </div>
        </div>

        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
