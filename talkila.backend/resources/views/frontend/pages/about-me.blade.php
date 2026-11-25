@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="right-left-wrap hide-for-medium2 d-flex step pl16 pr16 headingAbouter">
        <a class="inFront" href="{{ route('home') }}">
            <span id="">
                @include('frontend.partials.svg.icons.arrow-left')
            </span>
        </a>
        <p class="tac tacer">{{ __('ABOUT_ME') }}
        <div class="centerVH height100 posabsolute right1rem cp supikar" data-popup="shareProfilePopUp2">

            @include('frontend.partials.svg.icons.share')
        </div>
        </p>
    </div>
    <div class="grid-container">


        @include('frontend.partials.pages.about_me.about_me')
    </div>
@endsection

@section('popup_section')

    @include('frontend.partials.pages.profile.experience')
    @include('frontend.partials.pages.jtc.time-slot-popup')
    
@endsection
