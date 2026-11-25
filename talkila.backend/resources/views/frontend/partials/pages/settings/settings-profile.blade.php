<div class="setting-page white-box p16mob">
    <div class="show-for-medium">
        <div class="setting-inner">
            <div class="grid-x grid-margin-x">
                <div class='cell medium-12'>
                    <div class="setting-tabs">
                        @include('frontend.partials.components.settings-menu',['pointer' => __('PROFILE')])
                    </div>

                        <div class="tabs-panel is-active pt0" id="Profile">


                            <div class="grid-x">

                                {{-- <p class="subTitle">{{ __('JTC_STEP_1') }}</p> --}}

                                <div class='cell medium-12 largingZ{{-- @if ($loggedUserData['availability'] == '100' && $loggedUserData['approved'] == 0 ) large-8 @else large-12 @endif --}}'>

                                    <div class="setting-inner">

                                    </div>
                                </div>

                            {{--     @if ($loggedUserData['availability'] == '100' && $loggedUserData['approved'] == 0 )
                                    <div class='cell medium-12 large-4'>
                                        @include('frontend.partials.pages.settings.profile-progess')
                                    </div>
                                @endif --}}
                            </div>


                        </div>



                </div>
            </div>
        </div>
    </div>

</div>
