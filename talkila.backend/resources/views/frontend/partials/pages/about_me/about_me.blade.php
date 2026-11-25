<div class="grid-x white-box p16">
    <div class='cell medium-12'>
        <div class="grid-x">
            <div class='cell small-12 medium-6 large-4'>
                @include('frontend.partials.pages.profile.user-info', [
                    'folowers' => false,
                    'followButton' => false,
                    'favoriteButton' => null,
                ])
            </div>
            <div class='cell small-12 medium-6 large-8 bwhite'>
                <div class="grid-container mb24 mjtc">

                    @include('frontend.partials.pages.profile.user-info-about-me', [
                        'userId' => $user->id,
                        'imageUrl' => $user->profile_picture,
                        'online' => '0',
                        'aboutName' => $user->name,
                        'username' => $user->username,
                        'profession' => $user->profession,
                        'verified' => $user->approved,
                        'rating' => $user->ratings,
                        'folowers' => false,
                        'followButton' => false,
                        'favoriteButton' => null,
                    ])


                    @if (!empty($userExperience))
                        <section class="cell small-12 profileExperienceContainer">
                            <h5 class="profExperience mb16">

                                @lang('PROFILE_MY_AVAILABILITY')
                                <div class="wrapper-video">
                                    <div class="inner-video">
                                        <div class="grid-x">

                                            @if (!empty($userExperience) && (!empty($userExperience['education']) || !empty($userExperience['job'])))

                                                <div class="fl w-100 posrelative">

                                                    <ul class="experience_inner">
                                                        @foreach ($userExperience['education'] as $education)
                                                            <li>
                                                                <h5>{{ $education['company_name'] }} </h5>
                                                                <p>{{ $education['location'] }}</p>
                                                                <p>{{ $education['start_date'] }} -
                                                                    {{ !empty($education['end_date']) ? $education['end_date'] : (empty($education['end_date']) && $education['work_here'] ? 'ongoing' : '') }}
                                                                </p>
                                                            </li>
                                                        @endforeach
                                                        @if (!empty($userExperience) && !empty($userExperience['job']))

                                                            @foreach ($userExperience['job'] as $job)
                                                                <li>
                                                                    <h5>{{ $job['company_name'] }} </h5>
                                                                    <p>{{ $job['location'] }}</p>
                                                                    <p>{{ $job['start_date'] }} -
                                                                        {{ !empty($job['end_date']) ? $job['end_date'] : (empty($job['end_date']) && $job['work_here'] ? 'ongoing' : '') }}
                                                                    </p>
                                                                </li>
                                                            @endforeach

                                                        @endif



                                                    </ul>
                                                    @include('frontend.partials.svg.icons.dashed_line')
                                                </div>

                                            @endif


                                        </div>
                                    </div>
                                </div>
                        </section>
                    @endif

                    <br />



                    <h5>{{ $user->first_name }} @lang('AVAILABILITY')</h5>

                    @include('frontend.partials.components.addAvailability')

                    @if (!empty($userAvailability))
                        <div id="availabilitesInnerCont">
                            @include('frontend.partials.components.availabilities', [
                                'userAvailability' => $userAvailability['availabilities'],
                            ])
                        </div>
                    @endif



                    @if ($reviews->count())
                        <div class="posrelative" id="aboutMeContaR">
                            <div class="bMySlotsButtons">
                                <div class="bMySlotsButtonsCont noselect active" data-pointer="pc">
                                    <p class="pf"> {{ __('RECEIVED') }} </p>
                                </div>
                                <div class="bMySlotsButtonsCont noselect" data-pointer="gc">
                                    <p>{{ __('GIVEN') }}</p>
                                </div>
                                <div class="buttonLine"></div>
                            </div>

                            <div class="coursesBlock privateC pt25">
                                <div class="form-wrapper show-for-medium">
                                    <h6 class="">{{ __('YOUR_PROFILE_RATINGS') }}</h6>
                                    <p class="
                                    subTitle w-50">
                                        {{ __('JTC_STEP_1') }}
                                    </p>
                                </div>
                                <div class="reviewContRecieved">

                                    <div>
                                        <h5 class="fl">{{ __('PROFILE_REVIEWS') }}
                                            ({{ $reviews->count() }})</h5>
                                        <h5 class="fr">
                                            <a href="{{ route('settings_reviews') }}">{{ __('SEE_ALL') }}</a>
                                        </h5>
                                    </div>
                                    @include('frontend.partials.components.review-carousel', [
                                        'reviews' => $reviews,
                                    ])

                                </div>
                            </div>
                    @endif
                    @if ($feedbacks->count())
                        <div class="coursesBlock groupC p24 pl0 pt25">
                            <div class="form-wrapper show-for-medium">
                                <h6 class="">{{ __('YOUR_PROFILE_RATINGS') }}</h6>
                                <p class="
                                    subTitle w-50">{{ __('JTC_STEP_1') }}
                                </p>
                            </div>

                            <div class="givenContRecieved">

                                <div>
                                    <h5 class="fl">{{ __('PROFILE_REVIEWS') }}
                                        ({{ $feedbacks->count() }})
                                    </h5>
                                    <h5 class="fr">
                                        <a href="{{ route('settings_reviews') }}">{{ __('SEE_ALL') }}</a>
                                    </h5>
                                </div>
                                @include('frontend.partials.components.review-carousel', [
                                    'reviews' => $feedbacks,
                                ])

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<input type="hidden" id="userAvailabilites" value="{{ json_encode($userAvailability) }}">
