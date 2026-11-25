@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="oh posrelative">
        <div class="grid-container">

            @include('frontend.partials.pages.settings.settings-profile')
        </div>
        <div class="hide-for-medium">
            @include('frontend.partials.pages.settings.settings-mobile')
        </div>


        <div class="form-wrapper form-wrapperZ dn">
            <div class="small-12">
                <div class="form-option">
                    <div class="grid-x grid-padding-x">
                        <div class="small-12">

                            <p>{{ __('PUBLIC_INFO_MESSAGE') }}</p>
                        </div>

                        @php
                            $user_is_teacher = false;
                            if ($user->pendingProfileVerificationRequest) {
                                if ($user->type === UserRoles::TEACHER && $user->pendingProfileVerificationRequest->status == \App\Models\UserVerificationRequests::STATE['approved']) {
                                    $user_is_teacher = true;
                                }
                            }

                        @endphp

                        <div class="small-12">
                            @include('frontend.partials.components.upload-profile-picture')
                        </div>
                        <div
                            class="small-12 @if ($user_is_teacher) large-6 pr81024 @else large-12 @endif posrelative">
                            <label class="pon lh39">{{ __('YOUR_NAME') }}

                                <input type="text" value="{{ auth()->user()->name }}" id="fullNameHolder"
                                    readonly="readonly" class="poa iFName nonselect cp cpe" data-popup="editFullName">

                                <button
                                    class="poa hide-for-mobile btn eButtonSet @if ($user_is_teacher) r121024 @endif cp"
                                    data-popup="editFullName">
                                    {{ __('EDIT') }}
                                </button>
                                <span
                                    class="poa show-for-mobile eButtonSet2 @if ($user_is_teacher) r121024 @endif cp"
                                    data-popup="editFullName">
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </span>

                            </label>
                        </div>
                        @if ($user_is_teacher)
                            <div class="small-12 large-6 posrelative">
                                <label class="lh39">{{ __('USERNAME') }}
                                    <input type="text" class="inputUsername" placeholder="{{ auth()->user()->username }}"
                                        id="usernameHolder" disabled>
                                    <div class="ttcorrection1">
                                        @include('frontend.partials.components.tooltip-left', [
                                            'tooltip_text' => __('VALIDATION_USERNAME_1'),
                                        ])
                                    </div>
                                </label>
                            </div>
                        @endif
                        <div class="small-12 large-6 posrelative pr81024">
                            <label class="pon lh39">{{ __('ABOUT_ME') }}
                                <textarea rows="4" class="textareaMobileCorrection bioTextarea poa iFName nonselect cp cpe" readonly="readonly"
                                    data-popup="addShortDescription">{{ auth()->user()->description ? (strlen(auth()->user()->description) > 40 ? substr(auth()->user()->description, 0, 40) . ' ...' : auth()->user()->description) : null }}</textarea>

                                <button class="poa hide-for-mobile btn eButtonSet cp r121024"
                                    data-popup="addShortDescription"> {{ __('EDIT') }}</button>

                                <span class="poa show-for-mobile eButtonSet2 cp r121024" data-popup="addShortDescription">
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </span>

                            </label>
                        </div>

                        <div class="small-12 large-6 posrelative mt16mobile">
                            <label class="pon lh39">{{ __('PROFILE_TYPE') }}
                                <input id="setPrivateProfileInput" type="text"
                                    placeholder="@if (auth()->user()->visibility === 1) {{ __('PUBLIC_ACCOUNT') }} @else {{ __('PRIVATE_ACCOUNT') }} @endif"
                                    readonly="readonly" class="poa iFName nonselect cp cpe" data-popup="setPrivateProfile">


                                <button class="poa hide-for-mobile btn eButtonSet cp" data-popup="setPrivateProfile">
                                    {{ __('EDIT') }}</button>

                                <span class="poa show-for-mobile eButtonSet2 cp" data-popup="setPrivateProfile">
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </span>

                            </label>

                        </div>

                        <div class="small-12 posrelative mb16">
                            <label class="pon lh39">{{ __('CALENDAR') }}

                                <div class="upload-cv-wrap cp caleButtonMobile br5above768"
                                    data-popup="connected_calendars">
                                    <div class="cv-inner">{{ __('CONNECT_YOUR_CALENDAR_HERE') }}</div>
                                    @include('frontend.partials.svg.icons.settings_calendar')
                                </div>


                            </label>
                        </div>


                        <div class="small-12">
                            <h6 class="mt32 mb8">{{ __('PRIVATE_INFO') }}</h6>
                            <p>{{ __('NOTICE_WONT_DISPLAY_EMAIL') }}</p>
                        </div>
                        <div class="small-12 large-6 posrelative pr81024">
                            <label class="pon lh39">{{ __('EMAIL') }}
                                <input type="text" value="{{ auth()->user()->email }}" readonly="readonly"
                                    class="poa iFName nonselect cp cpe" data-popup="editEmail">

                                <button class="poa hide-for-mobile btn eButtonSet r121024 cp" data-popup="editEmail">
                                    {{ __('EDIT') }}</button>

                                <span class="poa show-for-mobile eButtonSet2 r121024 cp" data-popup="editEmail">
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </span>

                            </label>
                        </div>
                        <div class="small-12 large-6 posrelative">
                            <label class="pon lh39">{{ __('PASSWORD') }}
                                <input type="text" value="••••••••••" readonly="readonly"
                                    class="passwordHolder poa pr8 iFName nonselect cp cpe" data-popup="editPassword">

                                <button class="poa hide-for-mobile btn eButtonSet cp" data-popup="editPassword">
                                    {{ __('EDIT') }}</button>

                                <span class="poa show-for-mobile eButtonSet2 cp" data-popup="editPassword">
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </span>

                            </label>
                        </div>

                        @if (isset($blockedUsers) && !empty($blockedUsers))
                            <div class="small-12 posrelative" id="showBlockUserPopupButton">
                                <label class="poa lh39">{{ __('BLOCKED_USERS') }}
                                    <input type="text" value="{{ __('BLOCKED_USERS_PLACEHOLDER') }}" readonly="readonly"
                                        class="poa iFName nonselect cp cpe" data-popup="blockedUsersPopup">

                                    <button class="poa hide-for-mobile btn eButtonSet cp"
                                        data-popup="blockedUsersPopup">{{ __('BLOCKED_USERS_BUTTON_TEXT') }}</button>


                                    <span class="poa show-for-mobile eButtonSet2">@include('frontend.partials.svg.icons.arrow-right')</span>
                                </label>
                            </div>
                        @endif


                        <div class="small-12 large-6 posrelative">
                            <label class="pon lh39">{{ __('DELETE_PROFILE') }}
                                <input type="text" value="@lang('DELETE_PROFILE')" readonly="readonly"
                                    class="passwordHolder poa pr8 iFName nonselect cp cpe" data-popup="deleteProfilePopup">

                                <button class="poa hide-for-mobile btn eButtonSet cp" data-popup="deleteProfilePopup">
                                    {{ __('DELETE') }}</button>

                                <span class="poa show-for-mobile eButtonSet2 cp" data-popup="deleteProfilePopup">
                                    @include('frontend.partials.svg.icons.arrow-right')
                                </span>

                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('popup_section')
    @include('frontend.partials.pages.settings.settings-profile-popup')
    @include('frontend.partials.pages.settings.language_popup')
    @include('frontend.partials.pages.profile.add-short-description')
    @include('frontend.partials.pages.profile.edit-full-name-popup')
    @include('frontend.partials.pages.settings.email-edit-popup')
    @include('frontend.partials.pages.settings.connected_callendars')

    @include('frontend.partials.pages.settings.password-edit-popup')
    @include('frontend.partials.pages.jtc.upload-popup')

    @include('frontend.partials.components.take-picture-with-camera')

    @include('frontend.partials.pages.settings.set_private_account')
    @include('frontend.partials.pages.settings.feedback-popup')

    @include('frontend.partials.components.delete-user-popup')

    @if (isset($blockedUsers) && !empty($blockedUsers))
        @include('frontend.partials.pages.settings.blocked_users_popup')
    @endif
@endsection

@section('footer_scripts')
    <script>
        let deleteProfileBtn = document.querySelector('#deleteProfile');

        deleteProfileBtn.addEventListener('click', function() {
            showLoading();
            fetch(envAppBackendUrl + '/delete-user', {
                    method: 'POST',
                    body: JSON.stringify({
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    }),
                    headers: {
                        'Content-Type': 'application/json;charset=UTF-8',
                        'Authorization': document.querySelector('meta[name=\'access_token\']').content,
                        'Accept': 'application/json',
                    },
                }).then(response => response.json())
                .then(response => {

                    //store response inside dataObj so it can be used later in other placesRc

                    if (response.success === true) {
                        toastify(response.message);
                        location.assign('/');

                    }

                }).catch(function(error) {

                });


        });
    </script>
@endsection
