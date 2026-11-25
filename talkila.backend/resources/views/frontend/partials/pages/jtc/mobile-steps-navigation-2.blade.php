<div class="right-left-wrap show-for-mobile d-flex step steperko caki">
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
            <div class="centerVH height100 posrelative cp shareBut" data-popup="shareProfilePopUp">
                @include('frontend.partials.svg.icons.share')
            </div>

        </div>
    @endif


</div>
