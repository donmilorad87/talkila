@extends('frontend.layouts.frontendlayout')
@section('content')
    @include('frontend.partials.pages.jtc.mobile-steps-navigation-5', [
        'page_title' => __('EXPLORE_TALKS'),
        'page_back_link' => '0',
        'save_button' => '1',
        'zIndex' => 'zi999',
    ])



    <div class="container white-box zi998 posrelative">

        <div class="p1rem" id="coursesBlocks">

            <div class="w-100">
                <div class="df aic fdc jcsb">
                    <div class="df aic w-100 jcsb">
                        <h2 class="mb0">@lang('SEARCH_HEADING')</h2>
                        <a class="cblack underlineHover" href="{{ route('courses_all') }}">@lang('SHOW_ALL')</a>
                    </div>
                </div>

            </div>

            <div class="w-100 oa mt32">
                @php
                    $counter = 0;
                    $notEmptyCategories = [];
                    for ($i = 0; $i < count($categories); $i++) {
                        if ($categories[$i]['talks_count'] > 0) {
                            $counter++;
                            array_push($notEmptyCategories, $categories[$i]);
                        }
                    }

                    $first_carousel_lengt = ceil($counter / 2);
                    $seccond_carousel_lengt = $counter - $first_carousel_lengt;
                @endphp
                <div class="hide-for-medium2 fixedPositionMobile zi999">
                    <div class="df g1rem fl w-100 p1rem0dot5rem oxa">

                        @for ($i = 0; $i < count($notEmptyCategories); $i++)
                            <a class="cblack underlineHover categoriesLink"
                                href="{{ route('talkCategory', ['category' => $notEmptyCategories[$i]['engname']]) }}">
                                {{ $notEmptyCategories[$i]['value'] }}
                            </a>
                        @endfor

                    </div>
                </div>
                <div class="" id="mainCategoriesCarousel">
                    <div class="df g1rem fl w-100 mb8">

                        @for ($i = 0; $i < $first_carousel_lengt; $i++)
                            <a class="underlineHover categoriesLink"
                                href="{{ route('talkCategory', ['category' => $notEmptyCategories[$i]['engname']]) }}">
                                {{ $notEmptyCategories[$i]['value'] }}
                            </a>
                        @endfor

                    </div>

                    <div class="df g1rem fl w-100 mb16">

                        @for ($i = $first_carousel_lengt; $i < $counter; $i++)
                            <a class="underlineHover categoriesLink"
                                href="{{ route('talkCategory', ['category' => $notEmptyCategories[$i]['engname']]) }}">
                                {{ $notEmptyCategories[$i]['value'] }}
                            </a>
                        @endfor

                    </div>
                </div>


            </div>

            <div>
                @foreach ($categories as $category)
                    @if ($category['talks_count'] > 0)
                        <a href="{{ route('talkCategory', ['category' => $category['engname']]) }}">
                            <h4 class="mt16 cpointer underlineHover">{{ $category['value'] }}</h4>
                        </a>
                        <div class="w-100 talksCarouselMainSearch mt16">
                            @foreach ($category['talks'] as $talk)
                                <div class="talkItemMainSearch">


                                    <a class="talkItemMainImageDiv border1 searchPageLinks"
                                        href="{{ route('book_slot', $talk['id']) }}"
                                        data-mobile-href="{{ route('talk_details', ['user' => $talk['supplier']['username'], 'id' => $talk['id']]) }}">
                                        <img src="{{ $talk['supplier']['profile_picture'] ?? $talk['supplier']['profile_picture_tmp'] }}"
                                            alt="{{ $talk['supplier']['name'] }}">
                                        <div class="talkIconsContainer">
                                            <div class="durations duration{{ $talk['duration'] }}">
                                                {{ $talk['duration'] }} @lang('MINUTES_SHORT')
                                            </div>
                                            <div
                                                class="talkIcons {{ !$talk['is_anonymous_allowed'] ? 'curvedBorders' : '' }}">
                                                @if ($talk['talk_type'] === 1)
                                                    @include('frontend.partials.svg.icons.phone')
                                                @elseif ($talk['talk_type'] === 2)
                                                    @include('frontend.partials.svg.icons.video-camera')
                                                @endif
                                            </div>

                                            @if ($talk['is_anonymous_allowed'])
                                                <div class="cblack bGray">|</div>
                                                <div
                                                    class="talkIcons {{ $talk['is_anonymous_allowed'] ? 'curvedBorders' : '' }}">
                                                    @include('frontend.partials.svg.icons.anonymous')
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="mb16 mt16">
                                        <h4 class="tal mb0 talkHeadings underlineHover">
                                            <a href="{{ route('book_slot', $talk['id']) }}"
                                                title="{{ $talk['headline'] }}"
                                                href="{{ route('book_slot', $talk['id']) }}"
                                                data-mobile-href="{{ route('talk_details', ['user' => $talk['supplier']['username'], 'id' => $talk['id']]) }}"
                                                class="cblack headingForTalk searchPageLinks">
                                                {{ $talk['headline'] }}
                                            </a>
                                        </h4>
                                        <h6 class="mb0 lh2 userfullnamefield">
                                            <a href="{{ route('profile', $talk['supplier']['username']) }}"
                                                title="{{ $talk['supplier']['username'] }}" class="cblack underlineHover">
                                                {{ $talk['supplier']['name'] }}
                                            </a>
                                        </h6>
                                        <h4 class="tal mb0 cblack">
                                            {{ priceFormater($talk['price']) }}
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
