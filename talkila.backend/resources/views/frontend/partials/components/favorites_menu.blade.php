<ul class="ml16res mr16res medium-6 large-3 df tabs mb16 mainHeaderSettings favoritesMenuS">
    <li class="tabs-title @if ($pointer === __('TALKS')) is-active @endif"><a href="{{route('favorites_talks')}}">{{ __('TALKS') }}</a></li>
    <li class="tabs-title @if ($pointer === __('USERS')) is-active @endif"><a href="{{route('favorites_users')}}">{{ __('USERS') }}</a></li>
</ul>
