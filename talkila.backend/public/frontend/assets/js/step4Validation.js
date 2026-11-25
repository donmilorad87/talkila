let nameStatus = {}
// emailStatus = {}
let ibanStatus = {}

function addEvnets(x,y){
    for(let i = 0; i < x.length; i++){
        x[i].addEventListener("keyup", y)
    }
}

function initStep4Validation() {

    if (document.getElementsByClassName("step4Form")[0]) {
        let nameInput = document.getElementsByClassName("name-input")
        //let emailInput = document.getElementsByClassName("email-input")
        let ibanInput = document.getElementsByClassName("password-input")


        addEvnets(nameInput, nameHandler)
        //addEvnets(emailInput, emailHandler)
        addEvnets(ibanInput, ibanHandler)



        let submitButton = document.getElementsByClassName("submit-button")
        let submitButtonPayment = document.getElementsByClassName("payoutMethodsubmitButton")

        for(let i = 0; i < submitButton.length; i++){
            submitButton[i].addEventListener("click", handleSubmit)
        }

        for(let i = 0; i < submitButtonPayment.length; i++){
            submitButtonPayment[i].addEventListener("click", handleSubmit)
        }

        function handlerHelper(x,y,z){
            let a, b, c

            if(window.innerWidth < 640){
                a = document.getElementsByClassName(x)[1]
                b =  document.getElementsByClassName(y)[1]
                c = document.getElementsByClassName(z)[1]
            }else{
                a = document.getElementsByClassName(x)[0]
                b =  document.getElementsByClassName(y)[0]
                c = document.getElementsByClassName(x)[0]
            }
            return [a, b, c]
        }

        function nameHandler() {

            let helper = handlerHelper("name-input", "verified-name-svg", "name-warn")
            let nameInput = helper[0], nameSvg = helper[1], nameWarn = helper[2]

            let check = nameCheck(nameInput.value)
            //countLabelDriver({ el: nameInput, min: 4, max: 50 })
            nameStatus = check

            if (check.isOk) {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                nameInput.classList.remove("error")
                nameInput.classList.add("ok")
                nameSvg.classList.add("active")
                nameWarn.classList.remove("active")

            } else {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                nameInput.classList.add("error")
                nameInput.classList.remove("ok")
                nameSvg.classList.remove("active")
                nameWarn.classList.add("active")

                nameWarn.innerHTML = "&nbsp"
                nameWarn.innerHTML += check.hasName ? "" : translate.missingName + ","
                nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.missingSurname + ","
                nameWarn.innerHTML += check.hasNumber ? " " + translate.noNumbers + "," : ""
                nameWarn.innerHTML += check.hasSymbol ? " " + translate.noSpecialCharacters + "," : ""
                nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {'minimum_characters':'4', 'maximum_characters':'50'}) + "," : ""

            }
        }

        function ibanHandler() {

            let helper = handlerHelper("password-input", "verified-password-svg", "password-warn")
            let passwordInput = helper[0], passwordSvg = helper[1], passwordWarn = helper[2]



            if (IBAN.isValid(passwordInput.value)) {
                passwordInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
                passwordInput.classList.remove("error")
                passwordInput.classList.add("ok")
                passwordSvg.classList.add("active")
                passwordWarn.classList.remove("active")
                ibanStatus.isOk = true
            } else {
                passwordInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
                passwordInput.classList.add("error")
                passwordInput.classList.remove("ok")
                passwordSvg.classList.remove("active")
                passwordWarn.classList.add("active")
                ibanStatus.isOk = false

            }
        }
        function calculateHeight(){
            let firstHeighter = document.getElementsByClassName('mobileStep4Form')[0].getElementsByClassName('grid-x')[0].offsetHeight
            let secondHeighter = document.getElementsByClassName('bankTansferStuff')[0].getElementsByClassName('bankTansferStuffInner')[0].offsetHeight
            document.getElementsByClassName('mobileStep4Form')[0].style.height = firstHeighter + 'px'
            document.getElementsByClassName('bankTansferStuff')[0].style.height =  '253px'
            document.getElementsByClassName('bankTansferStuff')[0].style.maxHeight = '253px'

        }
        function handleSubmit(e) {

            e.preventDefault()
            nameHandler()
            //emailHandler()
            ibanHandler()
            calculateHeight()
            let postData
            window.innerWidth < 640 ?
                postData = {
                    name: document.getElementsByClassName("name-input")[1].value,
                    //email: document.getElementsByClassName("email-input")[1].value,
                    iban: document.getElementsByClassName("password-input")[1].value
                }
            :
                postData = {
                    name: document.getElementsByClassName("name-input")[0].value,
                    //email: document.getElementsByClassName("email-input")[0].value,
                    iban: document.getElementsByClassName("password-input")[0].value
                }
            if (nameStatus.isOk /* && emailStatus.isOk */ && ibanStatus.isOk) {

                console.log("signup success", postData)


                submitValidationForm(postData)

                //ajax
            } else {

                console.log("signup failed", postData)
                console.log("signup errors", { nameStatus, /* emailStatus, */ ibanStatus })

            }

            function submitValidationForm(formData)
            {
                let token = document.querySelector('meta[name="csrf-token"]').content
                jQuery.ajax({
                    type:'POST',
                    url:'/frontend/api/set-profile-payout-methods',
                    data: {
                        'method'        : 1,
                        'iban'          : formData.iban,
                        'iban_recipient': formData.name,
                        //'iban_email'    : formData.email,
                        '_token'        : token
                    },
                    beforeSend: function(){
                        // Handle the beforeSend event
                        showLoading()
                    },
                    complete: function() {
                        hideLoading()
                    },
                    success:function(response) {

                        if(response.success) {
                            toastify(response.message)


                                if(document.getElementById('chosePaymentMethodPopup')){
                                    closePopup("chosePaymentMethodPopup")
                                }



                        } else {
                            toastify(response.message)
                            return response.message;
                        }
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new JTCStep4SubmitError(errorMessage));
                    }
                });
            }

        }
    }
}

class GetTokenErrorJTCStep4 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenErrorJTCStep4"
    }
}
class JTCStep4SubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "JTCStep4SubmitError"
    }
}

(function () {
    initStep4Validation()
})()
