@section('popup_section')
    @if ($user)
        @include('frontend.partials.pages.jtc.upload-popup')

        @include('frontend.partials.components.take-picture-with-camera')
    @endif
@endsection


@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container df aic jcc w-100">



        <div class="w-100 maxw500px boxShadRes white-boxRes pl0 pr0 oh bgHeadingGray mt32res">

            @include('frontend.partials.components.jtc2_heading', [
                'headline' => __('JTC_STEP5_HEADLINE'),
                'description' => __('JTC_STEP5_DESCRIPTION'),
            ])

            <div class="bwhite p16 pt32 fl w-100" id="intersectActivator">

                <div class="iActivator">
                    <h3 class="mb0 fs24 tac h3DownloadAppNow">
                        @lang('DOWNLOAD_THE_APP_NOW')
                    </h3>

                    @include('frontend.partials.components.app_icons')
                </div>



                <div class="small-12">
                    <div>
                        <a href="{{ route('courses') }}" class="btn w-100 db">{{ __('EXPLORE') }} </a>
                    </div>

                </div>

            </div>


        </div>



    </div>
@endsection
