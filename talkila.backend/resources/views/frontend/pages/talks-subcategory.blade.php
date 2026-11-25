@extends('frontend.layouts.frontendlayout')
@section('popup_section')

    @if ($talks_count > config('app.show_more_talks'))
        @include('frontend.partials.components.filter-button')
        @include('frontend.partials.pages.courses.new_filter_popup')
    @endif
@endsection
@section('content')

    @if (Route::current()->getName() === 'talkCategorySubcategory')


        <div class="hide-for-medium2 d-flex step caki steperko33 caki2 possticky">

            <a href="{{ route('talkCategory', $subcategory->category) }}" class="lefterZ">
                @include('frontend.partials.svg.icons.arrow-left')
            </a>

            <div class="tac fw cnterZ">{{ $subcategory->english }}</div>

            @if ($talks_count > config('app.show_more_talks'))
                <div class="small-2 bwhite zi1000 posrelative filterIcon righterZ">
                    <div class="centerVH height100 posrelative shareBut filterOpener" data-opened="0">
                        @include('frontend.partials.svg.icons.filter')
                    </div>
                </div>
            @endif

        </div>

        @include('frontend.partials.components.dropdown_filter')

        <div class="talksBlock mt16 hide-for-medium2">
            <div class="talksShowMore df jcc tac @if ($talks_count <= config('app.show_more_talks')) dn @endif">
                <button class="btn btnShowMore">
                    {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                </button>

            </div>
        </div>
        <div class="no-found-heading hide-for-medium2 @if($talks_count > 0) dn @endif">
            <div>
                <img src="{{ asset('frontend/assets/img/taxi-waiting.png') }}" alt="Nothing Found" />
                <h5>{{ __('NOTICE_NOTHING_FOUND') }}</h5>
                <p class="filterero">{{ __('TRY_USING_FILTERS') }}</p>
            </div>

        </div>
    @endif

    <div class="container">
        <div class="dn" id="presentFilters">{{ json_encode($filters) }}</div>

        <div class="show-for-medium2">

            <div class="favorites-page inner-box-book leftBS searchPageContent">



                <div class="setting-inner">


                    <div class="setting-tabs">
                        @include('frontend.partials.pages.courses.tab-all-subcategories')
                    </div>
                </div>




            </div>
        </div>

        <div class="container hide-for-medium2"></div>

    </div>



@endsection
