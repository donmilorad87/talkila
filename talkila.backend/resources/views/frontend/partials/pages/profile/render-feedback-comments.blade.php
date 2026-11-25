
@if(isset($teacherFeedback['feedback_comments']) && !empty($teacherFeedback['feedback_comments']))
    @foreach(array_slice($teacherFeedback['feedback_comments'],0,2) as $item)
        <hr/>

        <div class="each-review">
            <div class="grid-x">
                <div class="cell small-7">
                    <div class="media-object">
                        <div class="media-object-section">
                            <div class="thumbnail df">
                                @if($item['anonym'])
                                    @include('frontend.partials.svg.icons.anonymous-black')
                                @elseif(!empty($item['profile_picture']))
                                    <img class="rounderReviewImage mr16" src="@if (isset($item['profile_picture']) && !empty($item['profile_picture'])) {{ $item['profile_picture'] }} @else {{ env('USER_DEFAULT_IMAGE') }} @endif">
                                @else
                                    @include('frontend.partials.svg.icons.no-profile-picture-shadow')
                                @endif
                            </div>
                        </div>
                        <div class="media-object-section df aic">
                            <div>
                                <p class="black mt10 mb0"><strong>{{ $item['anonym'] ? 'Anonymous' : $item['name']}}</strong></p>
                                <p class="small m0">{{changeDateFormatLocale('Y-m-d H:i:s',getTimeZonedDate('Y-m-d H:i:s', $item['created_date']))}}</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="cell small-5 text-right">
                    @for ($i = 0; $i < 5; $i++)
                        @if($i < $item['stars_content'])
                            @include('frontend.partials.svg.icons.full-star')
                        @else
                            @include('frontend.partials.svg.icons.zero-star')
                        @endif
                    @endfor
{{--                    @include('frontend.partials.svg.icons.half-star')--}}
                </div>
            </div>
            <div class="review-text black">
                <p>
                    {{$item['description']}}
                </p>
            </div>
        </div>
    @endforeach
@endif


