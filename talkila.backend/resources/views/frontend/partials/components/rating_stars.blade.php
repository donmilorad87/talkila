<div class="df aic jcsb specClassForStars">

    @for ($i = 0; $i < 5; $i++)
        @if (floatVal($ratings) >= ($i+1))
            @include('frontend.partials.svg.icons.yellow_star')
        @else
            @if (abs(floatVal($ratings) - ($i+1)) <= 0.5 && abs(floatVal($ratings) - ($i+1)) < 1)
                @include('frontend.partials.svg.icons.half_star')
            @elseif (abs(floatVal($ratings) - ($i+1)) >= 0.5)
                @include('frontend.partials.svg.icons.gray_star')
            @endif
        @endif
    @endfor

</div>
