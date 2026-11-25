<div class="popupBase" id="reviewPopUp">
    <div class="popuper ppB">

        <div id="reviewCarousel">
            <div class="innerCarouselElement">
                <p class="dn" id="reasonForCallEndTitle">@lang('REASON_FOR_END_TALK')</p>
                <p class="dn" id="reasonForCallEnd">{!! __('REASON_FOR_END_TALK') !!}</p>

                <h5 class="add-time-title text-center line-height">
                    {{ __('HOW_WAS_YOUR_TALK') }}
                    <span class="reviewName">

                    </span>
                </h5>


                <div class="grid-x grid-margin-x">


                    <div class="col-sm-12 large-12 cell">

                        <div class="review-inner">
                            <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" width="80" />
                            <p class="m0">{{ __('HOW_DID_TALK_GO') }}</p>
                            <div class="w-100 fl crpko">
                                <div class="rate rateUser">
                                    <input type="radio" id="star51" class="star5" name="rate1" value="5" />
                                    <label for="star51" title="text"></label>
                                    <input type="radio" id="star41" class="star4" name="rate1" value="4" />
                                    <label for="star41" title="text"></label>
                                    <input type="radio" id="star31" class="star3" name="rate1" value="3" />
                                    <label for="star31" title="text"></label>
                                    <input type="radio" id="star21" class="star2" name="rate1" value="2" />
                                    <label for="star21" title="text"></label>
                                    <input type="radio" id="star11" class="star1" name="rate1" value="1" />
                                    <label for="star11" title="text"></label>
                                </div>
                            </div>

                            <p><strong data-rate="" class="rateAnswer rateAnswerUser"></strong></p>
                        </div>
                       {{--  <hr>

                        <div class="review-inner">
                            <p>Average rating of this user:</p>
                            <div class="w-100 fl bgGrayStars">
                                <div class="stars" style="--rating: 3.7;" aria-label="Rating of this product is 3.7 out of 5."></div>
                            </div>
                            <p><strong>3.7 out of 5.</strong></p>
                        </div> --}}

                        <hr>
                        <div class="review-inner">
                            <p class="m0"> @lang('WHAT_WAS_VIDEO_QUALITY') </p>
                            <div class="w-100 fl crpko">
                                <div class="rate rateVoiceVideo">
                                    <input type="radio" id="star52" class="star5" name="rate2" value="5" />
                                    <label for="star52" title="text"></label>
                                    <input type="radio" id="star42" class="star4" name="rate2" value="4" />
                                    <label for="star42" title="text"></label>
                                    <input type="radio" id="star32" class="star3" name="rate2" value="3" />
                                    <label for="star32" title="text"></label>
                                    <input type="radio" id="star22" class="star2" name="rate2" value="2" />
                                    <label for="star22" title="text"></label>
                                    <input type="radio" id="star12" class="star1" name="rate2" value="1" />
                                    <label for="star12" title="text"></label>
                                </div>
                            </div>

                            <p><strong data-rate="" class="rateAnswer rateAnswerVoiceVideo"></strong></p>
                        </div>
                    </div>


                    <div class="medium-12 large-12 small-12 cell">
                        <div class="group-input-filed input-filed-here">
                            <label class="m0p0h0">{{ __('WRITE_REVIEW') }}</label>
                            <div class="position-input">
                                <input class="reviewDescription" type="text" placeholder="Write your comments here">
                            </div>
                        </div>

                    </div>

                </div>

                <button class="btn w-100 reviewSubmitButton" data-user-id="" data-pointer=""  data-pointer-talk-type="">{{ __('SUBMIT') }}</button>

                {{-- <button class="close-btn-center" data-close="" aria-label="Close reveal" type="button">
                    <a href="/" aria-hidden="true">{{ __('SKIP_REVIEW_BACK') }}</a>
                </button> --}}
            </div>
        </div>
    </div>
</div>
