<div class="chating-wrap-right zi999">
    <div class="chatting-inner-container">
        <div class="tabs-content" data-tabs-content="collapsing-tabs">
            <div class="cblack tabs-panel chating-main-wrap dn" id="chat-tabs1">
                <div class="d-flex title-participats-manage bb1">
                    <p>{{ __('GROUP_TALK') }}</p>
                    <p class="hideParticipants" data-opened="0">@lang('HIDE')
                        @include('frontend.partials.svg.icons.arrow-bottom')</p>
                </div>
                <div id="groupMuteUnmuteContainer">
                    <span class="btn hollow groupButtons mb0 dn mute-all-audio lh1" data-pointer="participants">
                        {{ __('MUTE_ALL_PARTICIPANTS') }} </span>
                    <span class="btn hollow groupButtons mt8 dn mute-all-video lh1" data-pointer="participants">
                        {{ __('TURN_OFF_ALL_PARTICIPANT_VIDEOS') }} </span>
                </div>


                <hr>
                <div class="mt16 d-flex title-participats-manage bb1">
                    <p>{{ __('PARTICIPIANTS') }}</p>
                    <p class="fr df g4px aic"> @include('frontend.partials.svg.icons.chat-users') <span id="actualNumberOfParticipants"></span>/<span
                            id="numberOfParticipants"></span> </p>

                </div>

                <div class="chating-main-wrap-inner" id="participants-box">

                </div>
            </div>
        </div>
        <ul class="tabs chating-tabs" data-active-collapse="true" data-tabs id="collapsing-tabs">
            <li class="tabs-title" id="showParticipantsOptions" data-opened="0">
                <span>
                    @include('frontend.partials.svg.icons.chat-users')
                </span>
            </li>
        </ul>
    </div>
</div>
