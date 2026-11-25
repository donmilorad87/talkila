<main class="setting-page p16mob">


    <div class='cell small-12 medium-6 large-4'>


    </div>
    <div class='cell small-12 medium-6 large-8 bwhite'>
        <div class="grid-container mjtc">


            @include('frontend.partials.pages.profile.user-info-about-me', [
                'userId' => auth()->user()->id,
                'imageUrl' => auth()->user()->profile_picture ?? auth()->user()->profile_picture_tmp,
                'online' => '0',
                'aboutName' => auth()->user()->name,
                'username' => auth()->user()->username,
                'profession' => auth()->user()->profession,
                'verified' => auth()->user()->approved,
                'rating' => auth()->user()->ratings,
                'folowers' => false,
                'followButton' => false,
                'favoriteButton' => null,
            ])

            <div class="grid-x mt24">

                <div class="df aic jcsb w-100 g1rem">

                    <div>
                        <div class="df aic fdc">
                            <b>{{ $user->metric->my_bookings }}</b>
                            <h6> {{ __('BOOKINGS') }} </h6>
                        </div>

                    </div>
                    <div>
                        <div class="df aic fdc">
                            <b>{{ $user->metric->talks }}</b>
                            <h6> {{ __('TALKS') }} </h6>
                        </div>
                    </div>
                    <div>
                        <div class="df aic fdc">
                            <b>{{ $user->metric->received_followers }}</b>
                            <h6> {{ __('FOLLOWERS') }} </h6>
                        </div>
                    </div>
                </div>

            </div>


            @include('frontend.partials.pages.profile.about-description-video2')



            <br />

            @include('frontend.partials.pages.profile.experience')




            <div class="posrelative" id="aboutMeContaR">
                @if (isset($reviews) && !empty($reviews) && count($reviews->toArray()))
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
                                                subTitle w-50">{{ __('JTC_STEP_1') }}
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
                @if (isset($feedbacks) && !empty($feedbacks))
                    <div class="coursesBlock groupC p24 pl0 pt25">

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

</main>
