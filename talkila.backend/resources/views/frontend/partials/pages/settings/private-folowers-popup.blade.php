<div class="popupBase" id="privateFollowingPopup" data-opened="0">
    <div class="popuper posrelative ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => __('PRIVATE_FOLLOW'),
                'page_back_link' => '1',
                'save_button' => '0',
                'step_progress_text' => 'Step 3 of 5',
                'back_popup' => 'privateFollowingPopup',
                'saveButtonText' => 'saveButtonTextEducation',
            ])



            <div class="grid-x">
                @if (isset($userFollowRequests['follow_requests_count']) && !empty($userFollowRequests['follow_requests_count']))
                    <p class="small-12 mb24">
                        {{ __('PRIVATE_FOLLOW') }}
                    </p>




                    <h5>@lang('PRIVATE_FOLLOWING_REQUEST')</h5>
                    @foreach ($userFollowRequests['follow_requests'] as $pending_follower)
                        <div class="df aic w-100 followRequestContainer g1rem mb16">
                            <div class="df aic jcc br12 oh mh82">
                                @if ($pending_follower['profile_picture'])
                                    <img src="{{ $pending_follower['profile_picture'] }}"
                                        alt="{{ $pending_follower['name'] }}" title="{{ $pending_follower['name'] }}">
                                @else
                                    @include('frontend.partials.svg.icons.no-profile-picture-60')
                                @endif

                            </div>
                            <div class="df fdc aic jcsa w-100">

                                <p class="df jcfs w-100 mb0 pendingFallowersName">
                                    {{ $pending_follower['name'] }}
                                </p>

                                <div class="df aic jcfs w-100">

                                    <button class="btn hollow mr8 lh24 h40 rejectFollowerPrivate"
                                        data-user-id={{ $pending_follower['id'] }}>
                                        @lang('REJECT')
                                    </button>

                                    <button class="btn lh24 h40 acceptFollowerPrivate"
                                        data-user-id={{ $pending_follower['id'] }}>
                                        @lang('ACCEPT')
                                    </button>

                                </div>
                            </div>
                        </div>
                    @endforeach


                    <hr class="pr24 w-100 fl">



                @endif

                @if (isset($usersThatIamFallowingData['follow_requests_count']) &&
                    !empty($usersThatIamFallowingData['follow_requests_count']))


                    <h5>@lang('PERSONAL_FOLLOWING_USERS')</h5>
                    @foreach ($usersThatIamFallowingData['follow_requests'] as $pending_follower)
                        <div class="df aic w-100 followRequestContainer g1rem mb16">
                            <div class="df aic jcc br12 oh mh82">
                                @if ($pending_follower['profile_picture'])
                                    <img src="{{ $pending_follower['profile_picture'] }}"
                                        alt="{{ $pending_follower['name'] }}" title="{{ $pending_follower['name'] }}">
                                @else
                                    @include('frontend.partials.svg.icons.no-profile-picture-60')
                                @endif

                            </div>
                            <div class="df fdc aic jcsa w-100">

                                <p class="df jcfs w-100 mb0 pendingFallowersName">
                                    {{ $pending_follower['name'] }}
                                </p>

                                <div class="df aic jcfs w-100">

                                    <button class="btn hollow mr8 lh24 h40 unfollow_user"
                                        data-user={{ $pending_follower['id'] }}>
                                        @lang('REMOVE')
                                    </button>


                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr class="pr24 w-100 fl">
                @endif
                @if (isset($usersThatFallowsMe) && !empty($usersThatFallowsMe))
                    @if (auth()->user()->visibility === 2)
                        <h5>@lang('PRIVATE_FOLLOWERS')</h5>
                    @else
                        <h5>@lang('FOLLOWERS')</h5>
                    @endif
                    @foreach ($usersThatFallowsMe as $user)
                        <div class="df aic w-100 followRequestContainer g1rem mb16">
                            <div class="df aic jcc br12 oh mh82">
                                @if ($user['profile_picture'])
                                    <img src="{{ $user['profile_picture'] }}" alt="{{ $user['name'] }}"
                                        title="{{ $user['name'] }}">
                                @else
                                    @include('frontend.partials.svg.icons.no-profile-picture-60')
                                @endif

                            </div>
                            <div class="df fdc aic jcsa w-100">

                                <p class="df jcfs w-100 mb0 pendingFallowersName">
                                    {{ $user['name'] }}
                                </p>

                                <div class="df aic jcfs w-100">

                                    @if (auth()->user()->visibility === 2)
                                        <button class="btn hollow mr8 lh24 h40 removeUserFromFollowingList"
                                            data-user-id={{ $user['id'] }}>
                                            @lang('REMOVE')
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <hr class="pr24">
                @endif
                <hr class="pr24">
            </div>


        </div>
    </div>
    <span class="closeSpanPopup dn">×</span>
</div>
