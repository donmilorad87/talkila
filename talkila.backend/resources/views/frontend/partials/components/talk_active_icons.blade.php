<div class="iconsSearchItem {{ $additionalClass ?? '' }}">

    <span> @include('frontend.partials.svg.icons.phone_icon') </span>

    <span> | </span>

    @if ($talk_type === 2)
        <span class="cameraIcon"> @include('frontend.partials.svg.icons.camera_icon')
        </span>
    @else
        <span class="cameraIcon"> @include('frontend.partials.svg.icons.camera_cross')
        </span>
    @endif


        <div class="annonContainer df {{$is_anon === 1 ? '' : 'dn'}}">
            <span> | </span>
            <span> @include('frontend.partials.svg.icons.anonymous') </span>
        </div>


</div>
