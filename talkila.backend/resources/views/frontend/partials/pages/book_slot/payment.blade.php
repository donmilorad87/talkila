<div id="payment-sec">
<div class="cell small-12">
    <div class="wrapper-video">


        <div class="date-time-tabs">
            <h5>{{ __('SELECT_PAYMENT_METHOD') }}</h5>
        </div>


        <div class="box-payment">
            {{ __('BASE_BASE_PRICE') }} <small class="text-right"> 1 X $50.00</small>
        </div>

        <div class="box-payment">
            {{ __('DISCOUNT') }} <small class="text-right"> $0.00</small>
        </div>
        <hr>

        <div class="box-payment active">
            {{ __('TOTAL_COST') }} <small class="text-right"> $50.00</small>
        </div>

    </div>
</div>



<div class="cell small-12">

    <div class="choose-payment-box noBorderNoBackground">
        <p class="payment-title"><strong>{{ __('SELECT_PAYMENT_METHOD') }}</strong></p>
        <ul class="tabs" data-active-collapse="true" data-tabs id="collapsing-tabs">
            <li class="tabs-title"><a href="#panel1d" aria-selected="true">

            <img src="{{ asset('frontend/assets/img/paypal.jpg') }}" alt="Paypal" />
                    <p>{{ __('PAYPAL') }}</p>


                </a></li>
            <li class="tabs-title"><a href="#panel2d">
            <img src="{{ asset('frontend/assets/img/credit.jpg') }}" alt="Credit Card" />
                    <p>{{ __('CREDIT_CARD') }}</p>

                </a></li>
            <li class="tabs-title"><a href="#panel3d">
            <img src="{{ asset('frontend/assets/img/online.jpg') }}" alt="Online" />
                    <p>{{ __('BANK_TRANSFER') }}</p>
                </a></li>

        </ul>

        <div class="tabs-content" data-tabs-content="collapsing-tabs">
            <div class="tabs-panel" id="panel1d">
    paypal

            </div>

            <div class="tabs-panel" id="panel2d">
                <form class="form-option">
                        <div class="grid-x grid-padding-x">

                            <div class="medium-6 cell">
                                <label>{{ __('BILLING_ADDRESS') }}


                                    <select>
                                        <option value="showboat">Select option</option>
                                        <option value="redwing">1</option>
                                        <option value="narcho">2</option>
                                        <option value="hardball">3</option>
                                    </select>

                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>{{ __('NAME_ON_CARD') }}
                                    <input type="text" placeholder="Name On Card">
                                </label>
                            </div>

                            <div class="medium-6 cell">
                                <label>{{ __('CARD_NUMBER') }}
                                    <input type="text" placeholder="Card Number">
                                </label>
                            </div>
                            <div class="medium-6 cell">

                                <div class="grid-x grid-padding-x">

                                    <div class="medium-6 cell">
                                        <label class='right'>{{ __('EXP_DATE') }}
                                            <select>
                                                <option value="showboat">MM/YY</option>
                                                <option value="redwing">1</option>
                                                <option value="narcho">2</option>
                                                <option value="hardball">3</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="medium-6 cell">
                                        <label class="left">{{ __('SECURITY_CODE') }}
                                            <input type="text" placeholder="****">
                                        </label>
                                    </div>

                                </div>

                            </div>

                        </div>



                </form>

            </div>
            <div class="tabs-panel" id="panel3d">

                {{ __('BANK_TRANSFER') }}


            </div>

        </div>
    </div>
</div>


<div class="text-right">

    <a href="#" class="button ">{{ __('COMPLETE_PAYMENT') }}</a>

</div>

</div>
