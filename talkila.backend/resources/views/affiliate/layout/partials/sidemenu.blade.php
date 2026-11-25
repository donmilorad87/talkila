<div class="sidemenu-area default">
    <nav class="sidemenu navbar navbar-expand navbar-light">
        <div class="navbar-collapse collapse">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('affiliate.home') }}">
                    <i data-feather="grid" class="icon"></i>
                    <span class="title">{{ trans('global.dashboard') }}</span>
                </a>

                <a class="nav-link" href="{{ route('affiliate.reports') }}">
                    <i data-feather="monitor" class="icon"></i>
                    <span class="title"> {{ __("REPORTS") }} </span>
                </a>

                <a class="nav-link" href="{{ route('affiliate.payout') }}">
                    <i data-feather="credit-card" class="icon"></i>
                    <span class="title">{{ trans('global.payout') }}</span>
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
