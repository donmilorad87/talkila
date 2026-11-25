<div class="popupBase" id="deleteProfilePopup" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container p0">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title'        =>  __('DELETE_PROFILE'),
                    'page_back_link'    => "",
                    "save_button"       => "0",
                    'step_progress_text'=> 'Step 3 of 5',
                    'back_popup'        => 'deleteProfilePopup',
                    'saveButtonText'    => 'deletePrivateAccount'
                ]
            )

            <div class="small-12 pl16 pr16 whiteb br0dot5rem">


                <div class="fdc flex-content-right mt48 aic jcc g0dot5rem pt16">
                    <p class="f2">
                        @lang('DELETE_POPUP_TEXT')

                    </p>
                    <div class="w-100 g1rem df mb16">
                        <button class="btn submit-btn-red lh40 w-100" id="deleteProfile">{{ __('DELETE') }}</button>
                        <button class="btn submit-btn-red lh40 w-100 hollow" onclick="closePopup('deleteProfilePopup')">{{ __('CANCEL') }}</button>
                    </div>

                </div>
            </div>

        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
