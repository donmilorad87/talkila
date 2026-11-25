<div class="grid-x white-box">

    <div class='small-12'>
        @include('frontend.partials.pages.jtc.mobile-steps-navigation-4', [
            'page_title' => __('TALK_DETAILS'),
            'page_back_link' => '0',
            'save_button' => '1',
        ])
        <input type="hidden" value={{$talk_details['id']}} name="talkId" id="talkId">
        <div class="credit-modal pe22em w-100 fl">
            <div class="course-item privateCourseItem m0">
                <a data-talk-id="{{ $talk_details['talk']['id'] }}" class="dataTalkId">
                    <div class="icon-sn book-sn-icon gray-bg divPrivTalk0">
                        <div class="divPrivTalk">
                            <h6>30</h6>
                            <p>
                                {{ __('PROFILE_MINUTES') }}
                            </p>
                        </div>
                    </div>
                    <div class="heading-slider">
                        <h6>{{ $talk_details['talk']['headline'] }}


                            @if ($talk_details['talk']['following'])
                                <span class="favoriteHeart" data-fallowing="1"
                                    data-id="{{ $talk_details['talk']['id'] }}">
                                    @include('frontend.partials.svg.icons.full-heart2')
                                </span>
                            @else
                                <span class="favoriteHeart" data-fallowing="0"
                                    data-id="{{ $talk_details['talk']['id'] }}">
                                    @include('frontend.partials.svg.icons.heart-black')
                                </span>
                            @endif

                        </h6>



                        <div class="df aic">
                            @include('frontend.partials.components.rating_stars', [
                                'ratings' => $talk_details['talk']['ratings'],
                            ])

                            <strong
                                class="colorBlack aic jcc">{{ sprintf('%.1f', $talk_details['talk']['ratings']) }}</strong>

                            <span class="ml8 small">({{ $talk_details['talk']['reviews'] }}reviews)</span>
                        </div>

                    </div>
                </a>
            </div>
            <hr class="mb0">

            <div class="form-option pl0 pr0 pb0 w-100">
                <div class="grid-x">
                    <fieldset class="large-12">
                        <div class="radio-option-inner">
                            <a href="/{{ $talk_details['username'] }}">
                                <label for="pocketsRed" class="dRed">

                                    @if (!empty($talk_details['profile_picture']))
                                        <div class="noProfilePhoto df aic">
                                            <img src="{{ $talk_details['profile_picture'] }}" alt="{{ $talk_details['name'] }}" />
                                        </div>
                                    @else
                                        <div class="noProfilePhoto df aic">
                                            @include('frontend.partials.svg.icons.no-profile-picture')
                                        </div>

                                    @endif
                                    <div class="ml16">
                                        <p class="smallerFontParagrafFontWeight m0">
                                            {{ $talk_details['username'] }}
                                        </p>
                                        <p class="biggerFontParagraf m0">
                                            {{ $talk_details['name'] }}
                                        </p>
                                    </div>
                                </label>
                            </a>
                        </div>
                        <div class="radio-option-inner">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.96 6.48132L10.8975 3.89112C10.3097 3.70296 9.69063 3.70296 9.1025 3.89112L1.04 6.48132C0.418125 6.68119 0 7.25802 0 7.91721C0 8.5764 0.418125 9.15323 1.04 9.3531L1.7475 9.58032C1.67062 9.74926 1.61 9.92602 1.56938 10.1112C1.23531 10.2799 1 10.6292 1 11.0419C1 11.3928 1.1775 11.6881 1.43313 11.8769L0.635312 15.6162C0.565938 15.9414 0.803438 16.25 1.12344 16.25H2.87687C3.19687 16.25 3.43438 15.9414 3.365 15.6162L2.56687 11.8769C2.82219 11.6881 3 11.3928 3 11.0419C3 10.6969 2.82844 10.4058 2.58031 10.2164C2.61562 10.1008 2.67281 9.99927 2.73187 9.8964L4.44656 10.4472L4 14.1666C4 15.317 6.68625 16.25 10 16.25C13.3138 16.25 16 15.3174 16 14.1666L15.5538 10.4472L18.96 9.35278C19.5822 9.1529 20 8.57607 20 7.91688C20 7.2577 19.5819 6.68119 18.96 6.48132ZM14.4513 13.8564C12.5856 14.9697 7.39188 14.956 5.54906 13.8564L5.90219 10.915L9.10281 11.9433C9.45125 12.055 10.1103 12.1962 10.8978 11.9433L14.0984 10.915L14.4513 13.8564ZM10.4559 10.4498C10.1609 10.5445 9.83875 10.5445 9.54375 10.4498L4.83187 8.93545L10.0916 7.90809C10.3631 7.85536 10.5419 7.58322 10.4909 7.30034C10.4403 7.01648 10.1756 6.83289 9.90781 6.88497L3.53969 8.12848C3.33219 8.16884 3.13969 8.24371 2.955 8.33258L1.66219 7.91656L9.54406 5.3843C9.83906 5.28957 10.1613 5.28957 10.4563 5.3843L18.3381 7.91753L10.4559 10.4498Z"
                                        fill="#172B4D"></path>
                                </svg>
                            </span>
                            <label for="pocketsRed">
                                @if ($talk_details['talk']['call_type'] == 1)
                                    {{ __('PRIVATE_TALK') }}
                                @elseif($talk_details['talk']['call_type'] == 2)
                                    {{ __('GALLERY_TALK') }}
                                @endif
                            </label>
                        </div>
                        <div class="radio-option-inner">
                            <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.81818 3H21.1818C22.186 3 23 3.89543 23 5V17C23 18.1046 22.186 19 21.1818 19H11V17H21V10H3V12H1V5C1 3.89543 1.81403 3 2.81818 3ZM21 5V8H3V5H21ZM1 17H5.58579L4.29289 18.2929L5.70711 19.7071L9.41421 16L5.70711 12.2929L4.29289 13.7071L5.58579 15H1V17Z"
                                        fill="black" />
                                </svg>

                            </span><label for="pocketsRed">
                                {{ priceFormater($talk_details['talk']['price']) }}
                            </label>
                        </div>


                        <div class="radio-option-inner">
                            <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.99998 19.1673C4.93737 19.1673 0.833313 15.0633 0.833313 10.0007C0.833313 4.93804 4.93737 0.833984 9.99998 0.833984C15.0626 0.833984 19.1666 4.93804 19.1666 10.0007C19.1666 15.0633 15.0626 19.1673 9.99998 19.1673ZM9.99998 17.5007C14.1421 17.5007 17.5 14.1428 17.5 10.0007C17.5 5.85852 14.1421 2.50065 9.99998 2.50065C5.85784 2.50065 2.49998 5.85852 2.49998 10.0007C2.49998 14.1428 5.85784 17.5007 9.99998 17.5007ZM14.1666 9.16732H10.8333V5.00065H9.16665V10.834H14.1666V9.16732Z"
                                        fill="#172B4D"></path>
                                </svg>
                            </span>
                            <label for="pocketsRed">
                                {{ $talk_details['talk']['duration'] }} {{ __('PROFILE_MINUTES') }}
                            </label>
                        </div>
                        <div class="radio-option-inner">

                            <label for="pocketsRed">
                                <span class="fl"><svg width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.96 6.48132L10.8975 3.89112C10.3097 3.70296 9.69063 3.70296 9.1025 3.89112L1.04 6.48132C0.418125 6.68119 0 7.25802 0 7.91721C0 8.5764 0.418125 9.15323 1.04 9.3531L1.7475 9.58032C1.67062 9.74926 1.61 9.92602 1.56938 10.1112C1.23531 10.2799 1 10.6292 1 11.0419C1 11.3928 1.1775 11.6881 1.43313 11.8769L0.635312 15.6162C0.565938 15.9414 0.803438 16.25 1.12344 16.25H2.87687C3.19687 16.25 3.43438 15.9414 3.365 15.6162L2.56687 11.8769C2.82219 11.6881 3 11.3928 3 11.0419C3 10.6969 2.82844 10.4058 2.58031 10.2164C2.61562 10.1008 2.67281 9.99927 2.73187 9.8964L4.44656 10.4472L4 14.1666C4 15.317 6.68625 16.25 10 16.25C13.3138 16.25 16 15.3174 16 14.1666L15.5538 10.4472L18.96 9.35278C19.5822 9.1529 20 8.57607 20 7.91688C20 7.2577 19.5819 6.68119 18.96 6.48132ZM14.4513 13.8564C12.5856 14.9697 7.39188 14.956 5.54906 13.8564L5.90219 10.915L9.10281 11.9433C9.45125 12.055 10.1103 12.1962 10.8978 11.9433L14.0984 10.915L14.4513 13.8564ZM10.4559 10.4498C10.1609 10.5445 9.83875 10.5445 9.54375 10.4498L4.83187 8.93545L10.0916 7.90809C10.3631 7.85536 10.5419 7.58322 10.4909 7.30034C10.4403 7.01648 10.1756 6.83289 9.90781 6.88497L3.53969 8.12848C3.33219 8.16884 3.13969 8.24371 2.955 8.33258L1.66219 7.91656L9.54406 5.3843C9.83906 5.28957 10.1613 5.28957 10.4563 5.3843L18.3381 7.91753L10.4559 10.4498Z"
                                            fill="#172B4D"></path>
                                    </svg>
                                </span>
                                <div class="fl">
                                    <a class="cblack" href="{{route('talkCategory',['category'=> $talk_details['talk']['category_name']])}}">{{ $talk_details['talk']['category_name'] }}</a>
                                    >
                                    <a class="cblack" href="{{
                                    route('talkCategorySubcategory',
                                        [
                                            'category' => $talk_details['talk']['category_name'],
                                            'subcategory'=> $talk_details['talk']['subcategory_name']
                                        ]
                                        )
                                    }}" id="languageText">{{ $talk_details['talk']['subcategory_name'] }}</a>
                                </div>
                            </label>
                        </div>
                        <div class="radio-option-inner cp cpointer shbt shbtt2 teacherShare" data-popup="shareProfilePopUpTalkDetails">

                            <label for="pocketsRed">
                                <span class="fl">
                                    @include('frontend.partials.svg.icons.share')
                                </span>
                                <div class="fl" id="teacherSharings">
                                    <span class="fl" id="teacherSharingDomain">{{config('app.appUrl')}}/</span>
                                    <span class="fl" id="languageTexter">{{$talk_details['username']}}</span>
                                </div>
                            </label>
                        </div>
                    </fieldset>

                    <h5 class="fl w-100 tal mb8 pt0 mt16">{{ __('DESCRIPTION') }}</h5>
                    <p class="fl w-100 wbba">
                        @if ($talk_details['talk']['description'])
                            {{ $talk_details['talk']['description'] }}
                        @else
                            @lang('THIS_TALK_DO_NOT_HAVE_DESCRIPTION')
                        @endif

                    </p>
                </div>

            </div>
        </div>
        <div class="fixedBookButton">

            <a href="/booking-summary/{{ $talk_details['talk']['id'] }}" class="btn w-100 db m0">
                {{ __('BOOK_TALK') }}</a>

        </div>
    </div>

</div>
