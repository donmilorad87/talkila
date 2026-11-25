@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="oh posrelative">
        <div class="show-for-mobile possticky top0 zi999">
            @include('frontend.partials.components.mobile-page-navigation-header', [
                'page_title' => __('BLOCKED_USERS'),
                'page_back_link' => route('settings_blocked_profiles'),
            ])
        </div>
        @include('frontend.partials.components.settings-navigation-mobile')
        <div class="container">
            <div class="grid-x setting-page white-box">
                <div class="cell setting-tabs">
                    <div class="show-for-medium">
                        @include('frontend.partials.components.settings-menu', [
                            'pointer' => __('BLOCKED_USERS'),
                        ])
                    </div>
                    <div class="tabs-content">

                        @if (isset($blockedUsers['user_count']) && !empty($blockedUsers['user_count']))
                            <h5> @lang('BLOCKED_USERS')</h5>
                            @foreach ($blockedUsers['user'] as $blockedUser)
                                <div class="df aic w-100 followRequestContainer g1rem mb16">
                                    <div class="df aic jcc mh82 oh br12">
                                        @if ($blockedUser['profile_picture'])
                                            <img src="{{ $blockedUser['profile_picture'] }}" alt="{{ $blockedUser['name'] }}"
                                                title="{{ $blockedUser['name'] }}">
                                        @else
                                            @include('frontend.partials.svg.icons.no-profile-picture-60')
                                        @endif

                                    </div>
                                    <div class="df fdc aic jcsa w-100">

                                        <p class="df jcfs w-100 mb0 pendingFallowersName">
                                            {{ $blockedUser['name'] }}
                                        </p>

                                        <div class="df aic jcfs w-100">


                                            <button class="btn hollow lh24 h40 unblockUser"
                                                data-user-id={{ $blockedUser['id'] }}>
                                                @lang('UNBLOCK')
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="df fdc no-found-heading">
                                @include('frontend.partials.svg.icons.lazy')
                                <h5 class="mt16">{!! __('YOU_DO_NOT_HAVE_ANY_BLOCKED_USERS') !!}</h5>
                                <a href="{{ route('settings_profile') }}">{!! __('BACK_TO_SETTIGS_PAGE') !!}</a>
                            </div>
                        @endif


                        <hr class="pr24">






                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
