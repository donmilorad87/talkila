@section('top_sticky_header')
    @include('frontend.partials.components.top-header')
@endsection


@extends('frontend.layouts.frontendlayout')

@section('popup_section')
    @include('frontend.partials.components.share-profile-popup-profile')
    @include('frontend.partials.components.app-popup')
    @include('frontend.partials.pages.profile.private-followers-popup-cancel')
@endsection



@section('content')
    <div class="container mb16">
        <div class="show-for-mobile2 mobilePaddings">
            @include('frontend.partials.pages.profile.user-info4', [
                'userId' => $userData['id'],
                'online' => '0',
                'aboutName' => $userData['name'],
                'username' => $userData['username'],
                'profession' => $userData['profession'],
                'verified' => $userData['approved'],
                'rating' => $userData['ratings'],
                'folowers' => $userData['total_followers'],
                'followButton' => $userData['follower'],
                'favoriteButton' => null,
                'loggedUserData' => $userData,
            ])

            <div class="white-box wbcorrection">
                <div class="grid-x">
                    @include('frontend.partials.pages.profile.left-container')

                </div>
            </div>

        </div>
        <div class="show-for-medium2 p1rem640only">

            <div class="white-boxer grid-x">
                <div class="w-35">

                    <div class="posrelative bb1">

                        @include('frontend.partials.pages.profile.profile_info')

                    </div>

                    <div class="p1reme w-100 pb0 df pb1dot5rem">
                        @include('frontend.partials.pages.profile.user-info-buttons')
                    </div>

                </div>

                <div class="w-65 back df fdc jcsb">
                    <div class="talksProfiler pl32 pr32 pt2rem">

                        @if (empty($userPrivateTalks) && empty($userPrivateTalks))
                            @include('frontend.partials.pages.profile.no-talks-box')
                        @elseif(
                                ($userData['visibility'] == 1 || $userData['is_me']) &&
                                ($userData['type'] == 2 && $userData['approved'])
                            )
                            <section class="small-12 gropings fl w-100">
                                @include('frontend.partials.pages.profile.user_talks_profile_page')
                            </section>

                        @elseif(
                            $userData['visibility']  == 2 &&
                            $userData['following']  == true
                        )
                            <section class="small-12 gropings fl w-100">
                                @include('frontend.partials.pages.profile.user_talks_profile_page')
                            </section>
                        @else
                            @include('frontend.partials.pages.profile.private-course-box')
                        @endif

                    </div>
                    <div class="talksProfiler mobileIconsContainerProfile">
                        <div class="df aic jcsb cblack p024">
                            <span class="mr8 spanerMobiler">
                                {{ __('BOOK_YOUR_FIRST_TALK') }} {{ __('WITH') }} <b> {{ $userData['username'] }}
                                </b> {{ __('VIA') }} Talkila.
                            </span>
                            <div>
                                <div class="mr8 {{($isApple['isIOSDevice'] || $isApple['isMacDevice']) ? 'df' : 'dn'}}">
                                    <a href="{{ config('app.iosStoreLink') }}">
                                        @include('frontend.partials.svg.icons.app_store_apple_outline')
                                    </a>

                                </div>
                                <div class="mr8 {{($isApple['isIOSDevice'] || $isApple['isMacDevice']) ? 'dn' : 'df'}}">
                                    <a href="{{ config('app.androidStoreLink') }}">
                                        @include('frontend.partials.svg.icons.app_store_google_outline')
                                    </a>

                                </div>
                            </div>


                        </div>
                    </div>


                </div>
                @if (isset($userData['description']) && !empty($userData['description']))
                    <div class="medium-12 br0 bb0">

                        <div class="talksProfiler">

                            <h5 class="talksProfilerh5">
                                {{ __('ABOUT') }}
                            </h5>

                            <p class="talksProfilerP">
                                {{ $userData['description'] }}
                            </p>

                        </div>



                    </div>
                @endif
                @if (!empty($userExperience))
                    <div class="medium-4 bb0">

                        <div class="talksProfiler">
                            @include('frontend.partials.pages.profile.experience')
                        </div>

                    </div>
                @endif
                @if (isset($teacherFeedback) && !empty($teacherFeedback))
                    <div class="medium-12 bt1">
                        <div class="reviewContRecieved">


                            <div class="talksProfiler mt0 pt0">

                                <h4 class="tac reviewHeadingProfile">
                                    {{ $userData['teacher_booked_review_count'] }} {{ __('VERIFIED_USER_RATINGS') }}
                                </h4>
                                <p class="tac">
                                    {!! __('PROFILE_REVIEW_SUBTITLE_1') !!} {{ $userData['name'] }}
                                    {{ __('PROFILE_REVIEW_SUBTITLE_2') }}
                                </p>
                            </div>

                            @include('frontend.partials.components.review-carousel-profile-page', [
                                'teacherFeed' => $teacherFeedback,
                            ])

                        </div>
                    </div>
                @endif
                <div class="medium-12 bb0 @if (
                    (isset($userData['description']) && !empty($userData['description'])) ||
                        (isset($teacherFeedback) && !empty($teacherFeedback))) bt1 @endif">
                    <div class="w-90 mauto posrelative">
                        <h4 class="tac mt60 mb48 cardsTitleZ">
                            {{ __('PROFILE_INFO_TITLE_1') }}
                        </h4>
                        <div class="df jcsa mb64">
                            <div class="tac f1">
                                <div class="df aic jcc">
                                    <div class="br50 circledIconsProfile br51">
                                        @include('frontend.partials.svg.icons.talkila_logo_small')
                                    </div>
                                </div>

                                <div class="bottomShadowed mt0">

                                    <div class="w-100 fl mmh80">
                                        <h6 class="mb8">
                                            {{ __('FIND_YOUR_TALK') }}
                                        </h6>
                                        <p class="cblack fs14 lh20">
                                            {!! __('OFFER_SEVERAL_TALKS', ['username' => $userData['name']]) !!}
                                        </p>
                                    </div>

                                    <div class="tal fl cblack">

                                        <div class="fl w-100">
                                            <div class="df aic mb6">
                                                <div class="mr8 df aic">
                                                    @include('frontend.partials.svg.icons.dark_blue_camera')
                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        {{ __('VIDEO_TALKS') }}
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('DEVICE_CAMERA_IS_ACTIVE') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="df aic mb6">
                                                <div class="mr8 df aic">
                                                    @include('frontend.partials.svg.icons.black_phone')
                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        {{ __('VOICE_TALKS') }}
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('NO_CAMERA_ACTIVE') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="df aic">
                                                <div class="mr8 df aic">
                                                    @include('frontend.partials.svg.icons.black_uneversity_cap')
                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        {{ __('PRIVATE_TALKS') }}
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('TOTALLY_ANONYMOUS', ['username' => $userData['name']]) }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="tac f1">
                                <div class="df aic jcc">
                                    <div class="br50 circledIconsProfile br52">
                                        @include('frontend.partials.svg.icons.booking_small')
                                    </div>
                                </div>

                                <div class="bottomShadowed mt0 df fdc">
                                    <div class="w-100 fl mmh80">
                                        <h6 class="mb8">
                                            {{ __('SELECT_AN_APPOINTMENT') }}
                                        </h6>

                                        <p class="cblack fs14 lh20">
                                            {!! __('HAS_SET_AVAILABILITES', ['username' => $userData['name']]) !!}
                                        </p>
                                    </div>

                                    <div class="tal fl cblack">
                                        <div class="fl w-100">
                                            <div class="df aic mb6">
                                                <div class="mr8 df aic">
                                                    @include('frontend.partials.svg.icons.black_calendar')
                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        {{ __('SELECT_DATE') }}
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('FIND_YOUR_PERFECT_APPOINTMENT') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="df aic">
                                                <div class="mr8 df aic">
                                                    @include('frontend.partials.svg.icons.black_clock')
                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        {{ __('SELECT_TIME') }}
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('SEE_ALL_FREE_TIMESLOTS') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tac f1">
                                <div class="df aic jcc">
                                    <div class="br50 circledIconsProfile br53">
                                        @include('frontend.partials.svg.icons.credit_card_small')
                                    </div>
                                </div>

                                <div class="bottomShadowed mt0">
                                    <div class="w-100 fl mmh80">
                                        <h6 class="mb8">
                                            {{ __('PAY_SAFE') }}
                                        </h6>
                                        <p class="cblack fs14 lh20">

                                            {!! __('WILL_BE_CREATED', ['username' => $userData['name']]) !!}

                                        </p>
                                    </div>
                                    <div class="tal fl cblack">
                                        <div class="fl w-100">
                                            <div class="df aic mb6">
                                                <div class="mr8 df aic">
                                                    @include('frontend.partials.svg.icons.pay_pal_dark_blue')
                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        PayPal
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('FLEXIBILE_PAYMENT') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="df aic">
                                                <div class="mr8 df aic">
                                                    <div class="mr8 df">
                                                        @include('frontend.partials.svg.icons.american_expred_dark_blue')
                                                    </div>
                                                    <div class="mr8 df">
                                                        @include('frontend.partials.svg.icons.master_card_dark_blue')
                                                    </div>
                                                    <div class="mr8 df">
                                                        @include('frontend.partials.svg.icons.visa_dark_blue')
                                                    </div>

                                                </div>
                                                <div class="iconDivs">
                                                    <p class="fl w-100 m0 fw600">
                                                        {{ __('CREDIT_CARD') }}
                                                    </p>
                                                    <small class="fl w-100">
                                                        {{ __('CHOSE_YOUR_CREDIT_CARD') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="medium-12 breadcrumpsers">
                    <div>
                        @include('frontend.partials.pages.profile.how_talkila_works')
                    </div>
                </div>
                @if ($category->talks_count !== 0)
                    <div class="medium-12 breadersers fs18">
                        <div class="df aic">
                            <b class="mr8">Talkila</b>
                            <b class="mr8">></b>
                            <b class="mr8"><a href="{{ route('talkCategory', ['category' => $category]) }}"
                                    style="color: inherit">{{ $category->name }}</a></b>
                            <span class="mr8">({{ $category->talks_count }})</span>
                            <b class="mr8">></b>
                            <b class="mr8"><a
                                    href="{{ route('talkCategorySubcategory', ['category' => $subcategory->category, 'subcategory' => $subcategory]) }}"
                                    style="color: inherit">{{ $subcategory->name }}</a></b>
                            <span class="mr8">({{ $subcategory->talks_count }})</span>
                        </div>
                    </div>
                @endif
                @if ($otherTeachers->isNotEmpty())
                    <div class="medium-12 otherTeachersSection pb52">
                        <h5 class="tac otherTeachersHeading"> @lang('OTHER_SUPPLIERS') </h5>

                        <div id="otherTeachersCarousel" class="owl-carousel testimonialAboutMe">
                            @foreach ($otherTeachers as $otherTeacher)
                                <div>
                                    @include('frontend.partials.pages.profile.user_info_summary', [
                                        'userId' => $otherTeacher->teacher->id ?? 'tester',
                                        'imageUrl' => $otherTeacher->teacher->profile_picture,
                                        'online' => '0',
                                        'aboutName' => $otherTeacher->teacher->name,
                                        'username' => $otherTeacher->teacher->username,
                                        'profession' => $otherTeacher->teacher->profession,
                                        'verified' => $otherTeacher->teacher->approved,
                                        'rating' => $otherTeacher->teacher->ratings,
                                        'folowers' => $otherTeacher->teacher->followers->count(),
                                        'followButton' => $otherTeacher->teacher->followings->count(),
                                        'favoriteButton' => null,
                                        'teacher_booked_students' => $otherTeacher->teacher->bookings->count(),
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="medium-12">
                    @include('frontend.partials.pages.home.faq')
                </div>
            </div>

        </div>
    </div>
@endsection
