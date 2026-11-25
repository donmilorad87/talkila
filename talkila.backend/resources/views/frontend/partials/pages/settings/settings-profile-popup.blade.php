<div class="popupBase" id="profileSettings" data-opened="0">
    <div class="popuper">
        <div class="grid-x">
            <div class="setting-page">

                <div class="grid-x grid-margin-x">

                    <div class="cell large-12">
                        @include('frontend.partials.pages.jtc.mobile-steps-navigation-3',
                            [
                                'page_title'        => "Edit Profile",
                                'page_back_link'    => "/jtc/welcome",
                                "save_button"       => "0",
                                'step_progress_text'=> 'Step 3 of 5',
                                'back_popup'        => 'profileSettings',
                                'saveButtonText'    => 'saveButtonTextProfile'
                            ]
                        )
                        <div class="cell small-12 large-12">
                            <div class="sidebar-menu-wrap setPageForm">

                            </div>
                            {{-- <div class="sidebar-menu-wrap">
                                <div class="group-profile">
                                    <a href="#" class="group-inner-profile">
                                        <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
                                        <span>@include('frontend.partials.svg.icons.camera-blue')</span>
                                    </a>
                                    <p>{{ __('CHANGE_PHOTO') }}</p>
                                </div>

                                <h6>{{ __('PUBLIC_INFO') }}</h6>
                                <p>{{ __('PUBLIC_INFO_MESSAGE') }}</p>

                                <ul class="menu-bar profile-menu">
                                    <li><a href="#"> {{ __('NAME') }} </a> <span><input type="text" placeholder="Helen Tran"> @include('frontend.partials.svg.icons.arrow-right') </span> </li>
                                    <li><a href="#">{{ __('USER_NAME') }}</a> <span><input type="text" placeholder="username1988"> @include('frontend.partials.svg.icons.arrow-right') </span> </li>
                                    <li><a href="#">{{ __('WEBSITE') }} </a> <span><input type="text" placeholder="Add a Website URL"> @include('frontend.partials.svg.icons.arrow-right') </span> </li>
                                    <li><a href="#">{{ __('BIO') }} </a> <span><input type="text" placeholder="Add a Bio to your profile"> @include('frontend.partials.svg.icons.arrow-right') </span> </li>
                                    <li>
                                        <a href="#">{{ __('CV') }} </a>

                                        <div class="upload-cv-wrap">
                                            <input type="file" placeholder="Add your CV">
                                            <div class="cv-inner">{{ __('ADD_YOUR_CV') }}</div>
                                            @include('frontend.partials.svg.icons.add-cv')
                                        </div>

                                    </li>
                                </ul>

                                <h6>{{ __('PRIVATE_INFO') }}</h6>
                                <p>{{ __('NOTICE_WONT_DISPLAY_EMAIL') }}</p>
                                <ul class="menu-bar profile-menu">
                                    <li>
                                        <label class="posrelative">{{ __('EMAIL') }}
                                            <input type="text" placeholder="{{ $loggedUserData['email'] }}" disabled>
                                            <button class="btn eButtonSet cp" data-popup="editEmail">{{ __('EDIT_EMAIL') }}</button>
                                        </label>
                                    </li>
                                    <li><a href="#">{{ __('PASSWORD') }} </a> <span><input type="text" placeholder="••••••••••••••••"> @include('frontend.partials.svg.icons.arrow-right') </span></li>

                                </ul>

                            </div> --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <span class="closeSpanPopup">×</span>
    </div>
</div>
