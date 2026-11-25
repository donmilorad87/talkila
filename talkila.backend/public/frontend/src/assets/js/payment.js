let bearerToken = document.querySelector('meta[name="access_token"]').content
let token = document.querySelector('meta[name="csrf-token"]').content

function openPaymentPopuper(x) {
    openPopup('specialLoading')
    document.getElementById('loadingText').textContent = x
}

export function initializePayPal(intentValue) {

    let paypal_client_id = document.getElementById('ppbpci').value

    loadScript("https://www.paypal.com/sdk/js?intent=" + intentValue + "&vault=false&client-id=" + paypal_client_id + "&disable-funding=credit,card,giropay,sofort,sepa&currency=EUR", function () {

        try {
            initPayPal()
        } catch (err) {
            Sentry.captureException(new TryCatchInitPayPal(err))
        }

        function initPayPal() {
            let payPalEnvironment = document.getElementById('ppenv').value

            paypal.Buttons({

                // Set your environment
                env: payPalEnvironment,

                // Set style of button
                style: {
                    layout: 'vertical', // horizontal | vertical
                    size: 'responsive', // medium | large | responsive
                    shape: 'pill', // pill | rect
                    color: 'gold' // gold | blue | silver | black
                },

                // Execute payment on authorize
                commit: true,
                // Wait for the PayPal button to be clicked
                createOrder: function () {

                    let total_amount

                    if (document.body.className === "settings_wallets") {
                        total_amount = parseFloat(document.getElementById('online_amount').value.replace(',', '.')).toFixed(2)
                    } else if (document.body.className === "video_conference") {

                        let userBalance = parseFloat(document.getElementById('upperBallance').textContent.replace(',', '.'))
                        let extendionPrice = parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))

                        if (userBalance > 0) {
                            total_amount = parseFloat(extendionPrice - userBalance).toFixed(2)
                        }else{
                            total_amount = parseFloat(extendionPrice).toFixed(2)
                        }

                        /* if( parseFloat(document.getElementById('upperBallance').textContent) === 0){

                            total_amount = parseFloat(
                                document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent
                            ).toFixed(2)

                        }else if(parseFloat(document.getElementById('upperBallance').textContent) < parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent)){
                            total_amount = parseFloat(

                                parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent)
                                -
                                parseFloat(document.getElementById('upperBallance').textContent)

                            ).toFixed(2)
                        } */


                    } else if (document.body.className === "book_slot_payment") {
                        /* total_amount = parseFloat(document.getElementById('paypalAmount').textContent.replace(',', '.')) */
                        total_amount = parseFloat(document.getElementById('paypalAmountReal').value).toFixed(2)
                    }else{
                        total_amount = parseFloat(document.getElementById('online_amount').value)

                    }

                    let payment_type = document.getElementById('payment_type').value

                    let params = {
                        item_amt: total_amount,
                        total_amt: total_amount,
                        currency: 'EUR',
                        intent: intentValue.toUpperCase(),
                        _token: token,
                        payment_type: payment_type
                    }

                    return fetch(
                        '/frontend/api/paypal-create-order', {
                        method: 'POST',
                        body: JSON.stringify(params),
                        headers: {
                            "Content-Type": "application/json;charset=UTF-8",
                            "X-CSRF-TOKEN": token,
                            "Time-Zone-Offset-UTC": getCookie('timezone')
                        }
                    }).then(function (response) {
                        return response.json()
                    }).then(function (resJson) {
                        return resJson.data.id
                    })
                },

                // Wait for the payment to be authorized by the customer
                onApprove: function (data, actions) {

                    let bookingObj = document.body.className === 'book_slot_payment' ? JSON.parse(getCookie('bookingObj')) : null
                    let amount, talk_id, start_call, extension_time, url

                    if (document.body.className === 'book_slot_payment') {
                        amount = parseFloat(parseFloat(document.getElementById('paypalAmountReal').value).toFixed(2))
                        talk_id = parseFloat(document.getElementsByClassName('dataTalkId')[0].dataset.talkId)
                        start_call = document.body.className === 'book_slot_payment' ? bookingObj.bookingDate + ' ' + bookingObj.bookingTime[0] : null
                        extension_time = false
                        url = '/frontend/api/bookings'

                    } else if (document.body.className === 'settings_wallets') {
                        amount = parseFloat(document.getElementById('addCoinsPaymentPopUp').getElementsByClassName('online_amount')[0].textContent)
                        url = '/frontend/api/paypal-capture-order'

                    } else if(document.body.className === 'video_conference') {
                        amount = parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent)
                        talk_id = parseFloat(9999999999999)
                        start_call = false
                        extension_time = parseInt(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_time')[0].textContent)
                        url = '/frontend/api/book-extension'

                    }else{

                        amount = parseFloat(document.getElementById('online_amount').value)
                        url = '/frontend/api/paypal-capture-order'
                    }


                    let params = {
                        order_id: data.orderID,
                        _token: token,
                        payment_type: 'paypal',
                        talk_id: talk_id,
                        amount: amount,
                        start_call: start_call,
                        extension_time: extension_time,
                    }

                    openPaymentPopuper(getPoTranslate('PROCESSING_PAYPAL_PAYMENT'))

                    try {
                        finishPayPalTransaction()

                    } catch (err) {

                        Sentry.captureException(new TryCatchFinishPayPalTransaction(err))
                    }

                    function finishPayPalTransaction() {

                        return fetch(
                            url, {
                            method: 'POST',
                            body: JSON.stringify(params),
                            headers: {
                                "Content-Type": "application/json;charset=UTF-8",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Time-Zone-Offset-UTC": getCookie('timezone')
                            }
                        }).then(function (res) {
                            return res.json()
                        }).then(function (res) {

                            if (res.success == true) {


                                if (document.body.className === "settings_wallets") {

                                    let available_balance = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(res.data.available_balance)).replace(/[^0-9.,]/g, '')

                                    document.getElementsByClassName('available_balance')[0].textContent = available_balance
                                    closePopup('addCoinsPaymentPopUp')
                                    closePopup('specialLoading')
                                    toastify(res.message)
                                } else if (document.body.className === "book_slot_payment") {
                                    document.cookie = 'bookingObj=; Path=/booking-payment; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                                    location.assign(origin + '/booking-thank-you')
                                    toastify(res.message)
                                } else if (document.body.className === "video_conference") {

                                    let thatsMe
                                    for (let i = 0; i < others.length; i++) {
                                        if (others[i].user_id === userObj1.id) {
                                            thatsMe = {
                                                name: others[i].name_of_user,
                                                profile_picture: others[i].user_image
                                            }
                                        }

                                    }

                                    EXTEND_CALL_SUCCESSFUL_Send_Event_Function(call, thatsMe, window.extendTalkParameters)

                                    closePopup('paymentWalletPopUp')
                                    openPopup('paymentCompletedPopUp')

                                    setTimeout(function () {
                                        closePopup('paymentCompletedPopUp')
                                    }, 5000)

                                    closePopup('specialLoading')

                                } else {




                                   toastify(res.message)
                                    closePopup('specialLoading')
                                    closePopup('blankPopup')
                                }

                            } else {

                                toastify(res.message)
                                closePopup('specialLoading')
                            }

                        }).catch((error) => {
                            Sentry.captureException(new finishPayPalTransactionError(error))
                        })

                    }
                }
            }).render('#paypalCheckoutContainer')

        }
    })

    class TryCatchInitPayPal extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchInitPayPal"
        }
    }
    class TryCatchFinishPayPalTransaction extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchFinishPayPalTransaction"
        }
    }
    class finishPayPalTransactionError extends Error {
        constructor(message) {
            super(message)
            this.name = "finishPayPalTransactionError"
        }
    }

}

