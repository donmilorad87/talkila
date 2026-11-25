<div class="setting-page white-box p16mob">
    {{-- <h1 class="page-title">{{ __('SETTINGS') }}</h1> --}}
    <div class="setting-inner">
        <div class="grid-x grid-margin-x">
            <div class='cell medium-12'>
                <div class="setting-tabs">
                    <div class="show-for-medium">
                        @include('frontend.partials.components.settings-menu', [
                            'pointer' => __('NOTIFICATIONS'),
                        ])
                    </div>
                    <div class="medium-12 large-12">
                        <div class="setting-inner">
                            <div class="form-wrapper df aci jcsb">
                                <h6 class="mb0">{{ __('RECENT_ACTIVITY') }}</h6>
                                <div class="optionButton @if (empty($notificationsData)) dn @endif" data-opened="0" id="notificationsOptions">
                                    @include('frontend.partials.svg.icons.v-dots')
                                    <ul>

                                        <li class="noselect" id="readAllNotifications"> {{ __('READ_ALL') }}
                                        </li>

                                        <li class="noselect" id="deleteAllNotifications"> {{ __('DELETE_ALL') }}
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="tabs-content">
                            <div class="tabs-panel is-active" id="Profile">
                                <div class="grid-x">

                                    <div class="medium-12 large-12">
                                        <div class="notificatoin-wrapper" id="notificationWrapper">

                                            @php
                                                $displayedDates = [];
                                            @endphp
                                            @if ($notificationsData)
                                                @foreach ($notificationsData['notifications'] as $item)
                                                    @php
                                                        $notificationDate = date('Y-m-d', strtotime($item['pushed_at']));
                                                    @endphp
                                                    @if ($notificationDate == date('Y-m-d') && empty($displayedDates[$notificationDate]))
                                                        <h6>{{ __('TODAY') }}</h6>
                                                    @else
                                                        @if (empty($displayedDates[$notificationDate]))
                                                            <h6 style="margin-top: 10px; margin-bottom: 5px;">

                                                                {{ changeDateFormatLocale('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($item['pushed_at'])), true) }}</h6>
                                                        @endif
                                                    @endif
                                                    @if (in_array($item['values'], $haveRedirects))
                                                        <a
                                                            href="{{ route('notification_redirect', ['notification' => $item]) }}">
                                                    @endif
                                                    <div class="notificatoin-box">
                                                        <small
                                                            class="@if ($item['state'] == 2) addDot @endif">{{ getTimeZonedDate('H:i', $item['pushed_at']) }}</small>


                                                        @if ($item['profile_picture'])
                                                            <img id="profile-img" width="32"
                                                                src="{{ $item['profile_picture'] }}"
                                                                alt="{{ $item['payload']['name_of_talk'] ?? 'notification' }}" />
                                                        @else
                                                            @include('frontend.partials.svg.icons.placeholder-profile')
                                                        @endif

                                                        <p>
                                                            @if (!empty($item['payload']) && isset($item['payload']['name_of_talk']))
                                                                <strong>{{ $item['payload']['name_of_talk'] }}</strong>
                                                            @endif
                                                            {{ $item['message'] }}
                                                        </p>

                                                    </div>
                                                    @if (in_array($item['values'], $haveRedirects))
                                                        </a>
                                                    @endif
                                                    @php
                                                        $displayedDates[$notificationDate] = true;
                                                    @endphp
                                                @endforeach

                                            @endif
                                            @if (!empty($notificationsData['notificationsCount']) && $notificationsData['notificationsCount'] > 5)
                                                <div class="">
                                                    <p class="text-center mb0 showMoreNot">
                                                        <button class="btn showMoreNotification m0a mb0">
                                                            {{ __('PROFILE_SHOW_MORE_BUTTON_TEXT') }}
                                                        </button>
                                                    </p>
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="total_notifications_count"
                        value="{{ $notificationsData['notificationsCount'] ?? 0 }}" id="total_notifications_count" />

                </div>
            </div>
        </div>
    </div>
    <div id="noNotificationsCont" class="fdc df aic @if (!empty($notificationsData['notificationsCount'])) dn @endif">
        <img src="{{ asset('frontend/assets/img/no-booking-found.png') }}" alt="No Booking Found" />
        <h6> @lang('NO_NOTIFICATIONS')</h6>
    </div>

</div>
