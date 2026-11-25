<h2 class="profileSubTitle mt60"> {{ __('HOW_TALKILA_WORKS') }} </h2>

<div class="df aic jcc">
    <div class="posrelative l10">
        <div class="fristSmallerDivProfile">

            <div>
                @include('frontend.partials.svg.icons.talkila_logo_text')
            </div>
            <p class="firsterica">
                {{strtolower(__('TALKS'))}} <b>{{$userData['name']}}</b>
            </p>
            <p>
                @lang('AT_THE_AGREED_TIME')
            </p>

        </div>
        <div class="secondSmallerDivProfile">

            <div>
                @include('frontend.partials.svg.icons.talkila_logo_text')
            </div>
            <p class="firsterica">
                {{strtolower(__('TALKS'))}} <b>@lang('YOU')</b>
            </p>
            <p>
                @lang('AT_THE_AGREED_TIME')
            </p>

        </div>

        <div class="thirdSmallerDivProfile">


            <p>
                ...@lang('EXTEND_YOUR_TALKS')
            </p>

        </div>

        <div class="fourthSmallerDivProfile">


            <p class="tac w-100 mb8 fs12">
                @lang('AND')
            </p>
            <div class="fl w-100">
                <p class="fl pl12">

                    <b>@lang('VIDEO_TALKS')</b>

                </p>
                <p class="fr pr12">
                    <b>@lang('VOICE_TALKS')</b>
                </p>
            </div>

        </div>

        <div class="fifthSmallerDivProfile">


            <p class="tac w-100 mb8 fs12">
                @lang('YOU')
            </p>

        </div>

        <div class="sixthSmallerDivProfile">

            <p class="tac w-100 mb8 fs12">
                {{$userData['name']}}
            </p>

        </div>
        <div class="seventhSmallerDivProfile">
            @include('frontend.partials.svg.icons.favicon')
        </div>
        @include('frontend.partials.svg.icons.how_talkila_works')
    </div>
</div>

