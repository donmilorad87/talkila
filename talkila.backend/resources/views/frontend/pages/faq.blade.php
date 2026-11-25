@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container w-100">
        <div class="grid-x">
            <div class="small-12">

                <div class="accounts-content white-box mb16">
                    @include('frontend.partials.pages.faq.faq-accordion')
                </div>

            </div>
        </div>
    </div>
@endsection
