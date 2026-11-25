<div class="mobileAboutContainer">
    <div class="bbt-none mobileAboutHeader">
        <div class="icon-sn book-sn-icon box-resize cp">
            <div>
                <img src="{{ asset('frontend/assets/img/user-img.png') }}" alt="user" />
            </div>
        </div>
        <div class="flexBoxCont">
            <div class="flex-box">
                <div>
                    <h6 class="mobName">Helen Tran</h6>
                    <p>Ernahrungsexperte</p>
                </div>
            </div>
            <div class="cp">
                <ul>
                    <li>
                        @include('frontend.partials.svg.icons.full-star')
                        <strong>4.9</strong>{{ __('BOOK_RATING') }}
                    </li>
                    <li><strong>124</strong>{{ __('BOOK_FOLLOWERS') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <p class="mobileHeaderText">Cum amet senectus inceptos eleifend adipscing ipsum vastibulum parturient consequat
        ullamiceptos about...</p>
</div>
