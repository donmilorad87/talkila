<div class="popupBase" id="deleteTalkPopup" data-opened="0">
    <div class="ppR popuper popupBackgroundGray oh">
        <div class="grid-x mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' =>  "Delete Talk",
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'1',
                    'back_popup' => 'deleteTalkPopup',
                    'saveButtonText' => '0'
                ]
            )

            <div class="w-100">

                <h5 class="tac mb16">
                    {{ __('ARE_YOU_SURE_TO_REMOVE_TALK') }}
                </h5>

                <div class="date-wrap-content w-100">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="cancel_bookings" type="checkbox" name="cancel_bookings">
                        <div class="posrelative anonim d-flex specWidth">

                            <p class="posrelative">
                                {{ __('CANCEL_FUTURE_BOOKINGS') }}
                            </p>
                            @include('frontend.partials.components.tooltip-left', [
                                'tooltip_text' => __('NOTICE_CANCEL_FUTURE_BOOKINGS'),
                                'class' => 'noticeCancelBookingsToolTip',
                            ])
                        </div>

                        <label class="switch-paddle" for="cancel_bookings">

                        </label>

                    </div>

                </div>

                <div class="w-100 df jcsb">

                    <span class="btn f1 mr16 hollow" id="cancelRemovingCourse">
                        {{ __('CANCEL') }}
                    </span>

                    <span class="btn f1" id="acceptRemovingCourse">
                        {{ __('YES') }}
                    </span>

                </div>

            </div>

        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
