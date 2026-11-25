<div class="popupBase" id="call-popup" data-opened="0">
    <div class="ppB popuper dark-border popup-sm">
        <div class="df p0">
            <div class="credit-model calling-model">
                <div>
                    <div class="circle-out circleOutCenter">
                        <div class="phonering-alo-phone phonering-alo-green phonering-alo-show"
                            id="phonering-alo-phoneIcon">
                            <div class="phonering-alo-ph-circle"></div>
                            <div class="phonering-alo-ph-circle-fill"></div>
                            <div class="phonering-alo-ph-img-circle"></div>
                        </div>
                    </div>

                </div>
                <div class="title-profile-group">

                    <div>
                        <div>

                            <img class="profile_image_calling_screen"
                                src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />

                        </div>
                    </div>


                </div>

            </div>

            <form class="form-option">

                <div class="grid-x grid-margin-x">

                    <div class="cell small-12">
                        <ul class="Classes-group-b1 df fdc w-100">
                            <li class="cwhite df aic">@include('frontend.partials.svg.icons.schollar_cap_white') <span class="room-name"
                                    {{ __('PLACEHOLDER_EXAMPLE_COURSE_PART_1') }}>{{ __('PLACEHOLDER_EXAMPLE_COURSE_PART_2') }}</span>
                            </li>
                            <li class="cwhite df aic">@include('frontend.partials.svg.icons.call_time_white') <span class="room-datetime">08:00am -
                                    09:00 am (60 {{ __('PROFILE_MINUTES') }})</span></li>


                            <li class="audioCallIconText cwhite df aic">
                                @include('frontend.partials.svg.icons.phone_hollow_white') <span class="talk-type">
                                    {{ __('AUDIO_TALK') }}</span>
                            </li>

                            <li class="videoCallIconText cwhite">
                                @include('frontend.partials.svg.icons.call_white') <span class="talk-type">
                                    {{ __('VIDEO_TALK') }}</span>
                            </li>


                            </li>
                        </ul>
                    </div>

                </div>
                <div class="grid-x grid-margin-x">

                    <div class="cell small-12">
                        <div class="call-participents mt16 mb16">

                            <div class="profile-img-box d-flex" id="people-holder">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="grid-x grid-margin-x mb16">

                    <div class="cell small-6">
                        <span class="btn btn-accept" id="acceptCall">@include('frontend.partials.svg.icons.accept')
                            <span class="callScreenButt">{{ __('ACCEPT') }}</span></span>
                    </div>

                    <div class="cell small-6"> <span class="btn btn-decline"
                            id="declineCall">@include('frontend.partials.svg.icons.decline')
                            <span class="callScreenButt">{{ __('DECLINE') }}</span></span> </div>


                </div>



            </form>
        </div>



        <span id="closeCallPopup" class="closeSpanPopup whiteX dn">×</span>
    </div>
</div>
