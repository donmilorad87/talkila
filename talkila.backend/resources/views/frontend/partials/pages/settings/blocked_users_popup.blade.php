<div class="popupBase" id="blockedUsersPopup" data-opened="0">
    <div class="popuper posrelative ppR popupBackgroundGray">
        <div class="grid-container mt52 popupWhiteRounded">

            @include('frontend.partials.pages.jtc.mobile-steps-navigation-3', [
                'page_title' => __('BLOCKED_USERS'),
                'page_back_link' => '1',
                'save_button' => '0',
                'step_progress_text' => 'Step 3 of 5',
                'back_popup' => 'blockedUsersPopup',
                'saveButtonText' => 'saveButtonTextEducation',
            ])

            <div class="container w-100">
                <div class="setting-inner w-100">

                    @if ($blockedUsers && !empty($blockedUsers))

                        @if (isset($blockedUsers['user_count']) && !empty($blockedUsers['user_count']))

                            @foreach ($blockedUsers['user'] as $blockedUser)
                                <div class="df aic w-100 followRequestContainer g1rem mb16">
                                    <div class="df aic jcc br12 oh">
                                        @if ($blockedUser['profile_picture'])
                                            <img src="{{ $blockedUser['profile_picture'] }}"
                                                alt="{{ $blockedUser['name'] }}" title="{{ $blockedUser['name'] }}">
                                        @else
                                            @include('frontend.partials.svg.icons.no-profile-picture-60')
                                        @endif

                                    </div>
                                    <div class="df fdc aic jcsa w-100">

                                        <p class="df jcfs w-100 mb0 pendingFallowersName">
                                            {{ $blockedUser['name'] }}
                                        </p>

                                        <div class="df aic jcfs w-100">


                                            <button class="btn lh24 h40 unblockUser"
                                                data-user-id={{ $blockedUser['id'] }}>
                                                @lang('UNBLOCK')
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        @endif

                    @endif

                    <hr class="pr24">
                </div>

            </div>
        </div>
    </div>
    <span class="closeSpanPopup dn">×</span>
</div>
</div>