export function extendTalkPaymentInitialize() {




    document.getElementsByClassName('getcddata')[0].addEventListener('click', function () {


        let walletBalance



        let url = envAppBackendUrl + "/get-wallet-balance"
        let xhr = new XMLHttpRequest()

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)


                if (response.success == true) {

                    walletBalance = parseFloat(response.data.available_balance_regular_format)
                    document.getElementById('upperBallance').textContent = walletBalance
                    closePopup('extendAnswer')

                    let walletBalanceContainer = document.getElementsByClassName('wallet_balance_section')[0]

                    if(parseFloat(response.data.available_balance_regular_format) == 0){


                        walletBalanceContainer.classList.add('dn')
                        document.getElementsByClassName('wallet_balance_section')[0].classList.add('dn')
                    }else{
                        document.getElementsByClassName('wallet_balance_section')[0].classList.remove('dn')
                        walletBalanceContainer.classList.remove('dn')
                    }
                    //openPaymentPopuper(getPoTranslate('PROCESSING_PAYMENT'))

                    document.getElementById('paypalVideoExtendViewAmount').textContent = parseFloat(
                        walletBalance - parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))
                    ).toFixed(2)

                    initializePayPal('authorize')
                    document.getElementById('nameOfTalkForPaymentExtension').textContent = call.room_name
                    openPopup('paymentWalletPopUp')
                   if (parseFloat(walletBalance) > parseFloat(document.getElementsByClassName('extend_call_price')[0].textContent)) {

                        let peregarders = document.getElementsByClassName('peregarder')
                        for (let i = 0; i < peregarders.length; i++) {
                            peregarders[i].classList.add('dn')

                        }
                        if(document.getElementById('stripePricer')){
                            document.getElementById('stripePricer').remove()
                        }
                        document.getElementById("pay_via_stripe_cachsier").textContent = getPoTranslate('PAY_VIA_COINS')

                    } else if ((parseFloat(document.getElementsByClassName('extend_call_price')[0].textContent) - parseFloat(walletBalance)) > 0) {

                        let peregarders = document.getElementsByClassName('peregarder')
                        for (let i = 0; i < peregarders.length; i++) {
                            peregarders[i].classList.remove('dn')

                        }
                        document.getElementById("pay_via_stripe_cachsier").textContent = getPoTranslate('PAY_USING_STRIPE')
                        let price = document.createElement('span')
                        price.id = "stripePricer"
                        price.textContent = ' (' + new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format((parseFloat(document.getElementsByClassName('extend_call_price')[0].textContent) - parseFloat(document.getElementsByClassName('greenInfo')[0].dataset.realPrice)).toFixed(2)) + ')'
                        document.getElementById("pay_via_stripe_cachsier").append(price)
                        document.getElementById('paypalVideoExtendViewAmount').textContent = parseFloat(
                            parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))
                            -
                            walletBalance
                        ).toFixed(2)
                        if(document.getElementById('payAmountStripeVideoExtend')){
                            document.getElementById('payAmountStripeVideoExtend').innerHTML = ' (<b>' + new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(document.getElementById('paypalVideoExtendViewAmount').textContent)) + '</b>)'
                        }
                      } else {
                        document.getElementById('pay_via_stripe_cachsier').classList.add('dn')
                        document.getElementById('paypalVideoExtendViewAmount').textContent = parseFloat(
                            parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))
                            -
                            walletBalance
                        ).toFixed(2)
                    }

                } else {


                    toastify(response.message)

                }

            }
        }

        xhr.open("GET", url, true)

        xhr.onerror = function () {
            hideLoading()
            closePopup('specialLoading')
            Sentry.captureException(new getWalletBalanceError('status: ' + this.statusText + '|| response: ' +
                this.statusText + ' || url: ' + location.href))
        }

        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send()

        class getWalletBalanceError extends Error {
            constructor(message) {
                super(message)
                this.name = "TryCatchBlockBookingPaymentFunction"
            }
        }


    })


}





