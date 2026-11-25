<div class="popupBase" id="extendCall">
    <div class="popuper ppBbb tac">

        <div class="credit-model feedback-popup talkilium">
            <div class="phoneTopLine"></div>
            {{-- @include('frontend.partials.pages.video_conference.breadcrumb_extend',['pointer' => 1]) --}}

            {{-- <h2>{{ __('TALK_EXTEND') }}</h2> --}}
            <div class="textForExtend">
             {{--    <p class="firstParagrafExtend">{{__('TALK_EXTEND')}}: <b id="seccondsLeftExtend" class="df jcc"><span id="minutess">00</span>:<span id='secondss'>59</span></b></p> --}}
                <p class="seccondParagrafExtend"><strong>{{__('EXTEND_POPUP_SUBTITLE')}}</strong></p>

            </div>
            <div class="innerExtendCall mt32 mb16">

                <div class="buttons">

                </div>

            </div>
            <div class="submitButtonsForExtend">
                {{-- <div class="w-100 fl tac">
                    <button class="btn hollow" id="cancelExtend">{{ __('CANCEL') }}</button>

                    <button class="button fr cp orangeButton" id="extendLesson" data-popup="extendAnswerAwait"
                        disabled>{{ __('TALK_EXTEND') }}</button>

                </div> --}}

                <input type="hidden" id="extendLessonTime">
                <input type="hidden" id="priceHours">
            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
