<div class="inner-box-book">


    <h5 class="bb1 mb0 pb16 mt0 suplierHeading">
        <span class="fw300">{{ __('BOOK_A_TALK_FROM') }}</span>
        <b>{{ $userData['name'] }}</b>
        <span class="fs18 fw300">({{ $talks_count }})</span>
    </h5>

    <div class="coursesBlock privateC" id="privateTeacherTalks">

        @include('frontend.partials.pages.profile.courses_profile',[
            'userPrivateTalks' => $userPrivateTalks
        ])

    </div>


        <div class="coursesBlock showHideButter @if ($talks_count > 5) db @else dn @endif">
            <div class="bookShowMoreCont">
                <button class="db privateShowMore" data-userId="{{ $userData['id'] }}" data-type="1">
                    {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                </button>
            </div>
            <div class="" style="display: none;">
                <button class="db privateHideMore" data-userId="{{ $userData['id'] }}" data-type="1">
                    {{ __('HIDE_MORE') }}
                </button>
            </div>

        </div>

</div>
