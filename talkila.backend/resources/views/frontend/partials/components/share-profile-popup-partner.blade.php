@auth
    <div class="popupBase" id="shareProfilePopUp24" data-opened="1" style="display: flex; align-items: center; z-index: 99999999; opacity: 1;">
        <div class="popuper ppR overflow-visible" style="padding: 0px; transform: scale(1); max-height: 100%;">
            <div class="credit-model fl oii">

                <div class="user-profile-model fl w-100">
                    <div class="firsterShare">
                        @if (!empty(auth()->user()->profile_picture))
                            <img class="imagePicRadius" height="110" width="110"
                                src="{{ auth()->user()->profile_picture ?? auth()->user()->profile_picture_tmp }}" alt="{{ auth()->user()->username }}" />
                        @else
                            <div class="imagePicRadius imagePicRadiusCorr1">

                                <div class="innerDiv boxShadBlack">

                                    <img class="imagePicRadius" height="110" width="110"
                                    src="{{ auth()->user()->profile_picture_tmp }}" alt="{{ auth()->user()->username }}" />


                                </div>

                            </div>
                        @endif

                        <h5 class="mt24 firsterShare fl w-100">{{ auth()->user()->name ?? '' }}</h5>

                    </div>
                    <div class="secShare">
                        @if (auth()->user()->profile_picture)
                            <img class="imagePicRadius" height="110" width="110"
                                src="{{ auth()->user()->profile_picture }}" alt="user" />
                        @else
                            <span class="imagePicRadius">@include('frontend.partials.svg.icons.no-profile-picture')</span>
                        @endif


                    </div>

                </div>

                <form class="m0a w-90 df fdc aic">

                    <div class="mt24 heading-content-share text-center">
                        <h5 class="firsterShare">{{ __('SHARE_YOUR_PROFILE') }}</h5>
                        <p class="firsterShare k1ff">{{ __('SHARE_YOUR_PROFILE_TEXT') }}</p>
                    </div>

                    <div class="grid-x grid-margin-x w-100 fl">

                        <div class="cell medium-12 large-12 k1ff">
                            <div class="social-wrap-group">
                                <ul class="shareList">
                                    <li>

                                        <a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ config('app.url') . '/' . auth()->user()->username }}">
                                            <span>@include('frontend.partials.svg.icons.share-fb')</span>
                                        </a>

                                    </li>

                                    <li>

                                        <a
                                            href="https://wa.me/?text={{ config('app.url') . '/' . auth()->user()->username }}">
                                            <span>@include('frontend.partials.svg.icons.share-whatsapp')</span>
                                        </a>

                                    </li>

                                    <li>

                                        <a
                                            href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ config('app.url') . '/' . auth()->user()->username }}">
                                            <span>@include('frontend.partials.svg.icons.twiter_icon')</span>
                                        </a>

                                    </li>

                                    <li>

                                        <a href="mailto:?body={{ config('app.url') . '/' . auth()->user()->username }}">
                                            <span>@include('frontend.partials.svg.icons.share-email')</span>
                                        </a>

                                    </li>

                                    <li>
                                        <span class="qrGeneration">@include('frontend.partials.svg.icons.qr-code')</span>

                                        <script>

                                        </script>
                                    </li>


                                    <li class="nativeShare"
                                        data-link={{ config('app.url') . '/' . auth()->user()->username }}>
                                        <span>@include('frontend.partials.svg.icons.share-other')</span>
                                    </li>
                                    <input type="hidden" id="shareTextTalkila" value="@lang('SHARE_YOUR_PROFILE_TEXT')" />
                                    <script>
                                        if (document.getElementsByClassName('nativeShare')[0]) {

                                            let nativeShares = document.getElementsByClassName('nativeShare')

                                            for (let i = 0; i < nativeShares.length; i++) {
                                                if (!navigator.share) {
                                                    nativeShares[i].style.display = 'none';
                                                    continue;
                                                }

                                                const shareData = {
                                                    title: 'Talkila',
                                                    text: document.getElementById('shareTextTalkila').value,
                                                    url: nativeShares[i].dataset.link
                                                }

                                                // Share must be triggered by "user activation"
                                                nativeShares[i].addEventListener('click', async () => {
                                                    try {
                                                        await navigator.share(shareData)
                                                    } catch (err) {
                                                        console.log(err)
                                                    }
                                                })
                                            }
                                        }
                                    </script>
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


                            <div class="qrcode realQr posrelative dn" id="qrcode34"></div>
                            <span class="closeQR dn">×</span>
                        </div>

                        <div class="cell medium-12 large-12">
                            <div class="Profession-input no-margin">
                                <div class="position-input">
                                    <div class="df aic jcc">
                                        <input type="text" readonly="readonly" id="profile-path-holder1"
                                            class="profile-path-holder pl8 copyText"
                                            value="{{ config('app.appUrl') . '/' . auth()->user()->username }}">
                                        <p class="copyText copyTexter">
                                            @include('frontend.partials.svg.icons.copy')
                                        </p>
                                    </div>


                                </div>

                                <div class="df fdc g1rem grayb6px p16 br8">
                                    <h5>@lang('ADD_YOUR_TALKILA_PROFILE_TO', ['partner_name' => $user->partner->name])</h5>
                                    <a href="{{$user->partner->url}}" class="btn warning copyText">
                                        @lang('ADD_ACCOUNT_TO_PARTNER_BUTTON', ['partner_name' => $user->partner->name])
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                </form>
            </div>
            <span class="closeSpanPopup">×</span>
        </div>
    </div>
@endauth
