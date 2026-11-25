<div class="popupBase" id="editPassword" data-opened="0">
    <div class="popuper posrelative ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' =>  __('EDIT_PASSWORD'),
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'1',
                    'back_popup' => 'editPassword',
                    'saveButtonText' => 'saveButtonTextEducation'
                ]
            )
            <div class="grid-x">
                <div class="grid-container small-12 p0">

                   {{--  <h5 class="small-12"> {{ __('EDIT_PASSWORD') }} </h5> --}}
                <p class="small-12 mb24"> {{ __('EDIT_YOUR_PASSWORD') }}</p>
                </div>

                <div class="cell small-12">
                    <form class="" id="edit_password_form">
                        <div id="_token">
                            @csrf
                        </div>
                        <div class="grid-x">

                            {{-- <div class="cell small-12">
                                <div class="group">
                                    <input class="email-input {{ !empty($loggedUserData['email']) ? 'ok' : '' }}"
                                           type="text"
                                           name="email"
                                           required
                                           @if(!empty($loggedUserData['email']))
                                           value="{{ $loggedUserData['email'] }}"
                                           @endif
                                           autocomplete="off" />
                                    <div class="verified-email-svg {{ !empty($loggedUserData['email']) ? 'active' : '' }}">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="email-warn">{{ __('MUST_BE_LEGAL_FORMAT') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('EMAIL') }}</label>
                                </div>
                            </div> --}}

                            <div class="medium-12 small-12">
                                <div class="group">
                                    <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <input class="password-input" type="password" name="password" required {{--autocomplete="off"--}}>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="count-label">0/50</label>
                                    <label class="password-warn">{{ __('VALIDATION_PASSWORD_FORMAT') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('PASSWORD') }}</label>
                                    @include('frontend.partials.components.password-eye')
                                    <div class="validationFields df fww g0dot5rem validationHeight">

                                    </div>

                                </div>

                            </div>

                            <div class="medium-12 small-12">
                                <div class="group">
                                    <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <input class="password-input" type="password" name="new_password" required {{--autocomplete="off"--}}>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="count-label">0/50</label>
                                    <label class="password-warn">{{ __('ADD_NEW') }} {{ __('VALIDATION_PASSWORD_FORMAT') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('NEW_PASSWORD') }}</label>
                                    @include('frontend.partials.components.password-eye')
                                    <div class="validationFields df fww g0dot5rem validationHeight">

                                    </div>
                                </div>

                            </div>

                            <div class="medium-12 small-12">
                                <div class="group">
                                    <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <input class="password-input" type="password" name="confirm_new_password" required {{--autocomplete="off"--}}>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="count-label">0/50</label>
                                    <label class="password-warn">{{ __('CONFIRM_NEW_PASSWORD_MASSAGE') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('CONFIRM_NEW_PASSWORD') }}</label>
                                    @include('frontend.partials.components.password-eye')
                                    <div class="validationFields df fww g0dot5rem validationHeight">

                                    </div>
                                </div>

                            </div>
                            <div id="redXIcon" class="dn">
                                @include('frontend.partials.svg.icons.red-x-icon')
                            </div>
                            <div id="greenCheckmarkIcon" class="dn">
                                @include('frontend.partials.svg.icons.green-checkmark-icon')
                            </div>
                        </div>
                    </form>
                    <div class="flex-content-right">
                        <button class="btn warning submit-button" id="passwordEdit">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
