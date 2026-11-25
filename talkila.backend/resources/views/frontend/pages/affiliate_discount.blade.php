@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="grid-container">

        <div class="grid-x white-box">
            <div class='cell medium-12'>
                <div class="grid-x">
                    <div class='cell small-12 hide-for-medium2'>
                        @include('frontend.partials.components.user-info_affiliate')
                    </div>

                    <div class='cell small-12 large-12 bwhite bottomDiscountDiv'>

                        <div class="df greenDiscount">
                            <div class="greenClock">
                                @include('frontend.partials.svg.icons.green_clock')
                            </div>
                            <div class="secDivGreen">
                                <p>
                                    <b>15% Rabatt noch</b>
                                    <span id="countdown"></span>
                                </p>
                                <p>Glückwusch, du sparst 15% auf alle Talks, wenn du innerhalb der nächsten 24 Stunden
                                    buchst.</p>
                            </div>
                            <script>
                                function countdownTimer() {
                                    const difference = new Date("2022-04-15 23:29:00") - new Date()
                                    let remaining = "Time's up!"

                                    if (difference > 0) {

                                        const parts = {
                                            hours: Math.floor((difference / (1000 * 60 * 60)) % 24) < 10 ? '0' + Math.floor((difference / (
                                                1000 * 60 * 60)) % 24) : Math.floor((difference / (1000 * 60 * 60)) % 24),
                                            minutes: Math.floor((difference / 1000 / 60) % 60) < 10 ? '0' + Math.floor((difference / 1000 /
                                                60) % 60) : Math.floor((difference / 1000 / 60) % 60),
                                            seconds: Math.floor((difference / 1000) % 60) < 10 ? '0' + Math.floor((difference / 1000) % 60) :
                                                Math.floor((difference / 1000) % 60)
                                        }

                                        remaining = Object.keys(parts).map(part => {
                                            return `${parts[part]}`
                                        }).join(":")
                                    }

                                    document.getElementById("countdown").innerHTML = remaining
                                }

                                countdownTimer()

                                setInterval(countdownTimer, 1000)
                            </script>
                        </div>

                        <section class="cell small-12 w-100 fl oh p24 pt0 pb0">
                            <div class="inner-box-book w-100 fl">

                                <div class="coursesBlock mb16">

                                    <div class="grid-x grid-margin-x m0mobile mt16">
                                        <div class="show-for-medium2">

                                            <table id="categorySubcategoryTalksTable" class="mt0">
                                                <thead>
                                                    <tr>
                                                        <td>{{ __('TALK_NAME') }}</td>
                                                        <td>{{ __('REVIEWS') }}</td>
                                                        <td>
                                                            {{ __('BASE_PRICE') }}
                                                        </td>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <div id="token" class="token">
                                                        @csrf
                                                    </div>
                                                    @foreach ($userPrivateTalks as $userTalks)
                                                        @include('frontend.partials.pages.talks_and_availabilites.list_of_talks_affiliate',
                                                            [
                                                                'item' => $userTalks,
                                                                'index' => $loop->index,
                                                            ])
                                                    @endforeach
                                                </tbody>
                                            </table>


                                        </div>

                                        <div class="grid-container w-100 grid-x p0 hide-for-medium2">

                                            @foreach ($userPrivateTalks as $userTalks)
                                                <div class="cell small-12">
                                                    @include('frontend.partials.pages.profile.affiliate_course_overview',
                                                        [
                                                            'userTalks' => $userTalks,
                                                        ])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
