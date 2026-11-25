<div class="profile-overview w-100 fl bookingSummaryHDmobile p1rempt1rem bb1 profileHeaderSumary white-box mt16">
    <div class="icon-sn book-sn-icon box-resize cp fl" data-popup="appStorePupUp">
        <a href="{{ route('profile', $username) }}" class="profPict">
            @if (!empty($imageUrl))
                <div class="firstDivInnerDiv t03s">
                    <img class="firstDivH5" src="{{ $imageUrl }}" alt={{$username}} title="{{$aboutName}}">
                    <div class="firstDivApproveIcon df">
                        <div class="df">
                            @include(
                                'frontend.partials.svg.icons.blue_checkmark'
                            )
                        </div>
                    </div>
                </div>
            @else
                @include('frontend.partials.svg.icons.no-profile-picture-94')
            @endif
        </a>
    </div>
    <div class="heading-slider mobileHomAbout fl m0">
        <div class="fl w-100">
            <div class="ml8 fl w-100">
                <h4 class="text-r-size lh1">
                    <a href="{{ route('profile', $username) }}">
                        <span class="step1name"
                            data-id="{{ $userId ?? (userId ?? '') }}">{{ $aboutName }}</span>
                    </a>
                </h4>
                <p class="step1username mt7" data-id="{{ $userId ?? ($userId ?? '') }}">
                    {{ $username }}
                </p>

                <div class="df jcsb mt16">
                    <div class="tac w22px">
                        <div class="w-100 fl">
                            @include(
                                'frontend.partials.svg.icons.bigRedHeart'
                            )
                        </div>
                        <div class="w-100 fl lh1">
                            <b>{{ $folowers }}</b>
                        </div>
                    </div>
                    <div class="tac w22px">
                        <div class="w-100 fl">
                            @include(
                                'frontend.partials.svg.icons.blueBookings'
                            )
                        </div>
                        <div class="w-100 fl lh1">
                            <b>{{ $teacher_booked_students }}</b>
                        </div>
                    </div>
                    <div class="tac w22px">
                        <div class="w-100 fl mr6">
                            @include(
                                'frontend.partials.svg.icons.yellow_starBig'
                            )
                        </div>
                        <div class="w-100 fl lh1">
                            <b>{{ floatFormater($rating, 1) }}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
