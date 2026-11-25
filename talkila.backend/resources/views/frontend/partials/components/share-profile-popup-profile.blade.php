<div class="popupBase" id="shareProfilePopUpEr" data-opened="0">
    <div class="popuper ppR overflow-visible">
        <div class="credit-model fl">

            <div class="user-profile-model">
                <div class="firsterShare">
                    @if (Route::current()->getName() === 'profile')
                        @if (!empty($userData['profile_picture']))
                            <img class="imagePicRadius" height="110" width="110"
                                src="{{ $userData['profile_picture'] }}" alt="user" />
                        @else
                            <span class="imagePicRadius">@include('frontend.partials.svg.icons.no-profile-picture')</span>
                        @endif

                        <h5 class="mt8 k1ff">{{ $userData['name'] }}</h5>
                    @else
                        @if (!empty(auth()->user()->profile_picture))
                            <img class="imagePicRadius" height="110" width="110"
                                src="{{ auth()->user()->profile_picture }}" alt="user" />
                        @else
                            <span class="imagePicRadius">@include('frontend.partials.svg.icons.no-profile-picture')</span>
                        @endif

                        <h5 class="mt8 k1ff">{{ auth()->user()->name ?? '' }}</h5>
                    @endif


                </div>
                <div class="secShare fisterkano">
                    @if (!empty(auth()->user()->profile_picture))
                        <img class="imagePicRadius" height="110" width="110"
                            src="{{ auth()->user()->profile_picture }}" alt="user" />
                    @else
                        <span class="imagePicRadius">@include('frontend.partials.svg.icons.no-profile-picture')</span>
                    @endif



                    @if (!empty($talk_details) && isset($talk_details))
                        <h5 class="mt8 k1ff">{{ $userData['username'] }}</h5>
                        <h6 class="mt8 k1ff">{{ $userData['talk']['headline'] }}</h6>
                    @endif
                </div>

            </div>

            <form class="form-option">

                <div class="heading-content-share text-center">
                    <h5 class="firsterShare">{{ __('SHARE_YOUR_PROFILE') }}</h5>
                    <p class="firsterShare k1ff mt24">{{ __('SHARE_YOUR_PROFILE_TEXT') }}</p>


                    <h5 class="secShare">{{ __('SHARE_THIS_TALK') }}</h5>
                    <p class="secShare k1ff secerr">{{ __('SHARE_YOUR_PROFILE_TEXT') }}</p>

                </div>

                <div class="grid-x grid-margin-x">

                    <div class="cell medium-12 large-12 k1ff">
                        <div class="social-wrap-group">

                            <ul>

                                <li>
                                    <a
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ config('app.url') . '/' . $userData['username'] }}">
                                        <span>@include('frontend.partials.svg.icons.share-fb')</span>
                                    </a>

                                </li>
                                <li>
                                    <a
                                        href="https://wa.me/?text={{ config('app.url') . '/' . $userData['username'] }}">
                                        <span>@include('frontend.partials.svg.icons.share-whatsapp')</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ config('app.url') . '/' . $userData['username'] }}">
                                        <span>@include('frontend.partials.svg.icons.twiter_icon')</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="mailto:?body={{ config('app.url') . '/' . $userData['username'] }}">
                                        <span>@include('frontend.partials.svg.icons.share-email')</span>
                                    </a>

                                </li>

                                <li>
                                    <span class="qrGeneration">@include('frontend.partials.svg.icons.qr-code')</span>
                                </li>

                                <li>
                                    <span>
                                        @include('frontend.partials.svg.icons.share-other')
                                    </span>
                                </li>

                            </ul>

                        </div>
                    </div>
                    <div class="qrCodeDiv dn poa">
                        <div class="exiting">
                            <svg class="qrcode m0 dn" height="280" viewBox="0 0 300 298" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.5" y1="22" x2="1.5" y2="0.5" stroke="black"
                                    stroke-width="3" />
                                <line x1="23" y1="2" x2="2" y2="2" stroke="black"
                                    stroke-width="3" />
                                <line x1="23.25" y1="295.75" x2="1.75" y2="295.75" stroke="black"
                                    stroke-width="3" />
                                <line x1="3.25" y1="274.25" x2="3.25" y2="295.25" stroke="black"
                                    stroke-width="3" />
                                <line y1="-1.5" x2="21.5" y2="-1.5"
                                    transform="matrix(4.37114e-08 -1 -1 -4.37114e-08 296.25 22)" stroke="black"
                                    stroke-width="3" />
                                <line y1="-1.5" x2="21" y2="-1.5"
                                    transform="matrix(1 8.74228e-08 8.74228e-08 -1 276.25 0.5)" stroke="black"
                                    stroke-width="3" />
                                <line y1="-1.5" x2="21.5" y2="-1.5"
                                    transform="matrix(1 8.74228e-08 8.74228e-08 -1 276 294.25)" stroke="black"
                                    stroke-width="3" />
                                <line y1="-1.5" x2="21" y2="-1.5"
                                    transform="matrix(-1.31134e-07 1 1 1.31134e-07 297.5 274.25)" stroke="black"
                                    stroke-width="3" />

                            </svg>
                        </div>
                        <div class="qrcode realQr posrelative dn" id="qrcode2"></div>
                        <span class="closeQR dn">×</span>
                    </div>

                    <div class="cell medium-12 large-12">
                        <div class="Profession-input no-margin">
                            <div class="position-input">
                                <div class="firsterShare copyText">
                                    <input type="text" readonly="readonly" id="profile-path-holder1"
                                        class="profile-path-holder"
                                        value="{{ env('APP_FRONTEND_URL') . '/' . ($userData['username'] ?? '') }}">
                                    <p class="copyText copyTexter">
                                        @include('frontend.partials.svg.icons.copy')
                                    </p>
                                </div>
                            </div>

                            <div class="text-center title-by-heading">{{ __('SHARE_PROFILE_BY_SIGNING_TEXT') }}
                                <span class="di"> <a href="/legal/terms-and-conditions"
                                        target="_blank">{{ __('TERMS_AND_CONDITIONS') }} </a> </span>
                                {{ __('AND') }}
                                <span class="di"> <a href="/legal/privacy-policy"
                                        target="_blank">{{ __('FOOTER_LINK_PRIVACY_POLICE') }}. </a> </span>
                            </div>

                        </div>

                    </div>


                </div>



            </form>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
