<div class="small-12">
    @if (Route::current()->getName() === 'home' || Route::current()->getName() === 'jtc2_add_your_first_talk')
        @include('frontend.partials.pages.jtc.mobile-steps-navigation-13', [
            'page_title' => __('ADD_PRIVATE_TALK'),
            'page_back_link' => '1',
            'save_button' => '1',
            'saveButtonText' => 'submitAddTalk',
            'back_popup' => 'addPrivateTalk',
        ])
    @endif




    <input type="hidden" id="talkuserid" value="{{ auth()->user()->id }}" />
    <form class="pl0" id="private-talk-form">

        <p class='addNewTalkDescription mb32'>
            @lang('ADD_NEW_TALK_DESCRIPTION')
        </p>

        <p class="editnewTalkDescription mb32 dn">
            @lang('EDIT_TALK_DESCRIPTION')
        </p>


        <div class="grid-x grid-margin-x pt16 ovh">
            @if (Route::current()->getName() === 'jtc2_add_your_first_talk')
                <div class="cell small-12 titleDescs">
                    <h4 class="cell small-12 p0 mainTitlePrivate"> {{ __('ADD_PRIVATE_TALK') }} </h4>
                    <p class="cell small-12 mb16"> {{ __('EDIT_TALK_DESCRIPTION') }} </p>
                </div>
            @endif

            <div class="cell small-12 dn">

                <div class="group">
                    <input class="default-input" type="hidden" name="talkIdP" required value=""
                        autocomplete="off" />
                </div>

            </div>

            <div class="dn" id="talkType">{{ $requestedTalk['talk_type'] ?? null }}</div>
            <div class="cell medium-12 small-12 large-12 corrections pb8">

                <div class="group zuk">
                    <input class="default-input ok" type="text" id="talkInputP" name="nameP" autocomplete="off"
                        @if (!empty($requestedTalk) && $requestedTalk['talk_type'] == 1) value="{{ $requestedTalk['headline'] ?? null }}" @endif />
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <label class="count-label dn">0/50</label>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}.</label>
                    <span class="bar"></span>
                    <label class="input-label">{{ __('TALK_NAME') }}</label>
                </div>


            </div>

            <div class="cell medium-12 small-12 large-12 descriptionPP">

                <div class="group">
                    <textarea class="default-textarea" type="text" name="descriptionP" value="">
