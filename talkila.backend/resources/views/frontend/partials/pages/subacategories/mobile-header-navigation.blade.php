<div class="hide-for-medium2 d-flex step {{$noStep ? '' ? steperko3}} caki caki2 {{$possticky ?? ''}}">
    @if ($page_back_link !== "0")
        <a href="{{ $page_back_link }}" class="lefterZ">
            @include('frontend.partials.svg.icons.arrow-left')
        </a>
    @endif
    @if (isset($page_title) && !empty($page_title))
        <div class="tac fw cnterZ">{{ $page_title }}</div>
    @endif


    @if ($save_button !== 0)
        <div class="small-2 bwhite zi1000 posrelative filterIcon righterZ">
            <div class="centerVH height100 posrelative shareBut filterOpener" data-opened="0">
                @include('frontend.partials.svg.icons.filter')
            </div>
        </div>
    @endif

</div>
