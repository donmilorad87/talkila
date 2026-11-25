<div class="popupBase" id="shareProfilePopUp3" data-opened="0">
    <div class="popuper ppR overflow-visible">
        <div class="credit-model fl">

            <div class="user-profile-model fl w-100">
                <div class="firsterShare">

                    @if (!empty(auth()->user()->profile_picture))
                        <img class="imagePicRadius" height="110" width="110"  src="{{ auth()->user()->profile_picture }}" alt="user" />
                    @else
                        <div class="imagePicRadius imagePicRadiusCorr1">

                            <div class="innerDiv">

                                <span class="imagePicRadius imagePicRadius2">
                                    @include('frontend.partials.svg.icons.favicon')
                                </span>

                            </div>

                        </div>
                    @endif

                    <h5 class="mt24 k1ff fl w-100">{{ auth()->user()->name ?? '' }}</h5>

                </div>

                <div class="secShare">

                    @if (auth()->user()->profile_picture)
                        <img class="imagePicRadius" height="110" width="110" src="{{ auth()->user()->profile_picture }}" alt="user" />
                    @else
                        <span class="imagePicRadius">@include('frontend.partials.svg.icons.no-profile-picture')</span>
                    @endif

                    @if (!empty($talk_details) && isset($talk_details))
                        <h5 class="mt8 k1ff">{{ $talk_details['username'] }}</h5>
                        <h6 class="mt8 k1ff">{{ $talk_details['talk']['headline'] ?? '' }}</h6>
                    @endif

                </div>

            </div>

            <form class="w-100 fl">

                <div class="mt24 heading-content-share text-center">

                    <h5 class="firsterShare">{{ __('INVITE_YOUR_FRIENDS') }}</h5>
                    <p class="firsterShare k1ff">{{ __('SHARE_YOUR_PROFILE_WITH_FRIENDS_TEXT') }}</p>

                </div>

                <div class="grid-x grid-margin-x">

                    <div class="cell medium-12 large-12 k1ff">
                        <div class="social-wrap-group">
                            <ul>

                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{config('app.url')  . '/' . auth()->user()->username }}">
                                        <span>@include('frontend.partials.svg.icons.share-fb')</span>
                                    </a>

                                </li>

                                <li>
                                    <a href="https://wa.me/?text={{config('app.url')  . '/' . auth()->user()->username }}">
                                        <span>@include('frontend.partials.svg.icons.share-whatsapp')</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{config('app.url')  . '/' . auth()->user()->username }}">
                                        <span>@include('frontend.partials.svg.icons.twiter_icon')</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="mailto:?body={{config('app.url')  . '/' . auth()->user()->username }}">
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

                    <div class="qrCodeDiv poa">
                        <div class="exiting">
                            <svg class="qrcode m0 dn" height="280" viewBox="0 0 300 298" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <line x1="1.5" y1="22" x2="1.5" y2="0.5" stroke="black" stroke-width="3" />
                                <line x1="23" y1="2" x2="2" y2="2" stroke="black" stroke-width="3" />
                                <line x1="23.25" y1="295.75" x2="1.75" y2="295.75" stroke="black" stroke-width="3" />
                                <line x1="3.25" y1="274.25" x2="3.25" y2="295.25" stroke="black" stroke-width="3" />
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


                        <div class="qrcode realQr posrelative dn" id="qrcode3"></div>
                        <span class="closeQR dn">×</span>

                    </div>

                    <div class="cell medium-12 large-12">
                        <div class="Profession-input no-margin">
                            <div class="position-input">
                                <div class="firsterShare">
                                    <input type="text" readonly="readonly" id="profile-path-holder1"
                                        class="profile-path-holder copyText" value="{{ env('APP_FRONTEND_URL') . '/' . (auth()->user()->username ?? '') }}">
                                    <p class="copyText copyTexter">
                                        @include('frontend.partials.svg.icons.copy')
                                    </p>
                                </div>
                                @if (Route::current()->getName() == 'talk_details')
                                    <div class="secShare">
                                        <input type="text" readonly="readonly" id="profile-path-holder2"
                                            class="profile-path-holder"
                                                value="{{ env('APP_URL') . '/' . $talk_details['username'] . '/talk/' . $talk_id }}">
                                        <p class="copyText copyTexter">
                                            @include('frontend.partials.svg.icons.copy')
                                        </p>
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>


                </div>

            </form>

        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
