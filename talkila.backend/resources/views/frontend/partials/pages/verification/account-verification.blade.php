<div class="mobile-verification profile-verification">

    {{-- <div class="d-flex right-left-wrap">
        <a href="/logged-in">
            @include('frontend.partials.svg.icons.arrow-left')</a>
        <p>{{ __('ACCOUNT_VERIFICATION') }}</p>
        <p></p>
    </div> --}}
    <div class="white-box p16">
    <div class="grid-x grid-margin-x">
        <div class="medium-12 large-12 small-12 cell">

            <div class="timing-box-left flex-wrap">
                <div class="account-Verification-heading mb16 hide-for-mobile">
               {{--      {{dd($loggedUserData)}} --}}
               <h5>{{ __('ACCOUNT_VERIFICATION') }}</h5>
              {{--       @if($loggedUserData['state'])
                        <h5>{{ __('ACCOUNT_VERIFICATION_SUCCESSFULL') }}</h5>
                    @else
                        <h5>{{ __('ACCOUNT_VERIFICATION_PENDING') }}</h5>
                    @endif --}}
                </div>
                <div class="status-box">
                 {{--    @if($loggedUserData['state'])
                        <div class="info-reload-wrap blue-wrap">
                            @include('frontend.partials.svg.icons.verification-success')
                        </div>
                    @else
                        <div class="info-reload-wrap">
                            @include('frontend.partials.svg.icons.verification-pending')
                        </div>
                    @endif --}}
                </div>

            </div>
                <div class="group-usr-inner account-Vtion-group">
                    <div class="grid-x grid-margin-x w-100">
                        <div class="cell small-2 d-flex aic">

                            @if(!empty($user->profile_picture) || !empty($user->profile_picture_tmp))
                                <img src="{{ $user->profile_picture ?? $user->profile_picture_tmp }}" alt="user" />
                            @endif
                        </div>
                        <div class="cell small-10 d-flex aic">

                    <div>
                        <div><strong>{{ $user->username }}</strong></div>
                     {{--    @if($loggedUserData['state'])
                            <p class="verified-inner"> @include('frontend.partials.svg.icons.verified-badge') {{ __('VERIFIED') }}</p>
                        @else
                            <p>{{ __('USER_NOT_VERIFIED') }}</p>
                        @endif --}}
                    </div>
                        </div>
                    </div>
                </div>
            <hr>

        </div>

    </div>


    <div class="grid-x grid-margin-x">
        <div class="small-12 medium-12 cell">
            <div class="table-details table-border-edit">
                <p class="title-heading-there-are">@lang('ACCOUNT_VERIFICATION_TEXT_DESCRIPTION')</p>
                @php
                    $latestStatus = 0;
                @endphp
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('NAME') }}</th>
                            <th>{{ __('DATE') }}</th>
                            <th class="text-right">{{ __('STATUS') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userVerifications as $verification)
                            <tr>
                                <td>{{ $verification['name'] }}</td>

                                <td>
                                    {{changeDateFormatLocale('Y-m-d H:i:s', getTimeZonedDate2('Y-m-d H:i:s', date('Y-m-d', strtotime($verification['request_date']))), true)}}
                                </td>

                                @if($verification['status'] == 2)
                                    <td class="text-danger">@lang('DECLINE')</td>
                                @elseif($verification['status'] == 0)
                                    <td class="title-yellow">@lang('PENDING')</td>
                                @elseif($verification['status'] == 1)
                                    <td class="title-blue">@lang('APPROVED')</td>
                                @else
                                    <td class="title-blue">@lang('UNDEFINED')</td>
                                @endif

                                @if($loop->last)
                                    @php
                                        $latestStatus = $verification['status'];
                                    @endphp
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($latestStatus == 2)
                @include('frontend.partials.pages.verification.right-container',
                    [
                        'pointer' => 1
                    ]
                )
            @endif

        </div>
    </div>
    </div>
</div>