function addCreditCardSubmit(stripe) {
    if (document.getElementById('submitAddCreditCard')) {

        let nameStatus = {}
        let nameValue

        if (document.getElementById("submitAddCreditCard")) {

            let nameInput = document.getElementById('card_holder_name')
            let nameWarn = nameInput.parentElement.getElementsByClassName("default-warn")[0]
            let nameSvg = nameInput.parentElement.getElementsByClassName("verified-svg")[0]

            nameInput.parentElement.getElementsByClassName('clear-button')[0].addEventListener('click',function(){
                this.parentElement.classList.remove('active')
                this.parentElement.parentElement.getElementsByClassName('default-input')[0].classList.remove('ok')
                this.parentElement.parentElement.getElementsByClassName('default-input')[0].value = ''
            })

            nameInput.addEventListener("input", nameHandler)


            function nameHandler() {
                nameValue = nameInput.value

                let check = nameCheck(nameValue)
                nameStatus = check

                if (check.isOk) {

                    nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                    countLabelDriver({ el: nameInput, min: 2, max: 100 })
                    nameInput.classList.remove("error")
                    nameInput.classList.add("ok")

                    nameSvg.classList.add("active")
                    nameWarn.classList.remove("active")

                } else {
                    nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'

                    countLabelDriver({ el: nameInput, min: 4, max: 50 })


                    nameInput.classList.add("error")
                    nameInput.classList.remove("ok")

                    nameSvg.classList.remove("active")

                    nameWarn.classList.add("active")

                    nameWarn.innerHTML = "&nbsp"
                    /* nameWarn.innerHTML += check.hasName ? "" : translate.missingName + ","
                    nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.missingSurname + ","
                    nameWarn.innerHTML += check.hasNumber ? " " + translate.noNumbers + "," : ""
                    nameWarn.innerHTML += check.hasSymbol ? " " + translate.noSpecialCharacters + "," : "" */
                    nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', { 'minimum_characters': '2', 'maximum_characters': '100' }) + "," : ""


                    nameWarn.textContent = removeCommaFromValidationWarning(nameWarn.textContent)
                }
            }


            document.getElementById('submitAddCreditCard').addEventListener('click', function () {

                nameHandler()

                let postData = {
                    name: nameValue
                }

                let postStatus = {
                    name: nameStatus
                }

                if (nameStatus.isOk) {


                    openPaymentPopuper(getPoTranslate('PROCESSING_ADD_CREDIT_CARD'))

                   /*  try { */
                        addCreditCardToWallet()
                    /* } catch (err) {
                        Sentry.captureException(new tryCatchAddCreditCardFunction(err));
                    } */

                    function addCreditCardToWallet() {


                        stripe.confirmCardSetup(
                            document.getElementById('userCardsIntent').value, {
                            payment_method: {
                                card: card,
                                billing_details: {
                                    name: document.getElementById('card_holder_name').value
                                }
                            }
                        }).then(function (result) {

                            if (result.error) {


                                if (document.getElementById('creditCardMesasge')) {
                                    let creditCardMesasge = document.getElementById('creditCardMesasge')
                                    creditCardMesasge.style.display = 'block'
                                    setTimeout(function () {

                                        creditCardMesasge.textContent = result.error.message
                                        creditCardMesasge.style.color = 'red'
                                        creditCardMesasge.style.opacity = '1'
                                        creditCardMesasge.style.transform = 'scale(1)'
                                        calculatePopUpHeight(document.getElementById('cardPopUp'))


                                        setTimeout(function () {

                                            creditCardMesasge.style.opacity = '0'
                                            creditCardMesasge.style.transform = 'scale(0)'
                                            setTimeout(function () {
                                                calculatePopUpHeight(document.getElementById('cardPopUp'))
                                                setTimeout(function () {

                                                    creditCardMesasge.style.display = 'none'


                                                }, 10)
                                            }, 350)
                                        }, 5000)


                                    }, 10)

                                    closePopup('specialLoading')

                                } else {
                                    toastify(result.error.message)
                                }


                            } else {

                                let params = {
                                    payment_method: result.setupIntent.payment_method,
                                    _token: token
                                }

                                let xhr = new XMLHttpRequest()

                                xhr.onreadystatechange = function () {

                                    if (this.readyState == 4 && this.status == 200) {

                                        let response = JSON.parse(this.responseText)

                                        toastify(response.message)

                                        if (document.getElementById('loadingText')) {
                                            document.getElementById('loadingText').textContent = response.message
                                        }



                                        closePopup('cardPopUp')

                                        openPaymentPopuper(getPoTranslate('PROCESSING_ADD_CREDIT_CARD'))

                                        removeActivePointerCreditCardsPointers()

                                        if (response.data.cards.hasOwnProperty('deleted')) {

                                            let cards = document.getElementsByClassName('set_default_card')
                                            for (let i = 0; i < cards.length; i++) {
                                                let cardItem = cards[i]
                                                if (cardItem.dataset.cardId === response.data.cards.deleted.card_id) {

                                                    cardItem.parentElement.style.scale = '0'

                                                    if (cardItem.parentElement.parentElement.classList.contains('card-list')) {
                                                        cardItem.removeEventListener('click', selectDefaultCardHelper)
                                                    } else if (cardItem.parentElement.parentElement.classList.contains('stripe_cards_without_delete')) {
                                                        cardItem.removeEventListener('click', selectPaymentCard)
                                                    }

                                                    setTimeout(function () {
                                                        cardItem.parentElement.remove()
                                                    }, 310)
                                                }

                                            }
                                            setTimeout(function () {
                                                appendClonedElement(response.data.cards.added)



                                            }, 310)


                                        } else {

                                            appendClonedElement(response.data.cards.added)

                                        }

                                        closePopup('specialLoading')

                                        if (document.body.className === 'settings_wallets') {
                                            document.getElementById('walletStripeButtonCont').classList.remove('dn')
                                        } else if (document.body.className === 'video_conference') {
                                            document.getElementById('pay_via_stripe_cachsier').classList.remove('dn')
                                            document.getElementById('ccContainerBookingFunnel').classList.remove('dn')
                                        }





                                        if (document.getElementById('add_wallet_booking_cachier')) {
                                            if (document.getElementById('add_wallet_booking_cachier').classList.contains('dn')) {
                                                document.getElementById('add_wallet_booking_cachier').classList.remove('dn')
                                            }
                                        }
                                    }
                                }

                                xhr.open("POST", "/frontend/api/add-card", true)

                                xhr.onerror = function (error) {
                                    hideLoading()
                                    closePopup('specialLoading')
                                    console.log(new Error(error))
                                }

                                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));

                                xhr.send(JSON.stringify(params))

                            }
                        })

                    }

                    class getStripeCardsForExtendionError extends Error {
                        constructor(message) {
                            super(message)
                            this.name = "getStripeCardsForExtendionError"
                        }
                    }

                    class tryCatchAddCreditCardFunction extends Error {
                        constructor(message) {
                            super(message)
                            this.name = "tryCatchAddCreditCardFunction"
                        }
                    }



                } else {
                    console.log("fullName validation failed", postData)
                    console.log("fullName validation errors", postStatus)
                }


            })
        }

    }
}

