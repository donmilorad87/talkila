<section class="calcCircles" id="calcCircles" data-desktop="1" data-mobile="1">
    <div class="container">
        <div class="grid-x" id="calcConter">
            <div class="verticalAlignMiddle cell small-12 medium-12 large-5">
                <h2 class="heading-tile-calulator">
                   {!! __('CALCULATOR_HEADLINE') !!}
                </h2>
                <div class="hide-for-large-only hide-for-large mobile-view-heading">
                    <h2 id="resultMobile">2,500 €</h2>
                    <p>{!! __('CALCULATOR_CONDITIONS') !!}<span class="newPrice">2.000 €</span></p>
                </div>
                <div class="tabs-all">
                    <div class="ul-main">
                        <ul class="tabs" id="deeplinked-tabs">
                            <li class="tabs-title noselect panell" data-pointer="pc">
                                {{ __('CALCULATOR_BUTTON_PRIVATE') }}
                            </li>
                            <li class="tabs-title noselect panell dn" data-pointer="gc">
                                {{ __('CALCULATOR_BUTTON_GROUP') }}
                            </li>
                        </ul>
                        <div class="calcButton"></div>
                    </div>
                </div>
                <div id="pc-content" class="tabs-content-v">
                    <div class="tabs-panel is-active">
                        <div class="rangeInput mb-5">
                            <div class="flex-input">
                                <label for="priceHours">{{ __('CALCULATOR_HEADLINE_BASE_PRICE') }}</label>
                                <div class="currencyinput">

                                    <span id="calcString">.00</span>
                                    <input class="box1" type="text" value="25"></div>
                                <span id="calcCur">€</span>
                            </div>
                            <input type="range" id="priceHours" name="priceHours" min="1" value="25" max="300">
                        </div>
                        <div class="rangeInput mb-5">
                            <div class="flex-input">
                                <label for="hoursQuantity">{{ __('CALCULATOR_HEADLINE_HOURS') }}</label>
                                <div class="currencyinput2">
                                    <input class="box2" type="text" value="100">
                                    <span id="calcHrsString"> hrs</span>
                                </div>
                            </div>
                            <input type="range" id="hoursQuantity" name="hoursQuantity" min="1" max="160" value="100">
                        </div>
                        <div class="rangeInput mb-5 peopleCount">
                            <div class="flex-input">
                                <label for="calcPeopleNumber">{{ __('CALCULATOR_HEADLINE_PARTICIPIANTS') }}</label>
                                <input id="box5" type="text" value="28">
                            </div>
                            <input type="range" id="calcPeopleNumber" name="calcPeopleNumber" min="1" max="50"
                                   value="28" step="1">
                        </div>
                    </div>

                </div>
            </div>
            <div class="cell small-0 medium-0 large-1">
            </div>
            <div class="circle cell small-12 medium-12 large-6 hide-for-small-only hide-for-medium-only">
                <div class="circle1">
                    <div class="circle2">
                        <div class="circle3">
                            <div class="verticalAlignCenter">
                                <h3 id="result"> 2,500 €</h3>
                                <p class="roundedP">{!! __('CALCULATOR_CONDITIONS') !!}<span class="newPrice">2.000 €</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

