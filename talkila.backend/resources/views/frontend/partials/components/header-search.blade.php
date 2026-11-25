@if(!auth()->user())
    <header class="slimHeader">
        <div class="grid-container grid-x m0auto">
            <div class="cell small-6 headerArea">
                <div id="search-top">

                        <a class="logoLink h74px" href="/">@include('frontend.partials.svg.icons.favicon')</a>
                        @if(Route::current()->getName() == 'book_slot_payment')
                            <h1 class="page-title h74px">{{ __('SELECT_PAYMENT_METHOD') }}</h1>
                        @elseif (Route::current()->getName() == 'book_slot')
                            <h1 class="page-title h74px">{{ __('CALENDAR_SELECT_DATE') }}</h1>
                        @else
                            <h1 class="page-title h74px">Talkila</h1>
                        @endif

                </div>
            </div>


                <div class="cell small-6 headerArea">
                    <ul class="smHeaderUl">
                        <li><a href="/account/login">{{ __('SIGN_IN') }}</a></li>
                        <li><a href="/account/signup">{{ __('SIGN_UP') }}</a></li>
                    </ul>
                </div>

        </div>
    </header>
@else
    @include('frontend.partials.components.header-third',['page_name' => 'Talkila'])
@endif
