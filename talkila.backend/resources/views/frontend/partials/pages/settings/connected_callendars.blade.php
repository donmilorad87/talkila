<div class="popupBase" id="connected_calendars" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

        <div class="step-heading-wrap mt52 popupWhiteRounded db fl">
            {{-- <h6 class="">{{ __('CV') }}</h6>
                <ul class="ability-headsad gledam oing-ul">
                    <li>{{ __('SETTING_BILLING_INFORMATION_TEXT_1') }}</li>
                    <li>{{ __('SETTING_BILLING_INFORMATION_TEXT_2') }}<br>{{ __('SETTING_BILLING_INFORMATION_TEXT_3') }} </li>
                </ul> --}}

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => __('CONNECTED_CALENDAR'),
                'page_back_link' => '/jtc/welcome',
                'save_button' => '0',

                'back_popup' => 'connected_calendars',
                'saveButtonText' => 'saveButtonText',
            ])


            @include('frontend.partials.components.calendar_list')

            @include('frontend.partials.components.add_calendar')

        </div>


        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
