@section('top_sticky_header')
    @include('frontend.partials.components.top-header')
@endsection

@extends('frontend.layouts.frontendlayout')

@section('popup_section')
    @include('frontend.partials.components.app-popup')
@endsection



@section('content')
    @include('frontend.partials.pages.home.banner')
    @include('frontend.partials.pages.home.slider-carousel')
    @include('frontend.partials.pages.home.mobile-slider-carousel')
    @include('frontend.partials.pages.home.calculator')
    @include('frontend.partials.pages.home.faq')
@endsection

