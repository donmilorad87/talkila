@extends('frontend.layouts.frontendlayout')
@section('content')
    @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
        'page_title' => __('ALL_CATEGORIES'),
        'page_back_link' =>  route('courses'),
        'save_button' => '1',
        'zIndex' => 'zi999',
    ])



    <div class="container white-box b1res">


        <div class="grid-x pt16 pb16" id="coursesBlocks">



            <div class="small-12 mb24 mt16 hide-for-small">
                <h4>{{ __('DISCOVER_OUR_DIVERSE') }}</h4>
                <span> {{ __('ALL_CATEGORIES') }} ({{ count($categories) }})</span>
            </div>

            @foreach ($categories as $category)
                @if ($category['talks_count'] > 0)
                    <div class="small-6 medium-3 b1 zumbo">

                        <a href="/search-talks/{{ $category['engname'] }}">

                            <div class="searchBlocks" data-category-id="{{ $category['id'] }}">

                                <h3 class="p0 m0 dif">
                                    {{ $category['value'] }}
                                </h3>

                                @include('frontend.partials.pages.courses.category-item', [
                                    'id' => $category['id'],
                                ])

                            </div>
                        </a>

                    </div>
                @else
                    <div class="small-6 medium-3 b1 zumbo" style="filter: grayscale(1); opacity:0.3; pointer-events:none;">

                        <a href="/search-talks/{{ $category['value'] }}">

                            <div class="searchBlocks" data-category-id="{{ $category['id'] }}">

                                <h3 class="p0 m0 dif"> {{ $category['value'] }} {{-- <span
                                    class="graycolor">({{ count($category['subcategories']) }})</span> --}}
                                </h3>

                                @include('frontend.partials.pages.courses.category-item', [
                                    'id' => $category['id'],
                                ])

                            </div>
                        </a>

                    </div>
                @endif
            @endforeach

        </div>

    </div>
@endsection
