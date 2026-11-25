@extends('frontend.layouts.frontendlayout')

@section('popup_section')

    @if ($talks_count > config('app.show_more_talks'))
        @include('frontend.partials.components.filter-button')
        @include('frontend.partials.pages.courses.new_filter_popup')
    @endif

@endsection

@section('content')
    <div class="hide-for-medium2 d-flex step caki steperko33 caki2 possticky">

        <a href="{{ route('home') }}" class="lefterZ">
            @include('frontend.partials.svg.icons.arrow-left')
        </a>

        <div class="tac fw cnterZ">{{ __('BOOKMARKS') }}</div>

        @if ($talks_count > config('app.show_more_talks'))
            <div class="small-2 bwhite zi1000 posrelative filterIcon righterZ">
                <div class="centerVH height100 posrelative shareBut filterOpener" data-opened="0">
                    @include('frontend.partials.svg.icons.filter')
                </div>
            </div>
        @endif

    </div>

    <div class="grid-x container setting-tabs">

        @include('frontend.partials.pages.favorites.favorites-talks', [
            'talks' => $talks,
        ])

        @include('frontend.partials.components.filter-button')

    </div>
@endsection
