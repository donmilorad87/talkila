@section('popup_section')
    @include('frontend.partials.components.add-group-talk-popup')

    @include('frontend.partials.components.add-private-talk-popup')
    @include('frontend.partials.components.add_talk_complete_popup')
    @include('frontend.partials.components.blank_popup')

    @include('frontend.partials.components.change-availability-popup', [
        'pointerForMobile' => '',
    ])

    @include('frontend.partials.pages.jtc.time-slot-popup')
    @include('frontend.partials.pages.jtc.upload-popup')
    @include('frontend.partials.components.take-picture-with-camera')


    @if (!isset($_COOKIE['promotionShow']))
        @if ($user->pendingProfileVerificationRequest)
            @if (
                $user->type === UserRoles::TEACHER &&
                    $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved']
            )
                @if ($user->partner)
                    @php
                        setcookie('promotionShow', 'true', time() + 30 * 24 * 3600 * 30, '/');
                    @endphp

                    @include('frontend.partials.components.share-profile-popup-partner')
                @endif
            @endif
        @endif
    @endif

@endsection


@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="talkAvaDiv">
        <div class='cell small-12 hide-for-medium'>
            @include('frontend.partials.pages.profile.user-info')
        </div>

        <div class="container white-box">





            <section class="bwhite w-100 oh">
                <div class="inner-box-book w-100 fl">

                    <div class="coursesBlock p16mob">

                        <div class="addGroupPrivateAva">

                            <h4 class="show-for-medium headlineAva pt16 pb16"> {{ __('ADD_NEW_TALKS') }} </h4>
                            <div class="addTalksCell df addTalksAndAvaContainer g1rem">

                                <div class="add-slot cp addPrivateTalk addPrivateTalkTalksAndAva"
                                    data-popup="addPrivateTalk">
                                    @include('frontend.partials.svg.icons.private_talk')
                                    <b>+</b> <span>{{ __('ADD_PRIVATE_TALKS') }}</span>
                                </div>

                                <div class="add-slot cp addPrivateTalk addGroupTalkTalksAndAva" data-popup="addGroupTalk">
                                    @include('frontend.partials.svg.icons.private_talk')
                                    <b>+</b> <span>@lang('ADD_GALLERY_TALK')</span>
                                </div>

                            </div>
                        </div>


                        <div class="mt16 pl2 df-show-for-medium2">

                            @if (!$user->pendingProfileVerificationRequest)
                                <div class="bshadow br6 mr16">
                                    <div class="bwhite mr4">
                                        <a class="w-100 df jcc" href="{{ route('jtc2_verify_account') }}">
                                            <h6 class="talignc w-100 mr4p14">{{ __('PLEASE_VERIFY_ACCOUNT') }}</h6>
                                        </a>

                                    </div>
                                </div>
                            @endif

                            <div class="bshadow br6 mr16">
                                <div class="bwhite mr4">
                                    <h6 class="talignc cp mr4p14" data-popup="changeAvailability">
                                        {{ __('CHANGE_AVAILABILITY') }}</h6>

                                </div>
                            </div>
                            <div class="bshadow br6">
                                <span class="loadAboutMe" data-popup="blankPopup" data-opened="0">
                                    <div class="bwhite mr4">
                                        <h6 class="talignc mr4p14">{{ __('ABOUT_ME') }}</h6>
                                    </div>
                                </span>
                            </div>

                        </div>


                        <h4 class="show-for-medium pt0 headlineAva mt16 mb16">
                            {{ __('OVERVIEW_OF_YOUR_TALKS') }} </h4>


                        <div class="grid-x mt16">
                            <div class="show-for-medium2">

                                <table id="categorySubcategoryTalksTable" class="mt0">
                                    <thead>
                                        <tr>
                                            <td class="width321">{{ __('TALKS') }}</td>
                                            <td class="w-100p">{{ __('TYPE') }}</td>
                                            <td class="w-110p tac">
                                                {{ __('REVIEWS') }}
                                            </td>
                                            <td class="w-80p df jcc">
                                                <div class="fl">
                                                    {{ __('BOOKMARKS') }}
                                                </div>
                                                <div class="sortingSearch2 fl tooltipser">
                                                    @include('frontend.partials.svg.icons.union')
                                                    <span
                                                        class="tooltiptexter">{{ __('BOOKMARK_FOLLOW_TALK_AND_AVA_TEXT') }}</span>
                                                </div>

                                            </td>
                                            <td class="w-80p df jcc">
                                                <div>
                                                    <div class="fl">
                                                        {{ __('EARNINGS') }}
                                                    </div>
                                                    <div class="sortingSearch2 fl tooltipser">
                                                        @include('frontend.partials.svg.icons.union')
                                                        <span class="tooltiptexter">{{ __('BOOKMARKS') }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="w-80p df jcc">
                                                <div>
                                                    <div class="fl">
                                                        {{ __('ACTIVE') }}
                                                    </div>
                                                    <div class="sortingSearch2 fl tooltipser">
                                                        @include('frontend.partials.svg.icons.union')
                                                        <span
                                                            class="tooltiptexter2">{{ __('PAUSE_TALK_TALKS_AND_AVA_TEXT') }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="w-80p df jcc"></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($userPrivateTalks as $userTalks)
                                            @include(
                                                'frontend.partials.pages.talks_and_availabilites.list_of_talks',
                                                [
                                                    'item' => $userTalks,
                                                    'index' => $loop->index,
                                                ]
                                            )
                                        @endforeach


                                        @include('frontend.partials.components.share-talk-popup-2')
                                    </tbody>
                                </table>


                            </div>

                            <div class="grid-container w-100 grid-x p0 hide-for-medium2" id="mobileContainerForTalks">

                                @foreach ($userPrivateTalks as $userTalks)
                                    @include(
                                        'frontend.partials.pages.profile.course-overview',
                                        [
                                            'userTalks' => $userTalks,
                                        ]
                                    )
                                @endforeach

                            </div>
                        </div>

                    </div>

                </div>
            </section>



        </div>

        <input type="hidden" id="userAvailabilites" value="{{ json_encode($userAvailability) }}">
    </div>
@endsection
