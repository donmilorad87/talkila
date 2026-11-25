<div class="right-left-wrap hide-for-medium2 d-flex step steperko caki caki2 zzswe">

    <span class="lefterZGT">
        @include('frontend.partials.svg.icons.arrow-left')
    </span>

    @include('frontend.partials.svg.icons.short_fat_line')
    <div class="tac fw">{{ $page_title }}</div>



    @if ($clear_button)
        <div class="small-2 bwhite btrans">
            <div class="centerVH height100 posrelative cp shareBut" data-popup="shareProfilePopUp">
                <span class="clrButt zi999">
                    {{__('CLEAR')}}
                </span>
            </div>

        </div>
    @endif


</div>
