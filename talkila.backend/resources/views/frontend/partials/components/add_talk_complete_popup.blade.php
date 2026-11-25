<div class="popupBase" id="addCompleteTalk" data-opened="0">
    <div class="popuper2 ppRbr oh">
        <div class="grid-x mt94 popupWhiteRounded oa hGrop">


            <div class="d-flex step steperko caki CVHeading pon">

                <div class="pageTitlePoperAva pon">{{ __('DONE') }}</div>

                <div class="closeAddTalkFunnel2 pea">
                    <div class="centerVH height100 posrelative">
                        <span class="closeThisPopup" data-close="addCompleteTalk">×</span>
                    </div>

                </div>


            </div>


            <form class="w-100 pon">

                <div class="white-box-share">

                    <div class="w-100 fl tac mt37">
                        <span class="blackerSpanings"> {{ __('YOUR_INCOME') }} <span id="addedTalkMessage"></span></span>
                    </div>

                    <div class="w-100 fl tac">
                        @include('frontend.partials.svg.icons.graph')
                    </div>
                    <div class="w-100 df jcc aib addCompletePopupTesteringMessage">
                        <span>€</span>
                        <b id="addedTalkPrice">600</b>
                        <span>{{ __('IN') }}</span>
                        <b id="addedTalkDuration">45</b>
                        <span>{{ __('MINUTES_SHORT') }}</span>
                    </div>
                </div>

                <div class="heading-content-share text-center p0105px">

                    <h5 class="mt32">{{ __('SHARE_THIS_TALK') }}</h5>
                    <p class=" k1ff">{{ __('SHARE_YOUR_PROFILE_TEXT') }}</p>

                </div>

                <div class="poa">

                    <div class="cell medium-12 large-12 k1ff">
                        <div class="df aic jcc social-wrap-group mb40">
                            <ul class="poa shareList">
                                <li>

                                    <a class="sharingTalks"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ config('app.url') . '/' . auth()->user()->username . '/talk/' }}">
                                        <span>@include('frontend.partials.svg.icons.share-fb')</span>
                                    </a>

                                </li>
                                <li>
                                    <a class="sharingTalks"
                                        href="https://wa.me/?text={{ config('app.url') . '/' . auth()->user()->username . '/talk/' }}">
                                        <span>@include('frontend.partials.svg.icons.share-whatsapp')</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="sharingTalks"
                                        href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ config('app.url') . '/' . auth()->user()->username . '/talk/' }}">
                                        <span>@include('frontend.partials.svg.icons.twiter_icon')</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="sharingTalks"
                                        href="mailto:?body={{ config('app.url') . '/' . auth()->user()->username . '/talk/' }}">
                                        <span>@include('frontend.partials.svg.icons.share-email')</span>
                                    </a>

                                </li>

                                <li>
                                    <span class="qrGeneration"
                                        data-add-talk-popup="1">@include('frontend.partials.svg.icons.qr-code')</span>
                                </li>

                                <li class="nativeShare" data-link={{config('app.url') . '/' . auth()->user()->username . '/talk/' }}>
                                    <span>
                                        @include('frontend.partials.svg.icons.share-other')
                                    </span>

                                </li>

                                <script>
                                    if (document.getElementsByClassName('nativeShare')[0]) {

                                        let nativeShares = document.getElementsByClassName('nativeShare')

                                        for (let i = 0; i < nativeShares.length; i++) {
                                            if (!navigator.share) {
                                                nativeShares[i].style.display = 'none';
                                                continue;
                                            }

                                            // Share must be triggered by "user activation"
                                            nativeShares[i].addEventListener('click', async () => {


                                                const shareData = {
                                                    title: 'Talkila',
                                                    text: document.getElementById('shareTextTalkila').value,
                                                    url: nativeShares[i].dataset.link
                                                }

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
                    <div class="qrCodeDiv mb64 dn">
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
                        <div class="qrcode realQr posrelative dn" id="qrcode1"></div>
                        <span class="closeQR dn">×</span>
                    </div>




                </div>



            </form>

        </div>
        <span class="closeSpanPopup dn">×</span>
    </div>
</div>
