<div class="popupBase" id="blankPopup" data-opened="0">
    <div class="popuper ppB popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' => __('ABOUT_ME'),
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'',
                    'back_popup' => 'blankPopup',
                    'saveButtonText' => 'saveButtonTextEducation'
                ]
            )

            <div id="blankPopupPopuper">

            </div>
        </div>


        <span class="closeSpanPopup">×</span>
    </div>

</div>
