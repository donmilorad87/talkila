<div class="step steperko caki CVHeading h94px hideFor640AndLess">

    <div class="pageTitlePoperAva">{{ $page_title }}</div>

    <div class="closeAddTalkFunnel">
        <div class="centerVH height100 posrelative">
            <span class="closeThisPopup" data-close="{{ $back_popup }}">×</span>
        </div>

    </div>



</div>

<div class="step steperko caki CVHeading showFor640AndLess">

    <div class="backButtonings2 dib posrelative" data-close="{{ $back_popup }}">
        @include('frontend.partials.svg.icons.arrow-left')
    </div>

    <div class="tac fw z-1 pageTitlePoperAva" id="mobilePrivateTalkTitle">{{ $page_title }}</div>

    @if ($save_button !== '0')
        <div class="small-2 bwhite">
            <div class="centerVH height100 posrelative shareBut">
                <span class="{{ $saveButtonText }} zi999 saveButtonPrivateTalk"> @lang('SAVE') </span>
            </div>

        </div>
    @endif


</div>
