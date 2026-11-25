<div class="popupBase" id="changeAvailability" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => __('SET_YOUR_AVAILABILITY'),
                'page_back_link' => '1',
                'save_button' => '0',
                'step_progress_text' => 'Step 3 of 5',
                'back_popup' => 'changeAvailability',
                'saveButtonText' => 'saveButtonTextEducation',
            ])
            <div class="grid-x">
                <div class="cell small-12">


                    @include('frontend.partials.components.addAvailability')

                    @if (!empty($userAvailability))
                        <div id="availabilitesContainer">
                            <div id="availabilitesInnerCont">
                                @include('frontend.partials.components.availabilities', [
                                    'userAvailability' => $userAvailability['availabilities'],
                                ])
                            </div>



                        </div>

                        @include('frontend.partials.components.add_calendar')
                        @include('frontend.partials.components.calendar_list')
                    @endif


                </div>
            </div>


        </div>



        <span class="closeSpanPopup">×</span>
    </div>
</div>

