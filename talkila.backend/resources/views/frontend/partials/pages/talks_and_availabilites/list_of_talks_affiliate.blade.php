

<tr>

    <td>

        <div class="w-100 fl df aic tal">

            <div class="icon-sn book-sn-icon gray-bg borderRad duration{{ $item['duration'] }}">
                <div class="talkDurationAva">
                    <h6 class="h6TalkAndAva">{{ $item['duration'] }}</h6>
                    <p>
                        @if ($item['duration'] > 1)
                            {!! __('PROFILE_MINUTES') !!}
                        @else
                            {!! __('PROFILE_MINUTE') !!}
                        @endif
                    </p>
                </div>
            </div>

            <div class="w-80 fl pl24 posrelative">
                <div class="w-100 fl">
                    <span class="boldTalkTalksTAble headlineTextSpecific">
                        {{ $item['headline'] }}
                    </span>
                </div>
            </div>
        </div>

    </td>
    <td>
        <div>
            <div class="df profesorNameSpan tac">

                @include('frontend.partials.components.rating_stars_affiliate',['ratings' => $item['ratings'] ])

                <strong class="ml8 cBlack">{{ $item['ratings'] }}</strong>

            </div>

        </div>
        <div>
            <span class="talksReviewsText">{{ $item['total_reviews'] }}
                @if ($item['total_reviews'] > 1) {{ strtolower(__('REVIEWS')) }}@else{{ strtolower(__('REVIEW')) }}@endif</span>
        </div>


    </td>
    <td>
        <span class="cBlack crossRed"> {{ $item['price'] }} €</span>
        <span class="fl w-100 greenAffiliateDiscountText">{{ $item['price'] * 0.85 }} €</span>
    </td>
</tr>
