<div class="grid-x">
    @if ($talks_count>config('app.show_more_talks')) @include('frontend.partials.components.filter-sidebar') @endif

    <div class="small-12 medium-12 @if ($talks_count<config('app.show_more_talks')) p16 m0 mt16 pt0 aic jcc large-12 @else large-9 @endif pl24resdes">
        <div class="w-100 searchContainerMain pointerForFilter bakareza2 white-box-rounded bordersSquareOposite @if (!$talks_count) > 0) dn @endif">
            <div class="w100 fl df breadCrumps w-100 fl specialDesktopPaddings25">
                <a href="{{ route('courses') }}">
                    <span> {{__('ALL')}} </span>
                </a>
                <span class="rightArrowZ df aic">
                    <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.40117e-08 8.825L3.825 5L1.05237e-07 1.175L1.18333 2.5253e-07L6.18333 5L1.18333 10L1.40117e-08 8.825Z" fill="#172B4D"></path>
                    </svg>
                </span>
                <ul class="tabs talkTabs w-100 fl df m0">
                    <li class="tabs-title h38 is-active mr8 dn">
                        <span class="minw94" data-all-categories="1">
                            {{ __('ALL_CATEGORIES') }}
                        </span>
                    </li>
                    <li class="owl-carousel" id="categoryCarousel">
                        @if(trim($subcategory->english) == request()->segments()[2])

                            @foreach ($subcategories as $subcategory_tab)

                                    <div class="tabs-title df aic jcc" data-category-id="{{ $subcategory_tab->id }}" data-parent-category-id="{{ $subcategory->category->id }}">

                                        <a class="dif carouselLinksSubs {{$subcategory_tab->english === basename(Request::url()) ? 'active pen' : ''}}"
                                           href="{{ route('talkCategorySubcategory', [$subcategory_tab->category->english, $subcategory_tab->english]) }}">

                                            <p> {{ $subcategory_tab->name }} </p>
                                            <p class="ml4">({{ $subcategory_tab->talks_count }})</p>
                                        </a>
                                    </div>


                            @endforeach
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-100 searchContainerMain mt16 bordersSquare">
            <div class="fav-item">
                <div class="grid-x @if (!$talks_count)) white-box p0 m0 df aic jcc @endif">
                    @if ($talks_count)
                        <div class="cell medium-12 large-12 searcTalksContainer">



                            <table id="categorySubcategoryTalksTable">
                                <thead>
                                    <tr>
                                        <td class="width321">{{ __('TALK_INFO') }}
                                            (<span id="talks_countField">{{ $talks_count }}</span>)
                                        </td>
                                        <td class="w-87p tac">{{ __('TYPE') }}</td>
                                        <td class="w-110p">
                                            <div class="fl" id="ratingSort">
                                                {{ __('RATING') }}
                                            </div>

                                            <div class="sortingSearch fl">
                                                @include('frontend.partials.svg.icons.bottom_', ['class' => 'w-100 fl orderByRateASC'])
                                                @include('frontend.partials.svg.icons.bottom_', ['class' => 'w-100 fl rotate180 orderByRateDESC'])
                                            </div>
                                        </td>
                                        <td class="w-80p jcc">
                                            <div>
                                                <div class="fl" id="durationSort">
                                                    {{ __('DURATION') }}
                                                </div>
                                                <div class="sortingSearch fl">
                                                    @include('frontend.partials.svg.icons.bottom_', ['class' => 'w-100 fl
                                                    orderByDurationASC'])
                                                    @include('frontend.partials.svg.icons.bottom_', ['class' => 'w-100 fl
                                                    rotate180 orderByDurationDESC'])
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-80p jcc">
                                            <div>
                                                <div class="fl" id="priceSort">
                                                    {{ __('BASE_PRICE') }}
                                                </div>
                                                <div class="sortingSearch fl">
                                                    @include('frontend.partials.svg.icons.bottom_', ['class' => 'w-100 fl
                                                    orderByPriceASC'])
                                                    @include('frontend.partials.svg.icons.bottom_', ['class' => 'w-100 fl
                                                    rotate180 orderByPriceDESC'])
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-80p jcc">
                                            <div class="fl">
                                                {{ __('BOOKMARKS') }}
                                            </div>
                                            <div class="sortingSearch2 fl tooltipser">
                                                @include('frontend.partials.svg.icons.union')
                                                <span class="tooltiptexter">{{__('BOOKMARK_FOLLOW_TEXT')}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($talks as $talk)
                                        @include('frontend.partials.pages.courses.paginate_new_talks', ['talk' => $talk])
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="talksBlock">
                                <div class="talksShowMore df jcc tac @if ($talks_count <= config('app.show_more_talks')) dn @endif">
                                    <button class="btn btnShowMore">
                                        {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                                    </button>

                                </div>
                            </div>

                            <div class="no-found-heading @if($talks_count > 0) dn @endif">
                                <div>
                                    <img src="{{ asset('frontend/assets/img/taxi-waiting.png') }}" alt="Nothing Found" />
                                    <h5>{{ __('NOTICE_NOTHING_FOUND') }}</h5>
                                    <p class="filterero">{{ __('TRY_USING_FILTERS') }}</p>
                                </div>

                            </div>



                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
