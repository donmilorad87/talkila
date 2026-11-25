@section('top_sticky_header')
    @include('frontend.partials.components.top-header')
@endsection

@section('popup_section')
    @if ($user)
        @include('frontend.partials.pages.jtc.upload-popup')

        @include('frontend.partials.components.take-picture-with-camera')
    @endif

    @include('frontend.partials.components.app-popup')
@endsection

@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container df aic jcc w-100">




        <div class="w-100 maxw500px boxShadRes white-boxRes pl0 pr0 oh bgHeadingGray">
            @if ($error_mesage)
                {{ $error_mesage }}
            @else
                <div class="aic {{ $user ? ( $user->partner ? 'jcsb' : 'jcc') : 'jcsb' }} g1rem zi999" id="secHead"
                    style="top:-60px">




                </div>

                @include('frontend.partials.components.jtc2_desktop_navigation')

                @include('frontend.partials.components.jtc2_heading', [
                    'headline' => $user


                        ? ( $user->partner
                            ? __('JTC_STEP1_HEADLINE', ['username'=>$user->username . ', '])
                            : __('JTC_STEP1_HEADLINE_2', ['username'=>$user->username ? $user->username . ', ' : '']))
                        : __('JTC_STEP1_HEADLINE3', ['username'=> (isset($requestParams) ? ($requestParams->tu ? $requestParams->tu  . ', ' : '') : '')]),


                    'description' => __('STEP_ONE_DESCRIPTION'),
                ])

                <div id="jtcStep1FormContainer" class="bwhite pl16 pr16 pb16 mt161res trans0dot3s boxShad br008px8px">
                    <form method="method" id="jtc2Step1Form">

                        <div class="grid-x grid-padding-x">
                            <input type="hidden"
                                value={{ $requestParams ? ($requestParams->te ? $requestParams->te : '') : '' }} />

                            @if ($user)
                                <div class="small-12 mt16">

                                    <div class="group">
                                        <input id="desktopUsername"
                                            class="step1username username-input {{ !empty($user['username']) ? 'ok' : '' }}"
                                            type="text" name="step1username" data-version="d"
                                            @if (!empty($user['username'])) data-username="{{ $user['username'] }}" value="{{ $user['username'] }}" @endif
                                            autocomplete="off" />
                                        <div class="verified-username-svg {{ !empty($user['username']) ? 'active' : '' }}">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <label class="count-label" style="display:none;">0/50</label>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>

                                        <label class="username-warn">{{ __('USERNAME_VALIDATION') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('USERNAME') }} </label>


                                    </div>

                                </div>
                            @else
                                @php
                                    $suggested = [];

                                    if ($savePartnerData) {
                                        if ($savePartnerData->data) {
                                            if (isset($savePartnerData->data->suggested)) {
                                                foreach ($savePartnerData->data->suggested as $item) {
                                                    array_push($suggested, $item);
                                                }
                                            }
                                        }
                                    }

                                @endphp
                                <div class="small-12 mt24">

                                    <div class="group">
                                        <input id="desktopUsername"
                                            class="step1username username-input {{ count($suggested) > 0 ? 'error' : (!empty($requestParams->tu) ? 'ok' : '') }}"
                                            type="text" name="step1username" data-version="d"
                                            @if (isset($requestParams->tu)) data-username="{{ preg_replace('/\s+/', '_', $requestParams->tu) ?? '' }}"
                                                                    value="{{ preg_replace('/\s+/', '_', $requestParams->tu) ?? '' }}" @endif
                                            autocomplete="off"
                                            style="color:{{ count($suggested) > 0 ? 'rgb(253, 42, 24)' : 'rgb(29, 41, 63)' }}" />
                                        <div
                                            class="verified-username-svg {{ count($suggested) > 0 ? '' : (!empty($requestParams->tu) ? 'active' : '') }}">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <label class="count-label" style="display:none;">0/50</label>
                                        <button type="button" class="clear-button"
                                            style="right:{{ count($suggested) > 0 ? '16px' : '-60px' }}"
                                            tabindex="-1">✖</button>

                                        <label
                                            class="username-warn {{ count($suggested) > 0 ? 'active' : '' }}">{{ __('ATTRIBUTE_UNIQUE', ['attribute' => 'username']) }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label"
                                            style="color:{{ count($suggested) > 0 ? 'rgb(253, 42, 24)' : 'rgb(29, 41, 63)' }}">{{ __('USERNAME') }}
                                        </label>
                                        <div>


                                            <div class="{{ count($suggested) > 0 ? 'cred' : 'dn' }}"
                                                id="suggestedUsernamesMesage">
                                                @lang('SUGGESTED_USERNAMES '):
                                            </div>



                                            <div class="p0 m0 lh2 df" id="suggestedUsernames">
                                                @foreach ($suggested as $item)
                                                    <div class="suggestedUsernameInput">{{ $item }}
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>

                                    </div>

                                </div>
                            @endif

                            @if ($user)
                                <div class="small-12">

                                    <div class="group">
                                        <input class="name-input {{ !empty($user['name']) ? 'ok' : '' }}" type="text"
                                            name="fullNameS" data-version="d" required id="fullNameS"
                                            @if (!empty($user['name'])) value="{{ $user['name'] }}" @endif
                                            autocomplete="off" />
                                        <div class="verified-name-svg {{ !empty($user['name']) ? 'active' : '' }}">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <label class="count-label">0/50</label>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="name-warn">{{ __('VALIDATION_NAME_TWO_WORDS') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('YOUR_NAME') }}</label>
                                    </div>

                                </div>
                            @endif



                            <div class="small-12">

                                <div class="group">
                                    <textarea id="descriptionjtc2"
                                        class="default-textarea {{ $user ? ($user->description ? 'ok' : '') : (isset($requestParams->td) ? 'ok' : '') }}"
                                        type="text" name="addBio" required>{{ $user ? $user->description ?? '' : (isset($requestParams->td) ? $requestParams->td : '') }}</textarea>
                                    <div
                                        class="verified-svg {{ $user ? ($user->td ? 'active' : '') : (isset($requestParams->td) ? 'active' : '') }}">
                                        @include('frontend.partials.svg.icons.check-verified')
                                    </div>
                                    <label class="count-label b0" style="display:none;">0/1000</label>
                                    <button type="button" class="clear-button" tabindex="-1">✖</button>
                                    <label class="default-warn">{{ __('REQUIRED_FIELD') }}</label>
                                    <span class="bar"></span>
                                    <label class="input-label">{{ __('ABOUT_ME') }}</label>
                                </div>

                            </div>

                            @if ($user)
                            @else
                                <div class="small-12">

                                    <div class="group">
                                        <input
                                            class="email-input {{ isset($requestParams->te) && !empty($requestParams->te) ? 'ok' : '' }}"
                                            type="text" name="emails" required
                                            value="{{ isset($requestParams->te) && !empty($requestParams->te) ? $requestParams->te : '' }}"
                                            id="emailJTC2" autocomplete="off" />
                                        <div
                                            class="verified-email-svg {{ isset($requestParams->te) && !empty($requestParams->te) ? 'active' : '' }}">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="email-warn">{{ __('MUST_BE_LEGAL_FORMAT') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('EMAIL') }}</label>
                                    </div>
                                </div>
                            @endif

                            @if ($user)
                            @else
                                <div class="small-12">
                                    <div class="group">
                                        <input class="password-input" type="password" name="password"
                                            autocomplete="off" />
                                        <div class="verified-password-svg">@include('frontend.partials.svg.icons.check-verified')
                                        </div>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="count-label">0/50</label>
                                        <label class="password-warn">{{ __('WRONG_PASSWORD_FORMAT') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('PASSWORD') }}</label>
                                        @include('frontend.partials.components.password-eye')
                                        <div class="validationFields df fww g0dot5rem validationHeight">

                                        </div>
                                        <div id="redXIcon" class="dn">
                                            @include('frontend.partials.svg.icons.red-x-icon')
                                        </div>
                                        <div id="greenCheckmarkIcon" class="dn">
                                            @include('frontend.partials.svg.icons.green-checkmark-icon')
                                        </div>
                                    </div>
                                </div>
                            @endif



                        </div>
                    </form>

                    <div class="small-12">
                        <div>
                            <button id="submitCreateProfileJtc2"
                                class="btn w-100 mb16 db">{{ __('CREATE_YOUR_ACCOUNT') }} </button>
                        </div>

                    </div>



                </div>
            @endif

        </div>
    </div>



    </div>
@endsection
