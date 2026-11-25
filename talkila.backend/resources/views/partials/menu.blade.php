<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
{{--            {{ trans('panel.site_title') }}--}}
            <img class="img-fluid" src="{{ asset('images/talkila-admin-logo.png') }}">
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_blocked_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users-blocked.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-blockeds') || request()->is('admin/user-blockeds/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-ban c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userBlocked.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_followed_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users-followed.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-followeds') || request()->is('admin/user-followeds/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-exchange-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userFollowed.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_dont_show_again_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user-dont-show-against.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-dont-show-against') || request()->is('admin/user-dont-show-against/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-eye-slash c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userDontShowAgain.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('system_login_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.system-logins.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/system-logins') || request()->is('admin/system-logins/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-sign-in-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.systemLogin.title') }}
                </a>
            </li>
        @endcan
        @can('static_profession_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.static-professions.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/static-professions') || request()->is('admin/static-professions/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-chalkboard-teacher c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.staticProfession.title') }}
                </a>
            </li>
        @endcan
        @can('static_forbidden_name_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.static-forbidden-names.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/static-forbidden-names') || request()->is('admin/static-forbidden-names/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-tag c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.staticForbiddenName.title') }}
                </a>
            </li>
        @endcan
        @can('static_blocked_user_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.static-blocked-users.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/static-blocked-users') || request()->is('admin/static-blocked-users/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-ban c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.staticBlockedUser.title') }}
                </a>
            </li>
        @endcan
        @can('search_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.searches.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/searches') || request()->is('admin/searches/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-search-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.search.title')  }}
                </a>
            </li>
        @endcan
        @can('cms_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.cms.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/cms') || request()->is('admin/cms/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-search-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.cms.title') }}
                </a>
            </li>
        @endcan
        @can('talk_categories_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.talk-categories.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/talk-categories') || request()->is('admin/talk-categories/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-search-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.talksCategories.title') }}
                </a>
            </li>
        @endcan
        @can('talk_subcategories_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.talk-subcategories.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/talk-subcategories') || request()->is('admin/talk-subcategories/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-search-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.talksSubcategories.title') }}
                </a>
            </li>
        @endcan
        @can('suggestions_home_screen_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.suggestions-home-screen.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/suggestions-home-screen') || request()->is('admin/suggestions-home-screen/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-search-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.suggestionsHomeScreen.title') }}
                </a>
            </li>
        @endcan
        @can('user_bookmarked_talks_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-bookmarked-talks.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-bookmarked-talks') || request()->is('admin/user-bookmarked-talks/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-search-plus c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userBookmarkedTalks.title') }}
                </a>
            </li>
        @endcan
        @can('profile_payout_method_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.profile-payout-methods.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/profile-payout-methods') || request()->is('admin/profile-payout-methods/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-money-bill c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.profilPayoutMethod.title') }}
                </a>
            </li>
        @endcan
        @can('profil_cv_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.profile-cvs.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/profile-cvs') || request()->is('admin/profile-cvs/*') ? 'active' : '' }}">
                    <i class="fa-fw fab fa-researchgate c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.profilCv.title') }}
                </a>
            </li>
        @endcan
        @can('language_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.languages.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/languages') || request()->is('admin/languages/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-flag-checkered c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.language.title') }}
                </a>
            </li>
        @endcan
        @can('country_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.countries.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/countries') || request()->is('admin/countries/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-flag c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.country.title') }}
                </a>
            </li>
        @endcan
        @can('languages_profil_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.languages-profils.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/languages-profils') || request()->is('admin/languages-profils/*') ? 'active' : '' }}">
                    <i class="fa-fw far fa-address-book c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.languagesProfil.title') }}
                </a>
            </li>
        @endcan
        @can('payout_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.payout-invoices.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/payout-invoices') || request()->is('admin/payout-invoices/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.payout.title') }}
                </a>
            </li>
        @endcan
        @can('payout_currency_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.payout-currencies.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/payout-currencies') || request()->is('admin/payout-currencies/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-money-bill-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.payoutCurrency.title') }}
                </a>
            </li>
        @endcan
        @can('disposal_domain_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.disposal-domains.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/disposal-domains') || request()->is('admin/disposal-domains/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-anchor c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.disposalDomain.title') }}
                </a>
            </li>
        @endcan
        @can('disposal_email_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.disposal-emails.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/disposal-emails') || request()->is('admin/disposal-emails/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-anchor c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.disposalEmail.title') }}
                </a>
            </li>
        @endcan
        @can('availability_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.availabilities.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/availabilities') || request()->is('admin/availabilities/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-thermometer-three-quarters c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.availability.title') }}
                </a>
            </li>
        @endcan
        @can('billing_address_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.billing-addresses.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/billing-addresses') || request()->is('admin/billing-addresses/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-file-invoice-dollar c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.billingAddress.title') }}
                </a>
            </li>
        @endcan
        @can('booking_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.bookings.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-atlas c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.booking.title') }}
                </a>
            </li>
        @endcan
        @can('calls_cancellation_reason_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.calls-cancellation-reasons.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/calls-cancellation-reasons') || request()->is('admin/calls-cancellation-reasons/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-headset c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.callsCancellationReason.title') }}
                </a>
            </li>
        @endcan
        @can('bookings_payout_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.bookings-payout-invoices.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/bookings-payout-invoices') || request()->is('admin/bookings-payout-invoices/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-file-invoice-dollar c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.bookingsPayout.title') }}
                </a>
            </li>
        @endcan
        @can('talk_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.talks.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/talks') || request()->is('admin/talks/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-user-graduate c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.talk.title') }}
                </a>
            </li>
        @endcan
        @can('talks_booking_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-bookmarked-talks.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-bookmarked-talks') || request()->is('admin/user-bookmarked-talks/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-chalkboard-teacher c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.talksBooking.title') }}
                </a>
            </li>
        @endcan
        @can('feedback_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.feedback.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/feedback') || request()->is('admin/feedback/*') ? 'active' : '' }}">
                    <i class="fa-fw far fa-comments c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.feedback.title') }}
                </a>
            </li>
        @endcan
        @can('user_report_type_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-report-types.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-report-types') || request()->is('admin/user-report-types/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-exclamation-triangle c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userReportType.title') }}
                </a>
            </li>
        @endcan
        @can('user_reported_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-reporteds.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-reporteds') || request()->is('admin/user-reporteds/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-exclamation c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userReported.title') }}
                </a>
            </li>
        @endcan
        @can('static_metric_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.static-metrics.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/static-metrics') || request()->is('admin/static-metrics/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-drafting-compass c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.staticMetric.title') }}
                </a>
            </li>
        @endcan
        @can('user_visited_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-visiteds.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/user-visiteds') || request()->is('admin/user-visiteds/*') ? 'active' : '' }}">
                    <i class="fa-fw far fa-eye c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userVisited.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
