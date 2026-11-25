@php
    $getRatings = floatVal($ratings);
@endphp

<div class="df">

    @for ($i = 0; $i < 5; $i++)
        @if (floatVal($getRatings) >= $i + 1)
            @include('frontend.partials.svg.icons.yellow_star')
        @else
            @if (abs(floatVal($getRatings) - ($i + 1)) <= 0.5 && abs(floatVal($getRatings) - ($i + 1)) < 1)
                @include('frontend.partials.svg.icons.half_star')
            @elseif (abs(floatVal($getRatings) - ($i + 1)) >= 0.5)
                @include('frontend.partials.svg.icons.gray_star')
            @endif
        @endif
    @endfor

</div>