function appendClonedElement(cardItem) {
    let clonedElementWithDelete = createClonedElement(cardItem)
    let clonedElementWithoutDelete = createClonedElement(cardItem)

    clonedElementWithDelete.querySelector(".set_default_card").addEventListener('click', selectDefaultCardHelper)
    clonedElementWithDelete.querySelector(".delete_card").addEventListener('click', deleteCardHelper)
    clonedElementWithoutDelete.querySelector(".set_default_card").addEventListener('click', selectPaymentCard)

    document.getElementsByClassName('card-list')[0]?.prepend(clonedElementWithDelete)
    document.getElementsByClassName('stripe_cards_without_delete')[0].prepend(clonedElementWithoutDelete)

    if (document.getElementsByClassName('noCardsAdded')[0]) {

        let noCardsAdded = document.getElementsByClassName('noCardsAdded')

        for (let i = noCardsAdded.length - 1; i >= 0; i--) {

            noCardsAdded[i].remove()
        }


    }
    if (document.body.className === 'settings_wallets') {
        let cardList = document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')

        if (cardList.length === 1) {
            document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')[0].classList.remove('dn')
        }
    }


    setTimeout(function () {
        calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))
    })

}

function createClonedElement(cardObject) {
    let cardItemTemplate = document.getElementById("cardItemTemplate")
    let clonedTemplate = cardItemTemplate.content.cloneNode(true)

    clonedTemplate.querySelector(".set_default_card").dataset.cardId = cardObject.card_id
    clonedTemplate.querySelector(".card-select").dataset.cardId = cardObject.card_id
    clonedTemplate.querySelector(".delete_card").dataset.cardId = cardObject.card_id

    clonedTemplate.querySelector(".cardHolderName").textContent = cardObject.name
    clonedTemplate.querySelector(".lastFourNumbers").textContent = cardObject.card_last_four_digit

    clonedTemplate.querySelector(".card_month_expire").textContent = cardObject.card_month_expire
    clonedTemplate.querySelector(".card_year_expire").textContent = cardObject.card_year_expire

    clonedTemplate.querySelector(".cardIconHolder").append(getCardIcon(cardObject.card_brand))
    return clonedTemplate
}

