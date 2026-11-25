<div class="popupBase" id="professionEdit" data-opened="0">
    <div class="popuper posrelative ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">
            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                [
                    'page_title' => __('EDIT_PROFESSION'),
                    'page_back_link' => "1",
                    "save_button"=>"0",
                    'step_progress_text'=>'1',
                    'back_popup' => 'professionEdit',
                    'saveButtonText' => 'saveButtonTextEducation'
                ]
            )
            <div class="grid-x">
                {{-- <h5 class="small-12"> {{ __('EDIT_PROFESSION') }} </h5> --}}
                <p class="small-12"> {{ __('EDIT_YOUR_PROFESSION') }}</p>
                <div class="small-12">
                    <form class="" id="edit_profession_form">
                        <div class="grid-x grid-margin-x">

                            <div class="cell small-12">



                                <div class="group">
                                        <input
                                            class="default-datalist {{ !empty($loggedUserData['profession']) ? 'ok' : '' }}"
                                            type="text"
                                            name="profession"
                                            placeholder="Profession"
                                            data-local-time-zone="{{ getLocalTimeZone() }}"
                                            data-inputed-profession='0'
                                            required
                                            @if(!empty($loggedUserData['profession']))
                                                value="{{ $loggedUserData['profession'] }}"
                                            @endif
                                            autocomplete="off"
                                        />


                                        <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button cbprofCV" tabindex="-1">✖</button>


                                        <label class="default-warn">{{ __('PROFESSIONS_MESSAGE_1') }}</label>
                                        <label class="input-label">{{ __('PROFESSION') }}</label>
                                </div>
                                <select id="professionn">

                                </select>
                                <div id="professions">

                                </div>
{{--                                 <div class="group">
                                    <input class="name-input {{ !empty($loggedUserData['profession']) ? 'ok' : '' }}"
                                           type="text"
                                           name="profession"
                                           required
                                           @if(!empty($loggedUserData['profession']))
                                           value="{{ $loggedUserData['profession'] }}"
                                           @endif
                                           autocomplete="off" />
                                    <div class="verified-svg {{ !empty($loggedUserData['profession']) ? 'active' : '' }}">@include('frontend.partials.svg.icons.check-verified')</div>
                                    <label class="count-label">0/50</label>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="default-warn">{{ __('PROFESSIONS_EROR_MESSAGE_1') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('PROFESSION') }}</label>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                    <div class="flex-content-right">
                        <button class="btn warning submit-button" id="editProfessionSubmit">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>

</div>
