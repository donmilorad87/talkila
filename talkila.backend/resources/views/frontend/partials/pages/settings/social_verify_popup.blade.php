<div class="popupBase" id="social_verify" data-opened="0">
    <div class="popuper ppBB popupBackgroundGray">

        <div class="step-heading-wrap mt52 popupWhiteRounded db fl">


            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => __('SOCIAL_VERIFY'),
                'page_back_link' => '/jtc/welcome',
                'save_button' => '0',

                'back_popup' => 'social_verify',
                'saveButtonText' => 'saveButtonText',
            ])


            <div>



                <div>



                    <a class="btn df jcc aic w-100 mt16 mb16 twitterVerifyButton"
                        href="{{ route('vsocials', ['social' => 'twitter']) }}">
                        <p class="df aic jcc m0">

                            @include('frontend.partials.svg.icons.twiter_icon')
                            <span class="buttonText">
                                {{ __('TWITER') }}
                            </span>
                        </p>
                    </a>
                    <div>


                    </div>

                </div>

                <div>

                    <a class="btn  df jcc aic w-100 linkedingVerifyButton" href="{{ route('vsocials', ['social' => 'linkedin']) }}">
                        <p class="df aic jcc m0">
                            @include('frontend.partials.svg.icons.linkedin')
                            <span class="buttonText">{{ __('VERIFY_LINKEDIN') }}</span>
                        </p>
                    </a>
                    <div>

                    </div>
                </div>

                <div>

                    <a class="btn instagramVerifyColor df jcc aic w-100 mt16 mb16"
                        href="{{ route('vsocials', ['social' => 'instagram']) }}">
                        <p class="df aic jcc m0">

                            @include('frontend.partials.svg.icons.instagram')
                            <span class="buttonText">
                                {{ __('VERIFY_INSTAGRAM') }}
                            </span>
                        </p>
                    </a>

                </div>

                <div>

                    <a class="btn facebookVerifyColor df jcc aic w-100 mt16 mb16"
                        href="{{ route('vsocials', ['social' => 'facebook']) }}">
                        <p class="df aic jcc m0">

                            @include('frontend.partials.svg.icons.facebook_2021')
                            <span class="buttonText">
                                {{ __('VERIFY_FACEBOOK') }}
                            </span>
                        </p>
                    </a>
                    <div>

                    </div>
                </div>
            </div>
            <ol>
                @foreach ($user->verifiedSocialProviders()->get(['social_providers','social_id','social_username','updated_at','id']) as $verifiedProvider)
                    <li>


                        <ul class="db fl w-100">
                            <li class="w-100">

                                @switch($verifiedProvider->social_providers)
                                    @case(0)
                                        type = facebook
                                    @break

                                    @case(1)
                                        type = instagram
                                        @break
                                    @case(2)
                                        type = linkedin
                                        @break
                                    @break

                                    @default
                                        type = twitter
                                @endswitch
                            </li>
                            <li class="w-100">
                                verified social_id = {{ $verifiedProvider->social_id }}
                            </li>
                            <li class="w-100">
                                verified social_username = {{ $verifiedProvider->social_username }}
                            </li>
                            <li class="w-100">
                                verified at =
                                {{ changeDateFormatLocale('Y-M-D H:i:s', date('Y-M-D H:i:s', strtotime($verifiedProvider->updated_at)), true) }}
                                @lang('AT')
                                {{ date('H:i', strtotime($verifiedProvider->updated_at)) }}
                            </li>
                            <li class="w-100">

                                <button class="btn hollow w-100 mb16 removeSocialVerification"
                                    data-verified-id="{{$verifiedProvider->id}}">
                                    Revoke social verification </button>
                            </li>
                        </ul>






                    </li>
                @endforeach
            </ol>



        </div>


        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