@if (!empty($requestedTalk) && $requestedTalk['talk_type'] == 1)
{{ $requestedTalk['description'] ?? '' }}
@endif
</textarea>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <label class="count-label">0/50</label>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label">{{ __('DESCRIPTION') }}</label>
                </div>
            </div>

            <div class="cell small-12 categP">
                <div class="group">

                    <select id="categoryP"
                        class="default-select {{ !empty($requestedTalk) && $requestedTalk['talk_type'] == 1 && !empty($requestedTalk['talk_categories_id']) ? 'ok' : '' }}"
                        name="categoryP">
                        <option value=""></option>



                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button clearCatP" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('CATEGORY') }}</label>
                </div>

            </div>
            <div class="cell small-12 subcatP dn">
                <div class="group">
                    <select id="subCategoryP"
                        class="default-select {{ !empty($requestedTalk) && !empty($requestedTalk['talk_subcategories_id']) ? 'ok' : '' }}"
                        name="subCategoryP">


                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('SUBCATEGORY') }}</label>
                </div>

            </div>

            <div class="cell medium-6 small-12 large-6">
                <div class="group">

                    <select id="durationP"
                        class="default-select {{ !empty($requestedTalk) && $requestedTalk['talk_type'] == 1 && !empty($requestedTalk['talk_categories_id']) ? 'ok' : '' }}"
                        name="durationP">

                        <option value="15" @if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 15) selected @endif>15
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="30" @if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 30) selected @endif>30
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="45" @if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 45) selected @endif>45
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="60" @if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 60) selected @endif>60
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="75" @if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 75) selected @endif>75
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="90" @if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 90) selected @endif>90
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="105"@if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 105) selected @endif>105
                            {{ __('MINUTES_SHORT') }}</option>
                        <option value="120"@if (!empty($requestedTalk['duration']) && $requestedTalk['talk_type'] == 1 && $requestedTalk['duration'] == 120) selected @endif>120
                            {{ __('MINUTES_SHORT') }}</option>
                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('DURATION') }}</label>
                </div>
            </div>
            <div class="cell medium-6 small-12 large-6">
                <div class="group">

                    <input class="default-input-number prices prickaraP" type="number" step='1'
                        onkeydown="if(event.key==='.'){event.preventDefault();}" name="priceP" required
                        autocomplete="off"
                        @if (!empty($requestedTalk) && $requestedTalk['talk_type'] == 1) value="{{ $requestedTalk['price'] ?? null }}" @endif />
                    <span class="eSign noselect">€</span>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>

                    <button type="button" class="clear-button" tabindex="-1">✖</button>

                    <label class="default-warn">{{ __('VALIDATION_MIN_0_MAX_999') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('BASE_PRICE') }}</label>
                </div>

            </div>
            <div class="cell medium-12 small-12 large-12">
                <div class="group">

                    <select id="languageP" class="default-select ok" name="languageP">


                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('LANGUAGE') }}</label>
                </div>

            </div>
            <div class="cell small-12 mt8">

                <div class="date-wrap-content w-100">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="exampleSwitch4" type="checkbox" name="allowVideoTalkP"
                            checked="true" @if (
                                !empty($requestedTalk) &&
                                    !empty($requestedTalk['call_type']) &&
                                    $requestedTalk['talk_type'] == 1 &&
                                    $requestedTalk['call_type']
                            ) checked @endif>
                        <div class="posrelative anonim d-flex">
                            @include('frontend.partials.svg.icons.camera')
                            <p class="posrelative">
                                {{ __('ALLOW_VIDEO_TALKS') }}
                            </p>
                        </div>

                        <label class="switch-paddle" for="exampleSwitch4">

                        </label>

                    </div>

                </div>
                <div class="date-wrap-content w-100">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="exampleSwitch5" type="checkbox" name="allowAnonimousTalkP"
                            checked>
                        <div class="posrelative anonim d-flex specWidth">
                            @include('frontend.partials.svg.icons.anonymous2')
                            <p class="posrelative">
                                {{ __('ALLOW_ANONYMOUS_TALKS') }}
                            </p>
                            @include('frontend.partials.components.tooltip-left', [
                                'tooltip_text' => __('NOTICE_ANONIMYS_TALK'),
                                'class' => 'anonimToolTip',
                            ])
                        </div>

                        <label class="switch-paddle" for="exampleSwitch5">

                        </label>

                    </div>

                </div>

                <div class="date-wrap-content w-100 pauseWrap dn">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="exampleSwitch6" type="checkbox" name="pauseThisTalk"
                            @if (!empty($requestedTalk) && !empty($requestedTalk['state']) && $requestedTalk['state'] == 1) checked @endif>
                        <div class="posrelative anonim d-flex specWidth">
                            @include('frontend.partials.svg.icons.pause_talk')
                            <p class="posrelative">
                                {{ __('PAUSE_THIS_TALK') }}
                            </p>
                            @include('frontend.partials.components.tooltip-left', [
                                'tooltip_text' => __('NOTICE_PAUSE_TALK'),
                                'class' => 'pouseCorrection',
                            ])
                        </div>
                        <label class="switch-paddle" for="exampleSwitch6">
                        </label>
                    </div>
                </div>

                @if (Route::current()->getName() !== 'jtc2_add_your_first_talk')
                    @if (auth()->user()->loadCount('talks')->talks_count === 0)
                        <div class="date-wrap-content w-100 ">
                            <div class="button-switch switch switch-re-edit d-flex">
                                <input class="switch-input" id="additional_talks" type="checkbox"
                                    name="additional_talks" checked>
                                <div class="posrelative anonim d-flex specWidth">
                                    @include('frontend.partials.svg.icons.magic_wand_hollow')
                                    <p class="posrelative">
                                        {{ __('ADD_DEMO_TALKS') }}
                                    </p>
                                    @include('frontend.partials.components.tooltip-left', [
                                        'tooltip_text' => __('NOTICE_DEMO_TALKS'),
                                        'class' => 'addDemoTalksCorrection',
                                    ])
                                </div>
                                <label class="switch-paddle" for="additional_talks">
                                </label>
                            </div>
                        </div>
                    @endif
                @endif


            </div>

            <div class="cell small-12">
                <div class="w-100 mt16">
                    <span class="btn w-100 df aic jcc saveButtonPrivateTalk dn"
                        id="privateSubmit">{{ __('ADD_PRIVATE_TALK') }}</span>
                </div>
            </div>


            <div class="cell medium-12 small-12 large-12 tac deleteTalkButtoner dn">
                <div class="group m0 p0 tac pointerCursor">

                    <b class="btn hollow mt16 mb16 cp black" data-popup='deleteTalkPopup'>
                        {{ __('DELETE_THIS_TALK') }}
                    </b>

                </div>

            </div>

        </div>

    </form>
</div>
