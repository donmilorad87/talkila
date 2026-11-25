@if (isset($userTalks))
    <div class="course-item privateCourseItem">
        @php
            if (!empty($editTalk)) {
                $routePath = route('jtc_create_your_first_talk', ['id' => $userTalks['id']]);
            } elseif (!empty($bookTalk)) {
                $routePath = route('book_slot', $userTalks['id']);
            } else {
                $routePath = null;
            }
        @endphp


        <a data-talk-id="{{ $userTalks['id'] }}" @if (!empty($routePath)) href="{{ $routePath }}" @endif
            class="dataTalkId">
            <div class="icon-sn book-sn-icon gray-bg divPrivTalk0 duration{{ $userTalks['duration'] }}">
                <div class="divPrivTalk">
                    <h6>{{ $userTalks['duration'] }}</h6>
                    <p>
                        @if ($userTalks['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>
            </div>
            <div class="heading-slider">

                <div class="df aic jcsb">
                    <h6 class="affiliateTitleMob">{{ $userTalks['headline'] }} </h6>
                    <span class="cBlack crossRed crossRed2">{{ $userTalks['price'] }} €</span>
                </div>

                <div class="df aic jcsb">
                    <ul>

                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $userTalks['ratings'])
                                <li>
                                    @include('frontend.partials.svg.icons.full-star')
                                </li>
                            @else
                                <li>
                                    @include('frontend.partials.svg.icons.zero-star')
                                </li>
                            @endif
                        @endfor

                        <li>
                            <span class="small">
                                ({{ $userTalks['total_reviews'] }} {{ __('PROFILE_REVIEWS') }})
                            </span>
                        </li>
                    </ul>
                    <span class="greenAffiliateDiscountText">{{ $userTalks['price'] * 0.85 }} €</span>
                </div>
            </div>
        </a>
    </div>
@endif
