@extends('frontend.layouts.frontendlayout')
@section('popup_section')

    @if ($talks_count > config('app.show_more_talks'))
        @include('frontend.partials.components.filter-button')
    @endif
@endsection
@section('content')

    @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
        'page_title' => basename($_SERVER['REQUEST_URI']),
        'page_back_link' => route('courses'),
        'save_button' => '1',
        'possticky' => 'possticky',
    ])

    <div class="container">

        <div class="show-for-medium2">
            @include('frontend.partials.pages.courses.courses-tabs')
        </div>

        <div class="container hide-for-medium2">
            <div class="grid-x grid-margin-x ulcorrer">


                <ul class="menu-bar w-100 p16 pb0 bwhite br12">

                    @foreach ($subcategories as $subcategory)
                        @if ($subcategory->talks_count > 0)
                            <li class="editPro h64">
                                <a href="{{ route('talkCategorySubcategory', ['category' => $category, 'subcategory' => $subcategory]) }}"
                                    class="@if ($subcategory->talks_count < 1) pon o05 @endif">
                                    <span>
                                        <span class="editProSpan cccc">
                                            {{ $subcategory->name . ' (' . $subcategory->talks_count . ')' }}
                                        </span>
                                        @include('frontend.partials.svg.icons.arrow-right')
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach

                    @if (empty($subcategories) || $subcategories->every(fn($s) => $s->talks_count == 0))
                        @include('frontend.partials.components.nothing-found', [
                            'display' => 'dn',
                        ])
                    @endif

                </ul>
            </div>
        </div>


    </div>
@endsection