function getCardIcon(card_brand) {
    switch (card_brand) {
        case 'visa':

            if (document.getElementById('visaCard')) {
                let cardIconTemplate = document.getElementById("visaCard")
                return cardIconTemplate.content.cloneNode(true)
            }

        case 'mastercard':

            if (document.getElementById('mastercardCard')) {
                let cardIconTemplate = document.getElementById("mastercardCard")
                return cardIconTemplate.content.cloneNode(true)
            }

        case 'amex':
            if (document.getElementById('amexCard')) {
                let cardIconTemplate = document.getElementById("amexCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Discover':
            if (document.getElementById('discoverCard')) {
                let cardIconTemplate = document.getElementById("discoverCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Diners Club':
            if (document.getElementById('dinersClubCard')) {
                let cardIconTemplate = document.getElementById("dinersClubCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'UnionPay':
            if (document.getElementById('unionPayCard')) {
                let cardIconTemplate = document.getElementById("unionPayCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'JCB':
            if (document.getElementById('JCBCard')) {
                let cardIconTemplate = document.getElementById("JCBCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Cartes Bancaires':
            if (document.getElementById('cartesBancairesCard')) {
                let cardIconTemplate = document.getElementById("cartesBancairesCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'paypal':
            if (document.getElementById('paypalCard')) {
                let cardIconTemplate = document.getElementById("paypalCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Interac':
            if (document.getElementById('interacCard')) {
                let cardIconTemplate = document.getElementById("interacCard")
                return cardIconTemplate.content.cloneNode(true)
            }
    }
}

export function initializeStripe() {
    loadScript('https://js.stripe.com/v3/', function () {

        let stripe_key = document.getElementById('spck').value
        var stripe = Stripe(stripe_key)
        var elements = stripe.elements()

        window.styleZ = {
            base: {
                fontWeight: 300,
                fontFamily: 'sans-serif',
                fontSize: '16px',

                ':focus': {
                    color: '#1d293f',
                },

                '::placeholder': {
                    color: '#999',
                },

                ':focus::placeholder': {
                    color: '#CFD7DF',
                },
            },
            invalid: {
                color: '#fff',
                ':focus': {
                    color: '#FA755A',
                },
                '::placeholder': {
                    color: '#FFCCA5',
                },
            },
        }

        window.card = elements.create('card', {
            iconStyle: 'solid',
            style: styleZ,
        })

        if (document.getElementById('card-element')) {
            card.mount('#card-element')
        }

        //this is used for stripe payment on settings wallet and video extend

        if (document.getElementById('pay_via_stripe_cachsier')) {

            document.getElementById('pay_via_stripe_cachsier').addEventListener('click', function () {

                openPaymentPopuper(getPoTranslate('PROCESSING_STRIPE_PAYMENT'))
bookingPayment()
                /* try {
                    bookingPayment()
                } catch (err) {
                    Sentry.captureException(new TryCatchBookingPaymentFunction(err))
                } */

            })

            function bookingPayment() {

                

                    if (document.body.className === "settings_wallets") {
                        //this part is used for add coins from wallet payments: stripe and automatic pay pal payment

                        let activeCard = document.getElementById('stripeerCont')?.getElementsByClassName('active')[0]
                        if (!activeCard) {
                            closePopup('specialLoading')
                            toastify(getPoTranslate('PLEASE_SELECT_A_CARD'))
                            return
                        }
                        let defaultCardElement = activeCard.dataset.cardId
                        let amount = parseFloat(document.getElementById('online_amount').value)
                        let payment_type, url


                        payment_type = 'stripe'
                        url = "/frontend/api/deposite-in-wallet"


                        let params = {

                            selected_card_data: {
                                "card_id": defaultCardElement
                            },
                            amount: amount,
                            _token: token,
                            payment_type: payment_type
                        }

                        let xhr = new XMLHttpRequest()

                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)

                                if (response.depositeInWallet.success == true) {

                                    if (response.depositeInWallet.hasOwnProperty('data')) {

                                        if (response.depositeInWallet.data.hasOwnProperty('redirect')) {
                                            let origins = location.origin

                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(origins + response.depositeInWallet.data.redirect)
                                        }

                                    } else {

                                        toastify(response.depositeInWallet.message)

                                        let ballance = response.wallet_balance
                                        let ballanceDiv = document.getElementById('Profile').getElementsByClassName('available_balance')[0]
                                        let coinsToAdd = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(ballance) ).replace(/[^0-9.,]/g, '')

                                        ballanceDiv.textContent = coinsToAdd
                                        closePopup('specialLoading')

                                        closePopup('addCoinsPaymentPopUp')
                                    }

                                } else {
                                    closePopup('specialLoading')


                                    toastify(response.depositeInWallet.message)

                                }

                            }
                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            closePopup('specialLoading')
                            /* Sentry.captureException(new depositInWalletPaymentStripeError_settingsWallet('status: ' + this.statusText + '|| response: ' +
                                this.statusText + ' || url: ' + location.href)) */
                        }

                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                        xhr.send(JSON.stringify(params))
                    } else if (document.body.className === "video_conference") {

                        //this part is used for video talk extend payments: stripe and automatic pay pal payment

                        let activeCardEl = document.getElementById('stripeerCont')?.getElementsByClassName('active')[0]
                        if (!activeCardEl) {
                            closePopup('specialLoading')
                            toastify(getPoTranslate('PLEASE_SELECT_A_CARD'))
                            return
                        }
                        let defaultCardElement = activeCardEl.parentElement.parentElement
                        let  url, payment_type, date_time

                        url = "/frontend/api/book-extension"
                        payment_type = 'stripe'


                        let booking_obj = JSON.parse(document.getElementById('bookingObjVideoTalk').textContent)

                        let params = {
                            booking_id: booking_obj.id,
                            talk_id: booking_obj.talk_id,
                            selected_card_data: {
                                "card_id": defaultCardElement.dataset.cardId
                            },
                            payment_type: payment_type,

                            _token: token,
                            date_time: date_time,
                            extension_time: parseInt(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_time')[0].textContent)
                        }



                        let xhr = new XMLHttpRequest()
                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)

                                if (response.success == true) {

                                    if (response.data.hasOwnProperty('redirect')) {

                                        if (response.data.redirect == null) {
                                            //toastify(response.message)
                                            closePopup('paymentWalletPopUp')

                                            let thatsMe
                                            for (let i = 0; i < others.length; i++) {
                                                if (others[i].user_id === userObj1.id) {
                                                    thatsMe = {
                                                        name: others[i].name_of_user,
                                                        profile_picture: others[i].user_image
                                                    }
                                                }

                                            }
                                            EXTEND_CALL_SUCCESSFUL_Send_Event_Function(call, thatsMe, window.extendTalkParameters)
                                            hideLoading()
                                            openPopup('paymentCompletedPopUp')

                                            setTimeout(function () {
                                                closePopup('paymentCompletedPopUp')
                                            }, 5000)

                                            /*    if (window.innerHeight > 767) {
                                                   document.getElementById('extendThisCallLi').style.left = "100%"
                                               } else {
                                                   document.getElementById('extendThisCallLi').style.top = "calc(100vh + 80px)"
                                               }
                                            */
                                            closePopup('specialLoading')
                                        } else {
                                            document.getElementById('specialLoading').style.zIndex = '9999999999999999999999999999999999999'
                                            let origins = location.origin

                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(origins + response.data.redirect)
                                        }

                                    }




                                } else {

                                    hideLoading()

                                    if (document.getElementById('errorMessageVideoTalk')) {
                                        let errorMessageVideoTalk = document.getElementById('errorMessageVideoTalk')
                                        errorMessageVideoTalk.classList.remove('dn')
                                        errorMessageVideoTalk.textContent = response.message
                                        setTimeout(function () {
                                            errorMessageVideoTalk.classList.add('dn')
                                        }, 5000)
                                    } else {
                                        toastify(response.message)
                                    }

                                    closePopup('specialLoading')

                                }


                            }

                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            hideLoading()
                            closePopup('specialLoading')
                           /*  Sentry.captureException(new bookExtensionPaymentStripeError_videoConference('status: ' + this.statusText + '|| response: ' +
                                this.statusText + ' || url: ' + location.href)) */
                        }

                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
                        xhr.setRequestHeader("X-CSRF-TOKEN", token)
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.send(JSON.stringify(params))

                    }else{

                        let activeCard = document.getElementById('stripeerCont')?.getElementsByClassName('active')[0]
                        if (!activeCard) {
                            closePopup('specialLoading')
                            toastify(getPoTranslate('PLEASE_SELECT_A_CARD'))
                            return
                        }
                        let defaultCardElement = activeCard.dataset.cardId
                        let amount = parseFloat(document.getElementById('online_amount').value)
                        let payment_type, url


                            payment_type = 'stripe'
                            url = "/frontend/api/deposite-in-wallet"

                        let params = {

                            selected_card_data: {
                                "card_id": defaultCardElement
                            },
                            amount: amount,
                            _token: token,
                            payment_type: payment_type
                        }

                        let xhr = new XMLHttpRequest()

                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)


                                if (response.depositeInWallet.success == true) {

                                    if (response.depositeInWallet.hasOwnProperty('data')) {

                                        if (response.depositeInWallet.data.hasOwnProperty('redirect')) {
                                            let origins = location.origin

                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(origins + response.depositeInWallet.data.redirect)
                                        }

                                    } else {

                                        toastify(response.depositeInWallet.message)

                                        closePopup('specialLoading')

                                        closePopup('addCoinsPaymentPopUp')
                                        closePopup('blankPopup')
                                    }

                                } else {
                                    closePopup('specialLoading')


                                    toastify(response.depositeInWallet.message)

                                }

                            }
                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            closePopup('specialLoading')
                           /*  Sentry.captureException(new depositInWalletPaymentStripeError_settingsWallet('status: ' + this.statusText + '|| response: ' +
                                this.statusText + ' || url: ' + location.href)) */
                        }

                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                        xhr.send(JSON.stringify(params))
                    }


                /* } catch (err) {
                    Sentry.captureException(new TryCatchBlockBookingPaymentFunction(err))
                } */
            }


            class TryCatchBookingPaymentFunction extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryCatchBookingPaymentFunction"
                }
            }

            class depositInWalletPaymentStripeError_settingsWallet extends Error {
                constructor(message) {
                    super(message)
                    this.name = "depositInWalletPaymentStripeError_settingsWallet"
                }
            }

            class bookExtensionPaymentStripeError_videoConference extends Error {
                constructor(message) {
                    super(message)
                    this.name = "bookExtensionPaymentStripeError_videoConference"
                }
            }

            class TryCatchBlockBookingPaymentFunction extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryCatchBlockBookingPaymentFunction"
                }
            }
        }

        //this is for adding stripe cards
        if (document.getElementsByClassName('creditCardReset')[0]) {
            let creditCardResets = document.getElementsByClassName('creditCardReset')

            for (let i = 0; i < creditCardResets.length; i++) {
                creditCardResets[i].addEventListener('click', function () {
                    showLoading()

                    window.cardAddingClicked = 1
                    //card.destroy()
                    card.destroy()

                    try {
                        getCreditCard()
                    } catch (err) {
                        Sentry.captureException(new TryCatchAddCardToWalletXMLHttpRequestFunction(err));
                    }

                    function getCreditCard() {

                        let xhr = new XMLHttpRequest()

                        xhr.onloadstart = function () {
                            showLoading()
                        }

                        xhr.onreadystatechange = function () {

                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.response)

                                if (response) {

                                    document.getElementById('carderPopuper').innerHTML = response.html
                                    document.getElementById('cardPopUp').getElementsByClassName('closeSpanPopup')[0].addEventListener('click', function () {
                                        closePopup('cardPopUp')
                                    })

                                    openPopup('cardPopUp')

                                    addCreditCardSubmit(stripe)

                                    window.card = elements.create('card', {
                                        theme: 'night',
                                        iconStyle: 'solid',
                                        style: styleZ,
                                    })

                                    if (document.getElementById('card-element')) {
                                        card.mount('#card-element')
                                    }

                                } else {
                                    toastify(response.message)
                                }

                                hideLoading()
                            }
                        }

                        xhr.onloadend = function () {
                            hideLoading()

                        }

                        xhr.onerror = function (error) {
                            toastify(this.statusText)
                            Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                        }

                        xhr.open("GET", "/add-stripe-card", true)

                        xhr.setRequestHeader("Content-Type", "application/text;charset=UTF-8");
                        xhr.setRequestHeader('Authorization', bearerToken);
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));

                        xhr.send()


                    }

                    let cardHolderInput = document.getElementById('card_holder_name')
                    let parent = cardHolderInput.parentElement

                    cardHolderInput.classList.remove('ok')
                    cardHolderInput.classList.remove('error')
                    cardHolderInput.value = ''
                    parent.getElementsByClassName('verified-svg')[0].classList.remove('active')
                    parent.getElementsByClassName('default-warn')[0].classList.remove('active')
                    parent.getElementsByClassName('input-label')[0].style.color = 'rgba(155, 172, 200, 1)'
                })

            }
        }

        //this is stripe payment on booking funnel
        if (document.getElementById('add_wallet_booking_cachier')) {

            document.getElementById('add_wallet_booking_cachier').addEventListener('click', function () {


                if (this.dataset.payment === 'paymentTalkila') {
                    openPaymentPopuper(getPoTranslate('PROCESSING_PAYMENT'))
                } else {
                    openPaymentPopuper(getPoTranslate('PROCESSING_STRIPE_PAYMENT'))
                }

                try {
                    bookingPayment()
                } catch (err) {
                    Sentry.captureException(new TryCatchAddCardToWalletXMLHttpRequestFunction(err));
                }
            })

            function bookingPayment() {

                try {

                    let activeCard = document.getElementsByClassName('stripe_cards_without_delete')[0]?.getElementsByClassName('active')[0]

                    let paymentMethod = document.getElementById('paymentTabsUl')?.getElementsByClassName('is-active')[0].dataset.card

                    try {
                        let bookingObj = JSON.parse(getCookie('bookingObj'))
                        let token = document.querySelector('meta[name="csrf-token"]').content

                        let amount = parseFloat(document.getElementById('moneyContar').value)
                        let payment_type, url

                        if (activeCard) {
                            if (activeCard.dataset.pointer === 'paypal') {
                                payment_type = 0
                                url = envAppBackendUrl + "/paypal-payment"
                            } else {
                                payment_type = 'stripe'
                                url = "/frontend/api/bookings"
                            }
                        } else {
                            url = "/frontend/api/bookings"
                        }

                        let params = {
                            account_id: activeCard?.dataset.cardId,
                            selected_card_data: {
                                "card_id": activeCard?.dataset.cardId
                            },
                            payment_method: paymentMethod,
                            talk_id: document.getElementsByClassName('dataTalkId')[0].dataset.talkId,
                            teacher_id: document.getElementsByClassName('step1username')[0].dataset.id,
                            start_call: bookingObj.bookingDate + ' ' + bookingObj.bookingTime[0],
                            date_time: bookingObj.bookingDate + ' ' + bookingObj.bookingTime[0],
                            anonym: bookingObj.anonymousMeeting,
                            amount: amount,
                            _token: token,
                            payment_type: payment_type


                        }

                        let xhr = new XMLHttpRequest()
                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)

                                if (response.success == true) {
                                    if (response.hasOwnProperty('data')) {
                                        if (response.data.hasOwnProperty('redirect')) {


                                            let origins = location.origin
                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(location.origin + response.data.redirect)


                                        } else {

                                            document.cookie = 'bookingObj=; Path=/booking-payment; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'


                                            location.assign(location.origin + '/booking-thank-you')
                                        }
                                    }

                                } else {

                                    closePopup('specialLoading')
                                    toastify(response.message)


                                }

                            }
                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            closePopup('specialLoading')
                            Sentry.captureException(new SendCCDetaulsToBe('status: ' + this.statusText + '|| response: ' +
                                this
                                    .statusText + ' || url: ' + location.href))
                        }


                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.send(JSON.stringify(params))
                    } catch (error) {
                        console.log(error)

                        toastify(getPoTranslate('PAYMENT_OBJECT_HAS_EXPIRED_PLEASE_RESTART_BOOKING_PROCESS'))
                        setTimeout(function () {
                            location.assign('')
                        }, 3000)

                    }


                } catch (err) {
                    console.log(err)
                    Sentry.captureException(new TryBookingPayment(err))
                }
            }



            class SendCCDetaulsToBe extends Error {
                constructor(message) {
                    super(message)
                    this.name = "SendCCDetaulsToBe"
                }
            }

            class TryBookingPayment extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryBookingPayment"
                }
            }
        }
    })

    class TryCatchBookingPaymentFunction extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchBookingPaymentFunction"
        }
    }
    class depositInWalletPaymentStripeError_settingsWallet extends Error {
        constructor(message) {
            super(message)
            this.name = "depositInWalletPaymentStripeError_settingsWallet"
        }
    }
    class bookExtensionPaymentStripeError_videoConference extends Error {
        constructor(message) {
            super(message)
            this.name = "bookExtensionPaymentStripeError_videoConference"
        }
    }

}

