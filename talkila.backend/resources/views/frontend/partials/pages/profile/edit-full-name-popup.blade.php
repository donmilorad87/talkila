<div class="popupBase" id="editFullName" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => __('EDIT_FULL_NAME'),
                        'page_back_link' => "1",
                        "save_button"=>"0",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'editFullName',
                        'saveButtonText' => 'saveButtonTextEducation'
                    ]
                )

            <div class="grid-x">


                <div class="small-12">
                    <form class="mt32 mb16" id="edit_full_name_form">
                        @csrf
                        <div class="grid-x grid-margin-x">

                            <div class="cell small-12">
                                <div class="group">
                                    <input class="name-input {{ !empty($user['name']) ? 'ok' : '' }}"
                                           type="text"
                                           name="name"
                                           data-version="d"
                                           required
                                           @if(!empty($user['name']))
                                           value="{{ $user['name'] }}"
                                           @endif
                                           autocomplete="off" />
                                    <div class="verified-name-svg {{ !empty($user['name']) ? 'active' : '' }}">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <label class="count-label">0/50</label>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="name-warn">{{ __('VALIDATION_NAME_TWO_WORDS') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('YOUR_NAME') }}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="flex-content-right">
                        <button class="btn warning submit-button" id="editFullNameButton">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
