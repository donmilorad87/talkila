let formData = {}
let formStatus = {}

function pasteCode(pastedData) {


        let pastedString = pastedData


        if (pastedString[0]) {
            first.value = pastedString[0]
        }

        if (pastedString[1]) {
            seccond.value = pastedString[1]
        }

        if (pastedString[2]) {
            third.value = pastedString[2]
        }

        if (pastedString[3]) {
            fourth.value = pastedString[3]
        }

        if (pastedString[4]) {
            fifth.value = pastedString[4]
        }

        if (pastedString[5]) {
            sixth.value = pastedString[5]
        }








}

function initJtc2Step2Validators() {
    if (document.getElementById("jtc2Step2Form")) {

        let first = document.getElementById('first')
        let seccond = document.getElementById('seccond')
        let third = document.getElementById('third')
        let fourth = document.getElementById('fourth')
        let fifth = document.getElementById('fifth')
        let sixth = document.getElementById('sixth')
        let submitButton = document.getElementById('submitVerifyEmail')

        first.focus()



        function handlePaste(e) {
            var clipboardData, pastedData;

            // Stop data actually being pasted into div

            e.preventDefault()

            // Get pasted data via clipboard API
            clipboardData = e.clipboardData || window.clipboardData;
            pastedData = clipboardData.getData('Text');

            // Do whatever with pasteddata
            if(pastedData.length >= 6){

                pasteCode(pastedData)

            }else{

                toastify(getPoTranslate('YOU_PASTED_STRING_IN_WRONG_FORMAT') + '|' + pastedData.length)

            }
        }

        first.addEventListener('paste', handlePaste)
        first.addEventListener('input', function (e) {



                if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                    if (e.data == 'e') {

                        first.value = ''
                    }

                    first.focus()

                } else if (
                    e.data == 0 ||
                    e.data == 1 ||
                    e.data == 2 ||
                    e.data == 3 ||
                    e.data == 4 ||
                    e.data == 5 ||
                    e.data == 6 ||
                    e.data == 7 ||
                    e.data == 8 ||
                    e.data == 9
                ) {

                    first.style.border = "1px solid transparent"

                    setTimeout(function () {
                        seccond.focus()
                    }, 10)


                }




        })
        seccond.addEventListener('keydown', function (e) {
            if(seccond.value.length === 0){
                if (e.key === "Backspace") {

                    first.focus()
                }
            }

        })
        seccond.addEventListener('paste', handlePaste)
        seccond.addEventListener('input', function (e) {


            if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                if (e.data == 'e') {

                    first.value = ''
                }

                seccond.focus()

                if (seccond.value === '') {

                    first.focus()
                }

            } else if (
                e.data == 0 ||
                e.data == 1 ||
                e.data == 2 ||
                e.data == 3 ||
                e.data == 4 ||
                e.data == 5 ||
                e.data == 6 ||
                e.data == 7 ||
                e.data == 8 ||
                e.data == 9
            ) {

                seccond.style.border = "1px solid transparent"

                setTimeout(function () {
                    third.focus()
                }, 10)


            }

        })
        third.addEventListener('paste', handlePaste)
        third.addEventListener('keydown', function (e) {
            if(third.value.length === 0){
                if (e.key === "Backspace") {

                    seccond.focus()
                }
            }

        })

        third.addEventListener('input', function (e) {



            if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                if (e.data == 'e') {

                    third.value = ''
                }

                third.focus()
                if (third.value === '') {
                    seccond.focus()
                }

            } else if (
                e.data == 0 ||
                e.data == 1 ||
                e.data == 2 ||
                e.data == 3 ||
                e.data == 4 ||
                e.data == 5 ||
                e.data == 6 ||
                e.data == 7 ||
                e.data == 8 ||
                e.data == 9
            ) {

                third.style.border = "1px solid transparent"

                setTimeout(function () {
                    fourth.focus()
                }, 10)


            }
        })


        fourth.addEventListener('paste', handlePaste)
        fourth.addEventListener('input', function (e) {



            if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                if (e.data == 'e') {

                    fourth.value = ''
                }

                fourth.focus()
                if (fourth.value === '') {
                    third.focus()
                }

            } else if (
                e.data == 0 ||
                e.data == 1 ||
                e.data == 2 ||
                e.data == 3 ||
                e.data == 4 ||
                e.data == 5 ||
                e.data == 6 ||
                e.data == 7 ||
                e.data == 8 ||
                e.data == 9
            ) {

                fourth.style.border = "1px solid transparent"

                setTimeout(function () {
                    fifth.focus()
                }, 10)


            }
        })


        fifth.addEventListener('paste', handlePaste)

        fifth.addEventListener('input', function (e) {


            if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                if (e.data == 'e') {

                    fifth.value = ''
                }

                fifth.focus()
                if (fifth.value === '') {
                    fourth.focus()
                }

            } else if (
                e.data == 0 ||
                e.data == 1 ||
                e.data == 2 ||
                e.data == 3 ||
                e.data == 4 ||
                e.data == 5 ||
                e.data == 6 ||
                e.data == 7 ||
                e.data == 8 ||
                e.data == 9
            ) {

                fifth.style.border = "1px solid transparent"

                setTimeout(function () {
                    sixth.focus()
                }, 10)
            }
        })

        sixth.addEventListener('paste', handlePaste)

        sixth.addEventListener('input', function (e) {
            pasteCode(e)

            if (e.inputType === "deleteContentBackward" || e.data == 'e') {
                if (e.data == 'e') {

                    sixth.value = ''
                }

                sixth.focus()
                if (sixth.value === '') {
                    fifth.focus()
                }

            } else if (
                e.data == 0 ||
                e.data == 1 ||
                e.data == 2 ||
                e.data == 3 ||
                e.data == 4 ||
                e.data == 5 ||
                e.data == 6 ||
                e.data == 7 ||
                e.data == 8 ||
                e.data == 9
            ) {

                sixth.style.border = "1px solid transparent"

                setTimeout(function () {
                    submitButton.focus()
                }, 10)
            }
        })

        submitButton.addEventListener('click', submitVerifyEmail)

        function submitVerifyEmail(e) {

            e.preventDefault()

            let verifyInputsContainer = document.getElementById('verifyInputsContainer').getElementsByTagName('input')
            let counter = 0
            for (let i = 0; i < verifyInputsContainer.length; i++) {
                if (verifyInputsContainer[i].value === '' || verifyInputsContainer[i].value.length > 1) {
                    verifyInputsContainer[i].style.cssText = "border:1px solid red; border-bottom:2px solid red!important"

                    counter++
                }

            }

            if (counter > 0) {
                document.getElementById('verifyInputsContainer').style.border = " 1px solid red"
                document.getElementById('verifyInputsContainerMessage').textContent = getPoTranslate('PLEASE_FILL_ALL_FIELDS')
                setTimeout(function () {
                    document.getElementById('verifyInputsContainer').style.border = " 1px solid rgba(6,4,3,.1)"
                    document.getElementById('verifyInputsContainerMessage').textContent = ''
                }, 5000)
            } else {
                //ajax here
                console.log(formData, formStatus);

            }

        }

    }
}

/* let xhr = new XMLHttpRequest()
let url = envAppBackendUrl + '/user-unblock'

let params = {
    '_token': token,
    'teacher_id': e.dataset.userId
}


xhr.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {
        let response = JSON.parse(this.response)

        if (response.success === true) {
            for (let j = 0; j < userBlocks.length; j++) {
                userBlocks[j].textContent = getPoTranslate('BLOCK')
                userBlocks[j].removeEventListener('click', userUnblock)
                userBlocks[j].setAttribute('onClick', 'userBlock(this)')
            }

            document.getElementsByClassName('thisUserIsBlocked')[0].classList.add('dn')


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
    Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
        .statusText +
        '|| response: ' + this.statusText + ' || url: ' + location.href));
}

xhr.open('POST', url, true)

xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
xhr.setRequestHeader('Authorization', bearerToken)
xhr.setRequestHeader('X-CSRF-TOKEN', token)

xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

xhr.send(JSON.stringify(params)) */


(function () {
    initJtc2Step2Validators()
})()
