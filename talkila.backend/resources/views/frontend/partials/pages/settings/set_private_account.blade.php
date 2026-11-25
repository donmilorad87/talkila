{{-- {{dd($loggedUserData)}} --}}

<div class="popupBase" id="setPrivateProfile" data-opened="0">
    <div class="popuper ppR">
        <div class="grid-container">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title'        =>  __('PRIVATE_ACCOUNT'),
                    'page_back_link'    => "/jtc/welcome",
                    "save_button"       => "0",
                    'step_progress_text'=> 'Step 3 of 5',
                    'back_popup'        => 'setPrivateProfile',
                    'saveButtonText'    => 'saveButtonTextPrivate'
                ]
            )

            <div class="small-12">
                <form class="" id="edit_private_profile_form">
                    <div id="_token">
                        @csrf
                    </div>
                    <div class="grid-x grid-margin-x">

                        <div class="cell small-12">
                            <div class="group m0 p0">

                                <div class="date-wrap-content w-100 fl m0 mb0 h44">
                                    <div class="button-switch switch d-flex">
                                        <input class="switch-input"
                                                id="exampleSwitch24"
                                                type="checkbox"
                                                name="privateProfileOnOff"
                                                @if (isset($user->visibility) && !empty($user->visibility) && $user->visibility == 2)
                                                    checked
                                                @endif
                                                />
                                        <div class="posrelative anonim d-flex">
                                            <div>
                                                <p class="posrelative m0 ml0 fw600 switchText w-100 fl">
                                                    {{ __('PRIVATE_ACCOUNT') }}
                                                </p>
                                                <p class="posrelative w-100 fl swpl m0">
                                                    {{ __('PROFILE_PRIVATE_STATUS') }}
                                                </p>
                                            </div>


                                        </div>
                                        <label class="switch-paddle" for="exampleSwitch24">

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </form>
                <div class="flex-content-right mt16">
                    <button class="btn warning submit-button" id="setPrivateProfileSubmit">{{ __('SAVE') }}</button>
                </div>
            </div>

        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
