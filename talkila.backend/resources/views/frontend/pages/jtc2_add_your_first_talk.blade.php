@section('popup_section')
@include('frontend.partials.components.add-group-talk-popup')
    @if ($user)
        @include('frontend.partials.pages.jtc.upload-popup')

        @include('frontend.partials.components.take-picture-with-camera')
    @endif

    @include('frontend.partials.components.add-private-talk-popup')

@endsection

@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container df aic jcc w-100">



        <div class="w-100 maxw500px boxShadRes white-boxRes pl0 pr0 oh bgHeadingGray">


            <div class="aic {{ $user ? ($user->partner ? 'jcsb' : 'jcc') : 'jcsb' }} g1rem zi999" id="secHead"
                style="top:-60px">




        </div>

        @include('frontend.partials.components.jtc2_desktop_navigation')

        @include('frontend.partials.components.jtc2_heading', [
            'headline' => __('JTC_STEP2_HEADLINE'),
            'description' => __('JTC_STEP2_DESCRIPTION'),
        ])

        <div class="boxShad bwhiteBr p16 pt16 fl w-100 mb16 mt161" id="intersectActivator">
            <div class="coursesBlock privateC" id="mobilePrivateProfileTeacherTalks">

                @include('frontend.partials.pages.profile.course_mobile_overview', [
                    'userPrivateTalks' => $userPrivateTalkData,
                ])

                <span class="mb16 add-slot cp addPrivateTalk addPrivateTalkTalksAndAva" data-popup="addPrivateTalk">
                    @include('frontend.partials.svg.icons.add-time-slot'){{ __('ADD_PRIVATE_TALKS') }}
                </span>


                <span class="mb16 add-slot cp addPrivateTalk addGroupTalkTalksAndAva" data-popup="addGroupTalk">
                    @include('frontend.partials.svg.icons.add-time-slot')@lang('ADD_GALLERY_TALK')
                </span>

            </div>


            <div class="small-12">
                <div>
                    <button class="btn w-100 db jtc2_submit" data-step='2'
                        data-redirect='/jtc/set-availabilities'>{{ __('CONTINUE') }} </button>
                </div>

            </div>

        </div>


    </div>



</div>
@endsection
