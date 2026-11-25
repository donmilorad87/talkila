function initAddCoinsValidation() {

    let postStatus = {}
    let postData = {}


    if (document.getElementById("addCoinsToWalletForm")) {
        let saveBtn = document.getElementById("add_coins")

        saveBtn.addEventListener("click", handleSubmitCoinsAdd)

        let coins = document.getElementById('coins')

        coins.addEventListener("input", coinsHandler)

    }


    function coinsHandler() {

        let params = { el: coins, type: "number", min: 1, max: 10000, svg: false, warn: false, msg: 'You can add minimum 1 talkila coin, maxium 10000 talkila coins' }
        postData["coins"] = coins.value
        postStatus["coins"] = inputDriver(params)
    }

    function handleSubmitCoinsAdd(e) {

        e.preventDefault()

        showLoading()
        coinsHandler()

        let isDataIsOK = Object.keys(postStatus).filter(function (el) { return !postStatus[el].isOk }).length > 0 ? false : true
        if (isDataIsOK) {

            let coinsToAdd = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(coins.value).replace(/[^0-9.,]/g, '')



            closePopup('addCoinsPopUp')


            removeActivePointerFromNoDeleteCardList()
            if (document.body.className === 'settings_wallets') {
                document.getElementById('online_amount').value = coins.value
                document.getElementsByClassName('online_amount')[0].textContent = coinsToAdd
                openPopup('addCoinsPaymentPopUp')

                let defaultElement = document.getElementsByClassName('card-list')[0].getElementsByClassName('active')[0]
                let defaultCardElements = document.getElementsByClassName('stripe_cards_without_delete')[0].getElementsByClassName('set_default_card')

                for (let i = 0; i < defaultCardElements.length; i++) {
                    if (defaultCardElements[i].dataset.cardId === defaultElement.dataset.cardId) {
                        defaultCardElements[i].classList.add('pon')
                        defaultCardElements[i].getElementsByClassName('card-select')[0].classList.add('active')
                    }

                }
            } else if (document.body.className === 'book_slot_payment' || document.body.className === 'video_conference') {

            } else {
                openPopup('addCoinsPaymentPopUpPartial')
            }


            hideLoading()
        } else {

            hideLoading()
            console.log("Add Coins Failed", postData)
            console.log("Errors", postStatus)

        }
    }

}

(function () {
    initAddCoinsValidation()
})()

class GetAddToCoinsPartial extends Error {
    constructor(message) {
        super(message)
        this.name = "GetAddToCoinsPartial"
    }
}
