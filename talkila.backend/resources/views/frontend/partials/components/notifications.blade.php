<a class="notificationBell svgBell mla" href="{{ route('settings_notifications') }}">
    @if (isset($notificationsCount) && !empty($notificationsCount))
        @include('frontend.partials.svg.icons.bell')
        @if ($notificationsCount['notificationsCount'])
            <div class="notificationBadgeHeaderDropdownMenu">
                {{ $notificationsCount['notificationsCount'] }}
            </div>
        @endif
    @else
        @include('frontend.partials.svg.icons.three_dots')
    @endif
</a>
