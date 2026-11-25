<section class="grid-container" id="socialSelection" data-desktop="1" data-mobile="1">
    <div class="wrraper-social">
        <h2 class="headint-title-social">{!! __('SOCIAL_HEADLINE') !!}</h2>
        <P>{!! __('SOCIAL_TEXT_1') !!}</P>
        <div class="cell small-12">
            <div class="social-img-inner">
            @include('frontend.partials.svg.icons.facebook')
            @include('frontend.partials.svg.icons.whatsup')
            @include('frontend.partials.svg.icons.google')
            @include('frontend.partials.svg.icons.envelope')
            </div>
        </div>
    </div>
    <div class="grid-x boder-top">
        <div class="cell small-12 medium-8 large-6 xlarge-5 socialInner">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-6 large-5">
                    <div class="main-comment">
                        <h2>10k</h2>
                        <ul class="button-group">
                            <li>@include('frontend.partials.svg.icons.full-heart')<li>
                            <li>@include('frontend.partials.svg.icons.full-heart')<li>
                            <li>@include('frontend.partials.svg.icons.full-heart')<li>
                            <li>@include('frontend.partials.svg.icons.half-heart')<li>
                            <li>@include('frontend.partials.svg.icons.zero-heart')<li>
                        </ul>
                        <p>{{ __('SOCIAL_ACTIVE_DOWNLOADS') }}</p>

                    </div>
                </div>
                <div class="cell small-12 medium-6 large-5">
                    <div class="main-comment">
                        <h2>4.7</h2>
                        <ul class="button-group">
                            <li>@include('frontend.partials.svg.icons.full-star')<li>
                            <li>@include('frontend.partials.svg.icons.full-star')<li>
                            <li>@include('frontend.partials.svg.icons.full-star')<li>
                            <li>@include('frontend.partials.svg.icons.half-star')<li>
                            <li>@include('frontend.partials.svg.icons.zero-star')<li>
                        </ul>
                        <p>1,938 {{ __('SOCIAL_RATING') }}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="cell small-12 medium-8 large-6 xlarge-5">
            <h4 class="social-heading-title">{!! __('SOCIAL_TEXT_3') !!}</h4>
        </div>
    </div>
</section>