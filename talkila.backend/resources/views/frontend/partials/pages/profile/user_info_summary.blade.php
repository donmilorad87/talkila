<div class="profile-overview w-100 fl bookingSummaryHDmobile p24 border1 mt16 profileHeaderSumary white-box">
    <div class="icon-sn book-sn-icon box-resize cp fl" data-popup="appStorePupUp">
        <a href="{{ route('profile', $username) }}" class="profPict shaddowDiver">
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
                @include('frontend.partials.svg.icons.no-profile-picture-102')
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

                <div class="df jcsb mt16 pr16">
                    <div>
                        <div class="w-100 fl tac">
                            @include(
                                'frontend.partials.svg.icons.bigRedHeart'
                            )
                        </div>
                        <div class="w-100 fl tac lh1">
                            <b>{{ $folowers }}</b>
                        </div>
                    </div>
                    <div>
                        <div class="w-100 fl tac">
                            @include(
                                'frontend.partials.svg.icons.blueBookings'
                            )
                        </div>
                        <div class="w-100 fl tac lh1">
                            <b>{{ $teacher_booked_students }}</b>
                        </div>
                    </div>
                    <div>
                        <div class="w-100 fl tac">
                            @include(
                                'frontend.partials.svg.icons.yellow_starBig'
                            )
                        </div>
                        <div class="w-100 fl tac lh1">
                            <b>{{ $rating }}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
