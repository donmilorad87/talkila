@extends('frontend.layouts.frontendlayout')

@section('content')

    <div class="video-conference-page">

        <div id="toastifyContForGroupTalk"></div>

        <div class="tac bRed dn noCamAndMicAccess">
            <h5 class="cw m0 p4 cp" data-popup="callSetting">{{ __('VIDEO_CONFERENCE_TEXT') }}
                <span id="cammeraNotAllowed"></span>
                <span id="microphoneNotAllowed"></span>
            </h5>
        </div>


        @include('frontend.partials.pages.video_conference.video-conference-main')


    </div>

@endsection

@section('popup_section')


    @include('frontend.partials.pages.video_conference.call-setting')



    @include('frontend.partials.pages.video_conference.extend-call')
    @include('frontend.partials.pages.video_conference.extend-popup-answer-await')
    @include('frontend.partials.pages.video_conference.extend-teacher-answer-popup')
    @include('frontend.partials.pages.video_conference.extend-popup-answer')

    @include('frontend.partials.pages.video_conference.successful-extended-call')


    @include('frontend.partials.pages.voice_call.payment-completed-popup')

    @include('frontend.partials.pages.video_conference.error-popup')


    @include('frontend.partials.pages.voice_call.review-popup')

    @include('frontend.partials.pages.voice_call.completed-popup')

    @include('frontend.partials.pages.video_conference.cancel-talk')
    @include('frontend.partials.pages.video_conference.cancel_extendion')
    @include('frontend.partials.pages.video_conference.kick-user-popup')

    @include('frontend.partials.pages.voice_call.payment-wallet')
    @include('frontend.partials.components.loading_payment_popup')
@endsection
