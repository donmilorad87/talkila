<div class="w-100 pb0 m0 right-left-wrap hide-for-medium2 d-flex step steperko caki caki2 {{ $possticky ?? '' }} {{ $zIndex ?? '' }}">
    @if ($page_back_link !== '0' && $page_back_link !== '00')
        <a href="{{ $page_back_link }}" class="zi999">
            @include('frontend.partials.svg.icons.arrow-left')</a>
    @elseif ($page_back_link === '00')
        <div class="backButtonings">
        @include('frontend.partials.svg.icons.arrow-left')</div>
    @endif
    @if (isset($talk_name) && !empty($talk_name))
        <div class="tac mainTitties">{{ $page_title }}</div>


        <div class="tac subatitle">{{ $talk_name }}</div>
    @else
        <div class="tac fw">{{ $page_title }}</div>
    @endif


    @if ($save_button !== '0')
        <div class="coinsAdder small-2 bwhite df aic jcc g4px cp">
            @auth
                <a class="df aic jcc g4px p3p2" href="{{route('settings_wallets', ['openAddCoins' => '1'])}}">
                    @include('frontend.partials.svg.icons.coins')
                    <b class="bCoins">{{ priceFormater($user->wallet_balance, true) }}</b>
                </a>
            @endauth


        </div>
    @endif


</div>
