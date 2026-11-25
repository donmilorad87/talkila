<nav class="menu-bar fl w-100" id="calendarNavigation">

    @if (isset($calendarsData['calendar_accounts']) && !empty($calendarsData['calendar_accounts']))
        @foreach ($calendarsData['calendar_accounts'] as $calendar)
            <li class="fdc">
                <span class="spanSettingsMobileMenu fs12 mb8">
                    <span
                        class="fs12 fw300 defaultCalendarSelection {{ $calendar['is_primary'] === 1 ? 'active' : '' }} {{ $calendar['is_primary'] === 1 && Route::current()->getName() !== 'book_slot' ? 'pon' : '' }}"
                        data-calendar-id="{{ $calendar['id'] }}">

                        <div class="spacerDivSettings df">
                            @if ($calendar['type'] == 1)
                                @include('frontend.partials.svg.icons.google_calendar_icon')
                            @else
                                @include('frontend.partials.svg.icons.office_icon')
                            @endif

                        </div>

                        {{ $calendar['email'] }}
                        <div class="mla circle-check grid-action defaultCardButton">
                            <div class="defaultCalendar">
                                @include('frontend.partials.svg.icons.check-blue')
                            </div>
                        </div>
                    </span>




                    @if (Route::current()->getName() !== 'book_slot')
                        <button
                            class="removeCalendar df aic buttoneroKale garbage_can buttoneroKalendar {{ $calendar['is_primary'] === 1 && count($calendarsData['calendar_accounts']) > 1 ? 'dn' : '' }}"
                            data-calendar-id={{ $calendar['id'] }}>
                            @include('frontend.partials.svg.icons.garbage_can')
                        </button>
                    @endif

                    <button class="buttoneroKale gear" data-opened="0">
                        @include('frontend.partials.svg.icons.gear')
                    </button>

                </span>

                <div class="tranzicioniHeight">
                    <div class="date-wrap-content w-100 fl m0 mb8">
                        <div class="button-switch switch d-flex mb0">
                            <input class="switch-input clientCaleInputState"
                                id="clientCaleInputState{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}"
                                type="checkbox"
                                name="clientCaleInputState{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}"
                                @if ($calendar['state'] === 1 || $calendar['state'] === 3) checked @endif />
                            <div class="posrelative anonim d-flex w-100">
                                <div class="df aic w-100">

                                    <p class="posrelative w-100 fl swpl m0 pl14 cblack">
                                        @lang('USE_CALENDAR_AS_CLIENT')
                                        @include('frontend.partials.components.tooltip-top', [
                                            'tooltip_text' => __('CLIENT_CALENDAR_INFO'),
                                        ])
                                    </p>
                                </div>


                            </div>
                            <label class="switch-paddle swp1 clientCalendarSwitch"
                                data-calendar-id={{ $calendar['id'] }} data-pointer="cli"
                                data-clicked="@if ($calendar['state'] === 1 || $calendar['state'] === 3) 1 @else 0 @endif"
                                for="clientCaleInputState{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}">

                            </label>

                        </div>

                    </div>

                    @if ($user->pendingProfileVerificationRequest)
                        @if (
                                ($user->type === UserRoles::TEACHER &&
                                    $user->pendingProfileVerificationRequest->status ==
                                        \App\Models\UserVerificationRequests::STATE['approved']))
                            <div class="date-wrap-content w-100 fl m0 mb16 suppliersCalendar">
                                <div class="button-switch switch d-flex mb0">
                                    <input class="switch-input supplierCaleInputState"
                                        id="supplierCaleInputState{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}"
                                        type="checkbox"
                                        name="supplierCaleInputState{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}"
                                        @if ($calendar['state'] === 2 || $calendar['state'] === 3) checked @endif />
                                    <div class="posrelative anonim d-flex w-100">
                                        <div class="df aic w-100">

                                            <p class="posrelative w-100 fl swpl m0 pl14 cblack">
                                                @lang('USE_CALENDAR_AS_SUPPLIER')
                                                @include('frontend.partials.components.tooltip-top', [
                                                    'tooltip_text' => __('SUPLIER_CALENDAR_INFO'),
                                                ])
                                            </p>
                                        </div>


                                    </div>
                                    <label class="switch-paddle swp1" data-calendar-id={{ $calendar['id'] }}
                                        data-pointer="sup"
                                        data-clicked="@if ($calendar['state'] === 2 || $calendar['state'] === 3) 1 @else 0 @endif"
                                        for="supplierCaleInputState{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}">

                                    </label>

                                </div>


                            </div>
                        @endif
                    @endif




                    <hr class="fl w-100 mb0">
                    <hr class="fl w-100">
                    @foreach ($calendar['calendars'] as $caleItems)
                        <div class="date-wrap-content w-100 fl m0 mb8">
                            <div class="button-switch switch d-flex mb0">
                                <input class="switch-input"
                                    id="exampleSwitch244{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}"
                                    type="checkbox"
                                    name="exampleSwitch244{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}"
                                    @if ($caleItems['state'] === 1) checked @endif />
                                <div class="posrelative anonim d-flex fw300">
                                    <div>

                                        <p class="posrelative w-100 fl swpl m0 pl14 cblack">
                                            {{ $caleItems['name'] }}
                                        </p>
                                    </div>


                                </div>

                                <label class="switch-paddle caleSwitchesCheckers"
                                    data-calendar-id="{{ $caleItems['id'] }}"
                                    data-clicked="@if ($caleItems['state'] === 1) 1 @else 0 @endif"
                                    for="exampleSwitch244{{ $loop->index }}{{ $calendar['id'] }}{{ $pointer ?? '' }}">

                                </label>

                            </div>


                        </div>
                    @endforeach
                </div>


            </li>
        @endforeach
    @endif

</nav>
