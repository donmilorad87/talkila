<div class="p01rem zi998 bt1res pt16 bwhiteclearres" id="firstHeader">
    <div class="cblack crossPosition hide-for-medium2">
        <a class="cblack fs19" href="{{ route('home') }}">
            ✖
        </a>

    </div>

    <div class="df aic {{ isset($pratnerData) ? 'jcsb' : ($user ? ($user->partner ? 'jcsb' : 'jcc') : 'jcc') }} g1rem tr03s"
        id="logoContainers">

        @if ($user)
            @if ($user->partner)
                <div class="df aic gap8px">
                    @include('frontend.partials.svg.icons.talkila-logo')
                </div>
            @endif
        @else
            @if (isset($pratnerData))
                <div class="df aic gap8px">
                    @include('frontend.partials.svg.icons.talkila-logo')
                </div>
            @endif

        @endif

        <div>
            <div class="posrelative loggedPic {{ $user && Route::current()->getName() !== 'jtc2_verify_account' ? 'cp' : '' }} uldrar br50 imagePointerForCropper"
                data-popup="uploadDropArea">

                @auth
                    <img src="{{ $user->profile_picture_tmp ?? $user->profile_picture }}" alt="{{ $user->name }}" title="{{ $user->name }}"/>
                    @if (Route::current()->getName() !== 'jtc2_verify_account')
                        @include('frontend.partials.svg.icons.profile-pic-plus')
                    @endif

                @endauth

                @guest
                    <img src="{{ isset($requestParams->ti) ? $requestParams->ti : '/assets/images/avatar.svg' }}"
                        alt="{{ isset($requestParams->tu) ? $requestParams->tu : '' }}" title="{{ isset($requestParams->tu) ? $requestParams->tu : '' }}"/>
                @endguest

            </div>
        </div>

        @if ($user)
            @if ($user->partner)

                <div class="df aic jcfe partnerLogo">
                    <img src="{{ $user->partner->logo }}" data-partner-slug="{{ $user->partner->slug }}"
                        alt="{{ $user->partner ? $user->partner->name : '' }}" title="{{ $user->partner ? $user->partner->name : '' }}">
                </div>
            @endif
        @else
            @if ($pratnerData)
                @if ($pratnerData->logo)
                    <div class="df aic jcfe partnerLogo">
                        <img src="{{ $pratnerData->logo }}" data-partner-slug="{{ $pratnerData->slug }}"
                            alt="{{ $pratnerData ? $pratnerData->name : '' }}">
                    </div>
                @endif
            @endif


        @endif



    </div>
    <div class="df fdc jcss aic mt16 w-80 m0a w-80 m0a" id="textCont">

        <h4 class="mb0 fs22 wbbw tac">

            {!! $headline !!}

        </h4>
        <p class="tac cblack mb8 fs14">{{ $description }}</p>

    </div>
</div>
