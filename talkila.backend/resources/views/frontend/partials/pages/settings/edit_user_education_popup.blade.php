<div class="popupBase" id="add_education" data-opened="0">
    <div class="popuper ppR popupBackgroundGray">

            <div class="step-heading-wrap mt52 popupWhiteRounded">
                @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                    [
                        'page_title' => __('EDIT_EDUCATION'),
                        'page_back_link' => "/jtc/welcome",
                        "save_button"=>"1",
                        'step_progress_text'=>'Step 3 of 5',
                        'back_popup' => 'add_education',
                        'saveButtonText' => 'saveButtonTextEducation'
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
                        <form {{-- class="form-option" --}} id="education-cv-form">
                            <div id="_token">
                                @csrf
                            </div>
                            <input type="hidden" name="user_id" id="user_id_education" value="{{auth()->user()->id}}">
                            <div class="grid-x grid-margin-x">
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">
                                        <input class="default-input dip"
                                            id="titleEducation"
                                            type="text"
                                            name="title"
                                            required
                                            autocomplete="off"
                                            placeholder="Title"
                                        {{--  @if(!empty($requestedTalk) && $requestedTalk['talk_type'] == 2)
                                                value=" {{ $requestedTalk['headline'] ?? null }}"
                                            @endif --}}
                                        />
                                        <div class="verified-svg">@include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">@lang('TITLE_MR_MRS')</label>
                                    </div>
                                </div>
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">

                                        <input class="default-input"
                                            id="CollegeEducation"
                                            type="text"
                                            name="college"
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
                                        <label class="input-label">{{ __('PROFILE_COLLEDGE') }}</label>
                                    </div>

                                </div>
                                <div class="cell medium-12 small-12 large-12">
                                    <div class="group">
                                        <input class="default-input"
                                            id="locationEducation"
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
                                            id="startDateEducation"
                                            name="startDate"
                                            class="default-input date-input-cv"
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
                                            id="endDateEducation"
                                            name="endDate"
                                            class="default-input date-input-cv"
                                            max="{{ date("Y-m-d") }}"
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
                                            id="iCurrentlyEducateHere"
                                            name="currently_educate"
                                            class="default-checkbox"
                                        />
                                        <label for="iCurrentlyEducateHere" class="checkbox-label" > {{ __('PROFILE_EDUCATE') }} </label>
                                        {{-- <div class="verified-svg">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label> --}}
                                        {{-- <label class="default-warn">{{ __('VALIDATION_MIN_4_MAX_50') }}</label>
                                        <span class="bar"></span> --}}
                                        {{-- <label class="input-label">End date</label> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <button class="btn hollow expanded cp" data-popup="add_cv_work_experience"> New entry </button>
                <h6 class="title-billing-info">Your Work Experience</h6>
                <p class="subTitle">This will be visible for all users on Talkila</p>
                <button class="btn hollow expanded cp" data-popup="addGroupTalk"> New entry </button> --}}

            </div>


        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
