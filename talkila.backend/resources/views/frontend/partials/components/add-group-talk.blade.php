<div class="small-12">


    @include('frontend.partials.pages.jtc.mobile-steps-navigation-13', [
        'page_title' => __('ADD_GALLERY_TALK'),
        'page_back_link' => '1',
        'save_button' => '1',
        'saveButtonText' => 'submitAddTalk',
        'back_popup' => 'addGroupTalk',
    ])



    <form class="form-option" id="group-talk-form">
        <div class="grid-x grid-margin-x">

            <div class="cell small-12 titleDescs">
                <p class="cell small-12 mb16 dn" id="jtc_add_gallery_talk_description">{{ __('JTC_ADD_GALLERY_TALK_DESCRIPTION') }}</p>
                <p class="cell small-12 mb16 dn" id="jtc_edit_gallery_talk_description">{{ __('JTC_EDIT_GALLERY_TALK_DESCRIPTION') }}</p>
            </div>

            <div class="cell small-12 dn">

                <div class="group">
                    <input class="default-input" type="hidden" name="talkIdG" required value=""
                        autocomplete="off" />

                </div>

            </div>

            <div class="dn" id="talkType">{{ $requestedTalk['talk_type'] ?? null }}</div>


            <div class="cell medium-12 small-12 large-12">
                <div class="group groupTalkings">

                    <input class="default-input" id="talkInputG" type="text" name="nameG" required
                        autocomplete="off"
                        @if (!empty($requestedTalk) && $requestedTalk['talk_type'] == 2) value=" {{ $requestedTalk['headline'] ?? null }}" @endif />
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button cleanerEx" tabindex="-1">✖</button>
                    <label class="count-label">0/50</label>
                    <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                    <span class="bar"></span>
                    <label class="input-label">{{ __('TALK_NAME') }}</label>
                </div>


            </div>

            <div class="cell medium-12 small-12 large-12">
                <div class="group">

                    <select id="participantsG"
                        class="default-select {{ !empty($requestedTalk) && $requestedTalk['talk_type'] == 2 && !empty($requestedTalk['talk_categories_id']) ? 'ok' : '' }}"
                        name="participantsG">

                        @for ($i = 1; $i < config('app.group_participants_limit'); $i++)
                            <option value="{{ $i }}" {{ $i === 5 ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor

                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button clearCat" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('PARTICIPIANTS') }}</label>
                </div>
            </div>

            <div class="cell small-12 categ">
                <div class="group">

                    <select id="categoryG"
                        class="default-select {{ !empty($requestedTalk) && $requestedTalk['talk_type'] == 2 && !empty($requestedTalk['talk_categories_id']) ? 'ok' : '' }}"
                        name="categoryG">
                        <option value=""></option>

                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button clearCat cleanerEx" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('CATEGORY') }}</label>
                </div>

            </div>
            <div class="cell small-12 subcat dn">
                <div class="group">

                    <select id="subCategoryG"
                        class="default-select {{ !empty($requestedTalk) && !empty($requestedTalk['talk_subcategories_id']) ? 'ok' : '' }}"
                        name="subCategoryG">


                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button cleanerEx" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('SUBCATEGORY') }}</label>
                </div>

            </div>
            <div class="cell medium-12 small-12 large-12">

                <div class="group">
                    <textarea class="default-textarea" type="text" name="descriptionG" required>
@if (!empty($requestedTalk) && $requestedTalk['talk_type'] == 2)
{{ $requestedTalk['description'] ?? null }}
@endif
</textarea>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <label class="count-label">0/50</label>
                    <button type="button" class="clear-button cleanerEx" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label">{{ __('DESCRIPTION') }}</label>
                </div>

            </div>


            <div class="cell medium-6 small-12 large-6">
                <div class="group">

                    <select id="languageG"
                        class="default-select {{ !empty($requestedTalk) && $requestedTalk['talk_type'] == 2 && !empty($requestedTalk['languages_id']) ? 'ok' : '' }}"
                        name="languageG">


                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('LANGUAGE') }}</label>
                </div>

            </div>

            <div class="cell medium-6 small-12 large-6">
                <div class="group">

                    <input class="default-input-number prices" type="number" step='0.01' name="priceG" required
                        autocomplete="off"
                        @if (!empty($requestedTalk) && $requestedTalk['talk_type'] == 2) value="{{ $requestedTalk['price'] ?? null }}" @endif />
                    <span class="eSign noselect">€</span>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button" tabindex="-1">✖</button>

                    <label class="default-warn">{{ __('VALIDATION_MIN_0_MAX_999') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('BASE_PRICE') }}</label>
                </div>
                @include('frontend.partials.components.tooltip-left', [
                    'tooltip_text' => __('NOTICE_WONT_SHARE_INFO'),
                ])
            </div>


            <div class="cell medium-12 small-12 large-12">
                <div class="group">

                    <select id="talkInteractionTypeG" class="default-select" name="talkInteractionTypeG">
                        <option value="0" class="dn" selected>
                        </option>
                        <option value="1">
                            @lang('WATCH_MODE')
                        </option>
                        <option value="2">
                            @lang('INTERACTIVE_MODE_ALL')
                        </option>
                        <option value="3">
                            @lang('INTERACTIVE_MODE_SINGLE')
                        </option>


                    </select>
                    <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                    <button type="button" class="clear-button clearCat" tabindex="-1">✖</button>
                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                    <span class="bar"></span>
                    <label class="input-label select-label">{{ __('TALK_INTERACTION_TYPE') }}</label>
                </div>
                @include('frontend.partials.components.tooltip-left', [
                    'tooltip_text' => __('NOTICE_WONT_SHARE_INFO'),
                ])
            </div>

            <div class="cell small-12">


                <div class="date-wrap-content w-100">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="exampleSwitch8" type="checkbox" name="allowVideoTalkG"
                            checked @if (
                                !empty($requestedTalk) &&
                                    !empty($requestedTalk['call_type']) &&
                                    $requestedTalk['talk_type'] == 2 &&
                                    $requestedTalk['call_type']
                            ) checked @endif>
                        <div class="posrelative anonim d-flex">
                            @include('frontend.partials.svg.icons.camera')
                            <p class="posrelative">
                                {{ __('ALLOW_VIDEO_TALKS') }}
                            </p>
                        </div>
                        <label class="switch-paddle" for="exampleSwitch8">
                            <span class="show-for-sr">{{ __('DOWNLOAD_KITTENS') }}</span>
                        </label>
                    </div>
                </div>



                <div class="date-wrap-content w-100">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="allowRepeatG" type="checkbox" name="allowRepeatG">

                        <div class="posrelative anonim d-flex specWidth">
                            @include('frontend.partials.svg.icons.calendar_repeat')
                            <p class="posrelative">
                                {{ __('REPEAT') }}
                            </p>
                            @include('frontend.partials.components.tooltip-left', [
                                'tooltip_text' => __('NOTICE_REPEAT_TALK'),
                                'class' => 'pouseCorrection',
                            ])
                        </div>

                        <label class="switch-paddle" for="allowRepeatG">

                        </label>

                    </div>

                </div>

                <div class="date-wrap-content w-100">
                    <div class="button-switch switch switch-re-edit d-flex">
                        <input class="switch-input" id="exampleSwitch7" type="checkbox" name="allowAnonimousTalkG"
                            @if (
                                !empty($requestedTalk) &&
                                    !empty($requestedTalk['is_anonymous_allowed']) &&
                                    $requestedTalk['talk_type'] == 2 &&
                                    $requestedTalk['is_anonymous_allowed']
                            ) checked @endif>
                        <div class="posrelative anonim d-flex">
                            @include('frontend.partials.svg.icons.anonymous2')
                            <p class="posrelative">
                                {{ __('ALLOW_ANONYMOUS_TALKS') }}
                            </p>

                        </div>

                        <label class="switch-paddle" for="exampleSwitch7">
                            <span class="show-for-sr">{{ __('DOWNLOAD_KITTENS') }}</span>
                        </label>

                    </div>

                </div>

            </div>
        </div>

        <div class="date-wrap-content w-100 pauseWrap dn mt16">
            <div class="button-switch switch switch-re-edit d-flex">
                <input class="switch-input" id="exampleSwitch26" type="checkbox" name="pauseThisTalk"
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
                <label class="switch-paddle" for="exampleSwitch26">
                </label>
            </div>
        </div>


        @include('frontend.partials.components.seven-days-static')

        @include('frontend.partials.components.time-select')
        <div id="timeRangeMessage" class="fl w-100 mt16 dn">

        </div>
        <div class="fl w-100 mt16 dn">
            <div class="w-100 mt16">
                <span class="btn w-100 df aic jcc saveButtonGroupTalk"
                    id="groupSubmit">{{ __('ADD_GALLERY_TALK') }}</span>
            </div>
        </div>

        <div class="fl w-100 tac deleteTalkButtoner dn">
            <div class="group m0 p0 tac pointerCursor">

                <b class="btn hollow mt16 mb16 cp black" data-popup='deleteTalkPopup'>
                    {{ __('DELETE_THIS_TALK') }}
                </b>

            </div>

        </div>


    </form>


</div>
