<div class="popupBase" id="add_cv_work_experience" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

            <div class="step-heading-wrap">
                @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => __('EDIT_EXPERIENCE'),
                        'page_back_link' => "/jtc/welcome",
                        "save_button"=>"1",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'add_cv_work_experience',
                        'saveButtonText' => 'saveButtonText'

                    ]
                )
                <h6 class="">{{ __('PUBLIC_INFO') }}</h6>
                <p>{{ __('SHARED_WORK_EXPERIENCE') }}</p>

                {{-- <ul class="ability-headsad gledam oing-ul">
                    <li>We need some information from you.</li>
                    <li>After every conversation, we send a <br> receipt to your customer. </li>
                </ul> --}}


                {{-- <h6 class="title-billing-info">Your Work Experience</h6>
                <p class="subTitle">This will be visible for all users on Talkila</p> --}}

                <div class="grid-x">
                    <div class="small-12">
                        <form {{-- class="form-option" --}} id="work-expirence-cv-form">
                            <div id="_token">
                                @csrf
                            </div>
                            <input type="hidden" name="user_id" id="user_id_cv" value="{{auth()->user()->id}}">
                            <div class="grid-x grid-margin-x">
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">
                                        <input class="default-input dip cp"
                                            data-popup="professionEdit"
                                            id="titleCV"
                                            type="text"
                                            name="title"
                                            required
                                            autocomplete="off"
                                            placeholder="Profession"
                                            readonly="readonly"
                                        {{--  @if(!empty($requestedTalk) && $requestedTalk['talk_type'] == 2)
                                                value=" {{ $requestedTalk['headline'] ?? null }}"
                                            @endif --}}
                                        />
                                        <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>

                                        <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('SUBJECT') }}</label>
                                    </div>
                                </div>
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">

                                        <input class="default-input"
                                            id="companyCV"
                                            type="text"
                                            name="company"
                                            required
                                            autocomplete="off"
                                        {{--  @if(!empty($requestedTalk) && $requestedTalk['talk_type'] == 2)
                                                value=" {{ $requestedTalk['headline'] ?? null }}"
                                            @endif --}}
                                        />
                                        <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('COMPANY') }}</label>
                                    </div>

                                </div>
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">
                                        <input class="default-input"
                                            id="locationCV"
                                            type="text"
                                            name="location"
                                            required
                                            autocomplete="off"
                                        {{--  @if(!empty($requestedTalk) && $requestedTalk['talk_type'] == 2)
                                                value=" {{ $requestedTalk['headline'] ?? null }}"
                                            @endif --}}
                                        />
                                        <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('LOCATION') }}</label>
                                    </div>
                                </div>


                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">

                                        <input
                                            type="date"
                                            max="{{ date("Y-m-d", strtotime("-1 days")) }}"
                                            id="startDateCV"
                                            name="startDate"
                                            class="default-input date-input-cv"
                                            onkeydown="return false"
                                            required
                                        />
                                        <div class="verified-svg">
                                            @include('frontend.partials.svg.icons.check-verified')
                                        </div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="default-warn">@lang('START_DATE') @lang('REQUIRED_FIELD')</label>
                                        <span class="bar"></span>
                                        <label class="input-label">@lang('START_DATE')</label>
                                    </div>
                                </div>
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">
                                        <input
                                            type="date"
                                            id="endDateCV"
                                            name="endDate"
                                            class="default-input date-input-cv"
                                            max="{{ date("Y-m-d") }}"
                                            onkeydown="return false"
                                            required />
                                        <div class="verified-svg">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="default-warn">@lang('END_DATE') @lang('REQUIRED_FIELD')</label>
                                        <span class="bar"></span>
                                        <label class="input-label">@lang('END_DATE')</label>
                                    </div>
                                </div>
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">


                                        <input
                                            type="checkbox"
                                            id="iCurrentlyWorkHere"
                                            name="currently_work"
                                            class="default-checkbox"
                                        />
                                        <label for="iCurrentlyWorkHere" class="checkbox-label" > {{ __('WORK_HERE') }} </label>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>


        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
