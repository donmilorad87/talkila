@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container df aic jcc w-100">



        <div class="w-100 maxw500px boxShadRes white-boxRes pl0 pr0 oh bgHeadingGray bgHeadingGray">
            <div class="aic {{ $user ? ( $user->partner ? 'jcsb' : 'jcc') : 'jcsb' }} g1rem zi999" id="secHead"
                style="top:-60px">


            </div>

            @include('frontend.partials.components.jtc2_desktop_navigation')
            @include('frontend.partials.components.jtc2_heading', [
                'headline' => __('JTC_STEP4_HEADLINE'),
                'description' => __('JTC_STEP4_DESCRIPTION'),
            ])

            <div class="boxShad bwhiteBr p16 pt16 fl w-100 mb16 mt161" id="intersectActivator">

                <ul class="lsn mb16 fs14">
                    <li class="lh2">
                        @include('frontend.partials.svg.icons.orange-checkmark-icon')
                        @lang('JTC_STEP4_TEXT_1')
                    </li>
                    <li class="lh2">
                        @include('frontend.partials.svg.icons.orange-checkmark-icon')
                        @lang('JTC_STEP4_TEXT_2')

                    </li>
                    <li class="lh2">
                        @include('frontend.partials.svg.icons.orange-checkmark-icon')
                        @lang('JTC_STEP4_TEXT_3')

                    </li>
                </ul>

                <section class="small-12 large-7 small-order-1 large-order-2 posrelative fl w-100 mt16">
                    <div class="authCont df aic jcc" data-verification="0">

                        <div class="login-right w-100">


                            <div id="succesUpload">
                                <div class="mobile-verification doc-uploaded text-center" style="position: relative;">
                                    @include('frontend.partials.svg.icons.uploaded-ok')
                                    <h5 style="z-index: 2;" id="uplText">{{ __('DOCUMENTS_UPLOADED') }}
                                    </h5>

                                    @include('frontend.partials.svg.icons.talkila-city')
                                </div>
                            </div>
                            <div id="verificationForm">


                                <form action="method" id="verification-form">
                                    @csrf

                                    <div class="group align-left">
                                        <input class="name-input @if (!empty($user['name'])) ok @endif" type="text"
                                            name="name"
                                            @if ($user['name']) value="{{ $user['name'] }}" @endif required />
                                        <div class="verified-name-svg @if (!empty($user['name'])) active @endif">
                                            @include('frontend.partials.svg.icons.check-verified')</div>
                                        <label class="count-label">0/50</label>
                                        <button type="button" class="clear-button" tabindex="-1">✖</button>
                                        <label class="name-warn">{{ __('NAME_MUST_CONTAIN_TWO_WORDS') }}</label>
                                        <span class="bar"></span>
                                        <label class="input-label">{{ __('YOUR_NAME') }}</label>
                                    </div>

                                    @include('frontend.partials.components.upload-drop-area', [
                                        'id' => '3',
                                    ])
                                    <span class="btn w-100 warning fr dn checkImageBeforeUpload"
                                        data-verification="verificationId">{{ __('COMPLETE') }}</span>
                                    <p class="fl w-100 tal">
                                        <small>
                                            @lang('UPLOAD_ID_INFO_TEXT')
                                        </small>
                                    </p>
                                </form>
                            </div>

                        </div>
                    </div>
                </section>

                <div class="tac fl w-100">

                    <p class="jtc2_submit mb0 pb0 btn hollow wfc" data-step='4' data-redirect='/'>
                        {{ __('SKIP_VERIFICATION') }}

                    </p>
                    <caption><p class="fs12 cblack mt16 skipInfo">@lang('YOU_CAN_VERIFY_ACCOUNT_LATER')</p></caption>

                </div>
            </div>


        </div>


    </div>
@endsection
