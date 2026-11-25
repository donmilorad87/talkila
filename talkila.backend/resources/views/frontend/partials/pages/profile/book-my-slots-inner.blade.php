<div class="inner-box-book">

    <div class="coursesBlock privateC" id="mobilePrivateProfileTeacherTalks">

        @include('frontend.partials.pages.profile.course_mobile_overview', [
            'userPrivateTalks'  => $userPrivateTalks,
            'userData'          => $userData,
        ])


    </div>


    <div class="coursesBlock mb16 @if ($talks_count <= 5) dn @endif">
        <div class="bookShowMoreCont">
            <button class="privateShowMore btn hollow w-100 db" data-userId="{{ $userData['id'] }}" data-type="1">
                {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
            </button>
        </div>
        <div style="display: none;">
            <button class="privateHideMore btn hollow w-100 db" data-userId="{{ $userData['id'] }}" data-type="1">
                {{ __('HIDE_MORE') }}
            </button>
        </div>
    </div>
</div>
