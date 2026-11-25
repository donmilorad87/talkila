<div class="popupBase" id="addShortDescription" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => __('ADD') . ' ' . __('BIO'),
                        'page_back_link' => "1",
                        "save_button"=>"0",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'addShortDescription',
                        'saveButtonText' => 'saveButtonTextEducation'
                    ]
                )

            <div class="grid-x">
                {{-- <div class="cell small-12 posrelative">
                    @include('frontend.partials.components.mobile-page-navigation-header', ['page_title' => 'Add bio', 'page_back_link' => '#'])
                </div> --}}
                {{-- <h5 class="small-12">{{ __('ABOUT_ME') }} </h5> --}}
                <p class="small-12">{{ __('USER_INF_ADD_BIO_DESCRIPTION') }} </p>
                <div class="small-12">
                    <form class="form-option" id="add-bio-form">

                        <div class="grid-x grid-margin-x">

                            <div class="cell small-12">
                                <div class="group pb24">
                                    <textarea class="default-textarea {{ $user->description ? 'ok': '' }}" type="text" name="addBio" required>{{ $user->description ?? null }}</textarea>
                                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')
                                    </div>
                                    <label class="count-label b0">0/1000</label>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('ABOUT_ME') }}</label>
                                </div>
                                {{-- @include('frontend.partials.components.tooltip-left', ['tooltip_text' =>  __('NOTICE_WONT_SHARE_INFO') ]) --}}
                            </div>
                        </div>
                    </form>
                    <div class="flex-content-right">
                        <button class="btn warning submit-button" id="bioSubmit">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
