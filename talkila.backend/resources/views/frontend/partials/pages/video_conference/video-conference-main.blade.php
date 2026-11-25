<div id="_token">@csrf</div>

<div id="viewUsTab">
    <ul class="tabs-re-manage">
        <li class="tabs-title1">
            {{ __('VIEW_US') }}
        </li>
        <li class="viewProfesor">
            @include('frontend.partials.svg.icons.video_laptop')
        </li>
        <li class="viewStudents is-active">
            @include('frontend.partials.svg.icons.video_grid')
        </li>
    </ul>
</div>

<div id="raise_hand_list" class="zi9999 posrelative">
    <div>
        <p>@lang('LIST_OF_RAISED_HANDS')</p>
        <ol>

        </ol>
    </div>
</div>

<div class="confefence-video-inner grid-x">

    <div class="dn">
        <div id="callType">2</div>
        <div id="webCamAllowed">0</div>
        <div id="microphoneAllowed">0</div>
        <div id="speakersAllowed">1</div>
        <div id="userObject">{{ json_encode($loggedUserData) }}</div>
        <input type="hidden" id="fromAppObj" value="{{ $fromApp }}">

    </div>


    <div class="displayMiddleFullScreen" id="displayMiddleFullScreen">
        <p class="m0">
            @lang('WAITING_FOR_OTHER_PARTICIPANTS')
        </p>
    </div>

    <div id="mainVideoBigFrame">
        <div class="small-12 videoBoxProfesorCont" data-swiped="1">

            <div class="videoBoxProfesor posrelative">
                <div class="innerVideoBox turnOnVideo">
                </div>

            </div>

            <div class="grid-x pinnedStudentsFrame">
            </div>
        </div>
    </div>

    <div class="talk-top swipeD" data-swiped="0">
        <div class="grid-x" id="studentFramePrivate">
            <div class="small-12" id="privateTalkStudentHelder">

            </div>
        </div>
    </div>

    <div class="small-4" id="studentContainer">

        <div class="grid-x noPinnedStudentsFrame">

            <div class="small-12" id="rowOne">

            </div>
            <div class="large6" id="rowOneA">

            </div>
            <div class="small-6" id="rowTwo">

            </div>
            <div class="large6" id="rowTwoA">

            </div>
        </div>
    </div>
    @include('frontend.partials.pages.video_conference.main-call-buttons')
    <div class="posabsolute menu lMobile df aic jcc h-100">
        <ul class="alignVH">

            <li id="settingsForMobile">
                <span class="cp" data-popup="callSetting">
                    @include('frontend.partials.svg.icons.setting')
                </span>
            </li>
            <li>
                <span class="mute-all-video">
                    @include('frontend.partials.svg.icons.video-black')
                </span>
            </li>
            <li>
                <span class="mute-all-audio">
                    @include('frontend.partials.svg.icons.mute')
                </span>
            </li>

            <li class="showPartClick" data-opened="0">
                <span class="showPart">
                    @include('frontend.partials.svg.icons.chat-users')
                </span>
            </li>

        </ul>
    </div>


    <input type="hidden" value="3" name="payment_type" id="payment_type">

</div>

@include('frontend.partials.pages.video_conference.chat_box')
