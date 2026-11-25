

<tr>
    <td class="width321 dataTalkId" data-talk-id="{{ $item['id'] }}">

        <div class="w-100 fl df aic tal pr">


            <div class="icon-sn book-sn-icon gray-bg borderRad duration{{$item['duration']}}">
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

    <td class="w-100p">
        <div>


            @if ($item['call_type'] == CallTypes::ONE_TO_ONE)
                <div class="w-100 fl tac">
                    @include('frontend.partials.svg.icons.schollar_cap')
                </div>
                <div class="w-100 fl tac talkTypeAva jcc"> {{ __('PRIVATE_TALK') }} </div>
            @elseif ($item['call_type'] == CallTypes::GROUP)
                <div class="w-100 fl tac">
                    @include('frontend.partials.svg.icons.chat-users')
                </div>
                <div class="w-100 fl tac talkTypeAva jcc"> {{ __('GALLERY_TALK') }} </div>
            @endif

            @include('frontend.partials.components.talk_active_icons',['additionalClass' => 'cesAvaTalkOver', 'talk_type' => $item['talk_type'], 'is_anon'=>$item['is_anonymous_allowed']])

        </div>
    </td>
    <td class="w-110p">

        <div class="middleFlex">
            <div class="df profesorNameSpan tac">

                @include('frontend.partials.components.rating_stars', ['ratings' => $item['ratings']])

                <strong class="colorBlack aic jcc">{{ $item['ratings'] }}</strong>

            </div>

        </div>
        <div class="df jcc">
            <span class="talksReviewsText">{{ $item['total_reviews'] }}
                @if ($item['total_reviews'] > 1)
                    {{ strtolower(__('REVIEWS')) }}@else{{ strtolower(__('REVIEW')) }}
                @endif
            </span>
        </div>




    </td>
    <td class="w-80p jcc">
        <div class="tac">

            <span>
                @include('frontend.partials.svg.icons.bigRedHeart')
            </span>
            <div class="specTextTalxAva">{{ $item['countFollowers'] }}</div>

        </div>
    </td>
    <td class="w-80p jcc">
        <div class="tac">

            <span>
                @include('frontend.partials.svg.icons.dolar_green')

            </span>
            <div class="specTextTalxAva">{{ $item['bookingsCount'] }}</div>

        </div>
    </td>

    <td class="w-80p jcc switcher" data-paused="{{ $item['state'] }}">

        <div class="date-wrap-content w-100">

            <div class="button-switch switch switch-re-edit df jcc">
                <input class="switch-input" id="activeTalk{{ $index }}" type="checkbox"
                    name="allowAnonimousTalkP{{ $index }}" @if ($item['state'] == \App\Models\Talk::STATE['valid']) checked @endif>


                <label class="switch-paddle" for="activeTalk{{ $index }}">

                </label>

            </div>
        </div>

    </td>

    <td class="df w-80p jcc cp shareTalk {{$item['state'] == \App\Models\Talk::STATE['paused'] ? 'pen' : ''}}" data-popup="shareProfilePopUp" >

        <div class="{{$item['state'] == \App\Models\Talk::STATE['paused'] ? 'dn' : 'df'}}">
            @include('frontend.partials.svg.icons.share')
        </div>




    </td>

</tr>

