<div class="right-left-wrap hide-for-medium2 d-flex step steperko caki caki2">
    @if ($page_back_link !== "0")
    <a href="{{ $page_back_link }}">
        @include('frontend.partials.svg.icons.arrow-left')</a>
    @else
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
        <div class="small-2 bwhite">
            <div class="centerVH height100 posrelative cp shareBut shbt zi999" data-popup="shareProfilePopUp" data-sharings='1'>
                @include('frontend.partials.svg.icons.share')
            </div>

        </div>
    @endif


</div>
