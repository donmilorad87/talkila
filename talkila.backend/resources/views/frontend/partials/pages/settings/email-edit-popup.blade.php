<div class="popupBase" id="editEmail" data-opened="0">
    <div class="popuper posrelative ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => __('EDIT_EMAIL'),
                        'page_back_link' => "1",
                        "save_button"=>"0",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'editEmail',
                        'saveButtonText' => 'saveButtonTextEducation'
                    ]
                )

            <div class="grid-x">

                <p class="small-12 mb24"> {{ __('EDIT_YOUR_EMAIL') }}</p>
                <div class="small-12">
                    <form class="" id="edit_email_form">
                        <div id="_token">
                            @csrf
                        </div>
                        <div class="grid-x grid-margin-x">

                            <div class="cell small-12">
                                <div class="group">
                                    <input class="email-input {{ !empty($user->email) ? 'ok' : '' }}"
                                           type="text"
                                           name="email"
                                           required
                                           @if(!empty($user->email))
                                           value="{{ $user->email }}"
                                           @endif
                                           autocomplete="off" />
                                    <div class="verified-email-svg {{ !empty($user->email) ? 'active' : '' }}">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="email-warn">{{ __('MUST_BE_LEGAL_FORMAT') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('EMAIL') }}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="flex-content-right">
                        <button class="btn warning submit-button" id="emailSubmit">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
