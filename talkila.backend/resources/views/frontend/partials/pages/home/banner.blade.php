<section class="wrapper-banner bannerMain" id="bannerMain" data-desktop="1" data-mobile="1">
  <div class="bg-banner">
    <div class="container">
      <div class="grid-x grid-margin-x ">
        <div class="cell small-12 medium-12 large-6">
          <div class="banner-left mbn">
            <div class="bannerHeadingCont">
              <h1 class="mainTitle">
                {!! __('HOMEPAGE_H1') !!}
              </h1>
              @include('frontend.partials.svg.icons.line')
            </div>
            <h6 class="title_tag">{!! __('HOMEPAGE_CLAIM') !!}</h6>
            <div class="bannerBoutonGroup">
              <a class="{{ ($isApple['isIOSDevice'] || $isApple['isMacDevice']) ? 'db' : 'dn'}}" href="{{ config('app.iosStoreLink') }}" target="_blank">@include('frontend.partials.svg.icons.apple-app-store')</a>
              <a class="{{ ($isApple['isIOSDevice'] || $isApple['isMacDevice']) ? 'dn' : 'db'}}"href="{{ config('app.androidStoreLink') }}" target="_blank">@include('frontend.partials.svg.icons.google-play-store')</a>
            </div>

          </div>
        </div>
        <div class="cell small-12 medium-12 large-6">
          <div class="banner-right">
            <img loading="lazy" src="/frontend/assets/img/webp/big/talkila_woman.webp" alt="Talkila Hero image" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
