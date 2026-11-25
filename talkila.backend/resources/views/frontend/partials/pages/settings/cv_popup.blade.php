<div class="popupBase" id="cv_popup" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

            <div class="step-heading-wrap mt52 popupWhiteRounded">
                {{-- <h6 class="">{{ __('CV') }}</h6>
                <ul class="ability-headsad gledam oing-ul">
                    <li>{{ __('SETTING_BILLING_INFORMATION_TEXT_1') }}</li>
                    <li>{{ __('SETTING_BILLING_INFORMATION_TEXT_2') }}<br>{{ __('SETTING_BILLING_INFORMATION_TEXT_3') }} </li>
                </ul> --}}

                @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => "Your CV",
                        'page_back_link' => "/jtc/welcome",
                        "save_button"=>"0",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'cv_popup',
                        'saveButtonText' => 'saveButtonText'
                    ]
                )

                <h6 class="title-billing-info">{{ __('YOU_WORK_EXPERIENCE') }}</h6>
                <p class="subTitle">{{ __('THIS_WILL_BE_VISIBLE') }}</p>
                <button class="btn w-100 hollow expanded cp" data-popup="add_cv_work_experience"> {{ __('ADD') }} </button>
                <h6 class="title-billing-info">{{ __('PROFILE_EDUCATION') }}</h6>
                <p class="subTitle">{{ __('THIS_WILL_BE_VISIBLE') }}</p>
                <button class="btn w-100 hollow expanded cp" data-popup="add_education"> {{ __('ADD') }} </button>

            </div>


        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
