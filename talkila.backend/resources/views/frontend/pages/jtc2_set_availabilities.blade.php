@section('popup_section')
    @include('frontend.partials.pages.jtc.time-slot-popup')
    @if ($user)
        @include('frontend.partials.pages.jtc.upload-popup')

        @include('frontend.partials.components.take-picture-with-camera')
    @endif
@endsection

@extends('frontend.layouts.frontendlayout')
@section('content')
    <input type="hidden" id="userAvailabilites" value="{{ json_encode($userAvailability2) }}">
    <div class="container df aic jcc w-100">



            <div class="w-100 maxw500px boxShadRes white-boxRes pl0 pr0 oh bgHeadingGray">
                <div class="aic {{ $user ? ( $user->partner ? 'jcsb' : 'jcc') : 'jcsb' }} g1rem zi999" id="secHead"
                    style="top:-60px">

                </div>
                @include('frontend.partials.components.jtc2_desktop_navigation')
                @include('frontend.partials.components.jtc2_heading', [
                    'headline' => __('JTC_STEP3_HEADLINE'),
                    'description' => __('JTC_STEP3_DESCRIPTION'),
                ])

                <div class="boxShad bwhiteBr p16 pt16 fl w-100 mb16 mt161" id="intersectActivator">

                    <div id="availabilitesInnerCont">


                        @if (isset($userAvailability) && !empty($userAvailability))
                            @include('frontend.partials.components.availabilities', [
                                'userAvailability' => $userAvailability['availabilities'],
                            ])
                        @endif

                        <div class="cell small-12 mb8">
                            <span class="add-slot cp cpzz" data-popup="time-slot-popup" data-jtctimeslot="1">
                                @include('frontend.partials.svg.icons.add-time-slot'){{ __('ADD_TIME_SLOT') }}
                            </span>
                        </div>

                    </div>



                    <div class="small-12">
                        <div>
                            <button class="btn w-100 db jtc2_submit" data-step='3'
                                data-redirect='/jtc/verify-account'>{{ __('CONTINUE') }} </button>
                        </div>

                    </div>

                </div>


            </div>


    </div>
@endsection
