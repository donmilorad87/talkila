<div class="inner-box-book w-100 fl">

    <div class="bMySlotsButtons revi">
        <div class="bMySlotsButtonsCont noselect active" data-pointer="pc">
            <p>{{ __('RECEIVED') }}</p>
        </div>
        <div class="bMySlotsButtonsCont noselect" data-pointer="gc">
            <p>{{ __('GIVEN') }}</p>
        </div>
        <div class="buttonLine"></div>
    </div>
    <div class="coursesBlock privateC pt25">
        <div class='cell medium-12'>
            <div class="setting-tabs">

                <div class="tabs-content">
                    <div class="is-active" id="Profile">
                        <div class="grid-x">
                            <div class="cell medium-12 large-12">
                                <div class="setting-inner">
                                    <div class="form-wrapper show-for-medium">
                                        <h6>{{ __('YOUR_PROFILE_RATINGS') }}</h6>
                                        <p class="subTitle">{{ __('JTC_STEP_1') }}</p>
                                    </div>
                                    @include('frontend.partials.pages.profile.rating', [
                                        'teacherFeedback' => $teacherFeedback
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="coursesBlock groupC pt25">
        <div class='cell medium-12'>
            <div class="setting-tabs">

                <div class="tabs-content">
                    <div class="is-active" id="Profile">
                        <div class="grid-x">
                            <div class="cell medium-12 large-12">
                                <div class="setting-inner">
                                    <div class="form-wrapper show-for-medium">
                                        <h6>{{ __('YOUR_GIVEN_RATINGS') }}</h6>
                                        <p class="subTitle">{{ __('JTC_STEP_1') }}</p>
                                    </div>
                                    @include('frontend.partials.pages.profile.rating', [
                                        'teacherFeedback' => $teacherFeedbackGiven
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
