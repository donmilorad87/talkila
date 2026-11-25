<div class="popupBase" id="time-slot-popup">
    <div class="popuper ppB popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => __('ADD_TIME_SLOT'),
                'page_back_link' => '1',
                'save_button' => '0',
                'step_progress_text' => '',
                'back_popup' => 'time-slot-popup',
                'saveButtonText' => 'saveButtonTextEducation',
            ])
            <div class="grid-x">


                <p class="m0">{{ __('DESCRIPTION_SET_AVAILABILITY') }} </p>

                <div class="form-option" id="step3-form">


                    @include('frontend.partials.components.seven-days-static')



                    @include('frontend.partials.components.time-select')

                    <div id="timeSlotValidation" class="mt8 mb8 fl w-100 h0o0"></div>

                    <div class="w-100 fl">
                        <span class="btn w-100 fl" id="submit-btn">{{ __('ADD_TIME_SLOT') }}</span>
                    </div>


                </div>
            </div>

            <template id="availabilitySlot">

                <div class="date-wrap-content d-flex g1rem bb1 mb8 pb8">

                    <div class="date-time availabilityIds" data-time-slot-id="IDD">
                        <p><strong class="availabilityDay"></strong></p>
                        <small><span class="availabilityStartTime"></span> - <span class="availabilityEndTime"></span></small>
                    </div>

                    <div class="button-switch switch">
                        <input class="switch-input user-availability availabilityId inputAva" id="availability-IDD" type="checkbox"
                            data-weekday="weekday" data-starttime="time" data-endtime="time"
                            name="availability" value="IDD" checked="">


                        <label class="switch-paddle" for="availability-IDD">
                            <span class="show-for-sr">DOWNLOAD_KITTENS</span>
                        </label>
                    </div>
                    <span class="availability-delete availabilityIdss" data-id="IDD">
                        @include('frontend.partials.svg.icons.remove')
                    </span>


                </div>

            </template>


        </div>

        <span class="closeSpanPopup">×</span>
    </div>

</div>
