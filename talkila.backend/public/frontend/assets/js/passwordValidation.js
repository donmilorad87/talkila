function initPasswordValidation() {
    let passwordStatus = {}
    let newPasswordStatus = {}
    let confirmNewPasswordStatus = {}

    if (document.getElementById("edit_password_form")) {


        let passwordInput = document.getElementById("edit_password_form").elements['password']
        let newPasswordInput = document.getElementById("edit_password_form").elements['new_password']
        let confirmNewPasswordInput = document.getElementById("edit_password_form").elements['confirm_new_password']
        let submitButton = document.getElementById("passwordEdit")


        let passwordWarn = passwordInput.parentElement.getElementsByClassName("password-warn")[0]
        let passwordSvg = passwordInput.parentElement.getElementsByClassName("verified-password-svg")[0]

        let newPasswordWarn = newPasswordInput.parentElement.getElementsByClassName("password-warn")[0]
        let newPasswordSvg = newPasswordInput.parentElement.getElementsByClassName("verified-password-svg")[0]

        let confirmNewPasswordWarn = confirmNewPasswordInput.parentElement.getElementsByClassName("password-warn")[0]
        let confirmNewPasswordSvg = confirmNewPasswordInput.parentElement.getElementsByClassName("verified-password-svg")[0]



        passwordInput.addEventListener("input", passwordHandler)
        newPasswordInput.addEventListener("input", newPasswordHandler)
        confirmNewPasswordInput.addEventListener("input", confirmNewPasswordHandler)

        submitButton.addEventListener("click", handleSubmit)

        function passwordHandler(e) {

            countLabelDriver({ el: passwordInput, min: 8, max: 50 })

            let check = passwordCheck(passwordInput.value)

            passwordStatus = check
            if (check.isOk) {
                passwordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                setInputToNotError(passwordInput)
                if(passwordInput.value === newPasswordInput.value){
                    newPasswordStatus = {isOk:false}

                    setInputToError(newPasswordInput)
                    newPasswordWarn.innerHTML = translate.newPasswordMarchOld
                }else{
                    //here we need to check if old password is true, than this validation is complete
                    newPasswordWarn.innerHTML = getPoTranslate('WRONG_PASSWORD_FORMAT')
                    setInputToNotError(newPasswordInput)
                    newPasswordHandler(true)
                }

            } else {
                passwordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                setInputToError(passwordInput)
                setPasswordWarn(passwordInput,check)
                passwordWarn.innerHTML += check.max ? "" : " " + translate.maximum + " 50 " + translate.characters + ", "
            }

            passwordWarn.textContent = removeCommaFromValidationWarning(passwordWarn.textContent)

        }
        function newPasswordHandler(e) {

            countLabelDriver({ el: newPasswordInput, min: 8, max: 50 })

            let check = passwordCheck(newPasswordInput.value)

            newPasswordStatus = check
            if (check.isOk) {
                newPasswordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                if (passwordInput.value === newPasswordInput.value) {
                    setInputToError(newPasswordInput)
                    setPasswordWarn(newPasswordWarn,check)

                    newPasswordWarn.innerHTML = translate.newPasswordMarchOld


                } else {
                    newPasswordWarn.innerHTML = getPoTranslate('WRONG_PASSWORD_FORMAT')
                    setInputToNotError(newPasswordInput)
                }

                if(newPasswordInput.value === confirmNewPasswordInput.value){
                    setInputToNotError(confirmNewPasswordInput)
                    confirmNewPasswordWarn.classList.remove('active')
                    newPasswordWarn.innerHTML = getPoTranslate('WRONG_PASSWORD_FORMAT')
                }else{

                    setInputToError(confirmNewPasswordInput)
                    confirmNewPasswordWarn.classList.add('active')
                    confirmNewPasswordWarn.textContent = translate.passwordDoNotMatch

                    //setPasswordWarn(confirmNewPasswordWarn,check)
                }


            } else {
                newPasswordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                setInputToError(newPasswordInput)
                setPasswordWarn(newPasswordInput,check)
                newPasswordWarn.textContent = removeCommaFromValidationWarning(newPasswordWarn.textContent)
                confirmNewPasswordWarn.textContent = removeCommaFromValidationWarning(confirmNewPasswordWarn.textContent)
            }


        }

        function confirmNewPasswordHandler(e) {

            countLabelDriver({ el: confirmNewPasswordInput, min: 8, max: 50 })

            let check = passwordCheck(confirmNewPasswordInput.value)

            confirmNewPasswordStatus = check

            if (check.isOk) {
                confirmNewPasswordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                if (newPasswordInput.value === confirmNewPasswordInput.value) {

                    setInputToNotError(confirmNewPasswordInput)
                    confirmNewPasswordWarn.classList.remove('active')
                } else {

                    setInputToError(confirmNewPasswordInput)
                    confirmNewPasswordWarn.classList.add('active')

                    confirmNewPasswordWarn.textContent = translate.passwordDoNotMatch

                }

            } else {
                newPasswordWarn.innerHTML = getPoTranslate('WRONG_PASSWORD_FORMAT')
                confirmNewPasswordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                setInputToError(confirmNewPasswordInput)

                setPasswordWarn(confirmNewPasswordInput,check)
                newPasswordWarn.textContent = removeCommaFromValidationWarning(newPasswordWarn.textContent)
                confirmNewPasswordWarn.textContent = removeCommaFromValidationWarning(confirmNewPasswordWarn.textContent)

            }

        }

        function handleSubmit(e) {
            e.preventDefault()

            passwordHandler(true)
            newPasswordHandler(true)
            confirmNewPasswordHandler(true)

            let postData = {
                password: passwordInput.value,
                new_password: newPasswordInput.value,
                confirm_new_password: confirmNewPasswordInput.value,
            }

            let postStatus = {
                password: passwordStatus,
                new_password: newPasswordStatus,
                confirm_new_password: confirmNewPasswordStatus
            }

            if (confirmNewPasswordStatus.isOk && newPasswordStatus.isOk && passwordStatus.isOk) {
                console.log("login post success", postData);
                submitValidationForm(postData)
            } else {
                console.log("login post data", postData)
                console.log("login post erorrs", postStatus)
                toastify('Something went wrong')
            }
        }

        function submitValidationForm(formData)
        {
            let token = document.getElementById("_token").getElementsByTagName("input")[0].value;

            jQuery.ajax({
                type:'POST',
                url: '/frontend/api/edit-profile-password',
                data: {
                    'new_password'           :formData.new_password,
                    'new_password_confirmed' :formData.confirm_new_password,
                    'password'               :formData.password,
                    '_token'                 :token
                },
                beforeSend: function() {
                    // Handle the beforeSend event
                    showLoading()
                },
                complete: function() {
                    hideLoading()
                },
                success:function(response) {

                    if(response.success) {
                        closePopup('editPassword')
                        toastify(response.message)

                    } else {

                        toastify(response.message)
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new PasswordValidationSubmitError(errorMessage + ' url: ' + location.href ));
                }
            });
        }



    function setPasswordWarn(passwordInput,check){

          for (let i = 0; i < Object.keys(check).length; i++) {
                    if(Object.keys(check)[i] === 'isOk'){

                    }else{
                        if(Object.values(check)[i].isOk){

                            createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'green', check, i)

                        }else{

                            createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'red', check, i)

                        }
                    }

                }

    }


    function setInputToNotError(input){

        input.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
        input.classList.remove("error")
        input.classList.add("ok")
        input.parentElement.getElementsByClassName("verified-password-svg")[0].classList.add("active")
        input.parentElement.getElementsByClassName("password-warn")[0].classList.remove("active")
        input.parentElement.getElementsByClassName('password-warn')[0].classList.remove('active')

    }

    function setInputToError(input){
        input.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
        input.parentElement.getElementsByClassName('password-warn')[0].classList.add('active')
        input.classList.add("error")
        input.classList.remove("ok")
        input.parentElement.getElementsByClassName("verified-password-svg")[0].classList.remove("active")


    }



    }
}

class GetTokenPasswordValidation extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenPasswordValidation"
    }
}
class PasswordValidationSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "PasswordValidationSubmitError"
    }
}

(function () {
    initPasswordValidation()
})();