//chose card for payment, not set as default
export function selectCardForPayment() {
    if(document.getElementById('stripeerCont')?.getElementsByClassName("set_default_card")[0]){
        let cardItems = document.getElementById('stripeerCont').getElementsByClassName("set_default_card")

        for (let i = 0; i < cardItems.length; i++) {

            cardItems[i].addEventListener('click', selectPaymentCard)
        }
    }

}

function selectPaymentCard(e) {

    let cardForPayment = e.currentTarget

    if (document.getElementById('stripeerCont').getElementsByClassName('active')[0]) {
        document.getElementById('stripeerCont').getElementsByClassName('active')[0].classList.remove('active')
    }
    if (document.getElementById('stripeerCont').getElementsByClassName('pon')[0]) {
        document.getElementById('stripeerCont').getElementsByClassName('pon')[0].classList.remove('pon')
    }
    cardForPayment.getElementsByClassName('card-select')[0].classList.add('active')
    cardForPayment.classList.add('pon')
}

export function selectDefaultCard() {

    let set_default_cards = document.getElementsByClassName('card-list')[0].getElementsByClassName('set_default_card')
    for (let i = 0; i < set_default_cards.length; i++) {
        set_default_cards[i].addEventListener('click', selectDefaultCardHelper)

    }

}

function selectDefaultCardHelper(e) {


    let defaultCardElement = e.currentTarget
    showLoading()
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/payment-methods/update'

    let params = {
        'id': defaultCardElement.dataset.cardId
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {

                removeActivePointerCreditCardsPointers()

                let cardItems = document.getElementById('stripeerCont').getElementsByClassName('set_default_card')
                for (let j = 0; j < cardItems.length; j++) {
                    if (cardItems[j].dataset.cardId === defaultCardElement.dataset.cardId) {
                        cardItems[j].getElementsByClassName('card-select')[0].classList.add('active')
                        cardItems[j].classList.add('pon')
                    }
                }

                defaultCardElement.parentElement.getElementsByClassName('delete_card')[0].classList.add('dn')
                defaultCardElement.getElementsByClassName('card-select')[0].classList.add('active')
                defaultCardElement.classList.add('pon')

                toastify(response.message)

            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {
        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitSetDefaultCreditCardError(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('PATCH', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)


    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

    class SubmitSetDefaultCreditCardError extends Error {
        constructor(message) {
            super(message)
            this.name = "SubmitSetDefaultCreditCardError"
        }
    }

}

function removeActivePointerCreditCardsPointers() {

    removeActivePointerFromNoDeleteCardList()

    if (document.body.className === 'settings_wallets') {

        removeActivePointers(document.getElementsByClassName('card-list')[0])
    } else if (document.body.className === 'book_slot_payment') {
        removeActivePointers(document.getElementsByClassName('stripe_cards_without_delete')[0])
    }

}

function removeActivePointers(cardList) {

    cardList.getElementsByClassName('active')[0]?.classList.remove('active')
    cardList.getElementsByClassName('pon')[0]?.classList.remove('pon')

    if (cardList.getElementsByClassName('delete_card')[0]) {

        let deleteCards = cardList.getElementsByClassName('delete_card')
        for (let i = 0; i < deleteCards.length; i++) {
            if (deleteCards[i].classList.contains('dn')) {
                deleteCards[i].classList.remove('dn')
            }

        }
    }
}

export function deleteCards() {

    let deleteButtons = document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')

    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function () {

            document.getElementById('delete_card_id').value = this.dataset.cardId
            openPopup('deleteStripeCardPopUp')

        })
    }

    document.getElementsByClassName('deletecard')[0].addEventListener('click', cardDelete)
    document.getElementsByClassName('canceldeletecard')[0].addEventListener('click', clearDeleteCardsEventsAndCloseDeleteCardsPrePopup)
    document.getElementById('deleteStripeCardPopUp').addEventListener('click', clearDeleteCardsEventsAndCloseDeleteCardsPrePopup)
}

function deleteCardHelper(e) {

    document.getElementById('delete_card_id').value = this.dataset.cardId
    openPopup('deleteStripeCardPopUp')

}

function clearDeleteCardsEventsAndCloseDeleteCardsPrePopup() {


    document.getElementById('delete_card_id').value = ''
    closePopup('deleteStripeCardPopUp')


}

function cardDelete() {



    showLoading()
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/payment-methods/delete'

    let params = {
        'id': document.getElementById('delete_card_id').value

    }


    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {








                let cards = document.getElementsByClassName('set_default_card')
                for (let j = 0; j < cards.length; j++) {
                    if (cards[j].dataset.cardId === document.getElementById('delete_card_id').value) {
                        let cardWrapper = cards[j].parentElement
                        cardWrapper.style.scale = '0'
                        setTimeout(function () {
                            cardWrapper.remove()

                            setTimeout(function () {
                                let deleteButtons = document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')

                                if (deleteButtons.length === 1) {
                                    deleteButtons[0].classList.remove('dn')
                                }
                            })

                        }, 310)
                    }

                }

                toastify(response.message)



                clearDeleteCardsEventsAndCloseDeleteCardsPrePopup()




                if (document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card').length === 1) {

                    let coinsAddPopupNoCards = document.createElement('p')
                    coinsAddPopupNoCards.className = 'noCardsAdded text-center m0'
                    coinsAddPopupNoCards.textContent = getPoTranslate('NO_CARDS')

                    document.getElementsByClassName('card-list')[0].append(coinsAddPopupNoCards)


                    document.getElementsByClassName('stripe_cards_without_delete')[0].append(coinsAddPopupNoCards.cloneNode(true))

                }



            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {

        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitDeleteCreditCardsError(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('DELETE', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)


    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

    class SubmitDeleteCreditCardsError extends Error {
        constructor(message) {
            super(message)
            this.name = "SubmitDeleteCreditCardsError"
        }
    }

}

