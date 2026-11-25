@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="oh posrelative">
        <div class="show-for-mobile possticky top0 zi999">
            @include('frontend.partials.components.mobile-page-navigation-header', [
                'page_title' => __('FOLLOWING'),
                'page_back_link' => route('settings_following'),
            ])
        </div>
        @include('frontend.partials.components.settings-navigation-mobile')
        <div class="container">
            <div class="grid-x setting-page white-box">
                <div class="cell setting-tabs">
                    <div class="show-for-medium">
                        @include('frontend.partials.components.settings-menu', [
                            'pointer' => __('FOLLOWING'),
                        ])
                    </div>
                    <div class="tabs-content">
                        <div class="tabs-panel is-active" id="Profile">
                            <div class="cell medium-12 large-12 pl16 pr16">
                                <div class="setting-inner" id="fallowingPageMainCont">
                                    {{-- this block is for pending private followong requests --}}
                                    @if (isset($userFollowRequests['follow_requests_count']) && !empty($userFollowRequests['follow_requests_count']))
                                        <div id="privatePendingContainer">
                                            @php
                                                if ($userFollowRequests['follow_requests_count'] > 9) {
                                                    $x_coordinate = 23;
                                                    $number_of_followers = '9+';
                                                } else {
                                                    $x_coordinate = 31;
                                                    $number_of_followers = $userFollowRequests['follow_requests_count'];
                                                }
                                            @endphp

                                            @include('frontend.partials.svg.icons.talkila_following', [
                                                'x_coordinate' => $x_coordinate /* 23 */,
                                                'number_of_followers' => $number_of_followers,
                                            ])

                                            <h6 class="following_title">
                                                <span
                                                    class="numberOfFollowers pr4">{{ $userFollowRequests['follow_requests_count'] }}</span>
                                                {{ __('NEW_REQUESTS_PENDING') }}
                                            </h6>
                                            <p class="following_subtitle">
                                                @lang('PRIVATE_FOLLOWING_DESCRIPTION')
                                            </p>
                                            <h5>@lang('PRIVATE_FOLLOWING_REQUEST')</h5>
                                            @foreach ($userFollowRequests['follow_requests'] as $pending_follower)
                                                <div class="df aic w-100 followRequestContainer g1rem mb16">
                                                    <div class="df aic jcc br12 oh mh82">
                                                        @if ($pending_follower['profile_picture'])
                                                            <img src="{{ $pending_follower['profile_picture'] }}"
                                                                alt="{{ $pending_follower['name'] }}"
                                                                title="{{ $pending_follower['name'] }}">
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
                                            <hr class="pr24">
                                        </div>
                                    @endif

                                    {{-- this block is for users that i am fallowing --}}
                                    @if (isset($usersThatIamFallowingData['follow_requests_count']) &&
                                            !empty($usersThatIamFallowingData['follow_requests_count']))
                                        <h5>@lang('PERSONAL_FOLLOWING_USERS')</h5>
                                        @foreach ($usersThatIamFallowingData['follow_requests'] as $pending_follower)
                                            <div class="df aic w-100 followRequestContainer g1rem mb16">
                                                <div class="df aic jcc br12 oh mh82">
                                                    @if ($pending_follower['profile_picture'])
                                                        <img src="{{ $pending_follower['profile_picture'] }}"
                                                            alt="{{ $pending_follower['name'] }}"
                                                            title="{{ $pending_follower['name'] }}">
                                                    @else
                                                        @include('frontend.partials.svg.icons.no-profile-picture-60')
                                                    @endif

                                                </div>
                                                <div class="df fdc aic jcsa w-100">

                                                    <p class="df jcfs w-100 mb0 pendingFallowersName">
                                                        {{ $pending_follower['name'] }}
                                                    </p>

                                                    <div class="df aic jcfs w-100">

                                                        <button class="btn hollow mr8 lh24 h40 removeFollower"
                                                            data-user-id={{ $pending_follower['id'] }}>
                                                            @lang('REMOVE')
                                                        </button>


                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <hr class="pr24">
                                    @endif

                                    {{-- this block is for users that fallowing me private and not private profile --}}
                                    @if (isset($usersThatFallowsMe) && !empty($usersThatFallowsMe))
                                        <div id="privateFollowersContainer">
                                            <h5>@lang('FOLLOWERS')</h5>
                                            <div id="privateFollowersContainerItems">
                                                @foreach ($usersThatFallowsMe as $folowUser)
                                                    <div class="df aic w-100 followRequestContainer g1rem mb16">
                                                        <div class="df aic jcc br12 oh mh82">
                                                            @if ($folowUser['profile_picture'])
                                                                <img src="{{ $folowUser['profile_picture'] }}"
                                                                    alt="{{ $folowUser['name'] }}"
                                                                    title="{{ $folowUser['name'] }}">
                                                            @else
                                                                @include('frontend.partials.svg.icons.no-profile-picture-60')
                                                            @endif

                                                        </div>
                                                        <div class="df fdc aic jcsa w-100">

                                                            <p class="df jcfs w-100 mb0 pendingFallowersName">
                                                                {{ $folowUser['name'] }}
                                                            </p>

                                                            <div class="df aic jcfs w-100">

                                                                <button
                                                                    class="btn hollow mr8 lh24 h40 removeUserFromFollowingList"
                                                                    data-user-id={{ $folowUser['id'] }}>
                                                                    @lang('REMOVE')
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <hr class="pr24">
                                        </div>
                                    @endif




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
