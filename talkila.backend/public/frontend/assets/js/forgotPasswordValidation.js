function initForgotPasswordValidation() {

    let newPasswordStatus = {}
    let confirmNewPasswordStatus = {}

    let passwordResetForm = document.getElementById("password_reset_form")

    if (passwordResetForm) {



        let newPasswordInput = passwordResetForm.elements['password']
        let confirmNewPasswordInput = passwordResetForm.elements['password_confirmation']
        let submitButton = document.getElementById("forgotPasswordEdit")

        let newPasswordWarn = newPasswordInput.parentElement.getElementsByClassName("password-warn")[0]
        let newPasswordSvg = newPasswordInput.parentElement.getElementsByClassName("verified-password-svg")[0]

        let confirmNewPasswordWarn = confirmNewPasswordInput.parentElement.getElementsByClassName("password-warn")[0]
        let confirmNewPasswordSvg = confirmNewPasswordInput.parentElement.getElementsByClassName("verified-password-svg")[0]


        newPasswordInput.addEventListener("input", newPasswordHandler)
        confirmNewPasswordInput.addEventListener("input", confirmNewPasswordHandler)

        submitButton.addEventListener("click", handleSubmit)


        function newPasswordHandler(e) {

            countLabelDriver({ el: newPasswordInput, min: 8, max: 50 })

            let check = passwordCheck(newPasswordInput.value)

            newPasswordStatus = check

            if (check.isOk) {
                newPasswordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''


                if (newPasswordInput.value === confirmNewPasswordInput.value) {
                    setInputToNotError(newPasswordInput)
                    setInputToNotError(confirmNewPasswordInput)
                    confirmNewPasswordWarn.classList.remove('active')
                    newPasswordWarn.innerHTML = getPoTranslate('WRONG_PASSWORD_FORMAT')
                } else {

                    setInputToError(confirmNewPasswordInput)
                    confirmNewPasswordWarn.classList.add('active')
                    confirmNewPasswordWarn.textContent = translate.passwordDoNotMatch


                }


            } else {
                newPasswordInput.parentElement.getElementsByClassName('validationFields')[0].innerHTML = ''
                setInputToError(newPasswordInput)
                setPasswordWarn(newPasswordInput, check)
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
                    setInputToNotError(newPasswordInput)
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

                setPasswordWarn(confirmNewPasswordInput, check)
                newPasswordWarn.textContent = removeCommaFromValidationWarning(newPasswordWarn.textContent)
                confirmNewPasswordWarn.textContent = removeCommaFromValidationWarning(confirmNewPasswordWarn.textContent)

            }

        }

        function handleSubmit(e) {
            e.preventDefault()


            newPasswordHandler(true)
            confirmNewPasswordHandler(true)

            let postData = {

                new_password: newPasswordInput.value,
                confirm_new_password: confirmNewPasswordInput.value,
            }

            let postStatus = {

                new_password: newPasswordStatus,
                confirm_new_password: confirmNewPasswordStatus
            }

            if (confirmNewPasswordStatus.isOk && newPasswordStatus.isOk) {
                console.log("login post success", postData);
                showLoading()
                passwordResetForm.submit()
            } else {
                console.log("login post data", postData)
                console.log("login post erorrs", postStatus)
                toastify('Something went wrong')
            }
        }





        function setPasswordWarn(passwordInput, check) {

            for (let i = 0; i < Object.keys(check).length; i++) {
                if (Object.keys(check)[i] === 'isOk') {

                } else {
                    if (Object.values(check)[i].isOk) {

                        createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'green', check, i)

                    } else {

                        createValidationElements(passwordInput.parentElement.getElementsByClassName('validationFields')[0], 'red', check, i)

                    }
                }

            }

        }


        function setInputToNotError(input) {

            input.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
            input.classList.remove("error")
            input.classList.add("ok")
            input.parentElement.getElementsByClassName("verified-password-svg")[0].classList.add("active")
            input.parentElement.getElementsByClassName("password-warn")[0].classList.remove("active")
            input.parentElement.getElementsByClassName('password-warn')[0].classList.remove('active')

        }

        function setInputToError(input) {
            input.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
            input.parentElement.getElementsByClassName('password-warn')[0].classList.add('active')
            input.classList.add("error")
            input.classList.remove("ok")
            input.parentElement.getElementsByClassName("verified-password-svg")[0].classList.remove("active")


        }

    }
}



(function () {
    initForgotPasswordValidation()
})()
