<div class="sidemenu-area default">
    <nav class="sidemenu navbar navbar-expand navbar-light">
        <div class="navbar-collapse collapse">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('admin.home') }}">
                    <i data-feather="grid" class="icon"></i>
                    <span class="title">{{ trans('global.dashboard') }}</span>
                </a>
                @can('booking_access')
                    <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                        <i data-feather="check-square" class="icon"></i>
                        <span class="title">{{ trans('cruds.booking.title') }}</span>
                    </a>
                @endcan

                <a class="nav-link" href="{{ route('admin.socket-rooms.index') }}">
                    <i data-feather="check-square" class="icon"></i>
                    <span class="title">{{ trans('cruds.socketRooms.title') }}</span>
                </a>

                @can('feedback_access')
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="dropdown-title">
                                <i data-feather="star" class="icon"></i>
                                <span class="title">
                                    {{ trans('cruds.feedback.title') }}
                                    <i data-feather="chevron-right" class="icon fr"></i>
                                </span>
                            </div>
                        </a>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.feedback.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('global.overview') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.waiting-for-approval.waitingForApproval') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.feedback.waiting_for_approval') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.feedback-under-review') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.feedback.bookings_under_review') }}
                            </a>
                        </div>
                    </div>
                @endcan
                @can('user_management_access')
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="dropdown-title">
                                <i data-feather="users" class="icon"></i>
                                <span class="title">
                                    {{ trans('cruds.userManagement.title') }}
                                    <i data-feather="chevron-right" class="icon fr"></i>
                                </span>
                            </div>
                        </a>

                        <div class="dropdown-menu">
                            @can('user_access')
                                <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                    <i data-feather="user" class="icon"></i>
                                    {{ trans('global.overview') }}
                                </a>
                            @endcan
                            @can('user_access')
                                <a class="dropdown-item" href="{{ route('admin.users.affiliateUsers') }}">
                                    <i data-feather="user" class="icon"></i>
                                    Affiliate users
                                </a>
                            @endcan
                            @can('user_blocked_access')
        						<a class="dropdown-item" href="{{ route('admin.users-blocked.index') }}">
                                    <i data-feather="x-circle" class="icon"></i>
                                    {{ trans('cruds.userBlocked.title') }}
                                </a>
                            @endcan
                            @can('user_reported_access')
                                <a class="dropdown-item" href="{{ route('admin.user-reporteds.index') }}">
                                    <i data-feather="file-text" class="icon"></i>
                                    {{ trans('cruds.userReported.title') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                @endcan
{{--                @can('payout_access')--}}
{{--                    <a class="nav-link" href="{{ route('admin.payout-invoices.index') }}">--}}
{{--                        <i data-feather="credit-card" class="icon"></i>--}}
{{--                        <span class="title">{{ trans('global.payout') }}</span>--}}
{{--                    </a>--}}
{{--                @endcan--}}

                <a class="nav-link" href="{{ route('admin.talks.index') }}">
                    <i data-feather="check-square" class="icon"></i>
                    <span class="title">{{ trans('cruds.talk.title') }}</span>
                </a>

                <a class="nav-link" href="{{ route('admin.billing-addresses.index') }}">
                    <i data-feather="check-square" class="icon"></i>
                    <span class="title">{{ trans('cruds.billingAddress.title') }}</span>
                </a>
                @can('payout_access')
                    <a class="nav-link" href="{{ route('admin.payout-invoices.index') }}">
                        <i data-feather="credit-card" class="icon"></i>
                        <span class="title">{{ trans('global.payout') }}</span>
                    </a>
                @endcan
                <a class="nav-link" href="{{ route('admin.cms.index') }}">
                    <i data-feather="monitor" class="icon"></i>
                    <span class="title">{{ trans('cruds.cms.title_uppercase') }}</span>
                </a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-title">
                            <i data-feather="file-text" class="icon"></i>
                            <span class="title">
                                {{ trans('global.static') }}
                                <i data-feather="chevron-right" class="icon fr"></i>
                            </span>
                        </div>
                    </a>

                    <div class="dropdown-menu">
                        @can('calls_cancellation_reason_access')
                            <a class="dropdown-item" href="{{ route('admin.calls-cancellation-reasons.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.callsCancellationReason.title') }}
                            </a>
                        @endcan
                        @can('talk_categories_access')
                            <a class="dropdown-item" href="{{ route('admin.talk-categories.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.talksCategories.title') }}
                            </a>
                        @endcan
                        @can('talk_subcategories_access')
                            <a class="dropdown-item" href="{{ route('admin.talk-subcategories.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.talksSubcategories.title') }}
                            </a>
                        @endcan
                        @can('country_access')
                            <a class="dropdown-item" href="{{ route('admin.countries.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.country.title') }}
                            </a>
                        @endcan
                        @can('language_access')
                            <a class="dropdown-item" href="{{ route('admin.languages.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.language.title') }}
                            </a>
                        @endcan
                        @can('payout_currency_access')
                            <a class="dropdown-item" href="{{ route('admin.payout-currencies.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.payoutCurrency.title') }}
                            </a>
                        @endcan
                        @can('static_profession_access')
                            <a class="dropdown-item" href="{{ route('admin.static-professions.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.staticProfession.title') }}
                            </a>
                        @endcan
                        @can('static_forbidden_name_access')
                            <a class="dropdown-item" href="{{ route('admin.static-forbidden-names.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.staticForbiddenName.title') }}
                            </a>
                        @endcan
                        @can('disposal_domain_access')
                            <a class="dropdown-item" href="{{ route('admin.disposal-domains.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.disposalDomain.title') }}
                            </a>
                        @endcan
                        @can('suggestions_home_screen_access')
                            <a class="dropdown-item" href="{{ route('admin.suggestions-home-screen.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.suggestionsHomeScreen.title') }}
                            </a>
                        @endcan
                        <a class="dropdown-item" href="{{ route('admin.profile-verifications.index') }}">
                            <i data-feather="chevron-right" class="icon"></i>
                            {{ trans('cruds.verifications.profil') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.user-image-verification.index') }}">
                            <i data-feather="chevron-right" class="icon"></i>
                            {{ trans('cruds.verifications.image') }}
                        </a>
{{--                        @can('socket_room_access')--}}
{{--                            <a class="dropdown-item" href="{{ route('admin.socket-rooms.index') }}">--}}
{{--                                <i data-feather="chevron-right" class="icon"></i>--}}
{{--                                {{ trans('cruds.socketRooms.title') }}--}}
{{--                            </a>--}}
{{--                        @endcan--}}
                        @can('vat_access')
                            <a class="dropdown-item" href="{{ route('admin.vat.index') }}">
                                <i data-feather="chevron-right" class="icon"></i>
                                {{ trans('cruds.vat.title') }}
                            </a>
                        @endcan
                    </div>
                </div>

                <a class="nav-link" href="{{ route('log-viewer.index') }}">
                    <i data-feather="check-square" class="icon"></i>
                    <span class="title"> {{ trans('global.log-viewer') }}</span>
                </a>

                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i data-feather="log-out" class="icon"></i>
                    <span class="title">{{ trans('global.logout') }}</span>
                </a>
                <form id="logoutform" action="{{ route('logout-admin') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </nav>
</div>
