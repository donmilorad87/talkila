<div class="d-flex step steperko caki CVHeading">
    @if ($page_back_link !== "0")
    <span class="cz df" @if (isset($back_popup) && !empty($back_popup)) data-close-popup='{{ $back_popup }}' @endif>
        @include('frontend.partials.svg.icons.arrow-left')
    </span>
    @else
    <div class="backButtonings">
        @include('frontend.partials.svg.icons.arrow-left')</div>

    @endif
    @if (isset($talk_name) && !empty($talk_name))
        <div class="tac mainTitties">{{ $page_title }}</div>


        <div class="tac subatitle">{{ $talk_name }}</div>
    @else
        <div class="tac fw add-time-title">{{ $page_title }}</div>
    @endif


    @if ($save_button !== '0')
        <div class="small-2 bwhite">
            <div class="centerVH height100 posrelative shareBut">
                <span class="{{$saveButtonText}}"> Save </span>
            </div>

        </div>
    @endif


</div>


