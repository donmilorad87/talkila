<div class="setting-page white-box p16mob">
    <div class="setting-inner">
        <div class="grid-x w-100">
            <div class='cell small-12 reviewHeader'>
                <div class="setting-tabs">
                    <div class="show-for-medium">
                        @include('frontend.partials.components.settings-menu',['pointer'=> __('FOOTER_LINK_REVIEWS'), 'loggedUserData' => $userData])
                    </div>
                </div>
            </div>
            <div class="cell small-12 inner-box-book w-100 fl">
                <section class="cell small-12 w-100 fl gropings oh ggs">
                    <div class="inner-box-book w-100 fl">
                        <div class='cell medium-12'>
                            <div class="setting-tabs">

                                <div class="tabs-content">
                                    <div class="is-active" id="Profile">
                                        <div class="grid-x">
                                            <div class="cell medium-12 large-12">
                                                <div class="setting-inner">
                                                    <section class="cell small-12 w-100 fl gropings oh">
                                                        <div class="inner-box-book w-100 fl" id="reviewHeighter">

                                                            <div class="bMySlotsButtons" id="bMySlotsButtons">
                                                                <div class="bMySlotsButtonsCont noselect active"
                                                                    data-pointer="pc">
                                                                    <p class="pf"> {{ __('RECEIVED') }} </p>
                                                                </div>
                                                                <div class="bMySlotsButtonsCont noselect"
                                                                    data-pointer="gc">
                                                                    <p>{{ __('GIVEN') }}</p>
                                                                </div>
                                                                <div class="buttonLine"></div>
                                                            </div>

                                                            <div class="coursesBlock privateC">
                                                                <div class="form-wrapper show-for-medium">
                                                                    <h6 class="">{{ __('YOUR_PROFILE_RATINGS') }}</h6>

                                                                </div>
                                                                <div class="reviewContRecieved">
                                                                    @include('frontend.partials.pages.profile.rating', ['pointer' => 1])
                                                                </div>
                                                            </div>

                                                            <div class="coursesBlock groupC pl0">
                                                                <div class="form-wrapper show-for-medium">
                                                                    <h6 class="">{{ __('YOUR_PROFILE_RATINGS') }}</h6>

                                                                </div>
                                                                <div class="givenContRecieved">
                                                                    @include('frontend.partials.pages.profile.given-rating', ['pointer' => 2])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <input type="hidden" value="{{ route('get_feedback_comments') }}"
                                                        id="feedbackCommentsUrl">

                                                    <input type="hidden"
                                                        value="{{ $teacherFeedback['stars_feedback']['totalReviews'] ?? 0 }}"
                                                        id="totalFeedbackCount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>


        </div>
    </div>
</div>
